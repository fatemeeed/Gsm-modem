<?php

namespace App\Http\Controllers\Panel;

use App\Models\City;
use App\Models\Pump;
use App\Models\Role;
use App\Models\Well;
use App\Models\Source;
use App\Models\CheckCode;
use App\Models\OrderCode;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Models\IndustrialCity;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataLoggerRequest;

class DataLoggerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $devices = Datalogger::all();

        $sources = Source::with([
            'datalogger.industrialCity',
            'datalogger.checkCodes',
            'datalogger.powerCheckCode',
            'datalogger.messages',
            'pumps',
            'wells'
        ])
            ->select('id', 'mobile_number', 'name')
            ->get()
            ->map(function ($source) {
                $source->dataloggerId = $source->datalogger->id;
                $source->type = 'منبع';
                $source->industrial_city_name = $source->datalogger->industrialCity->name ?? null;
                $source->power = $source->datalogger->power ?? null;
                $source->checkCodes = $source->datalogger->checkCodes;
                $source->powerCheckCode = $source->datalogger->powerCheckCode;
                $source->dataloggerLastStatus = $source->datalogger->dataloggerLastStatus();
                $source->wells = $source->wells ?? null;
                $source->pumps = $source->pumps ?? null;
                return $source;
            });

        $wells = Well::with([
            'datalogger.industrialCity',
            'datalogger.checkCodes',
            'datalogger.powerCheckCode',
            'datalogger.messages',
            'sources',
            
        ])
            ->select('id', 'mobile_number', 'name')
            ->get()
            ->map(function ($well) {
                $well->dataloggerId = $well->datalogger->id;
                $well->type = 'چاه';
                $well->industrial_city_name = $well->datalogger->industrialCity->name ?? null;
                $well->power = $well->datalogger->power ?? null;
                $well->checkCodes = $well->datalogger->checkCodes;
                $well->powerCheckCode = $well->datalogger->powerCheckCode ?? null;
                $well->dataloggerLastStatus = $well->datalogger->dataloggerLastStatus() ?? null;
                $well->pumps = null;
                $well->sources = $well->sources ?? null;

                return $well;
            });

        $pumps = Pump::with([
            'datalogger.industrialCity',
            'datalogger.checkCodes',
            'datalogger.powerCheckCode',
            'datalogger.messages',
            'sources',

        ])
            ->select('id', 'mobile_number', 'name')
            ->get()
            ->map(function ($pump) {
                $pump->dataloggerId = $pump->datalogger->id;
                $pump->type = 'پمپ';
                $pump->industrial_city_name = $pump->datalogger->industrialCity->name ?? null;
                $pump->power = $pump->datalogger->power ?? null;
                $pump->checkCodes = $pump->datalogger->checkCodes->map(function ($checkCode) {
                    return [
                        'code' => $checkCode->code,
                        'description' => $checkCode->description,
                    ];
                });
                $pump->powerCheckCode = $pump->datalogger->powerCheckCode;
                $pump->dataloggerLastStatus = $pump->datalogger->dataloggerLastStatus();
                $pump->well = null;
                $pump->sources = $well->sources ?? null;

                return $pump;
            });

        $equipments = $sources->merge($wells)->merge($pumps);



        return view('app.data-logger.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (auth()->user()->hasRole('SuperAdmin')) {
            $roles = Role::all();
            $industrials = IndustrialCity::all();
        } else {
            $roles = Role::where('name', '!=', 'SuperAdmin')->get();
            $industrials = IndustrialCity::whereHas('users')->get();
        }
        return view('app.data-logger.create', compact('industrials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataLoggerRequest $request)
    {

        $inputs = $request->all();
        $entity = null;

        switch ($request['entity_type']) {
            case 'source':
                $entity = Source::create([

                    'industrial_city_id' => $inputs['industrial_city_id'],
                    'name' => $inputs['name'],
                    'sensor_type' => $inputs['sensor_type'],
                    'fount_height' => $inputs['fount_height'],
                    'fount_bulk' => $inputs['fount_bulk'],
                    'mobile_number' => $inputs['mobile_number'],
                    'datalogger_model' => $inputs['datalogger_model'],
                    'status'  => $inputs['status']


                ]);
                break;
            case 'well':
                $entity = Well::create([

                    'industrial_city_id' => $inputs['industrial_city_id'],
                    'name' => $inputs['name'],
                    'yearly_bulk' => $inputs['yearly_bulk'],
                    'flow_rate' => $inputs['flow_rate'],
                    'mobile_number' => $inputs['mobile_number'],
                    'datalogger_model' => $inputs['datalogger_model'],
                    'status'  => $inputs['status']

                ]);
                break;
            case 'pump':
                $entity = Pump::create([

                    'industrial_city_id' => $inputs['industrial_city_id'],
                    'name' => $inputs['name'],
                    'mobile_number' => $inputs['mobile_number'],
                    'datalogger_model' => $inputs['datalogger_model'],
                    'status'  => $inputs['status']

                ]);
                break;
        }

        $entity->datalogger()->create([
            'industrial_city_id' => $inputs['industrial_city_id'],
            'mobile_number' => $inputs['mobile_number'],
            'status'  => $inputs['status']

        ]);

        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Datalogger $device)
    {

        $checkCodes = CheckCode::all();
        $pumps = Pump::all();
        $wells = Well::all();

        if (auth()->user()->hasRole('SuperAdmin')) {

            $industrials = IndustrialCity::all();
        } else {

            $industrials = IndustrialCity::whereHas('users')->get();
        }
        return view('app.data-logger.edit', compact('device', 'checkCodes', 'industrials', 'pumps', 'wells'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DataLoggerRequest $request, Datalogger $device)
    {


        $inputs = $request->all();

        DB::beginTransaction();

        try {
            // به‌روزرسانی مقادیر عمومی
            $device->update([
                'industrial_city_id' => $inputs['industrial_city_id'],
                'mobile_number' => $request->mobile_number,
                'power' => $request->power,
            ]);

            // به‌روزرسانی مقادیر خاص
            switch (class_basename($device->dataloggerable_type)) {
                case 'Pump':
                    $device->dataloggerable->update([
                        'industrial_city_id' => $inputs['industrial_city_id'],
                        'name' => $inputs['name'],
                        'sensor_type' => $inputs['sensor_type'],
                        'fount_height' => $inputs['fount_height'],
                        'fount_bulk' => $inputs['fount_bulk'],
                        'mobile_number' => $inputs['mobile_number'],
                        'datalogger_model' => $inputs['datalogger_model'],
                        'status'  => $inputs['status']
                    ]);
                    break;

                case 'Well':
                    $device->dataloggerable->update([
                        'industrial_city_id' => $inputs['industrial_city_id'],
                        'name' => $inputs['name'],
                        'yearly_bulk' => $inputs['yearly_bulk'],
                        'flow_rate' => $inputs['flow_rate'],
                        'mobile_number' => $inputs['mobile_number'],
                        'datalogger_model' => $inputs['datalogger_model'],
                    ]);
                    break;

                case 'Source':
                    $device->dataloggerable->update([
                        'industrial_city_id' => $inputs['industrial_city_id'],
                        'name' => $inputs['name'],
                        'sensor_type' => $inputs['sensor_type'],
                        'fount_height' => $inputs['fount_height'],
                        'fount_bulk' => $inputs['fount_bulk'],
                        'mobile_number' => $inputs['mobile_number'],
                        'datalogger_model' => $inputs['datalogger_model'],
                    ]);

                    $device->dataloggerable->wells()->sync($inputs['wells'] ?? []);
                    $device->dataloggerable->pumps()->sync($inputs['pumps'] ?? []);
                    break;
            }

            $device->checkCodes()->sync($request->checkCode);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('app.data-logger.edit', $device)->with('alert-section-error', ' .ویرایش با خطا مواجه شد');
            // something went wrong
        }



        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز  با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datalogger $device)
    {

        $device->delete();
        return redirect()->route('app.data-logger.index')->with('swal-success', 'تجهیز  با موفقیت حذف شد');
    }

    public function status(Datalogger $device)
    {


        $device->status = $device->status == 0 ? 1 : 0;
        $result = $device->save();
        if ($result) {
            if ($device->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    // public function checkCode(Datalogger $device)
    // {
    //     $checkCodes = CheckCode::all();
    //     return view('app.data-logger.check-code', compact('device', 'checkCodes'));
    // }

    // public function checkCodeStore(Request $request, Datalogger $device)
    // {
    //     $request->validate([
    //         'checkCode' => 'required|exists:check_codes,id|array'
    //     ]);

    //     $device->checkCodes()->sync($request->checkCode);
    //     return redirect()->route('app.data-logger.index')->with('swal-success', ' چک کد با موفقیت ویرایش شد');
    // }


}
