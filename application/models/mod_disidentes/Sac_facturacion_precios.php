<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/

class Sac_facturacion_precios extends MY_Model {
    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function brow($values){
        try {
            log_message('error', 'cco-> pasando x brow de sac servicios init!.');
            logGeneral($this,$values,__METHOD__);
            $values["view"]="SAC_Servicio";
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);

            $values["getters"]=array(
             "search"=>true,
             "googlesearch"=>true,
             "excel"=>true,
             "pdf"=>true,
           );

            $values["buttons"]=array(
                "new"=>false,
                "edit"=>true,
                "delete"=>false,
                "offline"=>false,
            );
            $values["columns"]=array(
                array("field"=>"ID","format"=>"text"),
                array("field"=>"FECHA","format"=>"text"),
                array("field"=>"","format"=>null),
                array("field"=>"","format"=>null),
            );

            $values["controls"]=array(
                "<label>".lang('p_FECHA')."</label><input type='number' id='browser_seccion' name='browser_seccion' class='form-control number'/>",
            );

            $values["filters"]=array(
                //array("name"=>"browser_search", "operator"=>"like","fields"=>array("TITULAR")),
                array("name"=>"browser_search", "operator"=>"like","fields"=>array("ID","FECHA")),
                
            );
            return parent::brow($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }


    public function excel($values){
        try {
            log_message('error', 'cco-> pasando x excel de sac serviicpos init!.');
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="SAC_Servicio";
            $values["delimiter"]=";";
            $values["pagesize"]=-1;
            //$values["order"]=" description ASC";
            $values["records"]=$this->get($values);

            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
				//array("field"=>"SECCION","format"=>"text"),
				//array("field"=>"SEPULTURA","format"=>"text"),
				//array("field"=>"TIPO","format"=>"text"),
				//array("field"=>"TITULAR","format"=>"text"),
				//array("field"=>"DIRECCION","format"=>"text"),
				//array("field"=>"LOCALIDAD","format"=>"text"),
				//array("field"=>"COD_POSTAL","format"=>"text"),
				//array("field"=>"TELEFONO","format"=>"text"),
				//array("field"=>"EMAIL","format"=>"text"),

            );

            log_message('error', 'cco-> pasando x excel de sac servicios end1!.');
            return parent::excel($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function pdf($values){
        try {
            if ($values["where"]!=""){$values["where"]=base64_decode($values["where"]);}
            $values["view"]="SAC_Servicio";
            $values["pagesize"]=-1;
            $values["order"]="1 ASC";
            $values["records"]=$this->get($values);
            $values["title"]="Servicios: Altas, Bajas, Consultas y Modificaciones";
            $values["columns"]=array(
                array("field"=>"ID","format"=>"code"),
                //array("field"=>"ssst","format"=>"code"),
				//array("field"=>"SECCION","format"=>"text"),
				//array("field"=>"SEPULTURA","format"=>"text"),
				//array("field"=>"TIPO","format"=>"text"),
				//array("field"=>"TITULAR","format"=>"text"),
				//array("field"=>"DIRECCION","format"=>"text"),
				//array("field"=>"LOCALIDAD","format"=>"text"),
				//array("field"=>"COD_POSTAL","format"=>"text"),
				//array("field"=>"TELEFONO","format"=>"text"),
				//array("field"=>"EMAIL","format"=>"text"),
            );
            log_message("error", "RELATED ".json_encode($values,JSON_PRETTY_PRINT));
            return parent::pdf($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }

    

    public function edit($values){
        try {
            log_message('error', 'cco-> pasando x edit de sac lotes!.');

            $location=explode("::",strtolower(__METHOD__));
            $values["interface"]=(MOD_DISIDENTES."/".$location[0]."/abm");
            $values["page"]=1;
            
            $values["view"]="SAC_Servicio";

            $values["where"]=("id=".$values["id"]);
            $values["records"]=$this->get($values);
            //log_message("error", "RECORDS ".json_encode($values["records"],JSON_PRETTY_PRINT));
            
            return parent::edit($values);
        }
        catch(Exception $e){
            return logError($e,__METHOD__ );
        }
    }
    public function save($values,$fields=null){
        log_message('error', 'cco-> pasando x save de precios 123 !.');
        //log_message('error', 'cco-> pasando x save de sac precios! ANTES IF . $values["TITULAR"]');
        try {
            $values["view"]="SAC_Servicio";
            $values["table"]="SAC_Servicio";
            if (!isset($values["id"])){$values["id"]=0;}
            $id=(int)$values["id"];
            if($id==0){
                log_message('error', 'cco-> pasando x save de sac precios! Sin ID entonces CREO una FILA.');
                //log_message('error', 'cco-> pasando x save de sac precios! Sin ID entonces CREO una FILA. $values["TITULAR"]');
                if($fields==null) {
                    $fields = array(
                        'ARR_DISIDE' => $values["ARR_DISIDE"],
                        'ARR_NODISI' => $values["ARR_NODISI"],
                        'ARRPARDI15' => $values["ARRPARDI15"],
                        'ARRPARND15' => $values["ARRPARND15"],
                        'ARRPARDI50' => $values["ARRPARDI50"],
                        'ARRPARND50' => $values["ARRPARND50"],
                        'ARRPARDI99' => $values["ARRPARDI99"],
                        'ARRPARND99' => $values["ARRPARND99"],
                        'ARRPARDI15N' => $values["ARRPARDI15N"],
                        'ARRPARND15N' => $values["ARRPARND15N"],
                        'ARRPARDI50N' => $values["ARRPARDI50N"],
                        'ARRPARND50N' => $values["ARRPARND50N"],
                        'ARRPARDI99N' => $values["ARRPARDI99N"],
                        'ARRPARND99N' => $values["ARRPARND99N"],
                        'ARRPARDI15U' => $values["ARRPARDI15U"],
                        'ARRPARND15U' => $values["ARRPARND15U"],
                        'ARRPARDI50U' => $values["ARRPARDI50U"],
                        'ARRPARND50U' => $values["ARRPARND50U"],
                        'ARRPARDI99U' => $values["ARRPARDI99U"],
                        'ARRPARND99U' => $values["ARRPARND99U"],


                        'ARRPINDI15' => $values["ARRPINDI15"],
                        'ARRPINND15' => $values["ARRPINND15"],
                        'ARRPINDI50' => $values["ARRPINDI50"],
                        'ARRPINND50' => $values["ARRPINND50"],
                        'ARRPINDI99' => $values["ARRPINDI99"],
                        'ARRPINND99' => $values["ARRPINND99"],
                        'ARRPINDI15N' => $values["ARRPINDI15N"],
                        'ARRPINND15N' => $values["ARRPINND15N"],
                        'ARRPINDI50N' => $values["ARRPiNDI50N"],
                        'ARRPINND50N' => $values["ARRPINND50N"],
                        'ARRPINDI99N' => $values["ARRPINDI99N"],
                        'ARRPINND99N' => $values["ARRPINND99N"],
                        'ARRPINDI15U' => $values["ARRPINDI15U"],
                        'ARRPINND15U' => $values["ARRPINND15U"],
                        'ARRPINDI50U' => $values["ARRPINDI50U"],
                        'ARRPINND50U' => $values["ARRPINND50U"],
                        'ARRPINDI99U' => $values["ARRPINDI99U"],
                        'ARRPINND99U' => $values["ARRPINND99U"],

                        'ARREUCDI15' => $values["ARREUCDI15"],
                        'ARREUCND15' => $values["ARREUCND15"],
                        'ARREUCDI50' => $values["ARREUCDI50"],
                        'ARREUCND50' => $values["ARREUCND50"],
                        'ARREUCDI99' => $values["ARREUCDI99"],
                        'ARREUCND99' => $values["ARREUCND99"],
                        'ARREUCDI15N' => $values["ARREUCDI15N"],
                        'ARREUCND15N' => $values["ARREUCND15N"],
                        'ARREUCDI50N' => $values["ARREUCDI50N"],
                        'ARREUCND50N' => $values["ARREUCND50N"],
                        'ARREUCDI99N' => $values["ARREUCDI99N"],
                        'ARREUCND99N' => $values["ARREUCND99N"],
                        'ARREUCDI15U' => $values["ARREUCDI15U"],
                        'ARREUCND15U' => $values["ARREUCND15U"],
                        'ARREUCDI50U' => $values["ARREUCDI50U"],
                        'ARREUCND50U' => $values["ARREUCND50U"],
                        'ARREUCDI99U' => $values["ARREUCDI99U"],
                        'ARREUCND99U' => $values["ARREUCND99U"],

                        'ARRANTDI15' => $values["ARRANTDI15"],
                        'ARRANTND15' => $values["ARRANTND15"],
                        'ARRANTDI50' => $values["ARRANTDI50"],
                        'ARRANTND50' => $values["ARRANTND50"],
                        'ARRANTDI99' => $values["ARRANTDI99"],
                        'ARRANTND99' => $values["ARRANTND99"],
                        'ARRANTDI15N' => $values["ARRANTDI15N"],
                        'ARRANTND15N' => $values["ARRANTND15N"],
                        'ARRANTDI50N' => $values["ARRANTDI50N"],
                        'ARRANTND50N' => $values["ARRANTND50N"],
                        'ARRANTDI99N' => $values["ARRANTDI99N"],
                        'ARRANTND99N' => $values["ARRANTND99N"],
                        'ARRANTDI15U' => $values["ARRANTDI15U"],
                        'ARRANTND15U' => $values["ARRANTND15U"],
                        'ARRANTDI50U' => $values["ARRANTDI50U"],
                        'ARRANTND50U' => $values["ARRANTND50U"],
                        'ARRANTDI99U' => $values["ARRANTDI99U"],
                        'ARRANTND99U' => $values["ARRANTND99U"],

                        'ARRBRIDI15' => $values["ARRBRIDI15"],
                        'ARRBRIND15' => $values["ARRBRIND15"],
                        'ARRBRIDI50' => $values["ARRBRIDI50"],
                        'ARRBRIND50' => $values["ARRBRIND50"],
                        'ARRBRIDI99' => $values["ARRBRIDI99"],
                        'ARRBRIND99' => $values["ARRBRIND99"],
                        'ARRBRIDI15N' => $values["ARRBRIDI15N"],
                        'ARRBRIND15N' => $values["ARRBRIND15N"],
                        'ARRBRIDI50N' => $values["ARRBRIDI50N"],
                        'ARRBRIND50N' => $values["ARRBRIND50N"],
                        'ARRBRIDI99N' => $values["ARRBRIDI99N"],
                        'ARRBRIND99N' => $values["ARRBRIND99N"],
                        
                        'ARRMUSDI15' => $values["ARRMUSDI15"],
                        'ARRMUSND15' => $values["ARRMUSND15"],
                        'ARRMUSDI50' => $values["ARRMUSDI50"],
                        'ARRMUSND50' => $values["ARRMUSND50"],
                        'ARRMUSDI99' => $values["ARRMUSDI99"],
                        'ARRMUSND99' => $values["ARRMUSND99"],
                        'ARRMUSDI15N' => $values["ARRMUSDI15N"],
                        'ARRMUSND15N' => $values["ARRMUSND15N"],
                        'ARRMUSDI50N' => $values["ARRMUSDI50N"],
                        'ARRMUSND50N' => $values["ARRMUSND50N"],
                        'ARRMUSDI99N' => $values["ARRMUSDI99N"],
                        'ARRMUSND99N' => $values["ARRMUSND99N"],
                        'ARRMUSDI15U' => $values["ARRMUSDI15U"],
                        'ARRMUSND15U' => $values["ARRMUSND15U"],
                        'ARRMUSDI50U' => $values["ARRMUSDI50U"],
                        'ARRMUSND50U' => $values["ARRMUSND50U"],
                        'ARRMUSDI99U' => $values["ARRMUSDI99U"],
                        'ARRMUSND99U' => $values["ARRMUSND99U"],


                        'CON_ADULTO' => $values["CON_ADULTO"],
                        'CON_NIN_UR' => $values["CON_NIN_UR"],

                        'INH_ADULTO' => $values["INH_ADULTO"],
                        'INH_NINOS' => $values["INH_NINOS"],
                        'INH_URNAS' => $values["INH_URNAS"],

                        'REN_ND_10' => $values["REN_ND_10"],
                        'REN_ND_5' => $values["REN_ND_5"],
                        'REN_DI_10' => $values["REN_DI_10"],
                        'REN_DI_5' => $values["REN_DI_5"],
                        'REN_NI_10' => $values["REN_NI_10"],
                        'REN_NI_5' => $values["REN_NI_5"],
                        'REN_UR_10' => $values["REN_UR_10"],
                        'REN_UR_5' => $values["REN_UR_5"],
                        

                        'RED_1' => $values["RED_1"],
                        'RED_2' => $values["RED_2"],
                        'RED_3' => $values["RED_3"],

                        'JARDINERIA' => $values["JARDINERIA"],
                        'TRANSLADOS' => $values["TRANSLADOS"],
                        'USOCAPILLA' => $values["USOCAPILLA"],
                        'TITULO' => $values["TITULO"],
                        'PLACAS_CENICEROS' => $values["PLACAS_CENICEROS"],
                        'LIBRO' => $values["LIBRO"],
                        'CENIZAS1' => $values["CENIZAS1"],
                        'CENIZAS2' => $values["CENIZAS2"],
                        'CENIZAS3' => $values["CENIZAS3"],
                        'CENIZAS4' => $values["CENIZAS4"],
                        


                        'RENPARDI50' => $values["RENPARDI50"],
                        'RENPARND50' => $values["RENPARND50"],
                        'RENPARDI99' => $values["RENPARDI99"],
                        'RENPARND99' => $values["RENPARND99"],
                        'RENPINDI50' => $values["RENPINDI50"],
                        'RENPINND50' => $values["RENPINND50"],
                        'RENPINDI99' => $values["RENPINDI99"],
                        'RENPINND99' => $values["RENPINND99"],

                        'RENEUCDI50' => $values["RENEUCDI50"],
                        'RENEUCND50' => $values["RENEUCND50"],
                        'RENEUCDI99' => $values["RENEUCDI99"],
                        'RENEUCND99' => $values["RENEUCND99"],
                        'RENANTDI50' => $values["RENANTDI50"],
                        'RENANTND50' => $values["RENANTND50"],
                        'RENANTDI99' => $values["RENANTDI99"],
                        'RENANTND99' => $values["RENANTND99"],

                        'RENBRiDI50' => $values["RENBRiDI50"],
                        'RENBRIND50' => $values["RENBRIND50"],
                        'RENBRIDI99' => $values["RENBRIDI99"],
                        'RENBRIND99' => $values["RENBRIND99"],
                        'RENMUSDI50' => $values["RENMUSDI50"],
                        'RENMUSND50' => $values["RENMUSND50"],
                        'RENMUSDI99' => $values["RENMUSDI99"],
                        'RENMUSND99' => $values["RENMUSND99"],

                        'PARQUE' => $values["PARQUE"],
                        'MUSEO' => $values["MUSEO"],
                        'RESERVA' => $values["RESERVA"],
                        'ANTIGUA' => $values["ANTIGUA"],

                        

                    );
                }
            } else {
                //log_message('error', 'cco-> pasando x save de sac precios: titulo-->".$//values["TITULO"]."<--!.');
                log_message("error", "RELATED precios".json_encode($values,JSON_PRETTY_PRINT));
                if($fields==null) {
                    $fields = array(
                       'ARR_DISIDE' => $values["ARR_DISIDE"],
                        'ARR_NODISI' => $values["ARR_NODISI"],
                        'ARRPARDI15' => $values["ARRPARDI15"],
                        'ARRPARND15' => $values["ARRPARND15"],
                        'ARRPARDI50' => $values["ARRPARDI50"],
                        'ARRPARND50' => $values["ARRPARND50"],
                        'ARRPARDI99' => $values["ARRPARDI99"],
                        'ARRPARND99' => $values["ARRPARND99"],
                        'ARRPARDI15N' => $values["ARRPARDI15N"],
                        'ARRPARND15N' => $values["ARRPARND15N"],
                        'ARRPARDI50N' => $values["ARRPARDI50N"],
                        'ARRPARND50N' => $values["ARRPARND50N"],
                        'ARRPARDI99N' => $values["ARRPARDI99N"],
                        'ARRPARND99N' => $values["ARRPARND99N"],
                        'ARRPARDI15U' => $values["ARRPARDI15U"],
                        'ARRPARND15U' => $values["ARRPARND15U"],
                        'ARRPARDI50U' => $values["ARRPARDI50U"],
                        'ARRPARND50U' => $values["ARRPARND50U"],
                        'ARRPARDI99U' => $values["ARRPARDI99U"],
                        'ARRPARND99U' => $values["ARRPARND99U"],


                        'ARRPINDI15' => $values["ARRPINDI15"],
                        'ARRPINND15' => $values["ARRPINND15"],
                        'ARRPINDI50' => $values["ARRPINDI50"],
                        'ARRPINND50' => $values["ARRPINND50"],
                        'ARRPINDI99' => $values["ARRPINDI99"],
                        'ARRPINND99' => $values["ARRPINND99"],
                        'ARRPINDI15N' => $values["ARRPINDI15N"],
                        'ARRPINND15N' => $values["ARRPINND15N"],
                        'ARRPINDI50N' => $values["ARRPiNDI50N"],
                        'ARRPINND50N' => $values["ARRPINND50N"],
                        'ARRPINDI99N' => $values["ARRPINDI99N"],
                        'ARRPINND99N' => $values["ARRPINND99N"],
                        'ARRPINDI15U' => $values["ARRPINDI15U"],
                        'ARRPINND15U' => $values["ARRPINND15U"],
                        'ARRPINDI50U' => $values["ARRPINDI50U"],
                        'ARRPINND50U' => $values["ARRPINND50U"],
                        'ARRPINDI99U' => $values["ARRPINDI99U"],
                        'ARRPINND99U' => $values["ARRPINND99U"],

                        'ARREUCDI15' => $values["ARREUCDI15"],
                        'ARREUCND15' => $values["ARREUCND15"],
                        'ARREUCDI50' => $values["ARREUCDI50"],
                        'ARREUCND50' => $values["ARREUCND50"],
                        'ARREUCDI99' => $values["ARREUCDI99"],
                        'ARREUCND99' => $values["ARREUCND99"],
                        'ARREUCDI15N' => $values["ARREUCDI15N"],
                        'ARREUCND15N' => $values["ARREUCND15N"],
                        'ARREUCDI50N' => $values["ARREUCDI50N"],
                        'ARREUCND50N' => $values["ARREUCND50N"],
                        'ARREUCDI99N' => $values["ARREUCDI99N"],
                        'ARREUCND99N' => $values["ARREUCND99N"],
                        'ARREUCDI15U' => $values["ARREUCDI15U"],
                        'ARREUCND15U' => $values["ARREUCND15U"],
                        'ARREUCDI50U' => $values["ARREUCDI50U"],
                        'ARREUCND50U' => $values["ARREUCND50U"],
                        'ARREUCDI99U' => $values["ARREUCDI99U"],
                        'ARREUCND99U' => $values["ARREUCND99U"],

                        'ARRANTDI15' => $values["ARRANTDI15"],
                        'ARRANTND15' => $values["ARRANTND15"],
                        'ARRANTDI50' => $values["ARRANTDI50"],
                        'ARRANTND50' => $values["ARRANTND50"],
                        'ARRANTDI99' => $values["ARRANTDI99"],
                        'ARRANTND99' => $values["ARRANTND99"],
                        'ARRANTDI15N' => $values["ARRANTDI15N"],
                        'ARRANTND15N' => $values["ARRANTND15N"],
                        'ARRANTDI50N' => $values["ARRANTDI50N"],
                        'ARRANTND50N' => $values["ARRANTND50N"],
                        'ARRANTDI99N' => $values["ARRANTDI99N"],
                        'ARRANTND99N' => $values["ARRANTND99N"],
                        'ARRANTDI15U' => $values["ARRANTDI15U"],
                        'ARRANTND15U' => $values["ARRANTND15U"],
                        'ARRANTDI50U' => $values["ARRANTDI50U"],
                        'ARRANTND50U' => $values["ARRANTND50U"],
                        'ARRANTDI99U' => $values["ARRANTDI99U"],
                        'ARRANTND99U' => $values["ARRANTND99U"],

                        'ARRBRIDI15' => $values["ARRBRIDI15"],
                        'ARRBRIND15' => $values["ARRBRIND15"],
                        'ARRBRIDI50' => $values["ARRBRIDI50"],
                        'ARRBRIND50' => $values["ARRBRIND50"],
                        'ARRBRIDI99' => $values["ARRBRIDI99"],
                        'ARRBRIND99' => $values["ARRBRIND99"],
                        'ARRBRIDI15N' => $values["ARRBRIDI15N"],
                        'ARRBRIND15N' => $values["ARRBRIND15N"],
                        'ARRBRIDI50N' => $values["ARRBRIDI50N"],
                        'ARRBRIND50N' => $values["ARRBRIND50N"],
                        'ARRBRIDI99N' => $values["ARRBRIDI99N"],
                        'ARRBRIND99N' => $values["ARRBRIND99N"],
                        
                        'ARRMUSDI15' => $values["ARRMUSDI15"],
                        'ARRMUSND15' => $values["ARRMUSND15"],
                        'ARRMUSDI50' => $values["ARRMUSDI50"],
                        'ARRMUSND50' => $values["ARRMUSND50"],
                        'ARRMUSDI99' => $values["ARRMUSDI99"],
                        'ARRMUSND99' => $values["ARRMUSND99"],
                        'ARRMUSDI15N' => $values["ARRMUSDI15N"],
                        'ARRMUSND15N' => $values["ARRMUSND15N"],
                        'ARRMUSDI50N' => $values["ARRMUSDI50N"],
                        'ARRMUSND50N' => $values["ARRMUSND50N"],
                        'ARRMUSDI99N' => $values["ARRMUSDI99N"],
                        'ARRMUSND99N' => $values["ARRMUSND99N"],
                        'ARRMUSDI15U' => $values["ARRMUSDI15U"],
                        'ARRMUSND15U' => $values["ARRMUSND15U"],
                        'ARRMUSDI50U' => $values["ARRMUSDI50U"],
                        'ARRMUSND50U' => $values["ARRMUSND50U"],
                        'ARRMUSDI99U' => $values["ARRMUSDI99U"],
                        'ARRMUSND99U' => $values["ARRMUSND99U"],


                        'CON_ADULTO' => $values["CON_ADULTO"],
                        'CON_NIN_UR' => $values["CON_NIN_UR"],
                        


                        'INH_ADULTO' => $values["INH_ADULTO"],
                        'INH_NINOS' => $values["INH_NINOS"],
                        'INH_URNAS' => $values["INH_URNAS"],

                        'REN_ND_10' => $values["REN_ND_10"],
                        'REN_ND_5' => $values["REN_ND_5"],
                        'REN_DI_10' => $values["REN_DI_10"],
                        'REN_DI_5' => $values["REN_DI_5"],
                        'REN_NI_10' => $values["REN_NI_10"],
                        'REN_NI_5' => $values["REN_NI_5"],
                        'REN_UR_10' => $values["REN_UR_10"],
                        'REN_UR_5' => $values["REN_UR_5"],
                        

                        'RED_1' => $values["RED_1"],
                        'RED_2' => $values["RED_2"],
                        'RED_3' => $values["RED_3"],

                        'JARDINERIA' => $values["JARDINERIA"],
                        'TRANSLADOS' => $values["TRANSLADOS"],
                        'USOCAPILLA' => $values["USOCAPILLA"],
                        'TITULO' => $values["TITULO"],
                        'PLACAS_CENICEROS' => $values["PLACAS_CENICEROS"],
                        'LIBRO' => $values["LIBRO"],
                        'CENIZAS1' => $values["CENIZAS1"],
                        'CENIZAS2' => $values["CENIZAS2"],
                        'CENIZAS3' => $values["CENIZAS3"],
                        'CENIZAS4' => $values["CENIZAS4"],
                        


                        'RENPARDI50' => $values["RENPARDI50"],
                        'RENPARND50' => $values["RENPARND50"],
                        'RENPARDI99' => $values["RENPARDI99"],
                        'RENPARND99' => $values["RENPARND99"],
                        'RENPINDI50' => $values["RENPINDI50"],
                        'RENPINND50' => $values["RENPINND50"],
                        'RENPINDI99' => $values["RENPINDI99"],
                        'RENPINND99' => $values["RENPINND99"],

                        'RENEUCDI50' => $values["RENEUCDI50"],
                        'RENEUCND50' => $values["RENEUCND50"],
                        'RENEUCDI99' => $values["RENEUCDI99"],
                        'RENEUCND99' => $values["RENEUCND99"],
                        'RENANTDI50' => $values["RENANTDI50"],
                        'RENANTND50' => $values["RENANTND50"],
                        'RENANTDI99' => $values["RENANTDI99"],
                        'RENANTND99' => $values["RENANTND99"],

                        'RENBRiDI50' => $values["RENBRiDI50"],
                        'RENBRIND50' => $values["RENBRIND50"],
                        'RENBRIDI99' => $values["RENBRIDI99"],
                        'RENBRIND99' => $values["RENBRIND99"],
                        'RENMUSDI50' => $values["RENMUSDI50"],
                        'RENMUSND50' => $values["RENMUSND50"],
                        'RENMUSDI99' => $values["RENMUSDI99"],
                        'RENMUSND99' => $values["RENMUSND99"],

                        'PARQUE' => $values["PARQUE"],
                        'MUSEO' => $values["MUSEO"],
                        'RESERVA' => $values["RESERVA"],
                        'ANTIGUA' => $values["ANTIGUA"],
                    );
                }
            }
             $id7=$this->saveRecord($fields,$id,"SAC_Servicio");
             $data=array("id"=>$id);
            logGeneral($this,$values,__METHOD__);
            return array(
                "code"=>"2000",
                "status"=>"OK",
                "message"=>$message,
                "function"=> ((ENVIRONMENT === 'development' or ENVIRONMENT === 'testing') ? __METHOD__ :ENVIRONMENT),
                "data"=>$data,
                );
            //return parent::save($values,$fields);
        }
        catch (Exception $e){
            return logError($e,__METHOD__ );
        }
    }
}
