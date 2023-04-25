<?php
    require("../../log/common/log.php");
    //by: Harol Arcos - Gonza Zeballos
    //Esta clase es para la conexion de la base de datos
    //Creacion: 23/04/2023
    class db{

        private $optionsLog;
        private $user,$dbName,$host,$password,$port;
        private $connectionName,$connectionStatus,$connection;
        //private $pathLog ="../../logs/errorDb.log";//modificar la ubicacion
        private $numRows,$numCols,$affectedRows,$lastError,$lastOid,$colsNames;

        function __construct($connectionName){
            
            $this->connectionName = $connectionName;
            if (isset($connectionName)) {
                $this->setParameters($connectionName);
            }
        }

        function __destruct(){

            unset($this->user);
            unset($this->dbName);
            unset($this->host);
            unset($this->password);
            unset($this->port);
            unset($this->connectionName);
            unset($this->connectionStatus);
            unset($this->connection);
            //unset($this->pathLog);
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

        private function setParameters($connectionName){
            $pathDataFile=__DIR__."/config/config.ini";
            $data=parse_ini_file($pathDataFile,true);
            if (array_key_exists($connectionName,$data)) {
                $this->user=$data[$connectionName]["user"];
                $this->dbName=$data[$connectionName]["dbName"];
                $this->host=$data[$connectionName]["host"];
                $this->password=$data[$connectionName]["password"];
                $this->port=$data[$connectionName]["port"];
                $this->connect();
            }else{
                //$this->printLog("Nombre de la conexion no encontrado [$connectionName]");
                $mensaje = "Nombre de la conexion no encontrado [$connectionName]";
                $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "warning");
            }
        }

        /*private function printLog($message){
            $message = date("Y-m-d H:i:s")." ".$message; 
            $php = $_SERVER["PHP_SELF"];
            error_log("[$php] ".$message."\n", 3, $this->pathLog);
            return true;    
        }*/

        private function connect(){

            $this->connection = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->dbName}", $this->user, $this->password);
            if ($this->connection) {
                $this->connectionStatus = $this->connection->get_connection_stats();//no hay metodo en pg, buscar otro
                return true;
            }
            return false;

        }

        private function close(){
            if (is_resource($this->connection)) {
                $this->connection->close();//revisar error
                unset($this->connection);
            }
        }

        private function setQueryParameters($sql)
        {
            $result = false;
            if (is_object($this->connection) && ( $this->connectionStatus )) {
                $result = $this->connection->query($sql);
                if ($result) {
                    $this->numRows = isset($result->num_rows) ? $result->num_rows : 0;
                    $this->numCols = isset($result->field_count) ? $result->field_count : 0;
                    $this->affectedRows = $this->connection->affected_rows;
                    $this->lastOid = $this->connection->insert_id;
                    $this->lastError = false;                
                } else {
                    $this->lastError = $this->connection->error;
                    $this->numRows = null;
                    $this->numCols = null;
                    $this->affectedRows = null;
                    $this->lastOid = null;                    
                    //$this->printLog("[$sql] [" . $this->lastError ."]");
                    $mensaje = "[$sql] [" . $this->lastError ."]";
                    $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "warning");
                }
            } else {
                //$this->printLog("[$sql] [Error en conexion]");
                $mensaje = "[$sql] [Error en conexion]";
                $this->createLog('dataBaseLog', $mensaje." Function error: ".__FUNCTION__, "error");
            }
            return $result;
        }

        public function query($sql)
        {
            $result = false;
            $res = $this->setQueryParameters($sql);
            
            if (!is_bool($res)) {
                $result = array();
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {//cambiar a pg
                    $result[] = $row;
                }
                $res->free();//cambiar a pg 
            } else {
                $result=$res;
            }
            return $result;
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

        public function getColsNames()
        {
            return $this->colsNames;
        }

        public function getStatus()
        {        
            return ($this->connection->ping()) ? TRUE : FALSE;
        }



    }