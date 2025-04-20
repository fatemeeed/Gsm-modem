<?php


namespace App\Http\Services\Message;

use App\Exceptions\GSMConnectionNotFoundException;
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
    protected $buffer;
    private $strReply = "";

    private function __construct()
    {
        $setting = Setting::where('status', '1')->first();


        if (!$setting) {

            throw new GSMConnectionNotFoundException('تنظیمات پورت یا باند مشخص نشده است.');
        }

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
                throw new GSMConnectionNotFoundException('امکان اتصال به مودم فراهم نیست ، لطفا پورت را چک کنید');
            }

            // تلاش برای باز کردن پورت
            $this->fp = fopen($this->port, "r+");
            if (!$this->fp) {
                error_log("Failed to open port: " . $this->port);
                throw new GSMConnectionNotFoundException("اتصال به پورت امکان پذیر نیست", 500);
            }

            stream_set_timeout($this->fp, 2);
        } catch (GSMConnectionNotFoundException $e) {
            throw $e;
            return back()->withError('امکان اتصال به مودم فراهم نیست ، لطفا پورت را چک کنید');
        }
    }

    public function sendATCommand($command, $delay = 2000000)
{
    if (!$this->fp || !is_resource($this->fp)) {
        $this->gsmConnection();
    }

    if (!$this->fp) {
        throw new GSMConnectionNotFoundException("اتصال به پورت امکان پذیر نیست");
    }

    fputs($this->fp, "$command\r");
    usleep($delay); // تأخیر اولیه

    $response = '';
    $timeout = time() + 5; // حداکثر 5 ثانیه منتظر پاسخ می‌مانیم
    while (time() < $timeout) {
        $buffer = fgets($this->fp, 128);
        if ($buffer === false) break;
        
        $response .= $buffer;
        if (strpos($buffer, "OK") !== false || strpos($buffer, "ERROR") !== false) {
            break;
        }

        usleep(500000); // نیم ثانیه وقفه قبل از خواندن مجدد
    }

    fclose($this->fp);
    return trim($response);
}


    public function read()
    {
        
        //$this->strReply = $this->sendATCommand("AT+CMGL=\"REC UNREAD\"");
        $this->strReply = $this->sendATCommand("AT+CMGL=\"ALL\"");


        $arrMessages = explode("+CMGL:", $this->strReply);



        return $arrMessages;
    }

    public function send($tel, $message)
{
    $tel = preg_replace("%[^0-9\+]%", '', $tel);
    $message = preg_replace("%[^\040-\176\r\n\t]%", '', $message);

    error_log("Setting text mode...");
    $status = $this->sendATCommand("AT+CMGF=1", 1000000);
    error_log("Text mode response: " . $status);

    if (!$status || strpos($status, 'OK') === false) {
        throw new Exception('Unable to set text mode');
    }

    error_log("Sending CMGS command...");
    $response = $this->sendATCommand("AT+CMGS=\"{$tel}\"", 1000000);
    error_log("CMGS Response: " . $response);

    if (strpos($response, '>') === false) {
        error_log("Error: Did not receive '>' prompt");
        return false;
    }

    error_log("Sending message content...");
    $response = $this->sendATCommand($message, 2000000);
    error_log("Message Sent Response: " . $response);

    error_log("Sending CTRL+Z...");
    $response = $this->sendATCommand(chr(26), 5000000);
    error_log("Final Send Response: " . $response);

    if (strpos($response, 'OK') !== false) {
        return true;
    }

    error_log("Message sending failed. Response: " . $response);
    return false;
}




    public function deleteMessage($index = null)
    {
        usleep(100000);

        try {

            $this->sendATCommand("AT+CMGF=1", 1000000); // تنظیم به حالت متنی

            // تست دستورات مختلف برای حافظه پیامک
            $memoryResponse = $this->sendATCommand("AT+CPMS?");
            error_log("Memory Check Response: " . $memoryResponse);


            // ادامه حذف پیام حتی اگر حافظه قابل شناسایی نباشد
            usleep(500000);

            $command = "AT+CMGD=1,4";  // حذف همه پیام‌ها
            $response = $this->sendATCommand($command, 2000000);
            usleep(500000);

            error_log("Delete Response: " . $response);

            if (strpos($response, 'OK') !== false) {
                return true;
            } else {
                throw new GSMConnectionNotFoundException('خطا در حذف پیام');
            }
        } catch (\Exception $e) {
            error_log("Delete Message Error: " . $e->getMessage());
            return false; // ادامه برنامه حتی اگر حذف پیام خطا داشته باشد
        }
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
