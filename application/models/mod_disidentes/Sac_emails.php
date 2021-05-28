<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
set_include_path(APPPATH.'third_party/PHPMailer-master');
include_once APPPATH.'third_party/PHPMailer-master/src/PHPMailer.php';
include_once APPPATH.'third_party/PHPMailer-master/src/SMTP.php';
include_once APPPATH.'third_party/PHPMailer-master/src/OAUTH.php';
include_once APPPATH.'third_party/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

//use PHPMailer\PHPMailer\Exception;

class Sac_emails extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }

    

   public function processBatchMail($values){
        try {
            log_message('error', 'cco-> pasando x processBatchMail de sac mails init!.');

            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}

            $where2 = $values["where"];

            log_message('error', 'cco-> pasando x processBatchMail de sac mails WHERE2: '.$where2);

            //$values["order"]=" description ASC";
            $notificaciones=$this->execAdHocAsArray("select * from emails where estado='' or estado is null or estado='error'");
            $server=$this->execAdHocAsArray("select top 1 * from mailers ");

            $host = $server[0]["Direccion"];
		    $username = $server[0]["usuario"];
		    $password = $server[0]["clave"];
            $port = $server[0]["Puerto"];

            log_message('error', "cco-> pasando x processBatchMail de sac mails host: ".$host." y port ".$port." user ".$username." pass ".$password);

            /*procesar los mails*/
             $mail = new PHPMailer();
             log_message('error', 'cco-> pasando x New PHPMailer() processBatchMail de sac mails init!.');
             foreach($notificaciones as $r){
                log_message('error', "cco-> pasando x processBatchMail de sac mails id: ".$r["id"]." y ".$r["toName"]);

 
		         $from = $r["remite"];
                 $fromName = $r["fromName"];
		         $to = $r["destinatario"];
                 $toName = $r["toName"];
		         $subject = $r["subject"];
		         $body = $r["body"];
		            
		            
            
		            //$mail->From = $from;
		            $mail->setFrom($from,$fromName);
		            //$mail->FromName = "Eduardo Garcia";




		            // Settings
		            $mail->IsSMTP();
		            $mail->CharSet = 'UTF-8';

		            $mail->Host       = $host; // SMTP server example
		            $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
				
			        if ($server[0]["UsaSSL"]=="S")
                    {

		                $mail->SMTPAuth   = true;                  // enable SMTP authentication

		                $mail->SMTPOptions = [
		                    'ssl' => [
		                        'verify_peer' => false,
		                        'verify_peer_name' => false,
		                        'allow_self_signed' => true,
		                    ]
		                ];

		                $mail->SMTPSecure = "ssl";
		                $mail->Username   = $username; // SMTP account username example
		                $mail->Password   = $password;        // SMTP account password example

                    }
		            $mail->Port       = $port;                    // set the SMTP port for the GMAIL server

		            $mail->AddAddress($to,$toName);

		            // Content
		            $mail->isHTML(true);                                  // Set email format to HTML
		            $mail->Subject = $subject;
		            $mail->Body    = $body;
		            $mail->AltBody = 'Mail en html';

		            log_message('error', 'cco-> pasando x before send() processBatchMail de sac mails init!.');



		            if(!$mail->Send()) {
		                log_message('error', 'cco-> pasando x error en send processBatchMail de sac mails init!: '.$mail->ErrorInfo);
                        $stat=$this->execAdHocAsArray("exec sp_emails_update ".$r["id"].",'".$mail->ErrorInfo."'");
            
		            }
                    else
                    {
                        $stat=$this->execAdHocAsArray("exec sp_emails_update ".$r["id"].",''");
                    }

            }

		    log_message('error', 'cco-> pasando x afer send() processBatchMail de sac mails init!.');

            /*fin procesar mails actualizar brow*/

            log_message('error', 'cco-> pasando x processBatchMail de sac lotes end1!.');

            $values["function"] = "brow";
            $values["view"]="emails";

            return $this->brow($values);
        }
        catch(Exception $e){
        
            log_message('error', 'cco-> pasando x EXCEPTION EN processBatchMail de sac lotes end1!.');
            return logError($e,__METHOD__ );
        }
    }

    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac emails init!.');

            log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));

            logGeneral($this,$values,__METHOD__);
            $values["view"]="emails";
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>true,
             "excel"=>true,
             "pdf"=>true,
             "processBatchMail"=>true,
           );

            $values["buttons"]=array(
                "new"=>false,
                "edit"=>true,
                "delete"=>true,
                "offline"=>false,
            );
            $values["columns"]=array(
                //array("field"=>"Id","format"=>"text"),

                array("field"=>"remite","format"=>"text"),
                array("field"=>"destinatario","format"=>"text"),
                array("field"=>"subject","format"=>"text"),
                array("field"=>"fecha_envio","format"=>"text"),
                array("field"=>"estado","format"=>"text"),
                array("field"=>"error","format"=>"text"),
                array("field"=>"body","format"=>"text"),
                //array("field"=>"ESTADO_OCUPACION","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            
            $values["controls"]=array(
                //"<a href='#' class='btn btn-md btn-danger btn-raised btnEnviarCorreos'>Enviar correos ahora!</a>",
                "<label>".lang('p_estado')."</label><input type='text' id='browser_estado' name='browser_estado' class='form-control text'/>",
                "<label>".lang('p_destinatario')."</label><input type='text' id='browser_destinatario' name='browser_destinatiario' class='form-control text'/>",
                "<label>".lang('p_body')."</label><input type='text' id='browser_body' name='browser_body' class='form-control text'/>",
                //"<label>".lang('p_ESTADO_OCUPACION')."</label><input type='text' id='browser_estado_ocupacion' name='browser_estado_ocupacion' class='form-control text'/>",

            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_estado", "operator"=>"like","fields"=>array("estado")),
                array("name"=>"browser_destinatario", "operator"=>"like","fields"=>array("destinatario")),
                array("name"=>"browser_body", "operator"=>"like","fields"=>array("body")),

            );

            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function edit($values){
        try {
            log_message('error', 'cco-> pasando x edit de sac emails!.');
            log_message("error", "ARRAY values ".json_encode($values,JSON_PRETTY_PRINT));
            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;

            $values["view"]="emails";

            $values["where"]=("Id=".$values["id"]);
            $values["records"]=$this->get($values);

            log_message('error', 'cco-> pasando x edit de emails!.'.$values["where"]);

            log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));

            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de memails!.');
        log_message('error', 'cco-> pasando x save de emails! ANTES IF');
        $values["view"]="emails";
        try {
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de emails! Sin ID entonces CREO una FILA.');
                log_message('error', 'cco-> pasando x save de emails! Sin ID entonces CREO una FILA.');

                if($fields==null) {
                    $fields = array(
                        'remite' => $values["remite"],
                        'destinatario' => $values["destinatario"],
                        'subject' => $values["subject"],
                        'body' => $values["body"],
                        'error' => $values["error"],
                        'estado' => $values["estado"],
                        'toName' => $values["toName"],
                        'fromName' => $values["fromName"],

                    );
                }
            } else {
                log_message('error', 'cco-> pasando x save de sac emails');
                log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                        'remite' => $values["remite"],
                        'destinatario' => $values["destinatario"],
                        'subject' => $values["subject"],
                        'body' => $values["body"],
                        'error' => $values["error"],
                        'estado' => $values["estado"],
                        'toName' => $values["toName"],
                        'fromName' => $values["fromName"],

                    );
                }
            }
            return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    public function delete($values){
        try {
            log_message('error', 'cco-> pasando x delete emails!.');
			try
			{
                log_message('error', 'cco-> borrando emails->'.$values["id"]);
				//foreach ($values as $key => $child) {
				//    log_message('error', 'cco-> borrando detalle recibo valores en: '.$key." <--> ".$child." <-");
				//    //if (is_array($child)) {
				//    //  $newArray =& array_flatten($child, $preserve_keys, $newArray);
				//    //} elseif ($preserve_keys + is_string($key) > 1) {
				//    //  $newArray[$key] = $child;
				//    //} else {
				//    //  $newArray[] = $child;
				//    //}
				//}

				$this->db->where('id', $values["id"]);
				$this->db->delete('emails');
			}
			catch(Exception $ee){
			    return logError($ee,__METHOD__ );
			    throw $ee;
			}   

            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>lang('msg_delete'),
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>null
                );
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
