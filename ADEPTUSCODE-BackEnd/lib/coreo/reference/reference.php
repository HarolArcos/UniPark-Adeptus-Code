<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 04/05/2023
//by: Harol Arcos
//Clase mapeada de la tabla referencia

class reference {

    private $optionsLog;
    private $_db;
    private $idReference,$tableNameReference,$nameSpaceReference, $descriptionReference,$valueReference,$statusReference;

    function __construct($_db,$idReference=0){
        
        $this->_db=$_db;
        if ($idReference!=0) {
            $this->setReference($idReference);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idReference);
        unset($this->tableNameReference);
        unset($this->nameSpaceReference);
        unset($this->descriptionReference);
        unset($this->valueReference);
        unset($this->statusReference);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/reference",           
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
    
    private function setReference($idReference){
        $response = FALSE;
        $dataReference = $this->findReferenceDb($idReference);
        if($dataReference){
            $this->mapReference($dataReference);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idReference,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findReferenceDb($idReference){
        $response = false;
        $sql =  "SELECT * FROM referencia ".
                "where referencia_id = $idReference";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idReference,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            $response = $rs[0];
            $arrLog = array("input"=>$idReference,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertReferenceDb($tableNameReference,$nameSpaceReference, $descriptionReference,$valueReference,$statusReference){
        $response = false;
        $sql =  "INSERT INTO referencia(referencia_nombre_tabla,referencia_nombre_campo,referencia_descripcion,referencia_valor,referencia_estado)
         VALUES ('$tableNameReference', '$nameSpaceReference', '$descriptionReference', '$valueReference', '$statusReference')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "tableNameReference"=> $tableNameReference,
                                            "nameSpaceReference"=> $nameSpaceReference,
                                            "descriptionReference"=> $descriptionReference, 
                                            "valueReference"=> $valueReference,
                                            "statusReference"=> $statusReference),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "tableNameReference"=> $tableNameReference,
                                            "nameSpaceReference"=> $nameSpaceReference,
                                            "descriptionReference"=> $descriptionReference, 
                                            "valueReference"=> $valueReference,
                                            "statusReference"=> $statusReference),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editReferenceDb($idReference, $tableNameReference, $nameSpaceReference, $descriptionReference, $valueReference, $statusReference){
        $response = false;
        $sql =  "UPDATE referencia SET 
        referencia_nombre_tabla = '$tableNameReference',
        referencia_nombre_campo = '$nameSpaceReference',
        referencia_descripcion = '$descriptionReference',
        referencia_valor = '$valueReference',
        referencia_estado = '$statusReference'
      WHERE referencia_id = $idReference";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idReference" => $idReference,
                                            "tableNameReference"=> $tableNameReference,
                                            "nameSpaceReference"=> $nameSpaceReference,
                                            "descriptionReference"=> $descriptionReference, 
                                            "valueReference"=> $valueReference,
                                            "statusReference"=> $statusReference),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idReference" => $idReference,
                                            "tableNameReference"=> $tableNameReference,
                                            "nameSpaceReference"=> $nameSpaceReference,
                                            "descriptionReference"=> $descriptionReference, 
                                            "valueReference"=> $valueReference,
                                            "statusReference"=> $statusReference),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function changeStateReferenceDb($idReference, $statusReference){
        $response = false;
        $sql =  "UPDATE referencia SET referencia_estado = $statusReference WHERE referencia_id = $idReference";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idReference" => $idReference,"referencia_estado" => $statusReference),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idReference" => $idReference,"referencia_estado" => $statusReference),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listReferencesDb($tableNameReference, $nameSpaceReference){
        $response = false;
        $sql =  "SELECT * FROM referencia WHERE referencia_nombre_tabla = '$tableNameReference' AND referencia_nombre_campo = '$nameSpaceReference'";
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

    public function listReferencesSolicitudDb($tableNameReference, $nameSpaceReference){
        $response = false;
        $sql =  "SELECT * FROM referencia WHERE referencia_nombre_tabla = '$tableNameReference' AND referencia_nombre_campo = '$nameSpaceReference' AND referencia_valor <> 'inhabilitada' AND referencia_valor <> 'mora'";
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

    public function listReferencesSuscripcionDb($tableNameReference, $nameSpaceReference){
        $response = false;
        $sql =  "SELECT * FROM referencia WHERE referencia_nombre_tabla = '$tableNameReference' AND referencia_nombre_campo = '$nameSpaceReference' AND referencia_valor <> 'en proceso' AND referencia_valor <> 'rechazada'";
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

    private function mapReference($rs){
        $this->idReference = $rs['referencia_id'];
        $this->tableNameReference = $rs['referencia_nombre_tabla'];
        $this->nameSpaceReference = $rs['referencia_nombre_campo'];
        $this->descriptionReference = $rs['referencia_descripcion'];
        $this->valueReference = $rs['referencia_valor'];
        $this->statusReference = $rs['referencia_estado'];
    }

    public function getReferenciaId(){
        return $this->idReference;
    }

    public function getReferenciaNombreTabla(){
        return $this->tableNameReference;
    }
    
    public function getReferenciaNombreCampo(){
        return $this->nameSpaceReference;
    }
    
    public function getReferenciaDescripcion(){
        return $this->descriptionReference;
    } 
    
    public function getReferenciaValor(){
        return $this->valueReference;
    }

    public function getReferenciaEstado(){
        return $this->statusReference;
    }
}