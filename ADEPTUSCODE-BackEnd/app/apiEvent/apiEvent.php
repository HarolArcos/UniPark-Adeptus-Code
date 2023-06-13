<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertEvent");
    $server->Register("listEvent");
    $server->Register("editEvent");
    $server->Register("changeTypeEvent");
    $server->start();

    function insertEvent($arg){
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
        $idVehicle = "";
        $typeEvent = "";
        //$dateEvent =  "";
        $alarmEvent =  "";
        $descriptionEvent =  "";
        $registerUser = "";


        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->idVehicle)){
            $idVehicle =  $arg->idVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro idVehicle");
        }
        if(isset($arg->typeEvent)){
                $typeEvent =  $arg->typeEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro typeEvent");
        }
        if(isset($arg->alarmEvent)){
            $alarmEvent =  $arg->alarmEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro alarmEvent");
        }
        if(isset($arg->registerUser)){
            $registerUser =  $arg->registerUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro registerUser");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPerson = $arg->idPerson;
        $idVehicle = $arg->idVehicle;
        $typeEvent = $arg->typeEvent;
        //$dateEvent =  $arg->dateEvent;
        $alarmEvent =  $arg->alarmEvent;
        $descriptionEvent =  $arg->descriptionEvent;
        $registerUser = $arg->registerUser;

        $_event = new event($_db);
        $responseInsert = $_event->insertEventDb($idPerson, $idVehicle, $typeEvent,$alarmEvent,$descriptionEvent, $registerUser);

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


    function editEvent($arg){
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
        $idEvent =  "";
        $idPerson = "";
        $idVehicle = "";
        $typeEvent = "";
        //$dateEvent =  "";
        $alarmEvent =  "";
        $descriptionEvent =  "";
        $registerUser = "";

        
        if(isset($arg->idEvent)){
            $idEvent =  $arg->idEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro idEvent");
        }
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
        if(isset($arg->typeEvent)){
            $typeEvent =  $arg->typeEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro typeEvent");
        }
        if(isset($arg->alarmEvent)){
            $alarmEvent =  $arg->alarmEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro alarmEvent");
        }
        if(isset($arg->registerUser)){
            $registerUser =  $arg->registerUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro registerUser");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idEvent =  $arg->idEvent;
        $idPerson = $arg->idPerson;
        $idVehicle = $arg->idVehicle;
        $typeEvent = $arg->typeEvent;
        //$dateEvent =  $arg->dateEvent;
        $alarmEvent =  $arg->alarmEvent;
        $descriptionEvent =  $arg->descriptionEvent;
        $registerUser = $arg->registerUser;

        $_event = new event($_db);
        $responseEdit = $_event->editEventDb($idEvent, $idPerson, $idVehicle,$typeEvent,$alarmEvent,$descriptionEvent, $registerUser);

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
    }

    function changeTypeEvent($arg){
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
        $idEvent =  "";
        $typeEvent = "";

        if(isset($arg->idEvent)){
            $idEvent =  $arg->idEvent;
        }else{
            array_push($errorlist,"Error: falta parametro idEvent");
        }
        if(isset($arg->typeEvent)){
            $typeEvent =  $arg->typeEvent;
        }
        else{
            array_push($errorlist,"Error: falta parametro typeEvent");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idEvent =  $arg->idEvent;
        $typeEvent = $arg->typeEvent;

        $_event = new event($_db);
        $responseDelete = $_event->changeTypeEventDb($idEvent, $typeEvent);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de estado exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de estado fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function listEvent(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_event = new event($_db);
        $responseList = $_event->listEventDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los eventos - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan eventos"));
            $mensaje = "No se pudo listara los eventos - Funcion: ".__FUNCTION__;
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
    