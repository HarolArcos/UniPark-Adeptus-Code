<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla evento

class event {

    private $optionsLog;
    private $_db;
    private $idEvent, $idVehicle,$idPerson,$typeEvent,$dateEvent,$alarmEvent,$descriptionEvent, $registerUser;

    function __construct($_db,$idEvent=0){
        
        $this->_db=$_db;
        if ($idEvent!=0) {
            $this->setEvent($idEvent);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idEvent);
        unset($this->idPerson);
        unset($this->idVehicle);
        unset($this->typeEvent);
        unset($this->dateEvent);
        unset($this->alarmEvent);
        unset($this->descriptionEvent);
        unset($this->registerUser);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/eventV",           
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
    
    private function setEvent($idEvent){
        $response = FALSE;
        $dataEvent = $this->findEventDb($idEvent);
        if($dataEvent){
            $this->mapEvent($dataEvent);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idEvent,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findEventDb($idEvent){
        $response = false;
        $sql =  "SELECT * FROM evento WHERE evento_id = $idEvent";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idEvent,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idEvent,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertEventDb($idPerson, $idVehicle,$typeEvent,$alarmEvent,$descriptionEvent, $registerUser){
        $response = false;
        $sql =  "INSERT INTO evento(vehiculo_persona_id, vehiculo_id, evento_tipo, evento_fecha, evento_alarma, evento_descripcion, registro_usuario) VALUES ('$idPerson', '$idVehicle','$typeEvent',date_trunc('second', timezone('America/La_Paz', current_timestamp)),$alarmEvent,'$descriptionEvent', '$registerUser')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "idVehicle"=> $idVehicle,
                                            "typeEvent"=> $typeEvent,
                                            "alarmEvent"=> $alarmEvent,
                                            "descriptionEvent"=> $descriptionEvent,
                                            "registerUser"=> $registerUser
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "idVehicle"=> $idVehicle,
                                            "typeEvent"=> $typeEvent, 
                                            "alarmEvent"=> $alarmEvent,
                                            "descriptionEvent"=> $descriptionEvent,
                                            "registerUser"=> $registerUser
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editEventDb($idEvent, $idPerson, $idVehicle,$typeEvent,$alarmEvent,$descriptionEvent, $registerUser){
        $response = false;
        $sql =  "UPDATE evento SET
        vehiculo_persona_id = '$idPerson',
        vehiculo_id ='$idVehicle',
        evento_tipo = '$typeEvent', 
        evento_alarma = $alarmEvent,
        evento_descripcion = '$descriptionEvent',
        registro_usuario = '$registerUser'
        WHERE evento_id = '$idEvent'";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idEvent"=> $idEvent,
                                            "idPerson"=> $idPerson,
                                            "idVehicle"=> $idVehicle,
                                            "typeEvent"=> $typeEvent,
                                            "alarmEvent"=> $alarmEvent,
                                            "descriptionEvent"=> $descriptionEvent,
                                            "registerUser"=> $registerUser
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idEvent"=> $idEvent,
                                            "idPerson"=> $idPerson,
                                            "idVehicle"=> $idVehicle,
                                            "typeEvent"=> $typeEvent,
                                            "alarmEvent"=> $alarmEvent,
                                            "descriptionEvent"=> $descriptionEvent,
                                            "registerUser"=> $registerUser
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeTypeEventDb($idEvent, $typeEvent){
        $response = false;
        $sql =  "UPDATE evento SET evento_tipo = $typeEvent WHERE vehiculo_id = $idEvent";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idEvent" => $idEvent,"evento_tipo" => $typeEvent),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idEvent" => $idEvent,"evento_tipo" => $typeEvent),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listEventDb(){
        $response = false;
        //$sql =  "SELECT * FROM vehiculo";
        /*$sql = "SELECT vehiculo.*, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS propietario
        FROM vehiculo
        JOIN persona ON vehiculo.persona_id = persona.persona_id";*/
        /*$sql = "SELECT e.*, v.persona_id, v.vehiculo_placa, r.referencia_valor
        FROM evento e
        INNER JOIN vehiculo v ON e.vehiculo_id = v.vehiculo_id AND e.vehiculo_persona_id = v.persona_id
        INNER JOIN referencia r ON e.evento_tipo = r.referencia_id";*/
        $sql = "SELECT evento.*, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS propietario, vehiculo.vehiculo_placa, referencia.referencia_valor 
        FROM evento 
        INNER JOIN vehiculo ON evento.vehiculo_id = vehiculo.vehiculo_id AND evento.vehiculo_persona_id = vehiculo.persona_id 
        INNER JOIN persona ON vehiculo.persona_id = persona.persona_id 
        INNER JOIN referencia ON evento.evento_tipo = referencia.referencia_id";
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

	
    private function mapEvent($rs){
        $this->idEvent = $rs['evento_id'];
        $this->idVehicle = $rs['vehiculo_id'];
        $this->idPerson = $rs['vehiculo_persona_id'];
        $this->typeEvent = $rs['evento_tipo'];
        $this->dateEvent = $rs['evento_fecha'];
        $this->alarmEvent = $rs['evento_alarma'];
        $this->descriptionEvent = $rs['evento_descripcion'];
        $this->registerUser = $rs['registro_usuario'];
    }


    public function getEventId(){
        return $this->idEvent;
    }
    
    public function getVehicleId(){
        return $this->idVehicle;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getTypeEvent(){
        return $this->typeEvent;
    }
    
    public function getDateEvent(){
        return $this->dateEvent;
    }
    
    public function getDescriptionEvent(){
        return $this->descriptionEvent;
    } 
    
    public function getAlarmEvent(){
        return $this->alarmEvent;
    }
    
    public function getRegisterUser(){
        return $this->registerUser;
    }

}