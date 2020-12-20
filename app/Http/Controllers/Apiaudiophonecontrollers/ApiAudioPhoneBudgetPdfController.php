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

    	dd('hola');

    	$pdf = app('dompdf.wrapper');
		$pdf->loadView('budgetview.presupuesto');
		return $pdf->stream();


    	//$pdf = PDF::loadView();

    	//return view('budgetview.presupuesto');
    }
}
