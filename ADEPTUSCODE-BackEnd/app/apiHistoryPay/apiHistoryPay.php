<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertHistoryPay");
    $server->Register("listHistoryPay");
    $server->Register("listHistoryPayWeek");
    $server->Register("listHistoryPayMonth");
    $server->Register("listHistoryPayClient");
    $server->start();

    function insertHistoryPay($arg){
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
        $idSubscription = "";
        //$dateHistoryPay = "";
        $amountHistoryPay = "";
        //$residueHistoryPay =  "";
        $totalHistoryPay =  "";
        $siteHistoryPay = "";


        if(isset($arg->idSubscription)){
            $idSubscription =  $arg->idSubscription;
        }
        else{
            array_push($errorlist,"Error: falta parametro idSubscription");
        }
        /*if(isset($arg->dateHistoryPay)){
            $dateHistoryPay =  $arg->dateHistoryPay;
        }
        else{
            array_push($errorlist,"Error: falta parametro dateHistoryPay");
        }*/
        if(isset($arg->amountHistoryPay)){
            $amountHistoryPay =  $arg->amountHistoryPay;
        }
        else{
            array_push($errorlist,"Error: falta parametro amountHistoryPay");
        }
        /*if(isset($arg->residueHistoryPay)){
                $residueHistoryPay =  $arg->residueHistoryPay;
        }
        else{
            array_push($errorlist,"Error: falta parametro residueHistoryPay");
        }*/
        if(isset($arg->totalHistoryPay)){
            $totalHistoryPay =  $arg->totalHistoryPay;
        }
        else{
            array_push($errorlist,"Error: falta parametro totalHistoryPay");
        }
        if(isset($arg->siteHistoryPay)){
            $siteHistoryPay =  $arg->siteHistoryPay;
        }
        else{
            array_push($errorlist,"Error: falta parametro siteHistoryPay");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idSubscription = $arg->idSubscription;
        //$dateHistoryPay = $arg->dateHistoryPay;
        $amountHistoryPay = $arg->amountHistoryPay;
        //$residueHistoryPay =  $arg->totalHistoryPay;
        $totalHistoryPay =  $arg->totalHistoryPay;
        $siteHistoryPay = $arg->siteHistoryPay;

        $_pay = new history_pay($_db);
        $responseInsert = $_pay->insertHistoryPayDb($idSubscription, $amountHistoryPay, $totalHistoryPay, $siteHistoryPay);

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

    function listHistoryPayClient($arg){
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


        
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

       
        $idPerson =  $arg->idPerson;

        $_pay = new history_pay($_db);
        $responseList = $_pay->listHistoryPayIDClientDb($idPerson);

        if ($responseList) {
            $mensaje = "Se listo correctamente - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no tengas pagos realizados"));
            $mensaje = "No se pudo listar los pagos del cliente - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listHistoryPay(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_pay = new history_pay($_db);
        $responseList = $_pay->listHistoryPayDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan pagos"));
            $mensaje = "No se pudo listar los pagos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listHistoryPayWeek(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_pay = new history_pay($_db);
        $responseList = $_pay->listHistoryPayWeekDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan pagos de hace una semana atras"));
            $mensaje = "No se pudo listar los pagos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listHistoryPayMonth(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_pay = new history_pay($_db);
        $responseList = $_pay->listHistoryPayMonthDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan pagos de hace un mes atras"));
            $mensaje = "No se pudo listar los pagos - Funcion: ".__FUNCTION__;
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
    