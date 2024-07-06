<?php

namespace App\Http\Services\Message;

class DestroyMessage extends ConnectService{

    public function destroy()
    {
        fputs($this->fp, "AT+CMGD=\"?\"\r");
       
        //fputs($this->fp, "AT+CMGL=\"ALL\"\r");

    
        //Wait for confirmation
        $status = $this->wait_reply("OK\r\n> ", 5);

        return $status;

    }

   


}