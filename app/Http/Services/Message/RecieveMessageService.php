<?php

namespace App\Http\Services\Message;

use App\Http\Services\Message\ConnectService;

class RecieveMessageService extends ConnectService{

     //Send message
   public function read() {

    //Filter tel
    $this->debugmsg("reading message ");
   

    //Start sending of message
    fputs($this->fp, "AT+CMGL=\"REC UNREAD\"\r");

    //Wait for confirmation
    $status = $this->wait_reply("OK\r\n> ", 5);

    // get the messages as an array
    $arrMessages = explode("+CMGL:", $this->strReply);
    
    // remove junk from the start of the array
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
            $strContent	= trim($arrMessage[0]);
            
            /* metta data format is:
             * 0	Id
             * 1	Status
             * 2	From
             * 3	?
             * 4	date
             * 5	time (with +offset)
             * 
             * values may have leading, trailing (or both) double quotes
             */
            
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
        }
    }
    
    // return messages array
    return $arrReturn;
}


}