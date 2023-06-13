<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertMessage");
    $server->Register("listMessage");
    //$server->Register("editVehicle");
    //$server->Register("changeStateMessage");
    $server->start();

    function insertMessage($arg){
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
        $idConversation = "";
        $authorMessage =  "";
        $textMessage =  "";
        $dateMessage =  "";


        if(isset($arg->idConversation)){
            $idConversation =  $arg->idConversation;
        }
        else{
            array_push($errorlist,"Error: falta parametro idConversation");
        }
        if(isset($arg->authorMessage)){
                $authorMessage =  $arg->authorMessage;
        }
        else{
            array_push($errorlist,"Error: falta parametro authorMessage");
        }
        if(isset($arg->textMessage)){
            $textMessage =  $arg->textMessage;
        }
        else{
            array_push($errorlist,"Error: falta parametro textMessage");
        }
        if(isset($arg->dateMessage)){
            $formato = 'Y-m-d H:i:s';
            $fecha_valida = DateTime::createFromFormat($formato, $arg->dateMessage);

            if ($fecha_valida !== false) {
                $dateMessage =  $arg->dateMessage;
            } else {
                array_push($errorlist,"Error: dateMessage debe estar en el formato  Y-m-d H:i:s");
            }
        }
        else{
            array_push($errorlist,"Error: falta parametro dateMessage");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idConversation = $arg->idConversation;
        $authorMessage =  $arg->authorMessage;
        $textMessage =  $arg->textMessage;
        $dateMessage =  $arg->dateMessage;

        $_message = new message($_db);
        $responseInsert = $_message->insertMessageDb($idConversation,$authorMessage,$textMessage,$dateMessage);

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

    /*function changeStateMessage($arg){
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
        $idMessage =  "";
        $statusMessage = "";

        if(isset($arg->idMessage)){
            $idMessage =  $arg->idMessage;
        }else{
            array_push($errorlist,"Error: falta parametro idMessage");
        }
        if(isset($arg->statusMessage)){
            $statusMessage =  $arg->statusMessage;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusMessage");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idMessage =  $arg->idMessage;
        $statusMessage = $arg->statusMessage;

        $_message = new message($_db);
        $responseDelete = $_message->changeStateMessageDb($idMessage, $statusMessage);

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
    }*/

    function listMessage(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_message = new message($_db);
        $responseList = $_message->listMessageDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los mensajes - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan mensajes"));
            $mensaje = "No se pudo listar los mensajes - Funcion: ".__FUNCTION__;
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
    