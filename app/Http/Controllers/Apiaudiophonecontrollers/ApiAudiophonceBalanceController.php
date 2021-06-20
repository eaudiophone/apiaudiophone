<?php

namespace App\Http\Controllers\ApiAudiophonecontrollers;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use App\Apiaudiophonemodels\ApiAudiophoneClient;
use App\Apiaudiophonemodels\ApiAudiophoneBalance;
use App\Traits\ApiResponserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiAudiophonceBalanceController extends Controller
{
    
    use ApiResponserTrait;

    /**
     * show ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function showApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

       // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'numeric|required',
            'stringsearch' => 'string|min:0|max:60',
            'start' => 'numeric',
            'end' => 'numeric' 
        ]);

       // :::: Obtenemos los valores del request :::: //

        $balance_data_show = $request->all();

        // :::: Obtenemos el numero de parámetros del arreglo :::: //

        $parameters_total = count($balance_data_show);

        // :::: Obtenemos el id del cliente :::: //

        $id_client_request = $balance_data_show['id_apiaudiophoneclients'];

        // :::: Obtenemos el stringsearch :::: //

        $string_client_request = $balance_data_show['stringsearch'];

        // :::: Obtenemos el start de la consulta :::: //

        $start_client_request = $balance_data_show['start'];

        // :::: Obtenemos el end de la consulta :::: //

        $end_client_request = $balance_data_show['end'];

        // :::: Obtenemos las keys del arreglo de parámetros de entrada :::: //

        $keys_balance_data_show = $this->arrayKeysRequest($balance_data_show);

        // :::: Obtenemos la cantidad de registros contables por cliente :::: //

        $count_balance_client = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)->count();

        // :::: Obtenemos el rol del usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // :::: asignamos la cantidad de registros por pagina :::: //

        $num_pag = 5;


        if($user_role == 'ADMIN_ROLE'){


           switch($count_balance_client)
           {

                case 0:

                    return $this->errorResponse('No existen registros contables para el cliente', 404);

                    break;
                default:

               if($parameters_total == 0){

                    return $this->errorResponse('Petición Inválida', 405);

                // :::: cuando trae un parámetro el request :::: //
                }elseif($parameters_total == 1){
 
                    $data_balance_show = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);

                // :::: cuando trae dos parámetros el request y con valor en cadena :::: //
                }elseif(($parameters_total == 2) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'stringsearch') && ($string_client_request)){


                    $data_balance_show = ApiAudiophoneBalance::where(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_desc', 'like', '%'.$string_client_request.'%'])
                    ->orWhere(['id_apiaudiophoneclients', $id_client_request], ['apiaudiophonebalances_date', 'like', '%'.$string_client_request.'%'])
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);    

                // :::: cuando trae dos parámetros el request y sin valor en cadena :::: //
                }elseif(($parameters_total == 2) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'stringsearch') && (!($string_client_request))){

                    $data_balance_show = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);
                
                // :::: cuando trae tres parámetros el request y con todos los valores del request :::: //
                }elseif(($parameters_total == 3) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'start') && ($keys_balance_data_show[2] == 'end') && ($start_client_request) && ($end_client_request)){


                    $data_balance_show = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->whereBetween('apiaudiophonebalances_id', [$start, $end])
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);
               
                // :::: cuando trae tres parámetros el request y sin valor en el end de la consulta:::: //
                }elseif(($parameters_total == 3) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'start') && ($keys_balance_data_show[2] == 'end') && ($start_client_request) && (!($end_client_request))){


                    $data_balance_show = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->whereBetween('apiaudiophonebalances_id', [$start, $end])
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);
               
                // :::: cuando trae tres parámetros el request y sin valor en el start de la consulta:::: //
                }elseif(($parameters_total == 3) && ($keys_balance_data_show[0] == 'id_apiaudiophoneclients') && ($keys_balance_data_show[1] == 'start') && ($keys_balance_data_show[2] == 'end') && (!($start_client_request)) && ($end_client_request)){


                    $data_balance_show = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)
                    ->whereBetween('apiaudiophonebalances_id', [$start, $end])
                    ->orderBy('apiaudiophonebalances_id', 'desc')
                    ->paginate($num_pag);

                    return $this->successResponseApiaudiophoneBalanceShow(true, 200, $data_client_show);
                
                }else{

                }
            }
        }else{

            return $this->errorResponse('Usuario no autorizado para consultar registros contables', 401);
        }
    }

    /**
     * create ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function createApiaudiophoneBalance(Request $request, $id_apiaudiophoneusers = null){

        // :::: Validación del Request :::: //

        $this->validate($request, [

            'id_apiaudiophoneclients' => 'numeric|required'
        ]);

        // :::: Obtenemos el ID del cliente :::: //

        $id_client_request = $request['id_apiaudiophoneclients'];

        // :::: Obtenemos la cantidad de registros de balance por usuario :::: //

        $count_balance_client = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)->count();

        // :::: Obtenemos el rol del usuario :::: //

        $user = ApiAudiophoneUser::userbalance($id_apiaudiophoneusers)->first();

        $user_role = $user->apiaudiophoneusers_role;

        // ::: Asignamos el numero de páginas a consultar :::: //

        $num_pag = 5;


        // :::: GESTIONAMOS LA CONSULTA CORRESPONDIENTE :::: //

        if($user_role == 'ADMIN_ROLE'){

            switch($count_balance_client){

                case 0:

                    return $this->errorResponse('No existen registros para el cliente: '.$user->apiaudiophoneusers_fullname, 404);
                break
                
                default:

                // :::: Consultamos registros creados para ese cliente :::: //

                $data_balance_create = ApiAudiophoneBalance::where('id_apiaudiophoneclients', $id_client_request)->paginate($num_pag);

                return $this->successResponseApiaudiophoneBalanceCreate(true, 200, $data_balance_create);
            }
        }else{

            return $this->errorResponse('Usuario no autorizado para consultar Clientes', 401);
        }
    }





    /**
     * store ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function storeApiaudiophoneBalance(){

    }




    /**
     * update ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function updateApiaudiophoneBalance(){

    }



    /**
     * destroy ApiAudiophoneBalance Instance 
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
    */
    public function destroyApiaudiophoneBalance(){
        
    }


    // :::: Función que devuelve las llaves de un arreglo :::: //

    public function arrayKeysRequest(array $request_array){


        $array_keys = array_keys($request_array);

        return $array_keys;
    }


    // :::: Función que devuelve el start de la consulta por el show :::: //


    public function starValue($endvalue){

    }


    // :::: Función que devuelve el end de la consulta por el show :::: //

    public function endvalue($starValue){

    }
}
