<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla person_has_rol

class person_has_rol {

    private $optionsLog;
    private $_db;
    private $idPersonHasRol,$idPerson,$idRol;

    function __construct($_db,$idPersonHasRol=0){
        
        $this->_db=$_db;
        if ($idPersonHasRol!=0) {
            $this->setPersonHasRol($idPersonHasRol);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idPersonHasRol);
        unset($this->idPerson);
        unset($this->idRol);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/person_has_rol",           
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
    
    private function setPersonHasRol($idPersonHasRol){
        $response = FALSE;
        $dataPersonHasRol = $this->findPersonHasRolDb($idPersonHasRol);
        if($dataPersonHasRol){
            $this->mapPersonHasRol($dataPersonHasRol);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idPersonHasRol,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findPersonHasRolDb($idPersonHasRol){
        $response = false;
        $sql =  "SELECT * FROM persona_has_rol ".
                "where persona_has_rol_id = $idPersonHasRol";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idPersonHasRol,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idPersonHasRol,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertPersonHasRolDb($idPerson,$idRol){
        $response = false;
        $sql =  "INSERT INTO persona_has_rol(persona_id, rol_id) VALUES ('$idPerson','$idRol')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "idRol"=> $idRol
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "idRol"=> $idRol
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editPersonHasRolDb($idPersonHasRol, $idPerson,$idRol){
        $response = false;
        $sql =  "UPDATE persona_has_rol SET
        persona_id = '$idPerson',
        rol_id ='$idRol'
        WHERE persona_has_rol_id = $idPersonHasRol";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPersonHasRol" => $idPersonHasRol,
                                            "idPerson"=> $idPerson,
                                            "idRol"=> $idRol
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPersonHasRol" => $idPersonHasRol,
                                            "idPerson"=> $idPerson,
                                            "idRol"=> $idRol
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }


    public function deletePersonHasRolDb($idPersonaHasRol){
        $response = false;
        $sql = "DELETE FROM persona_has_rol WHERE persona_has_rol_id = $idPersonaHasRol";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idPerson" => $idPersonaHasRol),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idPersonaHasRol),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listDataRolWhitTypePersonDb($typePerson){
        $response = false;
        $sql = "SELECT * FROM rol WHERE rol_nombre = '$typePerson'";
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

    public function listPersonHasRolDb(){
        $response = false;
        //$sql =  "SELECT * FROM persona_has_rol";
        $sql = "SELECT phr.*, 
        CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS persona, 
        r.rol_nombre AS rol 
        FROM persona_has_rol phr 
        INNER JOIN persona p ON phr.persona_id = p.persona_id 
        INNER JOIN rol r ON phr.rol_id = r.rol_id";
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

	
    private function mapPersonHasRol($rs){
        $this->idPersonHasRol = $rs['persona_has_rol_id'];
        $this->idPerson = $rs['persona_id'];
        $this->idRol = $rs['rol_id'];
    }


    public function getPersonHasRolId(){
        return $this->idPersonHasRol;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getIdRol(){
        return $this->idRol;
    }

}