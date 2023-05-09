<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");
//Clase Creada 08/05/2023
//by: Harol Arcos
//Clase Mapeada de la tabla Opcion

class option{
    private $optionsLog;
    private $_db;
    private $idOption,$statusOption, $fatherOption, $orderOption, $componentOption;
    
    function __construct($_db,$idOption=0){
        $this->_db=$_db;
        if ($idOption!=0) {
            $this->setOption($idOption);
        }
    }

    function _destruct(){
        unset($this->_db);
        unset($this->idOption);
        unset($this->fatherOption);
        unset($this->orderOption);
        unset($this->componentOption); 
        unset($this->statusOption);       
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

    private function setOption($idOption){
        $response = FALSE;
        $dataOption = $this->findOptionDb($idOption);
        if($dataOption){
            $this->mapOption($dataMessage);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idOption,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }

    public function insertOptionDb($fatherOption,$orderOption,$componentOption,$statusOption){
        $response = false;
        $sql =  "INSERT INTO opcion(opcion_padre, opcion_orden, opcion_componente, opcion_estado)
         VALUES ('$fatherOption','$orderOption','$componentOption','$statusOption')";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "fatherOption"=> $fatherOption,
                                            "orderOption"=> $orderOption,
                                            "componentOption"=> $componentOption,
                                            "statusOption"=> $statusOption
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "fatherOption"=> $fatherOption,
                                            "orderOption"=> $orderOption,
                                            "componentOption"=> $componentOption,
                                            "statusOption"=> $statusOption
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editOptionDb($idOption,$fatherOption,$orderOption,$componentOption,$statusOption){
        $response = false;
        $sql =  "UPDATE opcion SET
        opcion_padre ='$fatherOption',
        opcion_orden = '$orderOption', 
        opcion_componente = '$componentOption',
        opcion_estado = '$statusOption'
        WHERE opcion_id = $idOption";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idOption" => $idOption,
                                            "fatherOption"=> $fatherOption,
                                            "orderOption"=> $orderOption,
                                            "componentOption"=> $componentOption,
                                            "statusOption"=> $statusOption
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idOption" => $idOption,
                                            "fatherOption"=> $fatherOption,
                                            "orderOption"=> $orderOption,
                                            "componentOption"=> $componentOption,
                                            "statusOption"=> $statusOption
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

/*
    public function listRolDb(){
        $response = false;
        //$sql =  "SELECT * FROM rol";
        $sql = "SELECT r.*, ref.referencia_valor as estadoRol
        FROM rol r
        JOIN referencia ref
        ON r.rol_estado = ref.referencia_id";
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
*/

    private function mapOption($rs){
        $this->idOption = $rs['opcion_id'];
        $this->fatherOption = $rs['opcion_padre'];
        $this->orderOption = $rs['opcion_orden'];
        $this->componentOption = $rs['opcion_componente'];
        $this->statusOption = $rs['opcion_estado'];
    }


    public function getOptionId(){
        return $this->idOption;
    }

    public function getFatherOption(){
        return $this->fatherOption;
    }

    public function getOrderOption(){
        return $this->orderOption;
    }
    
    public function getComponentOption(){
        return $this->componentOption;
    }

    public function getStatusOption(){
        return $this->statusOption;
    }


}