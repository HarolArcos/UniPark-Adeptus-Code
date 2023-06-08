<?php
    //by: Gonza Zeballos
    //Esta clase es para la conexion a la base de datos
    //Creacion: 26/04/2023
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");
class dataBasePG{

    private $dbname, $dbhost, $dbuser, $dbpasswd, $dbport;
    private $_dblink;
    private $numRows, $numCols, $affectedRows, $lastError, $lastOid, $nameCols;
    private $optionsLog;


    private $connectionName, $connectionStatus;


    function __construct($connectionName)
    {
        $this->connectionName = $connectionName;
        if (isset($connectionName)) {
            $this->setParametrosBD($connectionName);
        }

    }


    function __destruct()
    {
        unset($this->dbuser);
        unset($this->dbname);
        unset($this->dbhost);
        unset($this->dbpasswd);
        unset($this->dbport);
        unset($this->connectionName);
        unset($this->connectionStatus);
        $this->close();
    }


    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT'].'/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/logDB',           
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


    /*
    * Ejecuta una sentencia SQL
    * @access private
    * @param string $tSql Cadena SQL a ser ejecutada
    * @return resource $res
    */
    private function setQueryParameters($tSql)
    {
        $result = false;
        if (  $this->getStatus() == false ) {
           $result = pg_query($this->_dblink, $tSql);
           if ($result == true) {
                $this->numRows = pg_num_rows($result);
                $this->numCols = pg_num_fields($result);
                $this->affectedRows = pg_affected_rows($result);
                $this->lastOid = pg_last_oid($result);
                $this->lastError = null;
                $this->createLog('dataBaseLog', "Consulta ejecutada con exito - Function: ".__FUNCTION__, "info");                
            } else {
                $this->lastError = pg_last_error($this->_dblink);
                $this->numRows = null;
                $this->numCols = null;
                $this->affectedRows = null;
                $this->lastOid = null;                    
                $mensaje = "[$tSql] [" . $this->lastError ."]";
                $this->createLog('dataBaseLog', $mensaje." Function: ".__FUNCTION__, "error");
            }
        } else {
            $mensaje = "[$tSql] [Error en conexion]".is_resource($this->_dblink);
            $this->createLog('dataBaseLog', $mensaje." Function: ".__FUNCTION__, "error");
        }
        return $result;
    }

    private function field_name($result)
    {
        $arr = array();
        for ($i = 0; $i < $this->getNumCols(); $i++) {
            $arr[] = pg_field_name($result, $i);
        }
        return $arr;
    }

    public function query($sql)
    {
        $result = false;
        $res = $this->setQueryParameters($sql);

        if (!is_bool($res)) {
            if ($this->lastError === NULL) {
                if($this->numRows == 0 && $this->affectedRows > 0 ){
                    $result = true;
                }
                else{
                    $table = array();
                    while ($row = pg_fetch_assoc($res)) {
                        $table[] = $row; // Agrega cada fila a $result
                    }
                    $this->nameCols = $this->field_name($res);
                    $result = $table;
                }
            }
            pg_free_result($res); // Libera los recursos de la consulta
        } else {
            $result = $res; // Si $res es un booleano (indicando un error), simplemente lo devuelve
        }
        #var_dump($result);
        return $result;
    }

    /*
    * Permite ejecutar sentencias SQL SELECT y obtiene los registros en un array asociativo
    * @access public
    * @param string $tSql Cadena SQL a ser ejecutada
    * @return array asociativo si el SQL tuvo exito, boolean si hubo algun problema $result
    */
    
    public function select($tSql){
        $res = $this->setQueryParameters($tSql);
        if (!is_bool($res)) {
            $this->nameCols = $this->field_name($res);
            $result = pg_fetch_all($res); 
            pg_free_result($res);
            //echo json_encode($result);
            return $result;
        } else {
            $mensaje ="[$tSql] [" . $this->getLastError() ."]";
            $this->createLog('dataBaseLog', $mensaje." Function: ".__FUNCTION__, "error");
            return $res;
        }
    }

    private function setParametrosBD($dataConnect)
    {
        $fileData = __DIR__."/config/config.ini";
        $data = parse_ini_file($fileData, true);
        if(array_key_exists($dataConnect, $data)) {
            $this->dbuser = $data[$dataConnect]['user'];
            $this->dbname = $data[$dataConnect]['dbName'];
            $this->dbhost = $data[$dataConnect]['host'];
            $this->dbpasswd = $data[$dataConnect]['password'];
            $this->dbport=$data[$dataConnect]["port"];
            $mensaje ="Datos asignados: user=[$this->dbuser], dbname=[$this->dbname],host=[$this->dbhost],password=[$this->dbpasswd],port=[$this->dbport]";
            $this->createLog('dataBaseLog', $mensaje." Function: ".__FUNCTION__, "info");
            $this->connect();
        } else {
            $mensaje ="Conexion invalida [$dataConnect]";
            $this->createLog('dataBaseLog', $mensaje." Function: ".__FUNCTION__, "warning");

        }
    }

    /*
    * Funcion que retorna un boolean dependiendo si pudo o no conectarse a la BD
    * en base a las configuraciones que fueron seteadas en el metodo setParametrosBD
    * @access private
    * @return boolean
    */
    public function connect()
    {
        
        $conn_string = "host=" . $this->dbhost . " port=" . $this->dbport . " dbname=" . $this->dbname . " user=" . $this->dbuser . " password=" . $this->dbpasswd;
        $this->_dblink = pg_connect($conn_string);
        if ($this->_dblink) {
            $this->connectionStatus = pg_connection_status($this->_dblink);
            $mensaje = $this->getStatus();
           
            $this->createLog('dataBaseLog', "Conexion buena: ".$mensaje." - Function: ".__FUNCTION__, "info");
            return true;
        }
        $mensaje = $this->getStatus();
        $this->createLog('dataBaseLog', "No hay conexion: ".$mensaje." - Function: ".__FUNCTION__, "warning");
        return false;
    }


 
    private function close()
    {
        if (is_resource($this->_dblink)) {
            pg_close($this->_dblink);
            unset($this->_dblink);
        }
    }
    public function getNumRows()
    {
        return $this->numRows;
    }

    public function getNumCols()
    {
        return $this->numCols;
    }

    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function getLastOID()
    {
        return $this->lastOid;
    }

    public function getNameCols()
    {
        return $this->nameCols;
    }
    public function getStatus(){
        $response = (pg_connection_status($this->getConexion()) === PGSQL_CONNECTION_OK) ? FALSE : TRUE;
        return $response;
    }
    public function getConexion()
    {
        return $this->_dblink;
    }
}
