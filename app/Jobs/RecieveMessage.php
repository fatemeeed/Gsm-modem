<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\Message\GSMConnection;


class RecieveMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       
        $gsmConnection = app(GSMConnection::class);
		$arrMessages = $gsmConnection->read();
		
        $strJunk = array_shift($arrMessages);
		
		// set return array
		$arrReturn = Array();
		
		// check that we have messages
		if (is_array($arrMessages) && !empty($arrMessages))
		{
			// for each message
			foreach($arrMessages as $arrMessage)
			{
				// split content from metta data
				$arrMessage	= explode("\n", $arrMessage, 2);
				$strMetta	= trim($arrMessage[0]);
				$arrMetta	= explode(",", $strMetta);
				$strContent	= trim($arrMessage[1]);
				
				
				// set the message array to go in the return array
				$arrReturnMessage = Array();
				
				// set the message values to return
				$arrReturnMessage['Id']			= trim($arrMetta[0], "\"");
				$arrReturnMessage['Status']		= trim($arrMetta[1], "\"");
				$arrReturnMessage['From']		= trim($arrMetta[2], "\"");
				$arrReturnMessage['Date']		= trim($arrMetta[4], "\"");
				$arrTime						= explode("+", $arrMetta[5], 2);
				$arrReturnMessage['Time']		= trim($arrTime[0], "\"");
				$arrReturnMessage['Content']	= trim($strContent);
				
	
				
				// add message to return array
				$arrReturn[] = $arrReturnMessage;

                Message::create([
                    'from'    => $arrReturnMessage['From'],
                    // 'date'    => $arrReturnMessage['Date'],
                    'time'    => $arrReturnMessage['Date'].' '.$arrReturnMessage['Time'],
                    'content' => $arrReturnMessage['Content'],
                    'type'    => '1'
                ]);
			}
			
		}

    }
}
