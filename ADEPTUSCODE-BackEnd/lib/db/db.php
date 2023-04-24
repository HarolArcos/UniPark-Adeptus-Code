<?php
    //by: Kevin Santillan
    //Esta clase es para la conexion de la base de datos
    //Creacion: 12/04/2022
    class db{

        private $user,$dbName,$host,$password,$port;
        private $connectionName,$connectionStatus,$connection;
        private $pathLog ="../../logs/errorDb.log";//modificar la ubicacion
        private $numRows,$numCols,$affectedRows,$lastError,$lastOid,$colsNames;

        function __construct($connectionName){
            
            $this->connectionName = $connectionName;
            if (isset($connectionName)) {
                $this->setParameters($connectionName);
            }
        }

        function __desctruct(){

            unset($this->user);
            unset($this->dbName);
            unset($this->host);
            unset($this->password);
            unset($this->port);
            unset($this->connectionName);
            unset($this->connectionStatus);
            unset($this->connection);
            unset($this->pathLog);
            $this->close();

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
                $this->printLog("Nombre de la conexion no encontrado [$connectionName]");
            }
        }

        private function printLog($message){
            $message = date("Y-m-d H:i:s")." ".$message; 
            $php = $_SERVER["PHP_SELF"];
            error_log("[$php] ".$message."\n", 3, $this->pathLog);
            return true;    
        }

        private function connect(){

            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbName,$this->port);
            if ($this->connection) {
                $this->connectionStatus = $this->connection->get_connection_stats();
                return true;
            }
            return false;

        }

        private function close(){
            if (is_resource($this->connection)) {
                $this->connection->close();
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
                    $this->printLog("[$sql] [" . $this->lastError ."]");
                }
            } else {
                $this->printLog("[$sql] [Error en conexion]");
            }
            return $result;
        }

        public function query($sql)
        {
            $result = false;
            $res = $this->setQueryParameters($sql);
            
            if (!is_bool($res)) {
                $result = array();
                while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
                    $result[] = $row;
                }
                $res->free();
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