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

    public function insertPersonDb($typePerson,$namePerson,$lastNamePerson,$ciPerson,$phonePerson, $telegramPerson, 
    $statusPerson,$nicknamePerson,$passwordPerson){
        $response = false;
        $sql =  "INSERT INTO persona(persona_tipo,persona_nombre, persona_apellido, persona_ci, persona_telefono, persona_telegram, persona_estado, persona_nickname, persona_contraseña) VALUES ('$typePerson','$namePerson' , '$lastNamePerson' , '$ciPerson' , '$phonePerson' , '$telegramPerson' , $statusPerson , '$nicknamePerson' , '$passwordPerson')";
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
        $sql =  "UPDATE persona SET persona_estado = $statusPerson WHERE persona_id = $idPerson";
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
        $sql =  "SELECT * FROM persona";
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

    public function getPersonaContraseña(){
        return $this->passwordPerson;
    }
}