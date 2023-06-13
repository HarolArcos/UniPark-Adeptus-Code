<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertPersonHasRol");
    $server->Register("listPersonHasRol");
    $server->Register("listDataRolWhitTypePerson");
    $server->Register("editPersonHasRol");
    $server->Register("deletePersonHasRol");
    $server->start();

    function insertPersonHasRol($arg){
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
        $idRol = "";


        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPerson = $arg->idPerson;
        $idRol = $arg->idRol;

        $_personHasRol = new person_has_rol($_db);
        $responseInsert = $_personHasRol->insertPersonHasRolDb($idPerson,$idRol);

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


    function editPersonHasRol($arg){
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
        $idPersonHasRol =  "";
        $idPerson = "";
        $idRol = "";

        if(isset($arg->idPersonHasRol)){
            $idPersonHasRol =  $arg->idPersonHasRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPersonHasRol");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }
        else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPersonHasRol =  $arg->idPersonHasRol;
        $idPerson = $arg->idPerson;
        $idRol = $arg->idRol;

        $_personHasRol = new person_has_rol($_db);
        $responseEdit = $_personHasRol->editPersonHasRolDb($idPersonHasRol, $idPerson,$idRol);

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

    function deletePersonHasRol($arg){
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
        $idPersonHasRol =  "";

        if(isset($arg->idPersonHasRol)){
            $idPersonHasRol =  $arg->idPersonHasRol;
        }else{
            array_push($errorlist,"Error: falta parametro idPersonHasRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idPersonHasRol =  $arg->idPersonHasRol;

        $_personHasRol = new person_has_rol($_db);
        $responseDelete = $_personHasRol->deletePersonHasRolDb($idPersonHasRol);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"eliminacion exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"eliminacion fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function listPersonHasRol(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_personHasRol = new person_has_rol($_db);
        $responseList = $_personHasRol->listPersonHasRolDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan personas con roles asignados en persona_has_rol"));
            $mensaje = "No se pudo listara a persona_has_rol - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listDataRolWhitTypePerson($arg){
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
        $typePerson =  "";

        
        if(isset($arg->typePerson)){
            $typePerson =  $arg->typePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro typePerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $typePerson =  $arg->typePerson;

        $_subscription = new person_has_rol($_db);
        $responseList = $_subscription->listDataRolWhitTypePersonDb($typePerson);

        if ( $responseList){
            $response = array("codError" => 200, "data" => array("desError"=>"Listado exitoso de datos de rol"));
            $mensaje = "Listado exitoso de sitios ocupados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido de rol segun el tipo de persona"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
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
    