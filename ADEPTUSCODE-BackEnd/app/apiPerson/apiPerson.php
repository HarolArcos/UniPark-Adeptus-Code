<?php
    include('autoload.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertPerson");
    $server->Register("listPerson");
    $server->Register("test");
    $server->Register("test2");
    $server->Register("editPerson");
    $server->Register("changeStatePerson");
    $server->start();

    function insertPerson($arg){
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
        $typePerson = "";
        $namePerson =  "";
        $lastNamePerson =  "";
        $ciPerson =  "";
        $phonePerson= "";
        $telegramPerson = "";
        $statusPerson = "";
        $nicknamePerson = "";
        $passwordPerson = "";


        if(isset($arg->typePerson)){
            $typePerson =  $arg->typePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro typePerson");
        }
        if(isset($arg->namePerson)){
            $namePerson =  $arg->namePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro namePerson");
        }
        if(isset($arg->lastNamePerson)){
                $lastNamePerson =  $arg->lastNamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastNamePerson");
        }
        if(isset($arg->ciPerson)){
            $ciPerson =  $arg->ciPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro ciPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(isset($arg->nicknamePerson)){
            $nicknamePerson =  $arg->nicknamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro nicknamePerson");
        }
        if(isset($arg->passwordPerson)){
            $passwordPerson =  $arg->passwordPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro passwordPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));//ver tipos de errores 
        }

        #$idPerson =  $arg->idPerson;
        $typePerson = $arg->typePerson;
        $namePerson =  $arg->namePerson;
        $lastNamePerson =  $arg->lastNamePerson;
        $ciPerson =  $arg->ciPerson;
        $phonePerson= $arg->phonePerson;
        $telegramPerson = $arg->telegramPerson;
        $statusPerson = $arg->statusPerson;
        $nicknamePerson = $arg->nicknamePerson;
        $passwordPerson = $arg->passwordPerson;

        $_person = new person($_db);
        $responseInsert = $_person->insertPersonDb($typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, $statusPerson,$nicknamePerson,$passwordPerson);

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


    function editPerson($arg){
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
        $idPerson =  "";
        $typePerson = "";
        $namePerson =  "";
        $lastNamePerson =  "";
        $ciPerson =  "";
        $phonePerson= "";
        $telegramPerson = "";
        $statusPerson = "";
        $nicknamePerson = "";
        $passwordPerson = "";

        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }


        if(isset($arg->typePerson)){
            $typePerson =  $arg->typePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro typePerson");
        }
        if(isset($arg->namePerson)){
            $namePerson =  $arg->namePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro namePerson");
        }
        if(isset($arg->lastNamePerson)){
                $lastNamePerson =  $arg->lastNamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastNamePerson");
        }
        if(isset($arg->ciPerson)){
            $ciPerson =  $arg->ciPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro ciPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(isset($arg->nicknamePerson)){
            $nicknamePerson =  $arg->nicknamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro nicknamePerson");
        }
        if(isset($arg->passwordPerson)){
            $passwordPerson =  $arg->passwordPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro passwordPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));//ver tipos de errores 
        }

        $idPerson =  $arg->idPerson;
        $typePerson = $arg->typePerson;
        $namePerson =  $arg->namePerson;
        $lastNamePerson =  $arg->lastNamePerson;
        $ciPerson =  $arg->ciPerson;
        $phonePerson= $arg->phonePerson;
        $telegramPerson = $arg->telegramPerson;
        $statusPerson = $arg->statusPerson;
        $nicknamePerson = $arg->nicknamePerson;
        $passwordPerson = $arg->passwordPerson;

        $_person = new person($_db);
        $responseEdit = $_person->editPersonDb($idPerson,$typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, $statusPerson,$nicknamePerson,$passwordPerson);

        if ( $responseEdit) {
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

    function changeStatePerson($arg){
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
        $idPerson =  "";
        $statusPerson = "";

        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));//ver tipos de errores 
        }

        $idPerson =  $arg->idPerson;
        $statusPerson = $arg->statusPerson;

        $_person = new person($_db);
        $responseDelete = $_person->changeStatePersonDb($idPerson, $statusPerson);

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

    function listPerson(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseInsert = $_person->listPersonActiveDb();

        if ( $responseInsert) {
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
            $mensaje = "Se listo correctamente a las personas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
            $mensaje = "No se pudo listara a las personas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
        }
        
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
    