<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla pago

class pay {

    private $optionsLog;
    private $_db;
    private $idPay,$idSubscription,$datePay;

    function __construct($_db,$idPay=0){
        
        $this->_db=$_db;
        if ($idPay!=0) {
            $this->setPay($idPay);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idPay);
        unset($this->idSubscription);
        unset($this->datePay);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/pay",           
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
    
    private function setPay($idPay){
        $response = FALSE;
        $dataPay = $this->findPayDb($idPay);
        if($dataPay){
            $this->mapPay($dataPay);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idPay,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findPayDb($idPay){
        $response = false;
        $sql =  "SELECT * FROM pago ".
                "where pago_id = $idPay";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idPay,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idPay,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertPayDb($idSubscription){
        $response = false;
        $sql =  "INSERT INTO pay(suscripcion_id, pago_fecha) VALUES ($idSubscription,timezone('America/La_Paz', now()))";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idSubscription,
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idSubscription
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }


    /*public function deletePersonHasRolDb($idPersonaHasRol){
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
    }*/

    public function listPayDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor,
        y.pago_fecha
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
        INNER JOIN pago y ON s.suscripcion_id = y.pago_id";
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

	
    private function mapPay($rs){
        $this->idPay = $rs['pago_id'];
        $this->idSubscription = $rs['suscripcion_id'];
        $this->datePay = $rs['pago_fecha'];
    }


    public function getIdPay(){
        return $this->idPay;
    }

    public function getSuscriptionId(){
        return $this->idSubscription;
    }

    public function getDatePay(){
        return $this->datePay;
    }

}