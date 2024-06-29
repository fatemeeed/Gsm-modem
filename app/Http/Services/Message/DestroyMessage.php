<?php

namespace App\Http\Services\Message;
use App\Http\Services\Message\ConnectService;

class DestroyMessage extends ConnectService{

    public function destroy()
    {
        // fputs($this->fp, "AT+CMGDA=\"DEL READ\"\r");
        //fputs($this->fp, "AT+CMGL=\"ALL\"\r");

        fputs($this->fp, "AT+CMGD=\"?\"\r");
        //Wait for confirmation
        $status = $this->wait_reply("OK\r\n> ", 5);

        return $status;

    }

   


}