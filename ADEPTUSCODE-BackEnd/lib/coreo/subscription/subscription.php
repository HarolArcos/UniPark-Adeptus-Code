<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla subscripcion

class subscription {

    private $optionsLog;
    private $_db;
    private $idSubscription,$idTarifa,$statusSubscription, $idPerson,$activationSubscription,$expirationSubscription, $numParkSubscription;

    function __construct($_db,$idSubscription=0){
        
        $this->_db=$_db;
        if ($idSubscription!=0) {
            $this->setSubscription($idSubscription);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idSubscription);
        unset($this->idTarifa);
        unset($this->statusSubscription);
        unset($this->idPerson);
        unset($this->activationSubscription);
        unset($this->expirationSubscription);
        unset($this->numParkSubscription);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/subscription",           
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
    
    private function setSubscription($idSubscription){
        $response = FALSE;
        $dataSubscription = $this->findSubscriptionDb($idSubscription);
        if($dataSubscription){
            $this->mapSubscription($dataSubscription);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idSubscription,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findSubscriptionDb($idSubscription){
        $response = false;
        $sql =  "SELECT * FROM subscription WHERE subscription_id = $idSubscription";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idSubscription,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idSubscription,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertSubscriptionDb($idTarifa,$statusSubscription, $idPerson,$activationSubscription,$expirationSubscription, $numParkSubscription){
        $response = false;
        $sql =  "INSERT INTO suscripcion(tarifa_id, suscripcion_estado, persona_id, suscripcion_activacion, suscripcion_expiracion, suscripcion_numero_parqueo) VALUES ($idTarifa,$statusSubscription, $idPerson,'$activationSubscription','$expirationSubscription', '$numParkSubscription')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idTarifa"=> $idTarifa,
                                            "statusSubscription"=> $statusSubscription,
                                            "idPerson"=> $idPerson,
                                            "activationSubscription"=> $activationSubscription,
                                            "expirationSubscription"=> $expirationSubscription, 
                                            "numParkSubscription"=> $numParkSubscription
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idTarifa"=> $idTarifa,
                                            "statusSubscription"=> $statusSubscription,
                                            "idPerson"=> $idPerson,
                                            "activationSubscription"=> $activationSubscription,
                                            "expirationSubscription"=> $expirationSubscription, 
                                            "numParkSubscription"=> $numParkSubscription
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editSubscriptionDb($idSubscription,$idTarifa,$statusSubscription, $idPerson,$activationSubscription,$expirationSubscription, $numParkSubscription){
        $response = false;
        $sql =  "UPDATE suscripcion SET
        tarifa_id = '$idTarifa',
        suscripcion_estado ='$statusSubscription',
        persona_id = '$idPerson', 
        suscripcion_activacion = '$activationSubscription', 
        suscripcion_expiracion = '$expirationSubscription',
        suscripcion_numero_parqueo = '$numParkSubscription'
        WHERE suscripcion_id = $idSubscription";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idSubscription" => $idSubscription,
                                            "idTarifa"=> $idTarifa,
                                            "statusSubscription"=> $statusSubscription,
                                            "idPerson"=> $idPerson,
                                            "activationSubscription"=> $activationSubscription,
                                            "expirationSubscription"=> $expirationSubscription, 
                                            "numParkSubscription"=> $numParkSubscription
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idSubscription" => $idSubscription,
                                            "idTarifa"=> $idTarifa,
                                            "statusSubscription"=> $statusSubscription,
                                            "idPerson"=> $idPerson,
                                            "activationSubscription"=> $activationSubscription,
                                            "expirationSubscription"=> $expirationSubscription, 
                                            "numParkSubscription"=> $numParkSubscription
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeStateSubscriptionDb($idSubscription, $statusSubscription){
        $response = false;
        //$sql =  "UPDATE suscripcion SET suscripcion_estado = $statusSubscription WHERE suscripcion_id = $idSubscription";
        $sql2= "UPDATE suscripcion
                SET suscripcion_estado = $statusSubscription,
                suscripcion_numero_parqueo = CASE WHEN $statusSubscription = 11 THEN 0 ELSE suscripcion_numero_parqueo END
                WHERE suscripcion_id = $idSubscription";
        $rs = $this->_db->query($sql2);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idSubscription" => $idSubscription,"statusSuscription" => $statusSubscription),
                            "sql"=>$sql2,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idSubscription" => $idSubscription,"statusSuscription" => $statusSubscription),
                            "output"=>$response,
                            "sql"=>$sql2);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listSubscriptionDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id";
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

    public function listSubscriptionInProgressDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
		WHERE r.referencia_valor = 'en proceso'";
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

    public function listSubscriptionDeniedDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
		WHERE r.referencia_valor = 'rechazada'";
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

    public function listSubscriptionActiveDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
		WHERE r.referencia_valor = 'habilitada'";
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

    public function listSubscriptionInactiveDb(){
        $response = false;
        $sql = "SELECT s.*, CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS cliente,
        r.referencia_valor,
        t.tarifa_nombre, t.tarifa_valor
        FROM suscripcion s
        INNER JOIN persona p ON s.persona_id = p.persona_id
        INNER JOIN tarifa t ON s.tarifa_id = t.tarifa_id
        INNER JOIN referencia r ON s.suscripcion_estado = r.referencia_id
		WHERE r.referencia_valor = 'inhabilitada'";
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

    public function listDisponiblesDb(){
        $response = false;
        $sql = "SELECT numeros FROM generate_series(1, 120) numeros
        WHERE NOT EXISTS (
            SELECT 1 FROM suscripcion
            WHERE suscripcion_numero_parqueo = numeros
        )
        ORDER BY numeros ASC";
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

    public function listOcupadosDb(){
        $response = false;
        $sql = "SELECT DISTINCT suscripcion_numero_parqueo AS sitios_ocupados
        FROM suscripcion
        WHERE suscripcion_numero_parqueo BETWEEN 1 AND 200
        ORDER BY suscripcion_numero_parqueo";
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

	
    private function mapSubscription($rs){
        $this->idSubscription = $rs['suscripcion_id'];
        $this->idPerson = $rs['persona_id'];
        $this->statusSubscription = $rs['suscripcion_estado'];
        $this->idTarifa = $rs['tarifa_id'];
        $this->activationSubscription = $rs['suscripcion_activacion'];
        $this->expirationSubscription = $rs['suscripcion_expiracion'];
        $this->numParkSubscription = $rs['suscripcion_numero_parqueo'];
    }


    public function getSubscriptionId(){
        return $this->idSubscription;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusSubscription(){
        return $this->statusSubscription;
    }
    
    public function getTarifaId(){
        return $this->idTarifa;
    }
    
    public function getActivationSubscription(){
        return $this->activationSubscription;
    } 
    
    public function getExpirationSubscription(){
        return $this->expirationSubscription;
    }

    public function getNumParkSubscription(){
        return $this->numParkSubscription;
    }

}