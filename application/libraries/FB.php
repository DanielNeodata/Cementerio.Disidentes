<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once 'Facebook/Facebook.php';
//require_once 'Facebook/autoload.php';

require 'Facebook/Facebook.php';
require_once dirname(__FILE__) . '/Facebook/Facebook.php';
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/Facebook/');
require_once __DIR__ . '/Facebook/autoload.php';

class FB{
    public $fb;
    public $time_limit="-6 hours";
    public $app_id="174621396079258";
    public $app_secret="4341ed6191da0d0aeb0d4fbbf2d64be3";
    public $page_token="";
    public $app_version ="v3.3";
    public $token="";
    /*¡Fuerza el uso de la token page a la de Neodata!*/
    public $tk_neodata="EAACe0TZAIkpoBAEHeUWI8ZBLRPCJHjw6eQl2GMQ6q8Tdbr7rT7JkMWfv9TfNHDXEZAqeTdohIHgqqQQgXLcbPhZBaZABu8wgqyzX4jmuYZBRjhL50zkBfFVal5aX5bHyZBEwqXoydLv0QJmIh4WkJxyRJmbCTBhGFTyMdDMgtJqaAZDZD";
    public $daniel_id="100002255911987";

    function __construct() {}

    function init(){
         $params=array('app_id' => $this->app_id,'app_secret' => $this->app_secret,'default_graph_version' => $this->app_version);
//log_message("error", "INIT ".json_encode($params,JSON_PRETTY_PRINT));
         $this->fb = new Facebook\Facebook($params);
         $query = http_build_query(array('client_id'=>$this->app_id,'client_secret'=>$this->app_secret,'grant_type'=>'client_credentials'));
//log_message("error", "INIT ".$this->fb->getApp()->getAccessToken());
         $response_graph = $this->fb->get('/oauth/access_token?'.$query,$this->fb->getApp()->getAccessToken());
         $graph = $response_graph->getGraphNode();
         $this->token = $graph->getField('access_token');
         $this->fb->setDefaultAccessToken($this->token);
    }

    function pageStats($id){
         try {
             $this->init();
             $fields="id,name,username,category,checkins,link,fan_count,were_here_count,rating_count,overall_star_rating";
             $response=$this->fb->get("/".$id."?fields=".$fields,$this->page_token);
             $go=$response->getGraphNode();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function pagePosts($id){
         try {
             $this->init();
             $from=date("Y-m-d H:i:s", strtotime($this->time_limit));
//log_message("error", "URL "."/".$id."/feed");
//log_message("error", "PAGE TOKEN ".$this->page_token);
             //$response=$this->fb->get("/".$id."/feed",$this->page_token);
             $response=$this->fb->get("/".$id."/feed?since=".$from."&until=now",$this->page_token);
             $go=$response->getGraphEdge();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function detailPost($id){
         try {
             $this->init();
             $response=$this->fb->get("/".$id,$this->page_token);
             $go=$response->getGraphNode();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }

    function pageConversations($id){
         try {
             $this->init();
             $from=date("Y-m-d H:i:s", strtotime($this->time_limit) );
             $response=$this->fb->get("/".$id."?fields=conversations&since=".$from."&until=now",$this->page_token);
             $go=$response->getGraphNode();//original
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function objectComments($id){
         try {
             $from=date("Y-m-d", strtotime($this->time_limit) );
             $response=$this->fb->get("/".$id."/comments?since=".$from."&until=now",$this->page_token);
             $go=$response->getGraphEdge();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function detailComment($id){
         try {
             $fields="id,created_time,from,like_count,message";
             $response=$this->fb->get("/".$id."?fields=".$fields,$this->page_token);
             $go=$response->getGraphNode();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function objectMessages($id){
         try {
             $from=date("Y-m-d", strtotime($this->time_limit) );
             $response=$this->fb->get("/".$id."/messages?since=".$from."&until=now",$this->page_token);
             $go=$response->getGraphEdge();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function detailMessage($id){
         try {
             $fields="id,created_time,message,sticker,tags,from,to";
             $response=$this->fb->get("/".$id."?fields=".$fields,$this->page_token);
             $go=$response->getGraphNode();
             return $go;
         } catch(Exception $e){
             return null;
         }
    }
    function postToObject($id,$postArray){
         try {
             if($this->fb==null){$this->init();}
             $response=$this->fb->post("/".$id."/comments",$postArray,$this->page_token);
             $go=$response->getGraphNode();
             return $go;
         } catch(Exception $e){
             return $this->page_token."<br/>".$e;             
         }
    }
    function postToPage($id,$postArray,$files){
        try {
            $id_photo=null;
            if($this->fb==null){$this->init();}
            /*------------------------------------*/
            /*Fuerza publicar en Neodata*/
            /*------------------------------------*/
            //$id="150183358364750";
            //$this->page_token = $this->tk_neodata;
            /*------------------------------------*/
            if($files!=null) {
               foreach($files as $file) {
                    $data = ['no_story'=>true,'caption'=>'','source'=>$this->fb->fileToUpload($file["filename"]),];
                    $response=$this->fb->post('/'.$id.'/photos', $data, $this->page_token);
                    $photo=$response->getGraphNode();
                    $id_photo=$photo["id"];
                    $postArray["object_attachment"]=$id_photo;
               }
            }
            $post=$this->fb->post("/".$id."/feed",$postArray,$this->page_token);
            $nodo=$post->getGraphNode();
            return array("id_post"=>$nodo["id"],"id_photo"=>$id_photo);
        } catch(Exception $e){
            return null;
        }
    }
    function postToMessenger($id,$message){
         try {
             if($this->fb==null){$this->init();}
             $url="https://graph.facebook.com/v8.0/me/messages?access_token=".$this->page_token;
             $url="https://graph.facebook.com/v8.0/"."115931448452946"."/messages?access_token=".$this->page_token;
             $fields=array("messaging_type"=>"RESPONSE","recipient"=>array("id"=>$id),"message"=>array("text"=>$message));
             $body=json_encode($fields);
             $headers=array('Content-Type: application/json','Accept: application/json','Content-Length: '.strlen($body));
log_message("error", "FIELDS ".json_encode($fields,JSON_PRETTY_PRINT));
             $response=$this->cUrl($url,$headers,$body);
log_message("error", "RESPONSE ".json_encode($response,JSON_PRETTY_PRINT));
             return $response;
         } catch(Facebook\Exceptions\FacebookResponseException $e) {
             return $this->page_token."->1<br/>".$e->getMessage();             
         } catch(Facebook\Exceptions\FacebookSDKException $e) {
             return $this->page_token."->2<br/>".$e->getMessage();             
         } catch(Exception $e){
             return $this->page_token."->3<br/>".$e;             
         }
    }

    function cUrl($url,$headers,$fields){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($headers!=null) {curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);}
        if ($fields!=null) {curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);}
        $jsonResponse = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err=curl_error($ch);
        curl_close($ch);
        $response = json_decode($jsonResponse, true);
        return $response;
    }   

    /*TESTING!!!!*/
    function getUserData($id,$fields,$access_token) {
        $opts = array('http'=>array('header' => "User-Agent:Mozilla/5.0\r\n")); 
        $context = stream_context_create($opts);
        $query=http_build_query(array('access_token'=>$access_token,'fields'=>$fields));
        $url="https://graph.facebook.com/v8.0/".$id."?".$query;
        $url=str_replace('&','&amp;',$url);
        $response=file_get_contents($url,false,$context);
        return json_decode($response,true);
    }
    function getPageData($id,$fields="id,access_token,name,username,category,checkins,link,location,fan_count,were_here_count,rating_count,overall_star_rating,likes,feed,visitor_posts") {
         $response=$this->fb->get("/".$id."?fields=".$fields);
         return $response->getGraphNode();
    }
    function getPageFeed($id) {
         $response=$this->fb->get("/".$id."/feed");
         return $response->getGraphEdge();
    }
    function getPageVisitorPosts($id) {
         $response=$this->fb->get("/".$id."/visitor_posts");
         return $response->getGraphEdge();
    }
    function getPageMetrics($id) {
         $response=$this->fb->get("/".$id."/insights?period=days_28&metric=page_views_total");
         return $response->getGraphEdge();
    }
    function getNext($cursor){
       return $this->fb->next($cursor);
    }


}
