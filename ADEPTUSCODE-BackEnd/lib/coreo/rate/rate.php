<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla tarifa

class rate {

    private $optionsLog;
    private $_db;
    private $idRate,$statusRate,$nameRate,$valueRate, $routeRate, $dateActivationRate, $dateExpirationRate;

    function __construct($_db,$idRate=0){
        
        $this->_db=$_db;
        if ($idRate!=0) {
            $this->setRate($idRate);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idRate);
        unset($this->statusRate);
        unset($this->nameRate);
        unset($this->valueRate);
        unset($this->routeRate);
        unset($this->dateActivationRate);
        unset($this->dateExpirationRate);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/rate",           
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
    
    private function setRate($idRate){
        $response = FALSE;
        $dataRate = $this->findRateDb($idRate);
        if($dataRate){
            $this->mapRate($dataRate);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idRate,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findRateDb($idRate){
        $response = false;
        $sql =  "SELECT * FROM tarifa WHERE tarifa_id = $idRate";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idRate,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idRate,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertRateDb($statusRate,$nameRate,$valueRate, $routeRate, $dateExpirationRate){
        $response = false;
        $sql =  "INSERT INTO tarifa(tarifa_estado, tarifa_nombre, tarifa_valor, tarifa_ruta, tarifa_activacion, tarifa_expiracion)
         VALUES ($statusRate,'$nameRate',$valueRate, '$routeRate', date_trunc('day', timezone('America/La_Paz', current_timestamp)), '$dateExpirationRate')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "statusRate"=> $statusRate,
                                            "nameRate"=> $nameRate,
                                            "valueRate"=> $valueRate,
                                            "routeRate"=> $routeRate,
                                            "dateExpirationRate"=> $dateExpirationRate
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "statusRate"=> $statusRate,
                                            "nameRate"=> $nameRate,
                                            "valueRate"=> $valueRate,
                                            "routeRate"=> $routeRate,
                                            "dateExpirationRate"=> $dateExpirationRate
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editRateDb($idRate,$statusRate,$nameRate,$valueRate, $routeRate){
        $response = false;
        $sql =  "UPDATE tarifa SET
        tarifa_estado =$statusRate,
        tarifa_nombre = '$nameRate', 
        tarifa_valor = $valueRate,
        tarifa_ruta = '$routeRate'
        WHERE tarifa_id = $idRate";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idRate" => $idRate,
                                            "statusRate"=> $statusRate,
                                            "nameRate"=> $nameRate,
                                            "valueRate"=> $valueRate,
                                            "routeRate"=> $routeRate
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRate" => $idRate,
                                            "statusRate"=> $statusRate,
                                            "nameRate"=> $nameRate,
                                            "valueRate"=> $valueRate,
                                            "routeRate"=> $routeRate
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeStateRateDb($idRate, $statusRate){
        $response = false;
        $sql =  "UPDATE tarifa SET tarifa_estado = $statusRate WHERE tarifa_id = $idRate";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idRate" => $idRate,"tarifa_estado" => $statusRate),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idRate,"tarifa_estado" => $statusRate),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listRateDb(){
        $response = false;
        $sql =  "SELECT t.*, r.referencia_valor AS estadotarifa
        FROM tarifa t
        JOIN referencia r ON t.tarifa_estado = r.referencia_id";
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

    public function listRateActiveDb(){
        $response = false;
        $sql =  "SELECT t.*, r.referencia_valor AS estadotarifa
        FROM tarifa t
        JOIN referencia r ON t.tarifa_estado = r.referencia_id
        WHERE r.referencia_valor = 'activo'";
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

    public function listRateInactiveDb(){
        $response = false;
        $sql =  "SELECT t.*, r.referencia_valor AS estadotarifa
        FROM tarifa t
        JOIN referencia r ON t.tarifa_estado = r.referencia_id
        WHERE r.referencia_valor = 'inactivo'";
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

	
    private function mapRate($rs){
        $this->idRate = $rs['tarifa_id'];
        $this->statusRate = $rs['tarifa_estado'];
        $this->nameRate = $rs['tarifa_nombre'];
        $this->valueRate = $rs['tarifa_valor'];
        $this->routeRate = $rs['tarifa_ruta'];
        $this->routeRate = $rs['tarifa_expiracion'];
    }


    public function getRateId(){
        return $this->idRate;
    }

    public function getStatusRate(){
        return $this->statusRate;
    }

    public function getNameRate(){
        return $this->nameRate;
    }
    
    public function getValueRate(){
        return $this->valueRate;
    }

    public function getRouteRate(){
        return $this->routeRate;
    }

    public function getExpirationRate(){
        return $this->dateExpirationRate;
    }

}