<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertVehicle");
    $server->Register("listVehicle");
    $server->Register("test");
    $server->Register("test2");
    $server->Register("editVehicle");
    $server->Register("changeStateVehicle");
    $server->start();

    function insertVehicle($arg){
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
        $statusVehicle = "";
        $plateVehicle =  "";
        $modelVehicle =  "";
        $colorVehicle =  "";


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

        $idPerson = $arg->idPerson;
        $statusVehicle = $arg->statusVehicle;
        $plateVehicle =  $arg->plateVehicle;
        $modelVehicle =  $arg->modelVehicle;
        $colorVehicle =  $arg->colorVehicle;

        $_plateVehicle = new vehicle($_db);
        $responseFind = $_plateVehicle->findPlateVehicleDb($plateVehicle);

        if($responseFind){
            $_vehicle = new vehicle($_db);
            $responseInsert = $_vehicle->insertVehicleDb($idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle);

            if ( $responseInsert) {
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
            }else{
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
            }
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe la placa"));
        }

        

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }


    function editVehicle($arg){
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


        $_plateVehicle = new vehicle($_db);
        $responseFind = $_plateVehicle->findPlateVehicleEDb($idVehicle, $plateVehicle);

        if($responseFind){
            $responseEdit = $_plateVehicle->editVehicleDb($idVehicle, $idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle);

            if ( $responseEdit) {
                $response = array("codError" => 200, "data" => array("desError"=>"Cambios realizados con exito"));
            }else{
                $response = array("codError" => 200, "data" => array("desError"=>"Cambios fallidos"));
            }
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe la placa"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeStateVehicle($arg){
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
        $statusVehicle = "";

        if(isset($arg->idVehicle)){
            $idVehicle =  $arg->idVehicle;
        }else{
            array_push($errorlist,"Error: falta parametro idVehicle");
        }
        if(isset($arg->statusVehicle)){
            $statusVehicle =  $arg->statusVehicle;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusVehicle");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idVehicle =  $arg->idVehicle;
        $statusVehicle = $arg->statusVehicle;

        $_vehicle = new vehicle($_db);
        $responseDelete = $_vehicle->changeStateVehicleDb($idVehicle, $statusVehicle);

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

    function listVehicle(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_vehicle = new vehicle($_db);
        $responseList = $_vehicle->listVehicleActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a las personas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan vehiculos"));
            $mensaje = "No se pudo listara a los vehiculos - Funcion: ".__FUNCTION__;
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
    