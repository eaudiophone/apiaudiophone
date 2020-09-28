<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponserTrait
{
  
  /*
   * Responser de Errores para Credenciales Vencidas
   *
   */
  	public function errorResponse($message, $code){

  	
	  	return response()->json([

	  		'errorMessage' => $message,
	  		'code' => $code
	  	], $code);
  	}
}
