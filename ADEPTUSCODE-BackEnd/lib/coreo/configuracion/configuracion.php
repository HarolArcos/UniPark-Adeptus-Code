<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 31/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla configuracion

class configuration {

    private $optionsLog;
    private $_db;
    private $idConfiguration,$nameConfiguration,$value1Configuration,$value2Configuration;

    function __construct($_db,$idConfiguration=0){
        
        $this->_db=$_db;
        if ($idConfiguration!=0) {
            $this->setConfiguration($idConfiguration);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idConfiguration);
        unset($this->nameConfiguration);
        unset($this->value1Configuration);
        unset($this->value2Configuration);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/configuracion",           
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
    
    private function setConfiguration($idConfiguration){
        $response = FALSE;
        $dataConfiguration = $this->findConfigurationDb($idConfiguration);
        if($dataConfiguration){
            $this->mapConfiguration($dataConfiguration);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idConfiguration,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findConfigurationDb($idConfiguration){
        $response = false;
        $sql =  "SELECT * FROM configuracion WHERE configuracion_id = $idConfiguration";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idConfiguration,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idConfiguration,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function insertConfigurationDb($nameConfiguration,$value1Configuration,$value2Configuration){
        $response = false;
        $sql =  "INSERT INTO configuracion(configuracion_nombre, configuracion_valor1, configuracion_valor2) VALUES ('$nameConfiguration','$value1Configuration','$value2Configuration')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "nameConfiguration"=> $nameConfiguration,
                                            "value1Configuration"=> $value1Configuration,
                                            "value2Configuration"=> $value2Configuration
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "nameConfiguration"=> $nameConfiguration,
                                            "value1Configuration"=> $value1Configuration,
                                            "value2Configuration"=> $value2Configuration
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editConfigurationDb($idConfiguration,$nameConfiguration,$value1Configuration,$value2Configuration){
        $response = false;
        $sql =  "UPDATE configuracion SET
        configuracion_nombre ='$nameConfiguration',
        configuracion_valor1 = '$value1Configuration', 
        configuracion_valor2 = '$value2Configuration'
        WHERE configuracion_id = $idConfiguration";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idConfiguration" => $idConfiguration,
                                            "nameConfiguration"=> $nameConfiguration,
                                            "value1Configuration"=> $value1Configuration,
                                            "value2Configuration"=> $value2Configuration
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idConfiguration" => $idConfiguration,
                                            "nameConfiguration"=> $nameConfiguration,
                                            "value1Configuration"=> $value1Configuration,
                                            "value2Configuration"=> $value2Configuration
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    /*public function changeStateRolDb($idRol, $statusRol){
        $response = false;
        $sql =  "UPDATE rol SET rol_estado = $statusRol WHERE rol_id = $idRol";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idPerson" => $idRol,"tabla_estado" => $statusRol),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson" => $idRol,"tabla_estado" => $statusRol),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }*/

    public function listConfigurationDb(){
        $response = false;
        $sql =  "SELECT * FROM configuracion";
        /*$sql = "SELECT r.*, ref.referencia_valor as estadoRol
        FROM rol r
        JOIN referencia ref
        ON r.rol_estado = ref.referencia_id";*/
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

	
    private function mapConfiguration($rs){
        $this->idConfiguration = $rs['configuracion_id'];
        $this->nameConfiguration = $rs['configuracion_nombre'];
        $this->value1Configuration = $rs['configuracion_valor1'];
        $this->value2Configuration = $rs['configuracion_valor2'];
    }


    public function getConfigurationId(){
        return $this->idConfiguration;
    }

    public function getNameConfiguration(){
        return $this->nameConfiguration;
    }

    public function getValue1Configuration(){
        return $this->value1Configuration;
    }
    
    public function getValue2Configuration(){
        return $this->value2Configuration;
    }

}