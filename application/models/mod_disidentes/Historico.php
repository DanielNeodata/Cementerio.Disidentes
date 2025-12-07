<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Historico extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }


    public function rubros($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x RUBROS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;
			

            log_message('error', 'cco-> pasando x Rubros en HISTORICO de rubos AFTER COMBO ');

            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function cuentas($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x CUENTAS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;
			
            $html=$this->load->view($values["interface"],$data,true);

            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function plan_de_cuentas($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x CUENTAS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;

            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function diario($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x RUBROS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;
			


            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function mayor($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x RUBROS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;

            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function balance($values){
        try {
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/".$location[1]);
            $data["parameters"] = $values;
            $data["title"] = ucfirst(lang("m_".strtolower($values["function"])));

            $sql = " SELECT ID, COMENTARIO FROM CON_Configuracion_Historico ORDER BY COMENTARIO";

            log_message('error', 'cco-> pasando x RUBROS en HISTORICO de rubos VIEW es:->'.$sql."<-");
            $ejercicios = $this->execAdHocAsArray($sql);

            $data["ejercicios"] = $ejercicios;

            $html=$this->load->view($values["interface"],$data,true);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>compress($this,$html),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null,
                "compressed"=>true
            );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
