<?php

namespace App\Http\Controllers\Apiaudiophonecontrollers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudioPhoneBudgetPdfController extends Controller
{
    
    public function showApiAudioPhoneBudgetPdf()
    {

    	return view('budgetview.presupuesto');
    }
}
