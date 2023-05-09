<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 0/05/2023
//by: Harol Arcos
//Clase mapeada de la tabla rol_has_opcion

class rol_has_option {
    private $optionsLog;
    private $_db;
    private $idRolHasOption, $idRol,$idOption;

    function __construct($_db,$idRolHasOption=0){
        $this->_db=$_db;
        if ($idRolHasOption!=0) {
            $this->setRolHasOption($idRolHasOption);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idRolHasOption);
        unset($this->idRol);
        unset($this->idOption);
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
    
    private function setRolHasOption($idRolHasOption){
        $response = FALSE;
        $dataRolHasOption = $this->findRolHasOption($idRolHasOption);
        if($dataRolHasOption){
            $this->mapPersonHasRol($dataRolHasOption);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idRolHasOption,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findRolHasOptionDb($idRolHasOption){
        $response = false;
        $sql =  "SELECT * FROM rol_has_opcion ".
                "where rol_has_opcion_id = $idRolHasOption";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idRolHasOption,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            $response = $rs[0];
            $arrLog = array("input"=>$idRolHasOption,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertRolHasOptionDb($idRol,$idOption){
        $response = false;
        $sql =  "INSERT INTO persona_has_rol(persona_id, rol_id) VALUES ('$idRol','$idOption')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idRol"=> $idRol,
                                            "idOption"=> $idOption
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRol"=> $idRol,
                                            "idOption"=> $idOption
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editPersonHasRolDb($idRolHasOption, $idRol, $idOption){
        $response = false;
        $sql =  "UPDATE rol_has_opcion SET
        rol_id ='$idRol',
        opcion_id = '$idOption'
        WHERE rol_has_opcion_id = $idRolHasOption";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idRolHasOption" => $idRolHasOption,
                                            "idRol"=> $idRol,
                                            "idOption"=> $idOption
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRolHasOption" => $idRolHasOption,
                                            "idRol"=> $idRol,
                                            "idOption"=> $idOption
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function deleteRolHasOptionDb($idRolHasOption){
        $response = false;
        $sql = "DELETE FROM rol_has_opcion WHERE rol_has_opcion_id = $idRolHasOption";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idRolHasOption" => $idRolHasOption),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRolHasOption" => $idRolHasOption),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listRolHasOptionDb(){
        $response = false;
        $sql =  "SELECT * FROM rol_has_opcion";
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

    private function mapRolHasOption($rs){
        $this->idRolHasOption = $rs['rol_has_option-id'];
        $this->idPerson = $rs['persona_id'];
        $this->idRol = $rs['rol_id'];
    }


    public function getRolHasOptionId(){
        return $this->idRolHasOption;
    }

    public function getoptionId(){
        return $this->idOption;
    }

    public function getIdRol(){
        return $this->idRol;
    }

}