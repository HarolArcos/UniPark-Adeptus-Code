<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 04/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla conversacion

class conversation {

    private $optionsLog;
    private $_db;
    private $idConversation,$idPerson,$statusConversation,$issueConversation;

    function __construct($_db,$idConversation=0){
        
        $this->_db=$_db;
        if ($idConversation!=0) {
            $this->setConversation($idConversation);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idConversation);
        unset($this->idPerson);
        unset($this->statusConversation);
        unset($this->issueConversation);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/conversation",           
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
    
    private function setConversation($idConversation){
        $response = FALSE;
        $dataConversation = $this->findConversationDb($idConversation);
        if($dataConversation){
            $this->mapConversation($dataConversation);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idConversation,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findConversationDb($idConversation){
        $response = false;
        $sql =  "SELECT * FROM conversacion WHERE conversacion_id = $idConversation";//REV
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idConversation,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idConversation,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertConversationDb($idPerson,$statusConversation,$issueConversation){
        $response = false;
        $sql =  "INSERT INTO conversacion(persona_id, conversacion_estado, conversacion_asunto) VALUES ('$idPerson','$statusConversation','$issueConversation')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "statusConversation"=> $statusConversation,
                                            "issueConversation"=> $issueConversation
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "statusConversation"=> $statusConversation,
                                            "issueConversation"=> $issueConversation
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "debug");
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
    public function changeStateConversationDb($idConversation, $statusConversation){
        $response = false;
        $sql =  "UPDATE conversacion SET conversacion_estado = $statusConversation WHERE conversacion_id = $idConversation";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idConversacion" => $idConversation,"conversacion_estado" => $statusConversation),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idConversacion" => $idConversation,"conversacion_estado" => $statusConversation),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listConversation(){
        $response = false;
        //$sql =  "SELECT * FROM conversacion";
        $sql = "SELECT c.*, r.referencia_valor as estadoConversacion, 
        CONCAT(p.persona_nombre, ' ', p.persona_apellido) as conversacion_persona
        FROM conversacion c
        JOIN persona p ON p.persona_id = c.persona_id
        JOIN referencia r ON r.referencia_id = c.conversacion_estado";
        $rs = $this->_db->select($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array(
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array(
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "debug");
        }
        return $response;
    }

	
    private function mapConversation($rs){
        $this->idConversation = $rs['conversacion_id'];
        $this->idPerson = $rs['persona_id'];
        $this->statusConversation = $rs['conversacion_estado'];
        $this->issueConversation = $rs['conversacion_asunto'];
    }


    public function getConversationId(){
        return $this->idConversation;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusConversation(){
        return $this->statusConversation;
    }
    
    public function getIssueConversation(){
        return $this->issueConversation;
    }

}