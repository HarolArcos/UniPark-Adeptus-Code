<?php
    include('autoload.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertUser");
    $server->Register("test");
    $server->Register("test2");
    $server->start();

    function insertUser($arg){
        $startTime = microtime(true);
        $_db=new db(CONNECTION);
        $_log = new log(LOGLEVEL,LOGPATH);
        $respValidate = validateArg($arg);  
        if($respValidate){
            $arrLog = array("input"=>$arg,"output"=>$arg);
            $_log->notice(__FUNCTION__,$arrLog);
            return $respValidate;
        }

        $errorlist=array();
        $idUser =  "";
        $nameUser =  "";
        $userNameUser =  "";
        $emailUser =  "";
        $positionUser="";

        if(isset($arg->idUser)){
            $idUser =  $arg->idUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro idUser");
        }
        if(isset($arg->nameUser)){
            $nameUser =  $arg->nameUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro nameUser");
        }
        if(isset($arg->userNameUser)){
                $userNameUser =  $arg->userNameUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro userNameUser");
        }
        if(isset($arg->emailUser)){
            $emailUser =  $arg->emailUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro emailUser");
        }
        if(isset($arg->positionUser)){
            $positionUser =  $arg->positionUser;
        }
        else{
            array_push($errorlist,"Error: falta parametro positionUser");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idUser =  $arg->idUser;
        $nameUser =  $arg->nameUser;
        $userNameUser =  $arg->userNameUser;
        $emailUser =  $arg->emailUser;
        $positionUser =  $arg->positionUser;

        $_user = new user($_db,$_log);
        $responseInsert = $_user->insertUserDb($idUser,$nameUser,$userNameUser,$emailUser,$positionUser);

        if ( $responseInsert) {
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $_log->notice(__FUNCTION__,$arrLog);
        return $response;
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
    