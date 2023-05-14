<?php
    include('autoload.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertOption");
    $server->Register("editOption");
    $server->Register("listOption");
    $server->start();

    function insertOption($arg){
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
        $fatherOption = "";
        $orderOption =  "";
        $componentOption =  "";
        $statusOption = "";


        if(isset($arg->orderOption)){
                $orderOption =  $arg->orderOption;
        }else{
            array_push($errorlist,"Error: falta parametro orderOption");
        }
        if(isset($arg->componentOption)){
            $componentOption =  $arg->componentOption;
        }else{
            array_push($errorlist,"Error: falta parametro componentOption");
        }
        if(isset($arg->statusOption)){
            $statusOption =  $arg->statusOption;
        }else{
            array_push($errorlist,"Error: falta parametro statusOption");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $fatherOption = $arg->fatherOption;
        $orderOption =  $arg->orderOption;
        $componentOption =  $arg->componentOption;
        $statusOption = $arg->statusOption;

        $_option = new option($_db);
        $responseInsert = $_option->insertOptionDb($fatherOption,$orderOption,$componentOption,$statusOption);

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


    function editOption($arg){
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
        $idOption = "";
        $fatherOption = "";
        $orderOption =  "";
        $componentOption =  "";
        $statusOption = "";

        if(isset($arg->idOption)){
            $idOption =  $arg->idOption;
        }
        else{
            array_push($errorlist,"Error: falta parametro idOption");
        }
        if(isset($arg->orderOption)){
                $orderOption =  $arg->orderOption;
        }
        else{
            array_push($errorlist,"Error: falta parametro orderOption");
        }
        if(isset($arg->componentOption)){
            $componentOption =  $arg->componentOption;
        }
        else{
            array_push($errorlist,"Error: falta parametro componentOption");
        }
        if(isset($arg->statusOption)){
            $statusOption =  $arg->statusOption;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusOption");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idOption = $arg->idOption;
        $fatherOption = $arg->fatherOption;
        $orderOption =  $arg->orderOption;
        $componentOption =  $arg->componentOption;
        $statusOption = $arg->statusOption;

        $_option = new option($_db);
        $responseEdit = $_option->editOptionDb($idOption,$fatherOption,$orderOption,$componentOption,$statusOption);

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

    function listOption(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_Option = new Option($_db);
        $responseList = $_Option->listOptionDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a las opciones - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan opciones"));
            $mensaje = "No se pudo listara a las opciones - Funcion: ".__FUNCTION__;
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
    