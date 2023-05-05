<?php
    include('autoload.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertRol");
    $server->Register("listRol");
    $server->Register("editRol");
    $server->Register("changeStateRol");
    $server->start();

    function insertRol($arg){
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
        $statusRol = "";
        $nameRol =  "";
        $descriptionRol =  "";


        if(isset($arg->statusRol)){
            $statusRol =  $arg->statusRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRol");
        }
        if(isset($arg->nameRol)){
                $nameRol =  $arg->nameRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro nameRol");
        }
        if(isset($arg->descriptionRol)){
            $descriptionRol =  $arg->descriptionRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro descriptionRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $statusRol = $arg->statusRol;
        $nameRol =  $arg->nameRol;
        $descriptionRol =  $arg->descriptionRol;

        $_rol = new rol($_db);
        $responseInsert = $_rol->insertRolDb($statusRol,$nameRol,$descriptionRol);

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


    function editRol($arg){
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
        $idRol = "";
        $statusRol = "";
        $nameRol =  "";
        $descriptionRol =  "";

        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(isset($arg->statusRol)){
            $statusRol =  $arg->statusRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRol");
        }
        if(isset($arg->nameRol)){
                $nameRol =  $arg->nameRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro nameRol");
        }
        if(isset($arg->descriptionRol)){
            $descriptionRol =  $arg->descriptionRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro descriptionRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idRol = $arg->idRol;
        $statusRol = $arg->statusRol;
        $nameRol =  $arg->nameRol;
        $descriptionRol =  $arg->descriptionRol;

        $_rol = new rol($_db);
        $responseEdit = $_rol->editRolDb($idRol,$statusRol,$nameRol,$descriptionRol);

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

    function changeStateRol($arg){
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
        $idRol =  "";
        $statusRol = "";

        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(isset($arg->statusRol)){
            $statusRol =  $arg->$statusRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idRol =  $arg->idRol;
        $statusRol = $arg->statusRol;

        $_rol = new rol($_db);
        $responseDelete = $_rol->changeStateRolDb($idRol, $statusRol);

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

    function listRol(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_rol = new rol($_db);
        $responseList = $_rol->listRolDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los roles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan roles"));
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
    