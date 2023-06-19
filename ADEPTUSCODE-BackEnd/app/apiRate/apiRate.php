<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertRate");
    $server->Register("listRate");
    $server->Register("listRateInactive");
    $server->Register("listRateActive");
    $server->Register("editRate");
    $server->Register("changeStateRate");
    $server->start();

    function insertRate($arg){
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
        $statusRate = "";
        $nameRate =  "";
        $valueRate =  "";
        $routeRate = "";
        $dateExpirationRate = "";


        if(isset($arg->statusRate)){
            $statusRate =  $arg->statusRate;
        }else{
            array_push($errorlist,"Error: falta parametro statusRate");
        }
        if(isset($arg->nameRate)){
                $nameRate =  $arg->nameRate;
        }else{
            array_push($errorlist,"Error: falta parametro nameRate");
        }
        if(isset($arg->valueRate)){
            $valueRate =  $arg->valueRate;
        }else{
            array_push($errorlist,"Error: falta parametro valueRate");
        }
        if(isset($arg->routeRate)){
            $routeRate =  $arg->routeRate;
        }else{
            array_push($errorlist,"Error: falta parametro routeRate");
        }
        if(isset($arg->dateExpirationRate)){
            $dateExpirationRate =  $arg->dateExpirationRate;
        }else{
            array_push($errorlist,"Error: falta parametro dateExpirationRate");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $statusRate = $arg->statusRate;
        $nameRate =  $arg->nameRate;
        $valueRate =  $arg->valueRate;
        $routeRate =  $arg->routeRate;
        $dateExpirationRate = $arg->dateExpirationRate;

        $_rate = new rate($_db);
        $responseInsert = $_rate->insertRateDb($statusRate,$nameRate,$valueRate, $routeRate, $dateExpirationRate);

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


    function editRate($arg){
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
        $idRate = "";
        $statusRate = "";
        $nameRate =  "";
        $valueRate =  "";
        $routeRate = "";

        if(isset($arg->idRate)){
            $idRate =  $arg->idRate;
        }else{
            array_push($errorlist,"Error: falta parametro idRate");
        }
        if(isset($arg->statusRate)){
            $statusRate =  $arg->statusRate;
        }else{
            array_push($errorlist,"Error: falta parametro statusRate");
        }
        if(isset($arg->nameRate)){
                $nameRate =  $arg->nameRate;
        }else{
            array_push($errorlist,"Error: falta parametro nameRate");
        }
        if(isset($arg->valueRate)){
            $valueRate =  $arg->valueRate;
        }else{
            array_push($errorlist,"Error: falta parametro valueRate");
        }
        if(isset($arg->routeRate)){
            $routeRate =  $arg->routeRate;
        }else{
            array_push($errorlist,"Error: falta parametro valueRate");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idRate = $arg->idRate;
        $statusRate = $arg->statusRate;
        $nameRate =  $arg->nameRate;
        $valueRate =  $arg->valueRate;
        $routeRate = $arg->routeRate;

        $_rate = new rate($_db);
        $responseEdit = $_rate->editRateDb($idRate,$statusRate,$nameRate,$valueRate, $routeRate);

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
    
    function changeStateRate($arg){
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
        $idRate =  "";
        $statusRate = "";

        if(isset($arg->idRate)){
            $idRate =  $arg->idRate;
        }else{
            array_push($errorlist,"Error: falta parametro idRate");
        }
        if(isset($arg->statusRate)){
            $statusRate =  $arg->statusRate;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRate");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idRate =  $arg->idRate;
        $statusRate = $arg->statusRate;

        $_rate = new rate($_db);
        $responseDelete = $_rate->changeStateRateDb($idRate, $statusRate);

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

    function listRate(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_rate = new rate($_db);
        $responseList = $_rate->listRateDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las tarifas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan tarifas"));
            $mensaje = "No se pudo listara a las tarifas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listRateActive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_rate = new rate($_db);
        $responseList = $_rate->listRateActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las tarifas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan tarifas activas"));
            $mensaje = "No se pudo listara a las tarifas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listRateInactive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_rate = new rate($_db);
        $responseList = $_rate->listRateInactiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las tarifas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan tarifas inactivas"));
            $mensaje = "No se pudo listara a las tarifas - Funcion: ".__FUNCTION__;
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
    