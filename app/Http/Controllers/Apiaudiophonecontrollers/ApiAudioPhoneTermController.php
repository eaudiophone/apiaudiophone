<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneTerm;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudioPhoneTermController extends Controller
{
	
	/**
	 *
	 * show ApiaudiophoneTerm instance.
	 *
	 @param \Illuminate\Http\Request $request
	 @param \Illuminate\Http\Response 
    *
    public function showApiAudiophoneTerm(Request $request, $id_apiaudiophoneusers) //pendiente el show
    {

    	//::::: Validación del Request :::::
    	$this->validate($request, [

        	'apiaudiophoneterms_quantityeventsweekly' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsmonthly' => 'required|numeric',
        	'apiaudiophoneterms_rankevents' => 'required|string|max:65',
        	'apiaudiophoneterms_daysevents' => 'array',
        	'apiaudiophoneterms_begintime' => 'required|date_format:H:i',
        	'apiaudiophoneterms_finaltime' => 'required|date_format:H:i'
    	]);

    	$apiaudiophonetermdata = $request->all();

    	dd($apiaudiophonetermdata, $id_apiaudiophoneusers);
    }*/




    /**
	 *
	 * store ApiaudiophoneTerm instance.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Illuminate\Http\Response 
    */
    public function storeApiAudiophoneTerm(Request $request, $id_apiaudiophoneusers)
    {

    	//::::: Validación del Request :::::
    	$this->validate($request, [

        	'apiaudiophoneterms_quantityeventsweekly' => 'required|numeric',
        	'apiaudiophoneterms_quantityeventsmonthly' => 'required|numeric',
        	'apiaudiophoneterms_rankevents' => 'required|string|max:65',
        	'apiaudiophoneterms_daysevents' => 'array',
        	'apiaudiophoneterms_begintime' => 'required|date_format:H:i',
        	'apiaudiophoneterms_finaltime' => 'required|date_format:H:i'
    	]);

    	
    	$apiaudiophonetermdata = $request->all();

    	dd($apiaudiophonetermdata, $id_apiaudiophoneusers);

    	$cantidad_dias = count($request->input('apiaudiophoneterms_daysevents'));


		$apiaudiophonetermnew = new ApiAudiophoneTerm;

		$apiaudiophonetermnew->id_apiaudiophoneusers = $id_apiaudiophoneusers;
		$apiaudiophonetermnew->apiaudiophoneterms_quantityeventsweekly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsweekly'];
		$apiaudiophonetermnew->apiaudiophoneterms_quantityeventsmonthly = $apiaudiophonetermdata['apiaudiophoneterms_quantityeventsmonthly'];
		$apiaudiophonetermnew->apiaudiophoneterms_rankevents = $apiaudiophonetermdata['apiaudiophoneterms_rankevents'];
		$apiaudiophonetermnew->apiaudiophoneterms_begintime = $apiaudiophonetermdata['apiaudiophoneterms_begintime'];
		$apiaudiophonetermnew->apiaudiophoneterms_finaltime = $apiaudiophonetermdata['apiaudiophoneterms_finaltime'];


		switch($cantidad_dias){

			case(1):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0');
				
				break;
			case(2):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1');
				
				break;
			case(3):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2');

				break;
			case(4):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3');

				break;
			case(5):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4');

				break;
			case(6):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5');

				break;
			case(7):

				$apiaudiophonetermnew->apiaudiophoneterms_daysevents = $request->input('apiaudiophoneterms_daysevents.0').', '.$request->input('apiaudiophoneterms_daysevents.1').', '.$request->input('apiaudiophoneterms_daysevents.2').', '.$request->input('apiaudiophoneterms_daysevents.3').', '.$request->input('apiaudiophoneterms_daysevents.4').', '.$request->input('apiaudiophoneterms_daysevents.5').', '.$request->input('apiaudiophoneterms_daysevents.6');

				break;
			default:

			$apiaudiophonetermnew->apiaudiophoneterms_daysevents = null;
		}


		//dd($apiaudiophonetermnew->apiaudiophoneterms_daysevents);

		$apiaudiophonetermnew->save();

		return response()->json([

			
		]);














    }
}
