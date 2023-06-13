<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertReference");
    $server->Register("editReference");
    $server->Register("changeStateReference");
    $server->Register("listReferences");
    $server->Register("listReferencesSubscription");
    $server->Register("listReferencesRequest");
    $server->Register("test");
    $server->Register("test2");
    $server->start();

    function insertReference($arg){
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
        $tableNameReference = "";
        $nameSpaceReference = ""; 
        $descriptionReference = "";
        $valueReference = "";
        $statusReference = "";
        if(isset($arg->tableNameReference)){
            $tableNameReference =  $arg->tableNameReference;
        }else{
            array_push($errorlist,"Error: falta parametro tableNameReference");
        }
        if(isset($arg->nameSpaceReference)){
            $nameSpaceReference =  $arg->nameSpaceReference;
        }else{
            array_push($errorlist,"Error: falta parametro nameSpaceReference");
        }
        if(isset($arg->descriptionReference)){
                $descriptionReference =  $arg->descriptionReference;
        }else{
            array_push($errorlist,"Error: falta parametro descriptionReference");
        }
        if(isset($arg->valueReference)){
            $valueReference =  $arg->valueReference;
        }else{
            array_push($errorlist,"Error: falta parametro valueReference");
        }
        if(isset($arg->statusReference)){
            $statusReference =  $arg->statusReference;
        }else{
            array_push($errorlist,"Error: falta parametro statusReference");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }
        $tableNameReference = $arg->tableNameReference ;
        $nameSpaceReference = $arg->nameSpaceReference; 
        $descriptionReference = $arg->descriptionReference;
        $valueReference = $arg->valueReference;
        $statusReference = $arg->statusReference;

        $_reference = new reference($_db);
        $responseInsert = $_reference->insertReferenceDb($tableNameReference,$nameSpaceReference,$descriptionReference,$valueReference,$statusReference);
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


    function editReference($arg){
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
        $idReference =  "";
        $tableNameReference = "";
        $nameSpaceReference = ""; 
        $descriptionReference = "";
        $valueReference = "";
        $statusReference = "";

        if(isset($arg->idReference)){
            $idReference =  $arg->idReference;
        }else{
            array_push($errorlist,"Error: falta parametro idReference");
        }
        if(isset($arg->tableNameReference)){
            $tableNameReference =  $arg->tableNameReference;
        }else{
            array_push($errorlist,"Error: falta parametro tableNameReference");
        }
        if(isset($arg->nameSpaceReference)){
            $nameSpaceReference =  $arg->nameSpaceReference;
        }else{
            array_push($errorlist,"Error: falta parametro nameSpaceReference");
        }
        if(isset($arg->descriptionReference)){
                $descriptionReference =  $arg->descriptionReference;
        }else{
            array_push($errorlist,"Error: falta parametro descriptionReference");
        }
        if(isset($arg->valueReference)){
            $valueReference =  $arg->valueReference;
        }else{
            array_push($errorlist,"Error: falta parametro valueReference");
        }
        if(isset($arg->statusReference)){
            $statusReference =  $arg->statusReference;
        }else{
            array_push($errorlist,"Error: falta parametro statusReference");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idReference =  $arg->idReference;
        $tableNameReference = $arg->tableNameReference ;
        $nameSpaceReference = $arg->nameSpaceReference; 
        $descriptionReference = $arg->descriptionReference;
        $valueReference = $arg->valueReference;
        $statusReference = $arg->statusReference;

        $_reference = new reference($_db);
        $responseEdit = $_reference->editReferenceDb($idReference, $tableNameReference, $nameSpaceReference, $descriptionReference, $valueReference, $statusReference);
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

    function changeStateReference($arg){
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
        $idReference =  "";
        $statusReference = "";
        if(isset($arg->idReference)){
            $idReference =  $arg->idReference;
        }else{
            array_push($errorlist,"Error: falta parametro idReference");
        }
        if(isset($arg->statusReference)){
            $statusReference =  $arg->statusReference;
        }else{
            array_push($errorlist,"Error: falta parametro statusReference");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idReference =  $arg->idReference;
        $statusReference = $arg->statusReference;

        $_reference = new reference($_db);
        $responseDelete = $_reference->changeStateReferenceDb($idReference, $statusReference);

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

    function listReferences($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $tableNameReference = $arg->tableNameReference ;
        $nameSpaceReference = $arg->nameSpaceReference;

        $_reference = new reference($_db);
        $responseList = $_reference->listReferencesDb($tableNameReference, $nameSpaceReference);

        if ( $responseList) {
            $mensaje = "Se listo correctamente a las personas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan personas"));
            $mensaje = "No se pudo listara a las personas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listReferencesSubscription($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $tableNameReference = $arg->tableNameReference ;
        $nameSpaceReference = $arg->nameSpaceReference;

        $_reference = new reference($_db);
        $responseList = $_reference->listReferencesSuscripcionDb($tableNameReference, $nameSpaceReference);

        if ( $responseList) {
            $mensaje = "Se listo correctamente a las personas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan personas"));
            $mensaje = "No se pudo listara a las personas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listReferencesRequest($arg){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $tableNameReference = $arg->tableNameReference ;
        $nameSpaceReference = $arg->nameSpaceReference;

        $_reference = new reference($_db);
        $responseList = $_reference->listReferencesSolicitudDb($tableNameReference, $nameSpaceReference);

        if ( $responseList) {
            $mensaje = "Se listo correctamente a las personas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan personas"));
            $mensaje = "No se pudo listara a las personas - Funcion: ".__FUNCTION__;
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
    