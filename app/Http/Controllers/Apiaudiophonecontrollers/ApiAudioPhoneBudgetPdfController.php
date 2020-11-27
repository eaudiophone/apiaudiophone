<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiAudioPhoneBudgetPdfController extends Controller
{
    
    public function showApiAudioPhoneBudgetPdf()
    {

    	return view('datos_empresa');
    }
}
