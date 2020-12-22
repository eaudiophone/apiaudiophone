<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Http\Controllers\Controller;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudioPhoneBudgetPdfController extends Controller
{
    
    public function createApiAudioPhoneBudgetPdf()
    {

      	$pdf = app('dompdf.wrapper');
		$pdf->loadView('budgetview.presupuesto');
		return $pdf->stream();


    	//$pdf = PDF::loadView();

    	//return view('budgetview.presupuesto');
    }

    /**
	 * show ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/
    public function showApiaudiophoneBudget(Request $request, $id_apiaudiophoneusers = null)
	{

	}

	/**
	 * store ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/
	public function storeApiaudiophoneBudget(Request $request, $id_apiaudiophoneusers = null)
	{


		


	}

	/**
	 * update ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/
	public function updateApiaudiophoneBudget(Request $request, $id_apiaudiophoneusers = null)
	{

	}


	/**
	 * destroy ApiaudiophoneItems Instance	
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response 
	*/
	public function destroyApiaudiophoneBudget(Request $request, $id_apiaudiophoneusers = null)
	{

	}


}
