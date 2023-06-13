<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertRolHasOption");
    $server->Register("listRolHasOption");
    $server->Register("editRolHasOption");
    $server->Register("deleteRolHasOption");
    $server->Register("resetRolHasOptionWhitRolId");
    $server->start();

    function insertRolHasOption($arg){
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
        $idOption = "";
        



        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(isset($arg->idOption)){
            $idOption =  $arg->idOption;
        }else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idRol = $arg->idRol;
        $idOption = $arg->idOption;
        

        $_RolHasOption = new rol_has_option($_db);
        $responseInsert = $_RolHasOption->insertRolHasOptionDb($idRol,$idOption);

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


    function editRolHasOption($arg){
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
        $idRolHasOption =  "";
        $idOption = "";
        $idRol = "";

        if(isset($arg->idRolHasOption)){
            $idRolHasOption =  $arg->idRolHasOption;
        }else{
            array_push($errorlist,"Error: falta parametro idRolHasOption");
        }
        if(isset($arg->idOption)){
            $idOption =  $arg->idOption;
        }else{
            array_push($errorlist,"Error: falta parametro idOption");
        }
        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idRolHasOption =  $arg->idRolHasOption;
        $idOption = $arg->idOption;
        $idRol = $arg->idRol;

        $_RolHasOption = new rol_has_option($_db);
        $responseEdit = $_RolHasOption->editRolHasPersonDb($idRolHasOption, $idOption,$idRol);
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

    function deleteRolHasOption($arg){
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
        $idRolHasOption =  "";
        if(isset($arg->idRolHasOption)){
            $idRolHasOption =  $arg->idRolHasOption;
        }else{
            array_push($errorlist,"Error: falta parametro idRolHasOption");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idRolHasOption =  $arg->idRolHasOption;
        $_RolHasOption = new rol_has_option($_db);
        $responseDelete = $_RolHasOption->deleteRolHasOptionDb($idRolHasOption);
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

    function resetRolHasOptionWhitRolId($arg){
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
        if(isset($arg->idRol)){
            $idRol =  $arg->idRol;
        }else{
            array_push($errorlist,"Error: falta parametro idRol");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idRol =  $arg->idRol;
        $_RolHasOption = new rol_has_option($_db);
        $responseDelete = $_RolHasOption->deleteRolHasOptionWhitRolIdDb($idRol);
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

    function listRolHasOption(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_RolHasOption = new rol_has_option($_db);
        $responseList = $_RolHasOption->listRolHasOptionDb();

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
