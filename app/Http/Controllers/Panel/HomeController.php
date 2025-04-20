<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Message;
use App\Models\IndustrialCity;
use App\Models\CheckCode;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Http\Services\Message\GSMConnection;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{


	public function index(GSMConnection $Connection, Request $request)
	{
		
		
		//return view('app.index', compact('dataloggers'));

		// پیش‌بارگذاری داده‌ها برای بهبود عملکرد
		$industrialCities = IndustrialCity::whereHas('sources', function ($query) {
			$query->whereHas('pumps.datalogger')->orWhereHas('wells.datalogger')->orWhereHas('datalogger');
		})->with([
			'sources.pumps.datalogger',
			'sources.wells.datalogger',
			'sources.datalogger'
		])->get();
		

	

		// پردازش داده‌ها برای هر شهر
		$data = $industrialCities->map(function ($city) {
			$nodes = collect(); // استفاده از Collection برای مدیریت بهتر
			$links = collect();

			$currentVolum = $availableStorage = $capacity = $totalFlowRate = 0;

			foreach ($city->sources as $source) {


				

				$level = isset($source->datalogger->lastCheckStatus['level'])
					? substr($source->datalogger->lastCheckStatus['level'], 0, 1)
					: 0;


				$capacity += $source->fount_bulk;

				$currentVolum += $source->fount_bulk * ($level / 4);


				// افزودن منبع به نودها
				$nodes->push([
					'id' => "source-{$source->id}",
					'dataloggerId' => $source->datalogger->id,
					'group' => 'source',
					'label' => $source->name,
					'status' => $source->datalogger->dataloggerLastStatus(), // روشن یا خاموش
					'level' => $source->datalogger->sourceVolumePercentage(), // سطح آب منبع
					'lastMessageTime' => optional(optional($source->datalogger)->lastRecieveMessage())->time ?? '',

				]);

				foreach ($source->pumps as $pump) {
					// افزودن پمپ‌ها
					$nodes->push([
						'id' => "pump-{$pump->id}",
						'dataloggerId' => $pump->datalogger->id,
						'group' => 'pump',
						'label' => $pump->name,
						'status' => $pump->datalogger->dataloggerLastStatus() ?? '', // روشن یا خاموش
						'lastMessageTime' => optional(optional($pump->datalogger)->lastRecieveMessage())->time ?? '',

					]);

					// ایجاد ارتباط بین منبع و پمپ
					$links->push([
						'source' => "source-{$source->id}",
						'target' => "pump-{$pump->id}"
					]);
				}

				foreach ($source->wells as $well) {

					$totalFlowRate += $well->flow_rate;

					$availableStorage += strtolower($well->datalogger->dataloggerLastStatus() ) == 'on' ? $well->flow_rate : '0';                    // افزودن چاه‌ها
					$nodes->push([
						'id' => "well-{$well->id}",
						'dataloggerId' => $well->datalogger->id,
						'group' => 'well',
						'label' => $well->name,
						'status' => $well->datalogger->dataloggerLastStatus(), // روشن یا خاموش
						'lastMessageTime' => optional(optional($well->datalogger)->lastRecieveMessage())->time ?? '',

					]);

					// ایجاد ارتباط بین منبع و چاه
					$links->push([
						'source' => "source-{$source->id}",
						'target' => "well-{$well->id}"
					]);
				}
			}

			return [
				'cityName' => $city->name,
				'nodes' => $nodes->unique('id')->values(), // حذف نودهای تکراری
				'links' => $links,
				'currentVolum' => $currentVolum,
				'availableStorage' => $availableStorage,
				'capacity' => $capacity,
				'totalFlowRate' => $totalFlowRate
			];
		});
		// ارسال داده‌ها به ویو
		return view('app.index', compact('data'));
	}

	// public function readMessage(GSMConnection $Connection)
	// {


	// 	$arrMessages = $Connection->read();
	// 	$Connection->deleteMessage();
	// 	$strJunk = array_shift($arrMessages);

	// 	// set return array
	// 	$arrReturn = array();

	// 	// check that we have messages
	// 	if (is_array($arrMessages) && !empty($arrMessages)) {
	// 		// for each message
	// 		foreach ($arrMessages as $arrMessage) {
	// 			// split content from metta data
	// 			$arrMessage	= explode("\n", $arrMessage, 2);
	// 			$strMetta	= trim($arrMessage[0]);
	// 			$arrMetta	= explode(",", $strMetta);

	// 			// set the message array to go in the return array
	// 			$arrReturnMessage = array();

	// 			// set the message values to return
	// 			$arrReturnMessage['Id']			= trim($arrMetta[0], "\"");
	// 			$arrReturnMessage['Status']		= trim($arrMetta[1], "\"");
	// 			$arrReturnMessage['From']		= str_replace('+98', '0', trim($arrMetta[2], "\""));
	// 			$arrReturnMessage['Date']		= trim($arrMetta[4], "\"");
	// 			$arrTime						= explode("+", $arrMetta[5], 2);
	// 			$arrReturnMessage['Time']		= trim($arrTime[0], "\"");

	// 			// add message to return array
	// 			$arrReturn[] = $arrReturnMessage;

	// 			$datalogger = Datalogger::where('mobile_number', $arrReturnMessage['From'])->first();

	// 			if ($datalogger) {

	// 				$strContent	= trim($arrMessage[1]);
	// 				$messageArray1 = [];


	// 				// dd($strContent);
	// 				$messageArray1 = $datalogger->parseMessage($strContent);

	// 				$lastStatus = $datalogger->last_status ?? [];



	// 				// بررسی و به‌روزرسانی وضعیت‌ها
	// 				foreach ($datalogger->checkCodes as $checkCode) {
	// 					if (isset($messageArray1[$checkCode->name]) && (!isset($lastStatus[$checkCode->name]) || $lastStatus[$checkCode->name] !== $messageArray1[$checkCode->name])) {
	// 						// فقط در صورتی که تغییر وجود داشته باشد، به‌روزرسانی می‌شود
	// 						$lastStatus[$checkCode->name] = $messageArray1[$checkCode->name];
	// 					}
	// 				}

	// 				if ($lastStatus) {
	// 					// به‌روزرسانی آخرین وضعیت و زمان آخرین به‌روزرسانی
	// 					$datalogger->lastCheckStatus = $lastStatus;

	// 					$datalogger->save();
	// 				}


	// 				Message::create([
	// 					'from'    => $datalogger->mobile_number,
	// 					'datalogger_id' => $datalogger->id,
	// 					'time'    => $arrReturnMessage['Date'] . ' ' . $arrReturnMessage['Time'],
	// 					'content' => $messageArray1,

	// 					'type'    => '1'
	// 				]);
	// 			}
	// 		}
	// 	}

	// 	return redirect()->route('app.index')->with('swal-success', 'بروزرسانی با موفقیت انجام شد');
	// }
}
