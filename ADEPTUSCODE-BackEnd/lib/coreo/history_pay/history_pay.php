<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla historial_pago

class history_pay {

    private $optionsLog;
    private $_db;
    private $idHistoryPay,$idSubscription,$dateHistoryPay, $amountHistoryPay, $residueHistoryPay, $totalHistoryPay, $siteHistoryPay;

    function __construct($_db,$idHistoryPay=0){
        
        $this->_db=$_db;
        if ($idHistoryPay!=0) {
            $this->setHistoryPay($idHistoryPay);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idHistoryPay);
        unset($this->idSubscription);
        unset($this->dateHistoryPay);
        unset($this->amountHistoryPay);
        unset($this->residueHistoryPay);
        unset($this->totalHistoryPay);
        unset($this->siteHistoryPay);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/history_pay",           
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
    
    private function setHistoryPay($idHistoryPay){
        $response = FALSE;
        $dataHistoryPay = $this->findHistoryPayDb($idHistoryPay);
        if($dataHistoryPay){
            $this->mapHistoryPay($dataHistoryPay);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idHistoryPay,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findHistoryPayDb($idHistoryPay){
        $response = false;
        $sql =  "SELECT * FROM historial_pago WHERE historial_pago_id = $idHistoryPay";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idHistoryPay,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idHistoryPay,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertHistoryPayDb($idSubscription, $amountHistoryPay, $totalHistoryPay, $siteHistoryPay){
        $response = false;
        $sql =  "INSERT INTO historial_pago(suscripcion_id, historial_pago_fecha, historial_pago_monto, historial_pago_total, historial_pago_sitio) VALUES ($idSubscription,date_trunc('second', timezone('America/La_Paz', current_timestamp)), $amountHistoryPay, $totalHistoryPay, $siteHistoryPay);";
        $sql2 = "UPDATE historial_pago
        SET historial_pago_residuo = 
          CASE 
            WHEN historial_pago_total > (SELECT SUM(historial_pago_monto) FROM historial_pago WHERE suscripcion_id = $idSubscription) 
            THEN (historial_pago_total - (SELECT SUM(historial_pago_monto) FROM historial_pago WHERE suscripcion_id = $idSubscription))
            ELSE 0
          END
        WHERE suscripcion_id = $idSubscription;";

        $rs = $this->_db->query($sql);
        $rs = $this->_db->query($sql2);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idSubscription"=> $idSubscription,
                                            "amountHistoryPay"=> $amountHistoryPay,
                                            "totalHistoryPay"=> $totalHistoryPay,
                                            "siteHistoryPay" => $siteHistoryPay
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idSubscription"=> $idSubscription,
                                            "amountHistoryPay"=> $amountHistoryPay, 
                                            "totalHistoryPay"=> $totalHistoryPay,
                                            "siteHistoryPay" => $siteHistoryPay
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

    public function listHistoryPayDb(){
        $response = false;
        $sql2 = "SELECT
        h.*, s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
        INNER JOIN historial_pago h ON s.suscripcion_id = h.historial_pago_id";
        $sql3 = "SELECT CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        t.tarifa_nombre,
        t.tarifa_valor,
        s.suscripcion_numero_parqueo,
        hp.*
        FROM persona p
        JOIN suscripcion s ON p.persona_id = s.persona_id
        JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        LEFT JOIN historial_pago hp ON s.suscripcion_id = hp.suscripcion_id";
                $sql = "SELECT * FROM historial_pago";
        $rs = $this->_db->select($sql3);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql2,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql2);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listHistoryPayIDClientDb($idPerson){
        $response = false;
        $sql3 = "SELECT CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        t.tarifa_nombre,
        t.tarifa_valor,
        s.suscripcion_numero_parqueo,
        hp.*
        FROM persona p
        JOIN suscripcion s ON p.persona_id = s.persona_id
        JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        LEFT JOIN historial_pago hp ON s.suscripcion_id = hp.suscripcion_id
        WHERE s.suscripcion_numero_parqueo <> 0 AND P.persona_id = $idPerson";
        $rs = $this->_db->select($sql3);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql3,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql3);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listHistoryPayWeekDb(){
        $response = false;
        $sql3 = "SELECT CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        t.tarifa_nombre,
        t.tarifa_valor,
        s.suscripcion_numero_parqueo,
        hp.*
        FROM persona p
        JOIN suscripcion s ON p.persona_id = s.persona_id
        JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        LEFT JOIN historial_pago hp ON s.suscripcion_id = hp.suscripcion_id
        WHERE hp.historial_pago_fecha < current_timestamp
        AND hp.historial_pago_fecha >= current_timestamp - interval '1 week'";
        
        $rs = $this->_db->select($sql3);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql3,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql3);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listHistoryPayMonthDb(){
        $response = false;
        $sql3 = "SELECT CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        t.tarifa_nombre,
        t.tarifa_valor,
        s.suscripcion_numero_parqueo,
        hp.*
        FROM persona p
        JOIN suscripcion s ON p.persona_id = s.persona_id
        JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        LEFT JOIN historial_pago hp ON s.suscripcion_id = hp.suscripcion_id
        WHERE hp.historial_pago_fecha < current_timestamp
        AND hp.historial_pago_fecha >= current_timestamp - interval '1 month'";
        
        $rs = $this->_db->select($sql3);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql3,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql3);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

	
    private function mapHistoryPay($rs){
        $this->idHistoryPay = $rs['historial_pago_id'];
        $this->idSubscription = $rs['suscripcion_id'];
        $this->dateHistoryPay = $rs['historial_pago_fecha'];
        $this->amountHistoryPay = $rs['historial_pago_monto'];
        $this->residueHistoryPay = $rs['historial_pago_residuo'];
        $this->totalHistoryPay = $rs['historial_pago_total'];
        $this->siteHistoryPay = $rs['historial_pago_sitio'];
    }


    public function getIdHistoryPay(){
        return $this->idHistoryPay;
    }

    public function getSuscriptionId(){
        return $this->idSubscription;
    }

    public function getDateHistoryPay(){
        return $this->dateHistoryPay;
    }

    public function getAmountHistoryPay(){
        return $this->amountHistoryPay;
    }

    public function getResidueHistoryPay(){
        return $this->residueHistoryPay;
    }

    public function getTotalHistoryPay(){
        return $this->totalHistoryPay;
    }

    public function getSiteHistoryPay(){
        return $this->siteHistoryPay;
    }

}