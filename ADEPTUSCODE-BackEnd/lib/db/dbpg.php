<?php
require("../../log/common/log.php");
class dataBasePG{

    private $dbname, $dbhost, $dbuser, $dbpasswd, $dbport;//corregido
    private $_dblink;//bien
    private $numRows, $numCols, $affectedRows, $lastError, $lastOid, $nameCols;
    private $_pathpass;
    private $optionsLog;
    //private $_pathlog;


    private $connectionName, $connectionStatus;//


    function __construct($connectionName)
    {
        //$this->_pathlog = "/var/log/process/errorDB.log";
        $this->connectionName = $connectionName;
        if (isset($connectionName)) {
            $this->setParametrosBD($connectionName);
        }

    }


    function __destruct()
    {
        unset($this->dbuser);//
        unset($this->dbname);//
        unset($this->dbhost);//
        unset($this->dbpasswd);//
        unset($this->dbport);//
        unset($this->connectionName);//
        unset($this->connectionStatus);//
        unset($this->_dblink);//adaptado
        $this->close();
    }


    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => '../../../../log/logDB',           
            'filename'       => $fileName,         
            'syslog'         => false,         // true = use system function (works only in txt format)
            'filePermission' => 0644,          // or 0777
            'maxSize'        => 0.001,         // in MB
            'format'         => 'txt',         // use txt, csv or htm
            'template'       => 'barecss',     // for htm format only: plain, terminal or barecss
            'timeZone'       => 'America/La_Paz',         
            'dateFormat'     => 'Y-m-d H:i:s', 
            'backtrace'      => true,          // true = slower but with line number of call
          );
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
    * Obtener la conexion a la BD
    * @access public
    * return enlace conexion BD
    */

    public function getStatus(){
        $response = (pg_connection_status($this->getConexion()) === PGSQL_CONNECTION_OK) ? TRUE : FALSE;
        return $response;
    }
    public function getConexion()
    {
        return $this->_dblink;
    }

    /**
    * Ejecuta una sentencia SQL
    * @access private
    * @param string $tSql Cadena SQL a ser ejecutada
    * @return resource $res
    */
    private function _query($tSql)
    {
        $result = false;
        if (is_resource($this->_dblink) && ( $this->connectionStatus === PGSQL_CONNECTION_OK )) {
           $result = pg_query($this->_dblink, $tSql);
           if ($result == true) {
                $this->numRows = pg_num_rows($result);
                $this->numCols = pg_num_fields($result);
                $this->affectedRows = pg_affected_rows($result);
                $this->lastOid = pg_last_oid($result);
                $this->lastError = null;                
            } else {
                $this->lastError = pg_last_error($this->_dblink);
                $this->numRows = null;
                $this->numCols = null;
                $this->affectedRows = null;
                $this->lastOid = null;                    
                //$this->printLog();
                $mensaje = "[$tSql] [" . $this->lastError ."]";
                $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "warning");
            }
        } else {
            $mensaje = "[$tSql] [Error en conexion]";
            $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "error");
        }
        return $result;
    }

    private function fetch_assoc($result)
    {
        return pg_fetch_assoc($result);
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
        $result = $this->_query($sql);
        return $result;
    }

    /*
    * Permite ejecutar sentencias SQL SELECT y obtiene los registros en un array asociativo
    * @access public
    * @param string $tSql Cadena SQL a ser ejecutada
    * @return array asociativo si el SQL tuvo exito, boolean si hubo algun problema $result
    */
    public function select($tSql)
    {
        $result = false;
        $res = $this->_query($tSql);

        if (!is_bool($res)) {
            $result = array();
            while ($row = pg_fetch_assoc($res)) {
                $result[] = $row;
            }
            $this->nameCols = $this->field_name($res);
            pg_free_result($res);
	    } else {
            $mensaje ="[$tSql] [" . $this->getLastError() ."]";
            $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "error");
        }
        return $result;
    }


   
    public function setParametrosBD($dataConnect)
    {
        $fileData = __DIR__ . "/ADEPTUSCODE-BackEnd/lib/db/config/config.ini";
        $data = parse_ini_file($fileData, true);
        if(array_key_exists($dataConnect, $data)) {
            $this->dbuser = $data[$dataConnect]['user'];
            $this->dbpasswd = $data[$dataConnect]['password'];
            $this->dbname = $data[$dataConnect]['base'];
            $this->dbhost = $data[$dataConnect]['host'];
        } else {
            //$this->printLog("Conexion invalida [$dataConnect]");
            $mensaje ="Conexion invalida [$dataConnect]";
            $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "warning");

        }
        
        return $this->connect();
    }

    /**
    * Funcion que retorna un boolean dependiendo si pudo o no conectarse a la BD
    * en base a las configuraciones que fueron seteadas en el metodo setParametrosBD
    * @access private
    * @return boolean
    */
    private function connect()
    {
        
        $conn_string = "host=" . $this->dbhost . " port=5432 dbname=" . $this->dbname . " user=" . $this->dbuser . " password=" . $this->dbpasswd;
        $this->_dblink = pg_connect($conn_string);
        if ($this->_dblink) {
            $this->connectionStatus = pg_connection_status($this->_dblink);
            return true;
        }
        return false;

    }


    /**
    * Cierra la conexion a la BD
    */
    private function close()
    {
        if (is_resource($this->_dblink)) {
            pg_close($this->_dblink);
            unset($this->_dblink);
        }
    }

    /*NO SRIVE
     private function printLog($message){
        $message = date("Y-m-d H:i:s")." ".$message; 
        $php = $_SERVER["PHP_SELF"];
        error_log("[$php] ".$message."\n", 3, $this->_pathlog);
        return true;    
    }*/

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

     /**
    * Metodo que setea los datos de conexion a la BD
    * @access public
    * @param string $dbhost Nombre o IP del host de la BD
    * @param string $dbname Nombre BD
    * @param string $dbuser Usuario de BD
    * @param string $dbpasswd Clave usuario BD
    * @return boolean {true|false}
    */
    
}
