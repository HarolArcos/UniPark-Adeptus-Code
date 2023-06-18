<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla rol

class rol {

    private $optionsLog;
    private $_db;
    private $idRol,$statusRol,$nameRol,$descriptionRol;

    function __construct($_db,$idRol=0){
        
        $this->_db=$_db;
        if ($idRol!=0) {
            $this->setRol($idRol);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idRol);
        unset($this->statusRol);
        unset($this->nameRol);
        unset($this->descriptionRol);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/rol",           
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
    
    private function setRol($idRol){
        $response = FALSE;
        $dataRol = $this->findRolDb($idRol);
        if($dataRol){
            $this->mapRol($dataRol);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idRol,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findRolDb($idRol){
        $response = false;
        $sql =  "SELECT * FROM rol WHERE rol_id = $idRol";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idRol,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idRol,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertRolDb($statusRol,$nameRol,$descriptionRol){
        $response = false;
        $sql =  "INSERT INTO rol(rol_estado, rol_nombre, rol_descripcion) VALUES ('$statusRol','$nameRol','$descriptionRol')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "statusRol"=> $statusRol,
                                            "nameRol"=> $nameRol,
                                            "descriptionRol"=> $descriptionRol,
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "statusRol"=> $statusRol,
                                            "nameRol"=> $nameRol,
                                            "descriptionRol"=> $descriptionRol,
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editRolDb($idRol,$statusRol,$nameRol,$descriptionRol){
        $response = false;
        $sql =  "UPDATE rol SET
        rol_estado ='$statusRol',
        rol_nombre = '$nameRol', 
        rol_descripcion = '$descriptionRol'
        WHERE rol_id = $idRol";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idRol" => $idRol,
                                            "statusRol"=> $statusRol,
                                            "nameRol"=> $nameRol,
                                            "descriptionRol"=> $descriptionRol
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRol" => $idRol,
                                            "statusRol"=> $statusRol,
                                            "nameRol"=> $nameRol,
                                            "descriptionRol"=> $descriptionRol
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeStateRolDb($idRol, $statusRol){
        $response = false;
        $sql =  "UPDATE rol SET rol_estado = $statusRol WHERE rol_id = $idRol";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idPerson" => $idRol,"tabla_estado" => $statusRol),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idRol,"tabla_estado" => $statusRol),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function idRolForTypePersonDb($typePerson){
        $response = false;
        $sql = "SELECT rol_id FROM rol WHERE rol_nombre = '$typePerson'";
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

    public function idRolForIdTypePersonDb($idTypePerson){
        $response = false;
        $sql = "SELECT rol_id FROM rol WHERE rol_nombre = (SELECT referencia_valor FROM referencia WHERE referencia_id = $idTypePerson)";
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

    public function listRolDb(){
        $response = false;
        //$sql =  "SELECT * FROM rol";
        $sql = "SELECT r.*, ref.referencia_valor as estadoRol
        FROM rol r
        JOIN referencia ref
        ON r.rol_estado = ref.referencia_id";
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

	
    private function mapRol($rs){
        $this->idRol = $rs['rol_id'];
        $this->statusRol = $rs['rol_estado'];
        $this->nameRol = $rs['rol_nombre'];
        $this->descriptionRol = $rs['rol_descripcion'];
    }


    public function getRolId(){
        return $this->idRol;
    }

    public function getStatusRol(){
        return $this->statusRol;
    }

    public function getNameRol(){
        return $this->nameRol;
    }
    
    public function getDescriptionRol(){
        return $this->descriptionRol;
    }

}