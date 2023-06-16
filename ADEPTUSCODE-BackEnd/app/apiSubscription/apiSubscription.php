<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertSubscription");
    $server->Register("listSubscription");
    $server->Register("listSubscriptionPorId");
    $server->Register("listSubscriptionDenied");
    $server->Register("listSubscriptionInProgress");
    $server->Register("listSubscriptionActive");
    $server->Register("listSubscriptionInactive");
    $server->Register("listSubscriptionMora");
    $server->Register("editSubscription");
    $server->Register("listSubscriptionActiveExpired");
    $server->Register("changeStateSubscription");
    $server->Register("listDisponibles");
    $server->Register("listOcupados");
    $server->Register("countOcupados");
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
        $numParkSubscription =  $arg->numParkSubscription;

        $_subscription = new subscription($_db);
        $responseInsert = $_subscription->insertSubscriptionDb($idTarifa,$statusSubscription, $idPerson, $numParkSubscription);

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
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones"));
            $mensaje = "No se pudo listara a los vehiculos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionPorId($arg){
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

        if(isset($arg->idSubscription)){
            $idSubscription =  $arg->idSubscription;
        }else{
            array_push($errorlist,"Error: falta parametro idSubscription");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idSubscription =  $arg->idSubscription;

        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionPorIdDb($idSubscription);

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones habilitadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones habilitadas"));
            $mensaje = "No se pudo listar las suscripciones habilitadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionActive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones habilitadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones habilitadas"));
            $mensaje = "No se pudo listar las suscripciones habilitadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionInactive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionInactiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones inabilitadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones inhabilitadas"));
            $mensaje = "No se pudo listar las suscripciones inhabilitadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionMora(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionMoraDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones inabilitadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones en mora"));
            $mensaje = "No se pudo listar las suscripciones en mora - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionActiveExpired(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionActiveExpiredDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones habilitadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones vencidas con estado habilitado"));
            $mensaje = "No se pudo listar las suscripciones vencidas con estado habilitado - Funcion: ".__FUNCTION__;
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
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones aceptadas y denegadas"));
            $mensaje = "No se pudo listar las suscripciones aceptadas y denegadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listSubscriptionDenied(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_subscription = new subscription($_db);
        $responseList = $_subscription->listSubscriptionDeniedDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente las suscripciones rechazadas - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan suscripciones rechazadas"));
            $mensaje = "No se pudo listar las suscripciones rechazadas - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listDisponibles($arg){
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
        $numberSities =  "";

        
        if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }
        else{
            array_push($errorlist,"Error: falta parametro numberSitieadsas");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $numberSities =  $arg->numberSities;

        $_subscription = new subscription($_db);
        $responseList = $_subscription->listDisponiblesDb($numberSities);

        if ( $responseList){
            $response = array("codError" => 200, "data" => array("desError"=>"Listado exitoso de sitios disponibles"));
            $mensaje = "Listado exitoso de sitios disponibles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido de sitios disponibles"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $responseList;
    }

    function listOcupados($arg){
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
        $numberSities =  "";

        
        if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }
        else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $numberSities =  $arg->numberSities;

        $_subscription = new subscription($_db);
        $responseList = $_subscription->listOcupadosDb($numberSities);

        if ( $responseList){
            $response = array("codError" => 200, "data" => array("desError"=>"Listado exitoso de sitios ocupados"));
            $mensaje = "Listado exitoso de sitios ocupados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido de sitios ocupados"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $responseList;
    }


    function countOcupados($arg){
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
        $numberSities =  "";

        
        if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }
        else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $numberSities =  $arg->numberSities;

        $_subscription = new subscription($_db);
        $responseList = $_subscription->countOcupadosDb($numberSities);

        if ( $responseList){
            $response = array("codError" => 200, "data" => array("desError"=>"Listado exitoso de sitios ocupados"));
            $mensaje = "Listado exitoso de sitios ocupados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido de sitios ocupados"));
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
    

    