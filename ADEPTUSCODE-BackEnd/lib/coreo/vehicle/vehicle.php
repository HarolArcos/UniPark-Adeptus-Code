<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla vehiculo

class vehicle {

    private $optionsLog;
    private $_db;
    private $idVehicle,$idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle;

    function __construct($_db,$idVehicle=0){
        
        $this->_db=$_db;
        if ($idVehicle!=0) {
            $this->setVehicle($idVehicle);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idVehicle);
        unset($this->idPerson);
        unset($this->statusVehicle);
        unset($this->plateVehicle);
        unset($this->modelVehicle);
        unset($this->colorVehicle);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/vehicle",           
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
    
    private function setVehicle($idVehicle){
        $response = FALSE;
        $dataVehicle = $this->findVehicleDb($idVehicle);
        if($dataVehicle){
            $this->mapVehicle($dataVehicle);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idVehicle,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findVehicleDb($idVehicle){
        $response = false;
        $sql =  "SELECT * FROM vehiculo ".
                "where vehiculo_id = $idVehicle";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idVehicle,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idVehicle,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function findPlateVehicleDb($plateVehicle){
        $response = false;
        $sql =  "SELECT * FROM vehiculo WHERE vehiculo_placa = '$plateVehicle'";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$plateVehicle,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$plateVehicle,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            $response = true;
            $arrLog = array("input"=>$plateVehicle,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function findPlateVehicleEDb($idVehicle, $plateVehicle){
        $response = false;
        $sql =  "SELECT * FROM vehiculo WHERE vehiculo_placa = '$plateVehicle' AND vehiculo_id <> $idVehicle";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$plateVehicle,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else if($this->_db->getNumRows() > 0){
            $arrLog = array("input"=>$plateVehicle,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");           
        }else{
            $response = true;
            $arrLog = array("input"=>$plateVehicle,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertVehicleDb($idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle){
        $response = false;
        $sql =  "INSERT INTO vehiculo(persona_id, vehiculo_estado, vehiculo_placa, vehiculo_modelo, vehiculo_color) VALUES ('$idPerson','$statusVehicle' , '$plateVehicle' , '$modelVehicle' , '$colorVehicle')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "statusVehicle"=> $statusVehicle,
                                            "plateVehicle"=> $plateVehicle, 
                                            "modelVehicle"=> $modelVehicle,
                                            "colorVehicle"=> $colorVehicle
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
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
    }

    public function editVehicleDb($idVehicle, $idPerson,$statusVehicle,$plateVehicle,$modelVehicle,$colorVehicle){
        $response = false;
        $sql =  "UPDATE vehiculo SET
        persona_id = '$idPerson',
        vehiculo_estado ='$statusVehicle',
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
    }
    public function changeStateVehicleDb($idVehicle, $statusVehicle){
        $response = false;
        $sql =  "UPDATE vehiculo SET vehiculo_estado = $statusVehicle WHERE vehiculo_id = $idVehicle";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idPerson" => $idVehicle,"tabla_estado" => $statusVehicle),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idVehicle,"tabla_estado" => $statusVehicle),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listVehicleActiveDb(){
        $response = false;
        //$sql =  "SELECT * FROM vehiculo";
        /*$sql = "SELECT vehiculo.*, CONCAT(persona.persona_nombre, ' ', persona.persona_apellido) AS propietario
        FROM vehiculo
        JOIN persona ON vehiculo.persona_id = persona.persona_id";*/
        $sql = "SELECT v.*,
        CONCAT(p.persona_nombre, ' ', p.persona_apellido) AS propietario,
        r.referencia_valor AS vehiculoEstado
        FROM vehiculo v
        JOIN persona p ON v.persona_id = p.persona_id
        JOIN referencia r ON v.vehiculo_estado = r.referencia_id
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

	
    private function mapVehicle($rs){
        $this->idVehicle = $rs['vehiculo_id'];
        $this->idPerson = $rs['persona_id'];
        $this->statusVehicle = $rs['vehiculo_estado'];
        $this->plateVehicle = $rs['vehiculo_placa'];
        $this->modelVehicle = $rs['vehiculo_modelo'];
        $this->colorVehicle = $rs['vehiculo_color'];
    }


    public function getVehicleId(){
        return $this->idVehicle;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusVehicle(){
        return $this->statusVehicle;
    }
    
    public function getPlateVehicle(){
        return $this->plateVehicle;
    }
    
    public function getModelVehicle(){
        return $this->modelVehicle;
    } 
    
    public function getColorVehicle(){
        return $this->colorVehicle;
    }

}