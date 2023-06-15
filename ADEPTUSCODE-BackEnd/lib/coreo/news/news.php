<?php
include_once($_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/lib/common/log.php");  
//Clase Creada 03/05/2023
//by: Gonza Zeballos M.
//Clase mapeada de la tabla noticia

class news {

    private $optionsLog;
    private $_db;
    private $idNews,$idPerson,$statusNews,$lastPerson,$titleNews,$textNews;// $dateNews, $lastDateNews;

    function __construct($_db,$idNews=0){
        
        $this->_db=$_db;
        if ($idNews!=0) {
            $this->setNews($idNews);
        }
    }

    function __destruct(){
        unset($this->_db);
        unset($this->idNews);
        unset($this->idPerson);
        unset($this->statusNews);
        unset($this->lastPerson);
        unset($this->titleNews);
        unset($this->textNews);
        //unset($this->dateNews);
        //unset($this->lastDateNews);
    }

    private function createLog($fileName, $logMessage, $tipeError){
        $this->optionsLog = array(
            'path'           => $_SERVER['DOCUMENT_ROOT']."/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/log/nucleo/news",           
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
    
    private function setNews($idNews){
        $response = FALSE;
        $dataNews = $this->findNewsDb($idNews);
        if($dataNews){
            $this->mapNews($dataNews);
            $response = TRUE;
        }
        $arrLog = array("input"=>$idNews,"output"=>$response);
        $this->createLog('apiLog', print_r($arrLog, true)." Function: ".__FUNCTION__, "warning");
        return $response;
    }
    
    private function findNewsDb($idNews){
        $response = false;
        $sql =  "SELECT * FROM noticia ".
                "where noticia_id = $idNews";
                
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>$idNews,"sql"=>$sql,"error"=>$this->_db->getLastError());
           $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");   
        } else {
            
            $response = $rs[0];
            $arrLog = array("input"=>$idNews,"output"=>$response,"sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }


    public function insertNewsDb($idPerson,$statusNews,$lastPerson,$titleNews,$textNews){
        $response = false;
        $sql =  "INSERT INTO noticia(noticia_estado, persona_id, ultima_persona_id, noticia_titulo, noticia_texto, noticia_fecha, noticia_ultima_modificacion) VALUES ($statusNews, $idPerson, $lastPerson, '$titleNews' , '$textNews' , date_trunc('second', timezone('America/La_Paz', current_timestamp)), date_trunc('second', timezone('America/La_Paz', current_timestamp)))";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "statusNews"=> $statusNews,
                                            "lastNews"=> $lastPerson, 
                                            "titleNews"=> $titleNews,
                                            "textNews"=> $textNews
                                        ),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idPerson"=> $idPerson,
                                            "statusNews"=> $statusNews,
                                            "lastNews"=> $lastPerson, 
                                            "titleNews"=> $titleNews,
                                            "textNews"=> $textNews
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);

            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function editNewsDb($idNews,$statusNews,$lastPerson,$titleNews,$textNews){
        $response = false;
        $sql =  "UPDATE noticia SET
        noticia_estado =$statusNews,
        ultima_persona_id = $lastPerson, 
        noticia_titulo = '$titleNews', 
        noticia_texto = '$textNews',
        noticia_ultima_modificacion =  date_trunc('second', timezone('America/La_Paz', current_timestamp))
        WHERE noticia_id = $idNews";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            
            $arrLog = array("input"=>array( "idNews"=> $idNews,
                                            "statusNews"=> $statusNews,
                                            "lastNews"=> $lastPerson, 
                                            "titleNews"=> $titleNews,
                                            "textNews"=> $textNews
                                        ),

                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idNews"=> $idNews,
                                            "statusNews"=> $statusNews,
                                            "lastNews"=> $lastPerson, 
                                            "titleNews"=> $titleNews,
                                            "textNews"=> $textNews
                                        ),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }
    public function changeStateNewsDb($idNews, $statusNews){
        $response = false;
        $sql =  "UPDATE noticia SET noticia_estado = $statusNews WHERE noticia_id = $idNews";
        $rs = $this->_db->query($sql);
        if($this->_db->getLastError()) {
            $arrLog = array("input"=>array( "idNews" => $idNews,"noticia_estado" => $statusNews),
                            "sql"=>$sql,
                            "error"=>$this->_db->getLastError());
            $this->createLog('dbLog', print_r($arrLog, true), "error");  
        } else {
            $response = $rs;
            $arrLog = array("input"=>array( "idNews" => $idNews,"noticia_estado" => $statusNews),
                            "output"=>$response,
                            "sql"=>$sql);
            $this->createLog('apiLog', print_r($arrLog, true)." Function error: ".__FUNCTION__, "debug");
        }
        return $response;
    }

    public function listNewsDb(){
        $response = false;
        $sql = "SELECT n.*, r.referencia_valor AS estadoNoticia,
        CONCAT(p1.persona_nombre, ' ', p1.persona_apellido) AS autor,
        CONCAT(p2.persona_nombre, ' ', p2.persona_apellido) AS autorModificacion
      FROM noticia n
      JOIN referencia r ON n.noticia_estado = r.referencia_id
      JOIN persona p1 ON n.persona_id = p1.persona_id
      JOIN persona p2 ON n.ultima_persona_id = p2.persona_id";
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

    public function listNewsActiveDb(){
        $response = false;
        $sql = "SELECT n.*, r.referencia_valor AS estadoNoticia,
        CONCAT(p1.persona_nombre, ' ', p1.persona_apellido) AS autor,
        CONCAT(p2.persona_nombre, ' ', p2.persona_apellido) AS autorModificacion
      FROM noticia n
      JOIN referencia r ON n.noticia_estado = r.referencia_id
      JOIN persona p1 ON n.persona_id = p1.persona_id
      JOIN persona p2 ON n.ultima_persona_id = p2.persona_id
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

	
    private function mapNews($rs){
        $this->idNews = $rs['noticia_id'];
        $this->idPerson = $rs['persona_id'];
        $this->statusNews = $rs['noticia_estado'];
        $this->lastPerson = $rs['ultima_persona_id'];
        $this->titleNews = $rs['noticia_titulo'];
        $this->textNews = $rs['noticia_texto'];
    }


    public function getNewsId(){
        return $this->idNews;
    }

    public function getPersonId(){
        return $this->idPerson;
    }

    public function getStatusNews(){
        return $this->statusNews;
    }
    
    public function getLastPerson(){
        return $this->lastPerson;
    }
    
    public function getTitleNews(){
        return $this->titleNews;
    } 
    
    public function getTextNews(){
        return $this->textNews;
    }

}