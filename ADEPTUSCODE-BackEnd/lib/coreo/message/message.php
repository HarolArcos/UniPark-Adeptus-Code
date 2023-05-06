<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla vehiculo

class message {

    private $optionsLog;
    private $_db;
    private $idMessage,$idConversation,$authorMessage,$textMessage,$dateMessage;

    function __construct($_db,$idMessage=0){
        
        $this->_db=$_db;
        if ($idMessage!=0) {
            $this->setMessage($idMessage);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idMessage);
        unset($this->idConversation);
        unset($this->authorMessage);
        unset($this->textMessage);
        unset($this->dateMessage);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/message",           
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
    
    private function setMessage($idMessage){
        $response = FALSE;
        $dataMessage = $this->findMessageDb($idMessage);
        if($dataMessage){
            $this->mapMessage($dataMessage);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idMessage,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findMessageDb($idMessage){
        $response = false;
        $sql =  "SELECT * FROM mensaje ".
                "where mensaje_id = $idMessage";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idMessage,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idMessage,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertMessageDb($idConversation,$authorMessage,$textMessage,$dateMessage){
        $response = false;
        $sql =  "INSERT INTO mensaje(conversacion_id, mensaje_autor, mensaje_texto, mensaje_fecha) VALUES ('$idConversation','$authorMessage','$textMessage','$dateMessage')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idConversation"=> $idConversation,
                                            "authorMessage"=> $authorMessage, 
                                            "textMessage"=> $textMessage,
                                            "dateMessage"=> $dateMessage
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idConversation"=> $idConversation,
                                            "authorMessage"=> $authorMessage, 
                                            "textMessage"=> $textMessage,
                                            "dateMessage"=> $dateMessage
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
    /*public function changeStateMessageDb($idMessage, $statusMessage){
        $response = false;
        $sql =  "UPDATE mensaje SET mensaje_estado = $statusMessage WHERE mensaje_id = $idMessage";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idMessage" => $idMessage,"tabla_estado" => $statusMessage),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idMessage" => $idMessage,"tabla_estado" => $statusMessage),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }*/

    public function listMessageDb(){
        $response = false;
        //$sql =  "SELECT * FROM mensaje";
        $sql = "SELECT m.*, c.conversacion_asunto, 
        CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS autor_mensaje
        FROM mensaje m 
        JOIN persona p ON m.mensaje_autor = p.persona_id 
        JOIN conversacion c ON m.conversacion_id = c.conversacion_id";
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

	
    private function mapMessage($rs){
        $this->idMessage = $rs['mensaje_id'];
        $this->idConversation = $rs['conversacion_id'];
        $this->authorMessage = $rs['mensaje_autor'];
        $this->textMessage = $rs['mensaje_texto'];
        $this->dateMessage = $rs['mensaje_fecha'];
    }


    public function getMessageId(){
        return $this->idMessage;
    }

    public function getConversationId(){
        return $this->idConversation;
    }
    
    public function getAuthorMessage(){
        return $this->authorMessage;
    }
    
    public function getTextMessage(){
        return $this->textMessage;
    } 
    
    public function getDateMessage(){
        return $this->dateMessage;
    }

}