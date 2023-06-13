<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertConfiguration");
    $server->Register("listConfiguration");
    $server->Register("listConfigurationNumSitios");
    $server->Register("listConfigurationHorario");
    $server->Register("listConfigurationContacto");
    $server->Register("editConfiguration");
    $server->Register("changeNumberPhone");
    $server->Register("changeNumberSities");
    $server->Register("changeGroupTelegram");
    $server->Register("changeTokenBot");
    $server->Register("changeHorarioAtencion");
    $server->Register("changeHorarioAtencionSaturday");
    $server->start();

    function insertConfiguration($arg){
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
        $nameConfiguration = "";
        $value1Configuration =  "";
        $value2Configuration =  "";


        if(isset($arg->nameConfiguration)){
            $nameConfiguration =  $arg->nameConfiguration;
        }
        else{
            array_push($errorlist,"Error: falta parametro nameConfiguration");
        }
        if(isset($arg->value1Configuration)){
                $value1Configuration =  $arg->value1Configuration;
        }
        else{
            array_push($errorlist,"Error: falta parametro value1Configuration");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $nameConfiguration = $arg->nameConfiguration;
        $value1Configuration =  $arg->value1Configuration;
        $value2Configuration =  $arg->value2Configuration;

        $_configuration = new configuration($_db);
        $responseInsert = $_configuration->insertConfigurationDb($nameConfiguration,$value1Configuration,$value2Configuration);

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


    function editConfiguration($arg){
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
        $idConfiguration = "";
        $nameConfiguration = "";
        $value1Configuration =  "";
        $value2Configuration =  "";

        if(isset($arg->idConfiguration)){
            $idConfiguration =  $arg->idConfiguration;
        }
        else{
            array_push($errorlist,"Error: falta parametro idConfiguration");
        }
        if(isset($arg->nameConfiguration)){
            $nameConfiguration =  $arg->nameConfiguration;
        }
        else{
            array_push($errorlist,"Error: falta parametro nameConfiguration");
        }
        if(isset($arg->value1Configuration)){
                $value1Configuration =  $arg->value1Configuration;
        }
        else{
            array_push($errorlist,"Error: falta parametro value1Configuration");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idConfiguration = $arg->idConfiguration;
        $nameConfiguration = $arg->nameConfiguration;
        $value1Configuration =  $arg->value1Configuration;
        $value2Configuration =  $arg->value2Configuration;

        $_configuration = new configuration($_db);
        $responseEdit = $_configuration->editConfigurationDb($idConfiguration,$nameConfiguration,$value1Configuration,$value2Configuration);

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

    function changeNumberSities($arg){
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
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $numberSities =  $arg->numberSities;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeNumberSitiesDb($numberSities);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeNumberPhone($arg){
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
        $numberPhone =  "";

        if(isset($arg->numberPhone)){
            $numberPhone =  $arg->numberPhone;
        }else{
            array_push($errorlist,"Error: falta parametro numberPhone");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $numberPhone =  $arg->numberPhone;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeNumberPhoneDb($numberPhone);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeGroupTelegram($arg){
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
        $groupTelegram =  "";

        if(isset($arg->groupTelegram)){
            $groupTelegram =  $arg->groupTelegram;
        }else{
            array_push($errorlist,"Error: falta parametro groupTelegram");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $groupTelegram =  $arg->groupTelegram;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeGroupTelegramDb($groupTelegram);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeTokenBot($arg){
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
        $tokenBot =  "";

        if(isset($arg->tokenBot)){
            $tokenBot =  $arg->tokenBot;
        }else{
            array_push($errorlist,"Error: falta parametro tokenBot");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $tokenBot =  $arg->tokenBot;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeTokenBotDb($tokenBot);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencion($arg){
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
        $monO =  "";
        $monC =  "";
        $tueO =  "";
        $tueC =  "";
        $thurO =  "";
        $thurC =  "";
        $wedO =  "";
        $wedC =  "";
        $friO =  "";
        $friC =  "";
        $satO = "";
        $satC = "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $monO =  $arg->monO;
        $monC =  $arg->monC;
        $tueC =  $arg->tueC;
        $tueO =  $arg->tueO;
        $thurC =  $arg->thurC;
        $thurO =  $arg->thurO;
        $wedC =  $arg->wedC;
        $wedO =  $arg->wedO;
        $friC =  $arg->friC;
        $friO =  $arg->friO;
        $satC =  $arg->satC;
        $satO =  $arg->satO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionDb($monO, $tueO, $wedO, $thurO, $friO, $satO, $monC, $tueC, $wedC, $thurC, $friC, $satC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionMonday($arg){
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
        $monO =  "";
        $monC =  "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $monO =  $arg->monO;
        $monC =  $arg->monC;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionLunesDb($monO, $monC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionTuesday($arg){
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
        $tueO =  "";
        $tueC =  "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        
        $tueC =  $arg->tueC;
        $tueO =  $arg->tueO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionMartesDb( $tueO,  $tueC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionWednesday($arg){
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
        
        $wedO =  "";
        $wedC =  "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

       
        $wedC =  $arg->wedC;
        $wedO =  $arg->wedO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionMiercolesDb($wedO, $wedC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionThursday($arg){
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
       
        $thurO =  "";
        $thurC =  "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }
        $thurC =  $arg->thurC;
        $thurO =  $arg->thurO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionJuevesDb($thurO, $thurC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionFriday($arg){
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
        
        $friO =  "";
        $friC =  "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        
        $friC =  $arg->friC;
        $friO =  $arg->friO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionViernesDb($friO, $friC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeHorarioAtencionSaturday($arg){
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
       
        $satO = "";
        $satC = "";

        /*if(isset($arg->numberSities)){
            $numberSities =  $arg->numberSities;
        }else{
            array_push($errorlist,"Error: falta parametro numberSities");
        }*/
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

       
        $satC =  $arg->satC;
        $satO =  $arg->satO;

        $_conf = new configuration($_db);
        $responseDelete = $_conf->changeHorarioAtencionSabadoDb($satO,$satC);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio fallido"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $responseDelete;
    }

    function listConfiguration(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_configuration = new configuration($_db);
        $responseList = $_configuration->listConfigurationDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los roles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan configuraciones"));
            $mensaje = "No se pudo listara a los vehiculos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listConfigurationContacto(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_configuration = new configuration($_db);
        $responseList = $_configuration->listConfigurationContactoDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los roles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan configuraciones"));
            $mensaje = "No se pudo listara los contactos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listConfigurationHorario(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_configuration = new configuration($_db);
        $responseList = $_configuration->listConfigurationHorarioDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los roles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan configuraciones"));
            $mensaje = "No se pudo listara a los horarios - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listConfigurationNumSitios(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_configuration = new configuration($_db);
        $responseList = $_configuration->listConfigurationNumSitiosDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente los roles - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan configuraciones"));
            $mensaje = "No se pudo listar el numero de sitios - Funcion: ".__FUNCTION__;
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
    