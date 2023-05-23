<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 19/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla solicitud

class request {

    private $optionsLog;
    private $_db;
    private $idRequest,$idPerson,$statusRequest,$issueRequest,$textRequest,$dateRequest;

    function __construct($_db,$idRequest=0){
        
        $this->_db=$_db;
        if ($idRequest!=0) {
            $this->setRequest($idRequest);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idRequest);
        unset($this->idPerson);
        unset($this->statusRequest);
        unset($this->issueRequest);
        unset($this->textRequest);
        unset($this->dateRequest);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/request",           
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
    
    private function setRequest($idRequest){
        $response = FALSE;
        $dataRequest = $this->findRequestDb($idRequest);
        if($dataRequest){
            $this->mapRequest($dataRequest);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idRequest,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findRequestDb($idRequest){
        $response = false;
        $sql =  "SELECT * FROM solicitud WHERE solicitud_id = $idRequest";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idRequest,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idRequest,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertRequestDb($statusRequest,$idPerson,$issueRequest,$textRequest,$dateRequest){
        $response = false;
        $sql =  "INSERT INTO solicitud(solicitud_estado, persona_id, solicitud_asunto, solicitud_texto, solicitud_fecha) VALUES ($statusRequest,$idPerson,'$issueRequest','$textRequest','$dateRequest')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "complaintStatus"=> $statusRequest,
                                            "complaintIssue"=> $issueRequest, 
                                            "complaintText"=> $textRequest,
                                            "complaintDate"=> $dateRequest
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                            "complaintStatus"=> $statusRequest,
                            "complaintIssue"=> $issueRequest, 
                            "complaintText"=> $textRequest,
                            "complaintDate"=> $dateRequest
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    /*public function editVehicleDb($idVehicle, $idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle){
        $response = false;
        $sql =  "UPDATE vehiculo SET
        persona_id = '$idPerson',
        tabla_estado ='$statusVehicle',
        vehiculo_placa = '$plateVehicle', 
        vehiculo_modelo = '$modelVehicle', 
        vehiculo_color = '$colorVehicle'
        WHERE vehiculo_id = $idVehicle";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idVehicle" => $idVehicle,
                                            "idPerson"=> $idPerson,
                                            "statusVehicle"=> $statusVehicle,
                                            "plateVehicle"=> $plateVehicle, 
                                            "modelVehicle"=> $modelVehicle,
                                            "colorVehicle"=> $colorVehicle
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idVehicle" => $idVehicle,
                                            "idPerson"=> $idPerson,
                                            "statusVehicle"=> $statusVehicle,
                                            "plateVehicle"=> $plateVehicle, 
                                            "modelVehicle"=> $modelVehicle,
                                            "colorVehicle"=> $colorVehicle
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }*/
    public function changeStateRequestDb($idRequest, $statusRequest){
        $response = false;
        $sql =  "UPDATE solicitud SET solicitud_estado = $statusRequest WHERE solicitud_id = $idRequest";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idRequest" => $idRequest,"solucion_estado" => $statusRequest),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idRequest" => $idRequest,"solicitud_estado" => $statusRequest),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }


    public function listRequestDb(){
        $response = false;
        //$sql =  "SELECT * FROM reclamo";
        $sql = "SELECT solicitud.*, referencia.referencia_valor AS solicitudEstado, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS solicitud_persona
        FROM solicitud
        JOIN persona ON solicitud.persona_id = persona.persona_id
        JOIN referencia ON solicitud.solicitud_estado = referencia.referencia_id";
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

	
    private function mapRequest($rs){
        $this->idRequest = $rs['solicitud_id'];
        $this->idPerson = $rs['persona_id'];
        $this->statusRequest = $rs['solicitud_estado'];
        $this->issueRequest = $rs['solicitud_asunto'];
        $this->textRequest = $rs['solicitud_texto'];
        $this->dateRequest = $rs['solicitud_fecha'];
    }


    public function getRequestId(){
        return $this->idRequest;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusRequest(){
        return $this->statusRequest;
    }
    
    public function getRequestIssue(){
        return $this->issueRequest;
    }
    
    public function getRequestText(){
        return $this->textRequest;
    } 
    
    public function getRequestDate(){
        return $this->dateRequest;
    }

}