<?php

namespace App\Http\Controllers\Panel;

use App\Models\Message;
use App\Models\Setting;
use App\Jobs\RecieveMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Services\Message\RecieveMessageService;

class HomeController extends Controller
{
    public function index()
    {
		// RecieveMessage::dispatch()->now();
        return view('app.index');
    }

	public function update()
    {

		$config=Setting::first();
        $recieveMessage=new RecieveMessageService();
        $recieveMessage->setDebug('true');
        $recieveMessage->setPort($config->port);
        $recieveMessage->setBaud($config->baud_rate);
		
        $recieveMessage->init();

        $arrMessages=$recieveMessage->read();
		
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
				$arrReturnMessage['Time']		= trim($arrMetta[4], "\"");
				// $arrTime						= explode("+", $arrMetta[5], 2);
				// $arrReturnMessage['Time']		= trim($arrTime[0], "\"");
				$arrReturnMessage['Content']	= trim($strContent);
				
	
				
				// add message to return array
				$arrReturn[] = $arrReturnMessage;

                Message::create([
                    'from'    => $arrReturnMessage['From'],
                    // 'date'    => $arrReturnMessage['Date'],
                    'time'    => $arrReturnMessage['Time'],
                    'content' => $arrReturnMessage['Content'],
                    'type'    => '1'
                ]);
			}
			
		}

        // Artisan::command('auto:recieveMessage');
        // $config=Setting::all();
        // $recieveMessage=new RecieveMessageService();
        // $recieveMessage->debug=true;
        // $recieveMessage->port=$config->port;
        // $recieveMessage->baud=$config->baud;
        // $recieveMessage->init();

        // $recieveMessage->read();
        // $strJunk = array_shift($arrMessages);
		
		// // set return array
		// $arrReturn = Array();
		
		// // check that we have messages
		// if (is_array($arrMessages) && !empty($arrMessages))
		// {
		// 	// for each message
		// 	foreach($arrMessages AS $strMessage)
		// 	{
		// 		// split content from metta data
		// 		$arrMessage	= explode("\n", $strMessage, 2);
		// 		$strMetta	= trim($arrMessage[0]);
		// 		$arrMetta	= explode(",", $strMetta);
		// 		$strContent	= trim($arrMessage[1]);
				
				
		// 		// set the message array to go in the return array
		// 		$arrReturnMessage = Array();
				
		// 		// set the message values to return
		// 		$arrReturnMessage['Id']			= trim($arrMetta[0], "\"");
		// 		$arrReturnMessage['Status']		= trim($arrMetta[1], "\"");
		// 		$arrReturnMessage['From']		= trim($arrMetta[2], "\"");
		// 		$arrReturnMessage['Date']		= trim($arrMetta[4], "\"");
		// 		$arrTime						= explode("+", $arrMetta[5], 2);
		// 		$arrReturnMessage['Time']		= trim($arrTime[0], "\"");
		// 		$arrReturnMessage['Content']	= trim($strContent);
				
	
				
		// 		// add message to return array
		// 		$arrReturn[] = $arrReturnMessage;

        //         $result=Message::create([
        //             'from'    => $arrReturnMessage['From'],
        //             'date'    => $arrReturnMessage['Date'],
        //             'time'    => $arrReturnMessage['Time'],
        //             'content' => $arrReturnMessage['Content'],
        //             'type'    => '0'
        //         ]);
		// 	}
            

           
			
			
		//}
        return redirect()->route('app.index')->with('swal-success', 'بروزرسانی با موفقیت انجام شد');
        
    }
}
