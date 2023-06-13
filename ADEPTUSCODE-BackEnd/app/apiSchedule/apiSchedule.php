<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertSchedule");
    $server->Register("listSchedule");
    $server->Register("changeSchedule");
    $server->start();

    function insertSchedule($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $startTime = microtime(true);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
        $respValidate = validateArg($arg);  
        if($respValidate){
            $arrLog = array("input"=>$arg,"output"=>$arg);
            $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
            $_log->notice($mensaje);
            return $respValidate;
        }

        $errorlist=array();
        $idPerson = "";
        $daySchedule =  "";
        $entrySchedule =  "";
        $departureSchedule =  "";


        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->daySchedule)){
                $daySchedule =  $arg->daySchedule;
        }
        else{
            array_push($errorlist,"Error: falta parametro daySchedule");
        }
        if(isset($arg->departureSchedule)){
            $formato = 'H:i:s';
            $fecha_valida = DateTime::createFromFormat($formato, $arg->departureSchedule);

            if ($fecha_valida !== false) {
                $departureSchedule =  $arg->departureSchedule;
            } else {
                array_push($errorlist,"Error: departureSchedule debe estar en el formato  H:i:s");
            }
        }
        else{
            array_push($errorlist,"Error: falta parametro departureSchedule");
        }
        if(isset($arg->entrySchedule)){
            $formato = 'H:i:s';
            $fecha_valida = DateTime::createFromFormat($formato, $arg->entrySchedule);

            if ($fecha_valida !== false) {
                $entrySchedule =  $arg->entrySchedule;
            } else {
                array_push($errorlist,"Error: entrySchedule debe estar en el formato  H:i:s");
            }
        }
        else{
            array_push($errorlist,"Error: falta parametro entrySchedule");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        
        $idPerson = $arg->idPerson;
        $daySchedule =  $arg->daySchedule;
        $entrySchedule =  $arg->entrySchedule;
        $departureSchedule =  $arg->departureSchedule;

        $_schedule = new schedule($_db);
        $responseInsert = $_schedule->insertScheduleDb($idPerson,$daySchedule,$entrySchedule,$departureSchedule);

        if ( $responseInsert) {
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }


    /*function editVehicle($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $startTime = microtime(true);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
        $respValidate = validateArg($arg);  
        if($respValidate){
            $arrLog = array("input"=>$arg,"output"=>$arg);
            $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
            $_log->notice($mensaje);
            return $respValidate;
        }

        $errorlist=array();
        $idVehicle =  "";
        $idPerson = "";
        $statusVehicle = "";
        $plateVehicle =  "";
        $modelVehicle =  "";
        $colorVehicle =  "";

        if(isset($arg->idVehicle)){
            $idVehicle =  $arg->idVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro idVehicle");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusVehicle)){
            $statusVehicle =  $arg->statusVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusVehicle");
        }
        if(isset($arg->plateVehicle)){
                $plateVehicle =  $arg->plateVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro plateVehicle");
        }
        if(isset($arg->modelVehicle)){
            $modelVehicle =  $arg->modelVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro modelVehicle");
        }
        if(isset($arg->colorVehicle)){
            $colorVehicle =  $arg->colorVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro colorVehicle");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idVehicle =  $arg->idVehicle;
        $idPerson = $arg->idPerson;
        $statusVehicle = $arg->statusVehicle;
        $plateVehicle =  $arg->plateVehicle;
        $modelVehicle =  $arg->modelVehicle;
        $colorVehicle =  $arg->colorVehicle;

        $_person = new vehicle($_db);
        $responseEdit = $_person->editVehicleDb($idVehicle, $idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle);

        if ( $responseEdit) {
            $response = array("codError" => 200, "data" => array("desError"=>"Cambios realizados con exito"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambios fallidos"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }*/

    function changeSchedule($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $startTime = microtime(true);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
        $respValidate = validateArg($arg);  
        if($respValidate){
            $arrLog = array("input"=>$arg,"output"=>$arg);
            $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
            $_log->notice($mensaje);
            return $respValidate;
        }

        $errorlist=array();
        $idSchedule =  "";
        $entrySchedule = "";
        $departureSchedule = "";

        if(isset($arg->idSchedule)){
            $idSchedule =  $arg->idSchedule;
        }else{
            array_push($errorlist,"Error: falta parametro idSchedule");
        }
        if(isset($arg->entrySchedule)){
            $entrySchedule =  $arg->entrySchedule;
        }
        else{
            array_push($errorlist,"Error: falta parametro entrySchedule");
        }
        if(isset($arg->departureSchedule)){
            $departureSchedule =  $arg->departureSchedule;
        }
        else{
            array_push($errorlist,"Error: falta parametro departureSchedule");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idSchedule =  $arg->idSchedule;
        $entrySchedule = $arg->entrySchedule;
        $departureSchedule = $arg->departureSchedule;

        $_schedule = new schedule($_db);
        $responseChange = $_schedule->changeScheduleDb($idSchedule, $entrySchedule, $departureSchedule);

        if ( $responseChange){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de horario exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de horario fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function listSchedule(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_schedule = new schedule($_db);
        $responseList = $_schedule->listScheduleDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los horarios - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan horarios"));
            $mensaje = "No se pudo listar los horarios - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }
    
    function validateArg($arg){
        $resp = false;
        if (!is_object($arg)) {
            $resp = array("codError" => 400, "data" =>array("desError"=>"Error en parametros") );
        }
        if (is_null($arg)) {
            $resp = array("codError" => 400, "data" =>array("desError"=>"Error parametros vacios"));
        }
        return $resp;
    }
    
    function test($arg) {    
        return array("codError" => 200, "data" => $arg);
    }

    function test2($arg) {    
        return array("codError" => 200, "data" => "Hola estamos en linea");
    }
    