<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 24/04/2023
//by: Harol Arcos
//Clase mapeada de la tabla usuarios

class person {

    private $optionsLog;
    private $_db;
    private $idPerson,$typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, 
    $statusPerson,$nicknamePerson,$passwordPerson;

    function __construct($_db,$idPerson=0){
        
        $this->_db=$_db;
        if ($idPerson!=0) {
            $this->setPerson($idPerson);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idPerson);
        unset($this->typePerson);
        unset($this->namePerson);
        unset($this->lastNamePerson);
        unset($this->ciPerson);
        unset($this->phonePerson);
        unset($this->telegramPerson);
        unset($this->statusPerson);
        unset($this->nicknamePerson);
        unset($this->passwordPerson);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/person",           
            'filename'       => $fileName,);
          $_log = new log($this->optionsLog);
          
          switch ($tipeError) {
            case "info":
                $_log->info($logMessage);
              break;
            case "notice":
                $_log->notice($logMessage);
              break;
            case "warning":
                $_log->warning($logMessage);
              break;
            case "error":
                $_log->error($logMessage);
              break;
            case "critical":
                $_log->critical($logMessage);
              break;
            case "alert":
                $_log->alert($logMessage);
              break;
            case "emergency":
                $_log->emergency($logMessage);
              break;
            case "gau":
                $_log->gau($logMessage);
              break;
            case "debug":
                $_log->debug($logMessage);
                break;
            default:
                $_log->info($logMessage);
                break;
          }
    }
    
    private function setPerson($idPerson){
        $response = FALSE;
        $dataPerson = $this->findPersonDb($idPerson);
        if($dataPerson){
            $this->mapPerson($dataPerson);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idPerson,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findPersonDb($idPerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_id = $idPerson";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idPerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idPerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonCIDb($ciPerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_ci = '$ciPerson'";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$ciPerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$ciPerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$ciPerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonNicknameDb($nicknamePerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_nickname = '$nicknamePerson'";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$nicknamePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$nicknamePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$nicknamePerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonPhoneDb($phonePerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_telefono = '$phonePerson'";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$phonePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$phonePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$phonePerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonCIDEb($ciPerson, $idPerson){
        $response = false;
        $sql =  "SELECT * FROM persona WHERE persona_ci = '$ciPerson' AND persona_id <> $idPerson";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$ciPerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            //echo ($this->_db->getNumRows());
            $arrLog = array("input"=>$ciPerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$ciPerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonNicknameEDb($nicknamePerson, $idPerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_nickname = '$nicknamePerson' AND persona_id <> $idPerson";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$nicknamePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$nicknamePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$nicknamePerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPersonPhoneEDb($phonePerson, $idPerson){
        $response = false;
        $sql =  "SELECT * FROM persona ".
                "where persona_telefono = '$phonePerson' AND persona_id <> $idPerson";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$phonePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$phonePerson,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            
            $response = true;
            $arrLog = array("input"=>$phonePerson,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertPersonDb($typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, 
    $statusPerson,$nicknamePerson,$passwordPerson){
        $response = false;
        $sql =  "INSERT INTO persona(persona_tipo,persona_nombre, persona_apellido, persona_ci, persona_telefono, persona_telegram, persona_estado, persona_nickname, persona_contraseña) VALUES ('$typePerson','$namePerson' , '$lastNamePerson' , '$ciPerson' , '$phonePerson' , '$telegramPerson' , $statusPerson , '$nicknamePerson' , '$passwordPerson') 
        returning persona_id";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "typePerson"=> $typePerson,
                                            "namePerson"=> $namePerson,
                                            "lastNamePerson"=> $lastNamePerson, 
                                            "ciPerson"=> $ciPerson,
                                            "phonePerson"=> $phonePerson,
                                            "telegramPerson"=> $telegramPerson ,
                                            "statusPerson"=> $statusPerson,
                                            "nicknamePerson"=> $nicknamePerson,
                                            "passwordPerson"=> $passwordPerson),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "typePerson"=> $typePerson,
                                            "namePerson"=> $namePerson,
                                            "lastNamePerson"=> $lastNamePerson, 
                                            "ciPerson"=> $ciPerson,
                                            "phonePerson"=> $phonePerson,
                                            "telegramPerson"=> $telegramPerson ,
                                            "statusPerson"=> $statusPerson,
                                            "nicknamePerson"=> $nicknamePerson,
                                            "passwordPerson"=> $passwordPerson
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editPersonDb($idPerson,$typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, 
    $statusPerson,$nicknamePerson,$passwordPerson){
        $response = false;
        $sql =  "UPDATE persona SET 
        persona_tipo = '$typePerson',
        persona_nombre = '$namePerson',
        persona_apellido = '$lastNamePerson',
        persona_ci = '$ciPerson',
        persona_telefono = '$phonePerson',
        persona_telegram = '$telegramPerson',
        persona_estado = $statusPerson,
        persona_nickname = '$nicknamePerson',
        persona_contraseña = '$passwordPerson'
      WHERE persona_id = $idPerson";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson" => $idPerson,
                                            "typePerson"=> $typePerson,
                                            "namePerson"=> $namePerson,
                                            "lastNamePerson"=> $lastNamePerson, 
                                            "ciPerson"=> $ciPerson,
                                            "phonePerson"=> $phonePerson,
                                            "telegramPerson"=> $telegramPerson ,
                                            "statusPerson"=> $statusPerson,
                                            "nicknamePerson"=> $nicknamePerson,
                                            "passwordPerson"=> $passwordPerson),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idPerson,
                                            "typePerson"=> $typePerson,
                                            "namePerson"=> $namePerson,
                                            "lastNamePerson"=> $lastNamePerson, 
                                            "ciPerson"=> $ciPerson,
                                            "phonePerson"=> $phonePerson,
                                            "telegramPerson"=> $telegramPerson ,
                                            "statusPerson"=> $statusPerson,
                                            "nicknamePerson"=> $nicknamePerson,
                                            "passwordPerson"=> $passwordPerson
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeStatePersonDb($idPerson, $statusPerson){
        $response = false;
        $sql2 =  "UPDATE persona SET persona_estado = $statusPerson WHERE persona_id = $idPerson;";
        $sql3 = "DO $$
        BEGIN
            UPDATE persona
            SET persona_estado = $statusPerson
            WHERE persona_id = $idPerson;
        
            IF (SELECT persona_estado FROM persona WHERE persona_id = $idPerson) = 2 THEN
                UPDATE vehiculo
                SET vehiculo_estado = 7
                WHERE persona_id = $idPerson;
            END IF;
        END $$;";
        $sql = "DO $$
        BEGIN
            UPDATE persona
            SET persona_estado = $statusPerson
            WHERE persona_id = $idPerson;
        
            IF (SELECT persona_estado FROM persona WHERE persona_id = $idPerson) = 2 THEN
                UPDATE vehiculo
                SET vehiculo_estado = 7
                WHERE persona_id = $idPerson;
                UPDATE suscripcion
                SET suscripcion_estado = 9
                WHERE persona_id = $idPerson;
                UPDATE suscripcion
                SET suscripcion_numero_parqueo = 0
                WHERE persona_id = $idPerson;
            ELSIF (SELECT persona_estado FROM persona WHERE persona_id = $idPerson) = 1 THEN
                UPDATE vehiculo
                SET vehiculo_estado = 6
                WHERE persona_id = $idPerson;
            END IF;
        END $$;";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idPerson" => $idPerson,"persona_estado" => $statusPerson),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idPerson,"persona_estado" => $statusPerson),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonActiveDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado 
        FROM persona 
        INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
        INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonClientDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado, 
        persona_has_rol.*
        FROM persona 
        INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
        INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id
        INNER JOIN persona_has_rol ON persona.persona_id = persona_has_rol.persona_id
        WHERE referencia_personaTipo.referencia_valor = 'cliente'";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonClientActiveDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado 
        FROM persona 
        INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
        INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id
        WHERE referencia_personaTipo.referencia_valor = 'cliente'
        AND referencia_personaEstado.referencia_valor = 'activo'";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonAdminDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado 
        FROM persona 
        INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
        INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id
        WHERE referencia_personaTipo.referencia_valor = 'admin'
        AND referencia_personaEstado.referencia_valor = 'activo'";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonEmployeeDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado,
        horario.*,
        persona_has_rol.*
    FROM persona 
    INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
    INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id
    INNER JOIN persona_has_rol ON persona.persona_id = persona_has_rol.persona_id
    LEFT JOIN horario ON persona.persona_id = horario.persona_id
    WHERE persona.persona_tipo NOT IN (
        SELECT referencia_id 
        FROM referencia 
        WHERE referencia_valor IN ('cliente', 'admin')
    )";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listPersonEmployeeActiveDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona";
        $sql = "SELECT 
        persona.*, 
        referencia_personaTipo.referencia_valor AS personaTipo, 
        referencia_personaEstado.referencia_valor AS personaEstado,
        horario.*
    FROM persona 
    INNER JOIN referencia AS referencia_personaTipo ON persona.persona_tipo = referencia_personaTipo.referencia_id 
    INNER JOIN referencia AS referencia_personaEstado ON persona.persona_estado = referencia_personaEstado.referencia_id
    LEFT JOIN horario ON persona.persona_id = horario.persona_id
    WHERE persona.persona_tipo NOT IN (
        SELECT referencia_id 
        FROM referencia 
        WHERE referencia_valor IN ('cliente', 'admin')
    ) AND referencia_personaEstado.referencia_valor = 'activo'";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function validatePersonDb($nicknamePerson, $passwordPerson){
        $response = false;
        $sql2 =  "SELECT opcion.*
        FROM persona
        INNER JOIN persona_has_rol ON persona.persona_id = persona_has_rol.persona_id
        INNER JOIN rol_has_opcion ON persona_has_rol.rol_id = rol_has_opcion.rol_id
        INNER JOIN opcion ON rol_has_opcion.opcion_id = opcion.opcion_id
        INNER JOIN referencia ON opcion.opcion_estado = referencia.referencia_id
        WHERE persona.persona_nickname = '$nicknamePerson'
        AND persona.persona_contraseña = '$passwordPerson'
        AND referencia.referencia_valor = 'activo'
        AND opcion_padre = 0";

        $sql3 = "SELECT opcion.*
        FROM persona
        INNER JOIN persona_has_rol ON persona.persona_id = persona_has_rol.persona_id
        INNER JOIN rol_has_opcion ON persona_has_rol.rol_id = rol_has_opcion.rol_id
        INNER JOIN opcion ON rol_has_opcion.opcion_id = opcion.opcion_id
        INNER JOIN referencia ON opcion.opcion_estado = referencia.referencia_id
        WHERE persona.persona_nickname = '$nicknamePerson'
        AND persona.persona_contraseña = '$passwordPerson'
        AND referencia.referencia_valor = 'activo'
        AND opcion_padre <> 0";
        

        $sql = "SELECT persona.*, tipoPersona.referencia_valor, rol.rol_nombre
        FROM persona
        JOIN referencia AS tipoPersona ON persona.persona_tipo = tipoPersona.referencia_id
        JOIN referencia AS estadoPersona ON persona.persona_estado = estadoPersona.referencia_id
        JOIN persona_has_rol ON persona.persona_id = persona_has_rol.persona_id
        JOIN rol ON persona_has_rol.rol_id = rol.rol_id
        WHERE persona.persona_nickname = '$nicknamePerson' 
          AND persona.persona_contraseña = '$passwordPerson' 
          AND estadoPersona.referencia_valor = 'activo'";
        $rs = $this->_db->select($sql);
        $rs2 = $this->_db->select($sql2);
        $rs3 = $this->_db->select($sql3);
        if($this->_db->getLastError() == false && $rs==false && $rs2==false && $rs3==false) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            //$response = $rs;
            $response = array('persona'=>$rs, 'opciones padre 0'=>$rs2, 'opciones padre disferente de 0'=>$rs3);
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

	
    private function mapPerson($rs){
        $this->idPerson = $rs['persona_id'];
        $this->typePerson = $rs['persona_tipo'];
        $this->namePerson = $rs['persona_nombre'];
        $this->lastNamePerson = $rs['persona_apellido'];
        $this->ciPerson = $rs['persona_ci'];
        $this->phonePerson = $rs['persona_telefono'];
        $this->telegramPerson = $rs['persona_telegram'];
        $this->statusPerson = $rs['persona_estado'];
        $this->nicknamePerson = $rs['persona_nickname'];
        $this->passwordPerson = $rs['persona_contraseña'];

    }

    public function getPersonaId(){
        return $this->idPerson;
    }

    public function getPersonaTipo(){
        return $this->typePerson;
    }
    
    public function getPersonaNombre(){
        return $this->namePerson;
    }
    
    public function getPersonaApellido(){
        return $this->lastNamePerson;
    } 
    
    public function getPersonaCi(){
        return $this->ciPerson;
    }

    public function getPersonaTelefono(){
        return $this->phonePerson;
    }

    public function getPersonaTelegram(){
        return $this->telegramPerson;
    }

    public function getPersonaEstado(){
        return $this->statusPerson;
    }

    public function getPersonaNickname(){
        return $this->nicknamePerson;
    }

    public function getPersonacontraseña(){
        return $this->passwordPerson;
    }
}