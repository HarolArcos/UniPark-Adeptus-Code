<?php
    include('autoLoad.php'); 
    $HTTP_RAW_POST_DATA = file_get_contents("php://input");
    $HTTP_RAW_POST_DATA = (json_decode($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA : '';
    $HTTP_RAW_POST_DATA = (empty($HTTP_RAW_POST_DATA)) ? json_encode(array_merge($_REQUEST, $_FILES)) : $HTTP_RAW_POST_DATA;
    $server = new apiJson($HTTP_RAW_POST_DATA);
    $server->Register("insertPerson");
    $server->Register("listPerson");
    $server->Register("listPersonClient");
    $server->Register("listPersonClientActive");
    $server->Register("listPersonAdmin");
    $server->Register("listPersonEmployee");
    $server->Register("listPersonEmployeeActive");
    $server->Register("test");
    $server->Register("test2");
    $server->Register("editPerson");
    $server->Register("changeStatePerson");
    $server->Register("validatePerson");
    $server->start();

    function insertPerson($arg){
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
        $typePerson = "";
        $namePerson =  "";
        $lastNamePerson =  "";
        $ciPerson =  "";
        $phonePerson= "";
        $telegramPerson = "";
        $statusPerson = "";
        $nicknamePerson = "";
        $passwordPerson = "";


        if(isset($arg->typePerson)){
            $typePerson =  $arg->typePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro typePerson");
        }
        if(isset($arg->namePerson)){
            $namePerson =  $arg->namePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro namePerson");
        }
        if(isset($arg->lastNamePerson)){
                $lastNamePerson =  $arg->lastNamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastNamePerson");
        }
        if(isset($arg->ciPerson)){
            $ciPerson =  $arg->ciPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro ciPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(isset($arg->nicknamePerson)){
            $nicknamePerson =  $arg->nicknamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro nicknamePerson");
        }
        if(isset($arg->passwordPerson)){
            $passwordPerson =  $arg->passwordPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro passwordPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        #$idPerson =  $arg->idPerson;
        $typePerson = $arg->typePerson;
        $namePerson =  $arg->namePerson;
        $lastNamePerson =  $arg->lastNamePerson;
        $ciPerson =  $arg->ciPerson;
        $phonePerson= $arg->phonePerson;
        $telegramPerson = $arg->telegramPerson;
        $statusPerson = $arg->statusPerson;
        $nicknamePerson = $arg->nicknamePerson;
        $passwordPerson = $arg->passwordPerson;

        $_person = new person($_db);
        
        $responseVerifyCI = $_person->findPersonCIDb($ciPerson);
        $responseVerifyNickname = $_person->findPersonNicknameDb($nicknamePerson);
        $responseVerifyPhone = $_person->findPersonPhoneDb($phonePerson);
        
        if($responseVerifyCI){
            if($responseVerifyNickname){
                if($responseVerifyPhone){
                    $responseInsert = $_person->insertPersonDb($typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, $statusPerson,$nicknamePerson,$passwordPerson);

                    if ( $responseInsert) {
                        //$response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
                        $response = $responseInsert;
                    }else{
                        $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
                    }
                }else{
                    $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el phone ingresado"));
                }
            }else{
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el nickname ingresado"));
            }
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el ci ingresado"));
        }
        
        /*if($responseVerifyCI == true && $responseVerifyNickname == true && $responseVerifyPhone == true){
            $responseInsert = $_person->insertPersonDb($typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, $statusPerson,$nicknamePerson,$passwordPerson);

            if ( $responseInsert) {
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción exitosa"));
            }else{
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida"));
            }
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, pueden existir datos duplicados"));
        }*/

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }


    function editPerson($arg){
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
        $idPerson =  "";
        $typePerson = "";
        $namePerson =  "";
        $lastNamePerson =  "";
        $ciPerson =  "";
        $phonePerson= "";
        $telegramPerson = "";
        $statusPerson = "";
        $nicknamePerson = "";
        $passwordPerson = "";

        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }


        if(isset($arg->typePerson)){
            $typePerson =  $arg->typePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro typePerson");
        }
        if(isset($arg->namePerson)){
            $namePerson =  $arg->namePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro namePerson");
        }
        if(isset($arg->lastNamePerson)){
                $lastNamePerson =  $arg->lastNamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro lastNamePerson");
        }
        if(isset($arg->ciPerson)){
            $ciPerson =  $arg->ciPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro ciPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(isset($arg->nicknamePerson)){
            $nicknamePerson =  $arg->nicknamePerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro nicknamePerson");
        }
        if(isset($arg->passwordPerson)){
            $passwordPerson =  $arg->passwordPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro passwordPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist)); 
        }

        $idPerson =  $arg->idPerson;
        $typePerson = $arg->typePerson;
        $namePerson =  $arg->namePerson;
        $lastNamePerson =  $arg->lastNamePerson;
        $ciPerson =  $arg->ciPerson;
        $phonePerson= $arg->phonePerson;
        $telegramPerson = $arg->telegramPerson;
        $statusPerson = $arg->statusPerson;
        $nicknamePerson = $arg->nicknamePerson;
        $passwordPerson = $arg->passwordPerson;

        $_person = new person($_db);
        
        $responseVerifyCI = $_person->findPersonCIDEb($ciPerson, $idPerson);
        $responseVerifyNickname = $_person->findPersonNicknameEDb($nicknamePerson, $idPerson);
        $responseVerifyPhone = $_person->findPersonPhoneEDb($phonePerson, $idPerson);
        
        if($responseVerifyCI){
            if($responseVerifyNickname){
                if($responseVerifyPhone){
                    $responseEdit = $_person->editPersonDb($idPerson,$typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, $statusPerson,$nicknamePerson,$passwordPerson);

                    if ( $responseEdit) {
                        $response = array("codError" => 200, "data" => array("desError"=>"Cambios realizados con exito"));
                    }else{
                        $response = array("codError" => 200, "data" => array("desError"=>"Cambios fallidos"));
                    }
                }else{
                    $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el phone ingresado"));
                }
            }else{
                $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el nickname ingresado"));
            }
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Inserción fallida, ya existe el ci ingresado"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function changeStatePerson($arg){
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
        $idPerson =  "";
        $statusPerson = "";

        if(isset($arg->idPerson)){
            $idPerson =  $arg->idPerson;
        }else{
            array_push($errorlist,"Error: falta parametro idPerson");
        }
        if(isset($arg->statusPerson)){
            $statusPerson =  $arg->statusPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro statusPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $idPerson =  $arg->idPerson;
        $statusPerson = $arg->statusPerson;

        $_person = new person($_db);
        $responseDelete = $_person->changeStatePersonDb($idPerson, $statusPerson);

        if ( $responseDelete){
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de estado exitosa"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Cambio de estado, exitoso"));
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $response;
    }

    function listPerson(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonActiveDb();

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

    function listPersonClient(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonClientDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a los clientes - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan clientes"));
            $mensaje = "No se pudo listara a los clientes - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listPersonClientActive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonClientActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a los clientes - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan clientes activos"));
            $mensaje = "No se pudo listara a los clientes - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listPersonAdmin(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonAdminDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a los administradores - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Listado fallido, es posible que no existan administradores"));
            $mensaje = "No se pudo listara a los administradores - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listPersonEmployee(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonEmployeeDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a los empleados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan empleados"));
            $mensaje = "No se pudo listara a los empleados - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function listPersonEmployeeActive(){
        $options = array('path' => LOGPATH,'filename' => FILENAME);
        $_db=new dataBasePG(CONNECTION);
        $_log = new log($options);
       
        $_person = new person($_db);
        $responseList = $_person->listPersonEmployeeActiveDb();

        if ( $responseList) {
            $mensaje = "Se listo correctamente a los empleados - Funcion: ".__FUNCTION__;
            $_log->info($mensaje);
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"Es posible que no existan empleados activos"));
            $mensaje = "No se pudo listara a los empleados activos - Funcion: ".__FUNCTION__;
            $_log->error($mensaje);
            return $response;
        }
        
        return $responseList;
    }

    function validatePerson($arg){
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
        $nicknamePerson =  "";
        $passwordPerson = "";

        if(isset($arg->nicknamePerson)){
            $nicknamePerson =  $arg->nicknamePerson;
        }else{
            array_push($errorlist,"Error: falta parametro nicknamePerson");
        }
        if(isset($arg->passwordPerson)){
            $passwordPerson =  $arg->passwordPerson;
        }
        else{
            array_push($errorlist,"Error: falta parametro passwordPerson");
        }
        if(count($errorlist)!==0){
            return array("codError" => 200, "data" => array("desError"=>$errorlist));
        }

        $nicknamePerson =  $arg->nicknamePerson;
        $passwordPerson = $arg->passwordPerson;

        $_person = new person($_db);
        $responseValidate = $_person->validatePersonDb($nicknamePerson, $passwordPerson);

        if ( $responseValidate){
            $response = array("codError" => 200, "data" => array("desError"=>"true"));
        }else{
            $response = array("codError" => 200, "data" => array("desError"=>"no se encontro a la persona en la db o su estado es inactivo"));
            return $response;
        }

        $timeProcess = microtime(true)-$startTime;
        $arrLog = array("time"=>$timeProcess, "input"=>json_encode($arg),"output"=>$response);
        $mensaje = print_r($arrLog, true)." Funcion: ".__FUNCTION__;
        $_log->notice($mensaje);
        return $responseValidate;
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
    