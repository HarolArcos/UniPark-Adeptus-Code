<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla horario

class schedule {

    private $optionsLog;
    private $_db;
    private $idSchedule,$idPerson,$daySchedule, $entrySchedule,$departureSchedule;

    function __construct($_db,$idSchedule=0){
        
        $this->_db=$_db;
        if ($idSchedule!=0) {
            $this->setSchedule($idSchedule);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idSchedule);
        unset($this->idPerson);
        unset($this->daySchedule);
        unset($this->entrySchedule);
        unset($this->departureSchedule);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/schedule",           
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
    
    private function setSchedule($idSchedule){
        $response = FALSE;
        $dataSchedule = $this->findScheduleDb($idSchedule);
        if($dataSchedule){
            $this->mapSchedule($dataSchedule);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idSchedule,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findScheduleDb($idSchedule){
        $response = false;
        $sql =  "SELECT * FROM horario WHERE horario_id = $idSchedule";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idSchedule,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idSchedule,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertScheduleDb($idPerson,$daySchedule,$entrySchedule,$departureSchedule){
        $response = false;
        $sql =  "INSERT INTO horario(persona_id, horario_dia, horario_entrada, horario_salida) VALUES ($idPerson,'$daySchedule','$entrySchedule','$departureSchedule')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "complaintStatus"=> $daySchedule,
                                            "complaintIssue"=> $entrySchedule, 
                                            "complaintText"=> $departureSchedule
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "complaintStatus"=> $daySchedule,
                                            "complaintIssue"=> $entrySchedule, 
                                            "complaintText"=> $departureSchedule
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
    public function changeScheduleDb($idSchedule, $entrySchedule, $departureSchedule){
        $response = false;
        $sql =  "UPDATE horario SET horario_entrada = '$entrySchedule', horario_salida = '$departureSchedule' WHERE horario_id = $idSchedule";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idSchedule" => $idSchedule,"horario_entrada" => $entrySchedule,"horario_salida" => $departureSchedule),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idSchedule" => $idSchedule,"horario_entrada" => $entrySchedule,"horario_salida" => $departureSchedule),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }


    public function listScheduleDb(){
        $response = false;
        //$sql =  "SELECT * FROM reclamo";
        $sql = "SELECT horario.*, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS horario_empleado
        FROM horario
        JOIN persona ON horario.persona_id = persona.persona_id";
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

	
    private function mapSchedule($rs){
        $this->idSchedule = $rs['horario_id'];
        $this->idPerson = $rs['persona_id'];
        $this->daySchedule = $rs['horario_dia'];
        $this->entrySchedule = $rs['horario_entrada'];
        $this->departureSchedule = $rs['horario_salida'];
    }


    public function getScheduleId(){
        return $this->idSchedule;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getDaySchedule(){
        return $this->daySchedule;
    }
    
    public function getEntrySchedule(){
        return $this->entrySchedule;
    }
    
    public function getDepartureSchedule(){
        return $this->departureSchedule;
    } 

}