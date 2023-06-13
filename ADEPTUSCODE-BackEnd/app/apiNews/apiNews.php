<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertNews");
    $server->Register("listNews");
    $server->Register("listNewsActive");
    $server->Register("editNews");
    $server->Register("changeStateNews");
    $server->start();

    function insertNews($arg){
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
        $statusNews = "";
        $lastPerson =  "";
        $titleNews =  "";
        $textNews =  "";


        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusNews)){
            $statusNews =  $arg->statusNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusNews");
        }
        if(isset($arg->lastPerson)){
            $lastPerson =  $arg->lastPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastPerson");
        }
        if(isset($arg->titleNews)){
            $titleNews =  $arg->titleNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro titleNews");
        }
        if(isset($arg->textNews)){
            $textNews =  $arg->textNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro textNews");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPerson = $arg->idPerson;
        $statusNews = $arg->statusNews;
        $lastPerson =  $arg->lastPerson;
        $titleNews =  $arg->titleNews;
        $textNews =  $arg->textNews;

        
            $_news = new news($_db);
            $responseInsert = $_news->insertNewsDb($idPerson,$statusNews,$lastPerson,$titleNews,$textNews);

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


    function editNews($arg){
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
        $idNews =  "";
        $statusNews = "";
        $lastPerson =  "";
        $titleNews =  "";
        $textNews =  "";

        if(isset($arg->idNews)){
            $idNews =  $arg->idNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro idNews");
        }
        
        if(isset($arg->statusNews)){
            $statusNews =  $arg->statusNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusNews");
        }
        if(isset($arg->lastPerson)){
            $lastPerson =  $arg->lastPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastPerson");
        }
        if(isset($arg->titleNews)){
            $titleNews =  $arg->titleNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro titleNews");
        }
        if(isset($arg->textNews)){
            $textNews =  $arg->textNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro textNews");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idNews =  $arg->idNews;
        $statusNews = $arg->statusNews;
        $lastPerson =  $arg->lastPerson;
        $titleNews =  $arg->titleNews;
        $textNews =  $arg->textNews;


        $_news = new news($_db);
        $responseEdit = $_news->editNewsDb($idNews,$statusNews,$lastPerson,$titleNews,$textNews);

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

    function changeStateNews($arg){
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
        $idNews =  "";
        $statusNews = "";

        if(isset($arg->idNews)){
            $idNews =  $arg->$idNews;
        }else{
            array_push($errorlist,"Error: falta parametro idNews");
        }
        if(isset($arg->statusNews)){
            $statusNews =  $arg->statusNews;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusNews");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idNews =  $arg->idNews;
        $statusNews = $arg->statusNews;

        $_news = new news($_db);
        $responsechangeState = $_news->changeStateNewsDb($idNews, $statusNews);

        if ( $responsechangeState){
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

    function listNews(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_news = new news($_db);
        $responseList = $_news->listNewsDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las noticias - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan noticias"));
            $mensaje = "No se pudo listar las noticias - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listNewsActive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_news = new news($_db);
        $responseList = $_news->listNewsActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las noticias - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan noticias"));
            $mensaje = "No se pudo listar las noticias - Funcion: ".__FUNCTION__;
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
    