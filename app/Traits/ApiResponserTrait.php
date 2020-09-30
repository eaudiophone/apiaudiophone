<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponserTrait
{

  /*
 * Responser de afirmacciones estándar
 *
 */
  public function successResponse($data, $code){

  
    return response()->json([

      'data' => $data,
      'code' => $code
    ], $code);
  }

 /*
 * Responser de afirmacciones estándar para ApiaudiophoneUser
 *
 */
  public function successResponseApiaudiophoneUser($ok = true, $code, $bduserstotal, $apiaudiophoneuserdata){

  
    return response()->json([

      'ok' => $ok,
      'status' => $code,
      'bduserstotal' => $bduserstotal,
      'apiaudiophoneuserdata' => $apiaudiophoneuserdata
    ], $code);
  }

  /*
 * Responser de afirmacciones estándar para ApiaudiophoneUser
 *
 */
  public function successResponseApiaudiophoneUserCount($ok = true, $code, $bduserstotal, $apiaudiophoneusercount, $apiaudiophoneuserdata){

  
    'ok' => $ok,
    'status' => $code,
    'bduserstotal' => $bduserstotal,
    'apiaudiophoneusercount' => $apiaudiophoneusercount,
    'apiaudiophoneuserdata' => $apiaudiophoneuserdata
    ], $code);
  }

  /*
 * Responser de afirmacciones estándar para ApiaudiophoneUser
 *
 */
  public function successResponseApiaudiophoneUserStore($ok = null, $code, $apiaudiophoneusermessage, $apiaudiophoneusernew){

  
    return response()->json([

        'ok' => $ok,
        'status' => $code,
        'apiaudiophoneusermessage' => $apiaudiophoneusermessage,
        'apiaudiophoneusernew' => $apiaudiophoneusernew
      ], $code);
  }

 /*
 * Responser de afirmacciones estándar para ApiaudiophoneTerm
 *
 */
  public function successResponseApiaudiophoneTerm($ok = null, $code, $apiaudiophoneterm_mesaage, $apiaudiophoneservices_name, $days_events_array, $apiaudiophonetermshowdata){

  
    return response()->json([

      'ok' => $ok, 
      'status' => $code,
      'apiaudiophoneterm_mesaage' => $apiaudiophoneterm_mesaage,
      'apiaudiophoneservices_name' => $apiaudiophoneservices_name,
      'days_events_array' => $days_events_array, 
      'apiaudiophonetermshowdata' => $apiaudiophonetermshowdata                
    ], $code);
  }

  /*
 * Responser de afirmacciones estándar para ApiaudiophoneTerm
 *
 */
  public function successResponseApiaudiophoneTermDestroy($ok = null, $code, $apiaudiophoneterm_mesaage, $termconfiguration_last){

  
    return response()->json([

      'ok' => $ok,
      'status' => $code,
      'apiaudiophonetermdelete' => $apiaudiophoneterm_mesaage,
      'termconfiguration_last' => $termconfiguration_last
    ], $code);
  }

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

  /*
 * Responser de afirmacciones estándar para ApiaudiophoneUser
 *
 */
  public function errorResponseApiaudiophoneUser($ok = true, $code, $bduserstotal, $apiaudiophoneusermessage){

  
    return response()->json([

      'ok' => $ok,
      'status' => $code,
      'bduserstotal' => $bduserstotal,
      'apiaudiophoneusermessage' => $apiaudiophoneusermessage
    ], $code);
  }

 /*
 * Responser de error estándar para ApiaudiophoneTerm
 *
 */
  public function errorResponseApiaudiophoneUserUpdate($ok = null, $code, $apiaudiophoneusermessage, $apiaudiophoneuserinactive){

  
    return response()->json([

      'ok' => $ok,
      'status' => $code,
      'apiaudiophoneusermessage' => $apiaudiophoneusermessage,
      'apiaudiophoneuserinactive' => $apiaudiophoneuserinactive
    ], $code);
  }

 /*
 * Responser de errores estándar para ApiaudiophoneTerm
 *
 */
  public function errorResponseApiaudiophoneTerm($ok = null, $code, $apiaudiophoneterm_mesaage){

  
    return response()->json([

        'ok' => $ok, 
        'status' => $code,
        'apiaudiophoneterm_mesaage' => $apiaudiophoneterm_mesaage
      ], $code);
  }

 /*
 * Responser de errores estándar para ApiaudiophoneTerm
 *
 */
  public function errorResponseApiaudiophoneTermShow($ok = null, $code, $apiaudiophoneterm_mesaage, $apiaudiophoneuser_status, $apiaudiophoneusers_fullname){

  
    return response()->json([

      'ok' => $ok,
      'status' => $code,
      'apiaudiophoneusermessage' => $apiaudiophoneterm_mesaage,
      'apiaudiophoneuser_status' => $apiaudiophoneuser_status, 
      'apiaudiophoneusers_fullname' => $apiaudiophoneusers_fullname
    ], $code);
  }

  /*
 * Responser de afirmacion estándar para ApiaudiophoneTermDestroy
 *
 */
  public function errorResponseApiaudiophoneUserDestroy($ok = null, $code, $apiaudiophoneterm_mesaage){

  
    return response()->json([

        'ok' => $ok, 
        'status' => $code,
        'apiaudiophoneterm_mesaage' => $apiaudiophoneterm_mesaage
      ], $code);
  }

 /*
 * Responser de afirmacion estándar para ApiaudiophoneTermDestroy
 *
 */
  public function errorResponseApiaudiophoneTermDestroy($ok = null, $code, $apiaudiophoneterm_mesaage){

  
    return response()->json([

        'ok' => $ok, 
        'status' => $code,
        'apiaudiophoneterm_mesaage' => $apiaudiophoneterm_mesaage
      ], $code);
  }

}
