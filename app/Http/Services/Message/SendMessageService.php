<?php

namespace App\Http\Services\Message;

use App\Http\Services\Message\ConnectService;

class SendMessageService extends ConnectService{

     
    public function send($tel, $message) {

        //Filter tel
        $tel = preg_replace("%[^0-9\+]%", '', $tel);

        //Filter message text
        $message = preg_replace("%[^\040-\176\r\n\t]%", '', $message);

        $this->debugmsg("Sending message \"{$message}\" to \"{$tel}\"");

        //Start sending of message
        fputs($this->fp, "AT+CMGS=\"{$tel}\"\r");

        //Wait for confirmation
        $status = $this->wait_reply("\r\n> ", 5);

        if (!$status) {
            //throw new Exception('Did not receive confirmation from modem');
            $this->debugmsg('Did not receive confirmation from modem');
            return false;
        }

        //Send message text
        fputs($this->fp, $message);

        //Send message finished indicator
        fputs($this->fp, chr(26));

        //Wait for confirmation
        $status = $this->wait_reply("OK\r\n", 180);

        if (!$status) {
            //throw new Exception('Did not receive confirmation of messgage sent');
            $this->debugmsg('Did not receive confirmation of messgage sent');
            return false;
        }

        $this->debugmsg("Message sent");

        return true;
    }


}