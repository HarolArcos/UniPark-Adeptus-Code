<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla reclamo

class complaint {

    private $optionsLog;
    private $_db;
    private $idComplaint,$idPerson,$complaintStatus,$complaintIssue,$complaintText,$complaintDate, $complaintSolution;

    function __construct($_db,$idComplaint=0){
        
        $this->_db=$_db;
        if ($idComplaint!=0) {
            $this->setComplaint($idComplaint);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idComplaint);
        unset($this->idPerson);
        unset($this->complaintStatus);
        unset($this->complaintIssue);
        unset($this->complaintText);
        unset($this->complaintDate);
        unset($this->complaintSolution);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/complaint",           
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
    
    private function setComplaint($idComplaint){
        $response = FALSE;
        $dataComplaint = $this->findComplaintDb($idComplaint);
        if($dataComplaint){
            $this->mapComplaint($dataComplaint);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idComplaint,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findComplaintDb($idComplaint){
        $response = false;
        $sql =  "SELECT * FROM reclamo ".
                "where reclamo_id = $idComplaint";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idComplaint,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idComplaint,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertComplaintDb($complaintStatus,$idPerson,$complaintIssue,$complaintText,$complaintDate, $complaintSolution){
        $response = false;
        $sql =  "INSERT INTO reclamo(reclamo_estado, persona_id, reclamo_asunto, reclamo_texto, reclamo_fecha, reclamo_solucion) VALUES ('$complaintStatus','$idPerson','$complaintIssue','$complaintText','$complaintDate', '$complaintSolution')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "complaintStatus"=> $complaintStatus,
                                            "complaintIssue"=> $complaintIssue, 
                                            "complaintText"=> $complaintText,
                                            "complaintDate"=> $complaintDate,
                                            "complaintSolution"=> $complaintSolution
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "complaintStatus"=> $complaintStatus,
                                            "complaintIssue"=> $complaintIssue, 
                                            "complaintText"=> $complaintText,
                                            "complaintDate"=> $complaintDate,
                                            "complaintSolution"=> $complaintSolution
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
    public function changeStateComplaintDb($idComplaint, $complaintStatus){
        $response = false;
        $sql =  "UPDATE reclamo SET reclamo_estado = $complaintStatus WHERE reclamo_id = $idComplaint";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idComplaint" => $idComplaint,"reclamo_estado" => $complaintStatus),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idComplaint" => $idComplaint,"reclamo_estado" => $complaintStatus),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function changeSolutionDb($idComplaint, $complaintSolution){
        $response = false;
        $sql =  "UPDATE reclamo SET reclamo_solucion = '$complaintSolution' WHERE reclamo_id = $idComplaint";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idComplaint" => $idComplaint,"reclamo_estado" => $complaintSolution),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idComplaint" => $idComplaint,"reclamo_estado" => $complaintSolution),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listComplaintDb(){
        $response = false;
        //$sql =  "SELECT * FROM reclamo";
        $sql = "SELECT reclamo.*, referencia.referencia_valor AS reclamoEstado, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS reclamo_persona
        FROM reclamo
        JOIN persona ON reclamo.persona_id = persona.persona_id
        JOIN referencia ON reclamo.reclamo_estado = referencia.referencia_id";
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

	
    private function mapComplaint($rs){
        $this->idComplaint = $rs['reclamo_id'];
        $this->idPerson = $rs['persona_id'];
        $this->complaintStatus = $rs['reclamo_estado'];
        $this->complaintIssue = $rs['reclamo_asunto'];
        $this->complaintText = $rs['reclamo_texto'];
        $this->complaintDate = $rs['reclamo_fecha'];
        $this->complaintSolution = $rs['reclamo_solucion'];
    }


    public function getComplaintId(){
        return $this->idComplaint;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusComplaint(){
        return $this->complaintStatus;
    }
    
    public function getComplaintIssue(){
        return $this->complaintIssue;
    }
    
    public function getComplaintText(){
        return $this->complaintText;
    } 
    
    public function getComplaintDate(){
        return $this->complaintDate;
    }

    public function getComplaintSolution(){
        return $this->complaintSolution;
    }

}