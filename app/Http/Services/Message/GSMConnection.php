<?php


namespace App\Http\Services\Message;

use Exception;
use App\Models\Setting;
use PhpParser\Node\Stmt\TryCatch;
use PHPUnit\Runner\Extension\Extension;

class GSMConnection
{
    private static $gsmConnectionInstance = null;
    private $debug;
    private $port;
    private $baud;
    public $fp;
    protected $buffer="";
    private $strReply = "";

    private function __construct()
    {
        $setting = Setting::first();

        $this->port = $setting->port;
        $this->baud = $setting->baud_rate;
        $this->gsmConnection();
    }

    public static function getGSMConnectionInstance()
    {

        if (self::$gsmConnectionInstance == null) {
            self::$gsmConnectionInstance = new GSMConnection();
        }

        return self::$gsmConnectionInstance;

       
    }

    private function gsmConnection()
    {

        try {
            exec("MODE {$this->port}: BAUD={$this->baud} PARITY=N DATA=8 STOP=1", $output, $retval);
            if ($retval != 0) {
                throw new Exception('Unable to setup COM port, check it is correct');
            }
        } catch (Extension $e) {
            throw new Exception('error gsm connection');
        }
    }

    public function sendATCommand($command, $delay = 500000)
    {
        $fp = @fopen($this->port, "r+");
        if (!$fp) {
            throw new Exception("Failed to open serial port");
        }

        fputs($fp, "$command\r");
        usleep($delay);

        $response = '';
        while ($buffer = fgets($fp, 128)) {
            $response .= $buffer;
            if (strpos($buffer, "OK") !== false || strpos($buffer, "ERROR") !== false) {
                break;
            }
        }

        fclose($fp);
        return $response;
    }

    public function read()
    {
        $this->fp = @fopen($this->port, "r+");
        if (!$this->fp) {
            throw new Exception("Failed to open serial port");
        }

        fputs($this->fp, "AT+CMGF=1\r"); // Set to text mode
        usleep(500000);

        fputs($this->fp, "AT+CMGL=\"REC UNREAD\"\r");
        $this->wait_reply("OK\r\n> ", 5);
    
        // get the messages as an array
        $arrMessages = explode("+CMGL:", $this->strReply);
        return $arrMessages;
    }

    protected function wait_reply($expected_result, $timeout) {
        // clear reply cache
		$this->strReply = "";

        //Clear buffer
        $this->buffer = '';

        //Set timeout
        $timeoutat = time() + $timeout;

        //Loop until timeout reached (or expected result found)
        do {

            // $this->debugmsg('Now: ' . time() . ", Timeout at: {$timeoutat}");

            $buffer = fread($this->fp, 1024);
            $this->buffer .= $buffer;

            usleep(200000);//0.2 sec
            // $this->debugmsg("Received: {$buffer}");

                $strReply = "";
            // get response
		
			$strReply 		 = $buffer;
			$this->strReply	.= $strReply;
		

            //Check if received expected responce
            if (preg_match('/'.preg_quote($expected_result, '/').'$/', $this->buffer)) {
               
                return true;
                //break;
            } else if (preg_match('/\+CMS ERROR\:\ \d{1,3}\r\n$/', $this->buffer)) {
                return false;
            }

        } while ($timeoutat > time());

        // $this->debugmsg('Timed out');

        return false;

    }

    

    public function send($tel, $message)
    {

        //Filter tel
        $tel = preg_replace("%[^0-9\+]%", '', $tel);

        //Filter message text
        $message = preg_replace("%[^\040-\176\r\n\t]%", '', $message);
        

        $this->sendATCommand("AT+CMGF=1\r"); // Set to text mode

        $this->sendATCommand("AT+CMGS=\"{$tel}\"\r");

        //Send message text
       return  $this->sendATCommand($message . chr(26));

        //Send message finished indicator

    }




    //Setup COM port
    // public function init()
    // {

    //     // $this->debugmsg("Setting up port: \"{$this->port} @ \"{$this->baud}\" baud");

    //     exec("MODE {$this->port}: BAUD={$this->baud} PARITY=N DATA=8 STOP=1", $output, $retval);

    //     if ($retval != 0) {
    //         throw new Exception('Unable to setup COM port, check it is correct');
    //     }

    //     $this->debugmsg(implode("\n", $output));

    //     $this->debugmsg("Opening port");

    //     //Open COM port
    //     $this->fp = fopen($this->port . ':', 'r+');

    //     //Check port opened
    //     if (!$this->fp) {
    //         throw new Exception("Unable to open port \"{$this->port}\"");
    //     }

    //     $this->debugmsg("Port opened");
    //     $this->debugmsg("Checking for responce from modem");

    //     //Check modem connected
    //     fputs($this->fp, "AT\r");

    //     //Wait for ok
    //     $status = $this->wait_reply("OK\r\n", 5);

    //     if (!$status) {
    //         throw new Exception('Did not receive responce from modem');
    //     }

    //     $this->debugmsg('Modem connected');

    //     //Set modem to SMS text mode
    //     $this->debugmsg('Setting text mode');
    //     fputs($this->fp, "AT+CMGF=1\r");

    //     $status = $this->wait_reply("OK\r\n", 5);

    //     if (!$status) {
    //         throw new Exception('Unable to set text mode');
    //     }

    //     $this->debugmsg('Text mode set');
    // }

    //Wait for reply from modem
    // protected function wait_reply($expected_result, $timeout)
    // {
    //     // clear reply cache
    //     $this->strReply = "";

    //     $this->debugmsg("Waiting {$timeout} seconds for expected result");

    //     //Clear buffer
    //     $this->buffer = '';

    //     //Set timeout
    //     $timeoutat = time() + $timeout;

    //     //Loop until timeout reached (or expected result found)
    //     do {

    //         // $this->debugmsg('Now: ' . time() . ", Timeout at: {$timeoutat}");

    //         $buffer = fread($this->fp, 1024);
    //         $this->buffer .= $buffer;

    //         usleep(200000); //0.2 sec
    //         // $this->debugmsg("Received: {$buffer}");

    //         $strReply = "";
    //         // get response

    //         $strReply          = $buffer;
    //         $this->strReply    .= $strReply;


    //         //Check if received expected responce
    //         if (preg_match('/' . preg_quote($expected_result, '/') . '$/', $this->buffer)) {
    //             $this->debugmsg('Found match');
    //             return true;
    //             //break;
    //         } else if (preg_match('/\+CMS ERROR\:\ \d{1,3}\r\n$/', $this->buffer)) {
    //             return false;
    //         }
    //     } while ($timeoutat > time());

    //     // $this->debugmsg('Timed out');

    //     return false;
    // }

    //Print debug messages
    // protected function debugmsg($message)
    // {

    //     if ($this->debug == true) {
    //         $message = preg_replace("%[^\040-\176\n\t]%", '', $message);
    //         echo $message . "\n";
    //     }
    // }

    //Close port
    // private function close()
    // {

    //     $this->debugmsg('Closing port');

    //     fclose($this->fp);
    // }
}
