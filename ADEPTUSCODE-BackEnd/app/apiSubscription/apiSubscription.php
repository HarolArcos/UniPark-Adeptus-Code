<?php
    include('autoload.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertSubscription");
    $server->Register("listSubscription");
    $server->Register("listSubscriptionInProgress");
    $server->Register("listSubscriptionAcepDeni");
    $server->Register("editSubscription");
    $server->Register("changeStateSubscription");
    $server->Register("listDisponibles");
    $server->Register("listOcupados");
    $server->start();

    function insertSubscription($arg){
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
        $idTarifa = "";
        $idPerson = "";
        $statusSubscription = "";
        $activationSubscription =  "";
        $expirationSubscription =  "";
        $numParkSubscription =  "";


        if(isset($arg->idTarifa)){
            $idTarifa =  $arg->idTarifa;
        }
        else{
            array_push($errorlist,"Error: falta parametro idTarifa");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusSubscription)){
            $statusSubscription =  $arg->statusSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusSubscription");
        }
        if(isset($arg->activationSubscription)){
                $activationSubscription =  $arg->activationSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro activateSubscription");
        }
        if(isset($arg->expirationSubscription)){
            $expirationSubscription =  $arg->expirationSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro expirationSubscription");
        }
        if(isset($arg->numParkSubscription)){
            $numParkSubscription =  $arg->numParkSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro numParkSubscription");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPerson = $arg->idPerson;
        $idTarifa = $arg->idTarifa;
        $statusSubscription = $arg->statusSubscription;
        $activationSubscription =  $arg->activationSubscription;
        $expirationSubscription =  $arg->expirationSubscription;
        $numParkSubscription =  $arg->numParkSubscription;

        $_subscription = new subscription($_db);
        $responseInsert = $_subscription->insertSubscriptionDb($idTarifa,$statusSubscription, $idPerson,$activationSubscription,$expirationSubscription, $numParkSubscription);

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


    function editSubscription($arg){
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
        $idSubscription =  "";
        $idTarifa = "";
        $idPerson = "";
        $statusSubscription = "";
        $activationSubscription =  "";
        $expirationSubscription =  "";
        $numParkSubscription =  "";

        if(isset($arg->idSubscription)){
            $idSubscription =  $arg->idSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro idSubscription");
        }
        if(isset($arg->idTarifa)){
            $idTarifa =  $arg->idTarifa;
        }
        else{
            array_push($errorlist,"Error: falta parametro idTarifa");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusSubscription)){
            $statusSubscription =  $arg->statusSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusSubscription");
        }
        if(isset($arg->activationSubscription)){
                $activationSubscription =  $arg->activationSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro activateSubscription");
        }
        if(isset($arg->expirationSubscription)){
            $expirationSubscription =  $arg->expirationSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro expirationSubscription");
        }
        if(isset($arg->numParkSubscription)){
            $numParkSubscription =  $arg->numParkSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro numParkSubscription");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idSubscription =  $arg->idSubscription;
        $idPerson = $arg->idPerson;
        $idTarifa = $arg->idTarifa;
        $statusSubscription = $arg->statusSubscription;
        $activationSubscription =  $arg->activationSubscription;
        $expirationSubscription =  $arg->expirationSubscription;
        $numParkSubscription =  $arg->numParkSubscription;

        $_subscription = new subscription($_db);
        $responseEdit = $_subscription->editSubscriptionDb($idSubscription,$idTarifa,$statusSubscription, $idPerson,$activationSubscription,$expirationSubscription, $numParkSubscription);

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

    function changeStateSubscription($arg){
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
        $idSubscription =  "";
        $statusSubscription = "";

        if(isset($arg->idSubscription)){
            $idSubscription =  $arg->idSubscription;
        }else{
            array_push($errorlist,"Error: falta parametro idSubscription");
        }
        if(isset($arg->statusSubscription)){
            $statusSubscription =  $arg->statusSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusSubscription");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idSubscription =  $arg->idSubscription;
        $statusSubscription = $arg->statusSubscription;

        $_subscription = new subscription($_db);
        $responseDelete = $_subscription->changeStateSubscriptionDb($idSubscription, $statusSubscription);

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

    function listSubscription(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan suscripciones"));
            $mensaje = "No se pudo listara a los vehiculos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionAcepDeni(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionAcepDeniDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones aceptadas y denegadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan suscripciones aceptadas y denegadas"));
            $mensaje = "No se pudo listar las suscripciones aceptadas y denegadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionInProgress(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionInProgressDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones aceptadas y denegadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan suscripciones aceptadas y denegadas"));
            $mensaje = "No se pudo listar las suscripciones aceptadas y denegadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listDisponibles(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listDisponiblesDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los sitios disponibles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan suscripciones"));
            $mensaje = "No se pudo listar los sitios disponibles - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listOcupados(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listOcupadosDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los sitios ocupados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan suscripciones"));
            $mensaje = "No se pudo listar los sitios ocupados - Funcion: ".__FUNCTION__;
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
    