<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertRequest");
    $server->Register("listRequest");
    $server->Register("listRequestInProgress");
    $server->Register("changeStateRequest");
    $server->start();

    function insertRequest($arg){
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
        $statusRequest = "";
        $idPerson = "";
        $issueRequest =  "";
        $textRequest =  "";
        $dateRequest =  "";


        if(isset($arg->statusRequest)){
            $statusRequest =  $arg->statusRequest;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRequest");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->issueRequest)){
                $issueRequest =  $arg->issueRequest;
        }
        else{
            array_push($errorlist,"Error: falta parametro issueRequest");
        }
        if(isset($arg->textRequest)){
            $textRequest =  $arg->textRequest;
        }
        else{
            array_push($errorlist,"Error: falta parametro textRequest");
        }
        if(isset($arg->dateRequest)){
            $formato = 'Y-m-d H:i:s';
            $fecha_valida = DateTime::createFromFormat($formato, $arg->dateRequest);

            if ($fecha_valida !== false) {
                $dateRequest =  $arg->dateRequest;
            } else {
                array_push($errorlist,"Error: dateRequest debe estar en el formato  Y-m-d H:i:s");
            }
        }
        else{
            array_push($errorlist,"Error: falta parametro dateRequest");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        
        $statusRequest = $arg->statusRequest;
        $idPerson = $arg->idPerson;
        $issueRequest =  $arg->issueRequest;
        $textRequest =  $arg->textRequest;
        $dateRequest =  $arg->dateRequest;

        $_request = new request($_db);
        $responseInsert = $_request->insertRequestDb($statusRequest, $idPerson,$issueRequest,$textRequest,$dateRequest);

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


    /*function editVehicle($arg){
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

        $_person = new vehicle($_db);
        $responseEdit = $_person->editVehicleDb($idVehicle, $idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle);

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
    }*/

    function changeStateRequest($arg){
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
        $idRequest =  "";
        $statusRequest = "";

        if(isset($arg->idRequest)){
            $idRequest =  $arg->idRequest;
        }else{
            array_push($errorlist,"Error: falta parametro idRequest");
        }
        if(isset($arg->statusRequest)){
            $statusRequest =  $arg->statusRequest;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusRequest");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idRequest =  $arg->idRequest;
        $statusRequest = $arg->statusRequest;

        $_request = new request($_db);
        $responseDelete = $_request->changeStateRequestDb($idRequest, $statusRequest);

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

    
    function listRequest(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_request = new request($_db);
        $responseList = $_request->listRequestDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las solicitudes - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan solicitudes"));
            $mensaje = "No se pudo listar las solicitudes - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listRequestInProgress(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_request = new request($_db);
        $responseList = $_request->listRequestInProgressDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las solicitudes en proceso - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan solicitudes en proceso"));
            $mensaje = "No se pudo listar las solicitudes en proceso - Funcion: ".__FUNCTION__;
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
    