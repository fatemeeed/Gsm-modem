<?php

namespace App\Livewire;

use App\Models\Datalogger;
use Livewire\Component;

use Illuminate\Support\Facades\DB;
use App\Http\Services\Message\GSMConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DataloggerToggle extends Component
{

    use LivewireAlert;

    public $datalogger;
    public $status;
    public $orderCode;

    public function mount(Datalogger $datalogger){

        $this->datalogger=$datalogger;
        $this->status=$datalogger->dataloggerLastStatus();


    }

    public function toggleStatus( GSMConnection $gsmConnection)
    {

     

        $this->status = $this->status == 'OFF' ? 'ON' : 'OFF';

        $this->orderCode = $this->datalogger->order_codes()->where('order', $this->status)->first();

        

        if (!$this->orderCode) {

            //$this->emit('showMessage','success','پیام با موفقیت ارسال شد');
            //$this->dispatchBrowserEvent('swal', ['title' => 'hello from Livewire']);
            $this->alert('error', 'دستور معتبر برای این دیتالاگر وجود ندارد.');
            // return response()->json(['error' => 'دستور معتبر برای این دیتالاگر وجود ندارد.'], 400);

        }

       
        $mobile_number = $this->datalogger->mobile_number;

        DB::transaction(function () use ($mobile_number, $gsmConnection) {


            //$result=$gsmConnection->send($mobile_number, $request->content);

            try {
                $response = $gsmConnection->send($mobile_number, $this->orderCode->name);

              
                    Message::create(
                        [
                            'from' => $mobile_number,
                            'datalogger_id' => $this->datalogger->id,
                            'content' => $this->orderCode->name,
                            'time' => Carbon::now(),
                            'type' => 0
    
                        ]
                    );
                
               


                // Log::info('SMS sent', ['phone_number' => $mobile_number, 'message' => $this->orderCode->name , 'response' => $response]);
                $this->alert('success', 'پیام با موفقیت ارسال شد');
            } catch (\Exception $e) {
                Log::error('Failed to send SMS', ['error' => $e->getMessage()]);
                $this->alert('error', 'خطا در ارسال پیام');
                
            }
        });


    }


    public function render()
    {
        return view('livewire.datalogger-toggle') ;
    }
}
