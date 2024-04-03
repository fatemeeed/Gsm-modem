<?php

namespace App\Console\Commands;

use App\Http\Services\Message\RecieveMessageService;
use App\Jobs\ConnectModem;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Console\Command;

class RecieveMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:recieveMessage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    public $connect;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        

        $config=Setting::all();
        $recieveMessage=new RecieveMessageService();
        $recieveMessage->debug=true;
        $recieveMessage->port=$config->port;
        $recieveMessage->baud=$config->baud;
        $recieveMessage->init();

        $recieveMessage->read();
        $strJunk = array_shift($arrMessages);
		
		// set return array
		$arrReturn = Array();
		
		// check that we have messages
		if (is_array($arrMessages) && !empty($arrMessages))
		{
			// for each message
			foreach($arrMessages AS $strMessage)
			{
				// split content from metta data
				$arrMessage	= explode("\n", $strMessage, 2);
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

                $result=Message::create([
                    'from'    => $arrReturnMessage['From'],
                    'date'    => $arrReturnMessage['Date'],
                    'time'    => $arrReturnMessage['Time'],
                    'content' => $arrReturnMessage['Content'],
                    'type'    => '0'
                ]);
			}
			
			
			
			
		}
        
    }
}
