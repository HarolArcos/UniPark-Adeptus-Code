<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertComplaint");
    $server->Register("listComplaint");
    $server->Register("changeStateComplaint");
    $server->Register("changeSolutionComplaint");
    $server->start();

    function insertComplaint($arg){
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
        $complaintStatus = "";
        $idPerson = "";
        $complaintIssue =  "";
        $complaintText =  "";
        $complaintDate =  "";
        $complaintSolution = "";


        if(isset($arg->complaintStatus)){
            $complaintStatus =  $arg->complaintStatus;
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintStatus");
        }
        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->complaintIssue)){
                $complaintIssue =  $arg->complaintIssue;
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintIssue");
        }
        if(isset($arg->complaintText)){
            $complaintText =  $arg->complaintText;
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintText");
        }
        if(isset($arg->complaintDate)){
            $formato = 'Y-m-d H:i:s';
            $fecha_valida = DateTime::createFromFormat($formato, $arg->complaintDate);

            if ($fecha_valida !== false) {
                $complaintDate =  $arg->complaintDate;
            } else {
                array_push($errorlist,"Error: complaintDate debe estar en el formato  Y-m-d H:i:s");
            }
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintDate");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        
        $complaintStatus = $arg->complaintStatus;
        $idPerson = $arg->idPerson;
        $complaintIssue =  $arg->complaintIssue;
        $complaintText =  $arg->complaintText;
        $complaintDate =  $arg->complaintDate;
        $complaintSolution = $arg->complaintSolution;

        $_complaint = new complaint($_db);
        $responseInsert = $_complaint->insertComplaintDb($complaintStatus, $idPerson,$complaintIssue,$complaintText,$complaintDate, $complaintSolution);

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

    function changeStateComplaint($arg){
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
        $idComplaint =  "";
        $complaintStatus = "";

        if(isset($arg->idComplaint)){
            $idComplaint =  $arg->idComplaint;
        }else{
            array_push($errorlist,"Error: falta parametro idComplaint");
        }
        if(isset($arg->complaintStatus)){
            $complaintStatus =  $arg->complaintStatus;
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintStatus");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idComplaint =  $arg->idComplaint;
        $complaintStatus = $arg->complaintStatus;

        $_complaint = new complaint($_db);
        $responseDelete = $_complaint->changeStateComplaintDb($idComplaint, $complaintStatus);

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

    function changeSolutionComplaint($arg){
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
        $idComplaint =  "";
        $complaintSolution = "";

        if(isset($arg->idComplaint)){
            $idComplaint =  $arg->idComplaint;
        }else{
            array_push($errorlist,"Error: falta parametro idComplaint");
        }
        if(isset($arg->complaintSolution)){
            $complaintSolution =  $arg->complaintSolution;
        }
        else{
            array_push($errorlist,"Error: falta parametro complaintSolution");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idComplaint =  $arg->idComplaint;
        $complaintSolution = $arg->complaintSolution;

        $_complaint = new complaint($_db);
        $responseDelete = $_complaint->changeSolutionDb($idComplaint, $complaintSolution);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de solucion exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de solucion fallida"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }
    function listComplaint(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_complaint = new complaint($_db);
        $responseList = $_complaint->listComplaintDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los reclamos - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan reclamos"));
            $mensaje = "No se pudo listar los reclamos - Funcion: ".__FUNCTION__;
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
    