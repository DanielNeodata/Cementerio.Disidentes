<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//log_message("error", "RELATED ".json_encode($data,JSON_PRETTY_PRINT));
/*---------------------------------*/
log_message("error", "RELATED ".json_encode($parameters,JSON_PRETTY_PRINT));

$html=buildHeaderBrowStd($parameters,$title);
if (!isset($parameters["records"])) {
    $html.=getUnInitialized();
} else {
    $nodata=getNoData();
    $html.="<div class='body-browser d-flex border-light m-0 p-0 rounded shadow-sm'>";
    $html.=" <table class='table table-hover table-sm table-browser m-0 p-0' style='min-width:750px;width:100%;'>";
    $html.=buildBodyHeadBrowStd($parameters);
    $html.="  <tbody>";
    if(is_array($parameters["records"]["data"])) {
        foreach ((array)$parameters["records"]["data"] as $record){
            $nodata="";
            $style="";
            if(isset($parameters["conditionalBackground"])) {
                foreach($parameters["conditionalBackground"] as $conditional){
                    $style="";
                    $OK=false;
                    if (!isset($conditional["operator"])) {$conditional["operator"]="=";}
                    switch($conditional["operator"]) {
                        case "=":
                            $OK=($record[$conditional["field"]]==$conditional["value"]);
                            break;
                        case "!=":
                            $OK=($record[$conditional["field"]]!=$conditional["value"]);
                            break;
                        case ">=":
                            $OK=($record[$conditional["field"]]>=$conditional["value"]);
                            break;
                        case "<=":
                            $OK=($record[$conditional["field"]]<=$conditional["value"]);
                            break;
                        case ">":
                            $OK=($record[$conditional["field"]]>$conditional["value"]);
                            break;
                        case "<":
                            $OK=($record[$conditional["field"]]<$conditional["value"]);
                            break;
                    }
                    if ($OK) {$style="style='background-color:".$conditional["color"].";'";break;}
                }
            }
            $html.="<tr data-table='".$parameters["table"]."' data-module='".$parameters["module"]."' data-model='".$parameters["model"]."' data-id='".secureField($record,"id")."' class='record-dbl-click record-".secureField($record,"id")."' ".$style.">";
            $html.=getTdCheck($parameters,$record,true);
            $html.=getTdEdit($parameters,$record,true);
            foreach ($parameters["columns"] as $column) {$html.=getTdCol($parameters,$record,$column);}
            $html.=getTdDelete($parameters,$record,true);
            $html.=getTdOffline($parameters,$record,true);
            $html.="</tr>";
        }
    }
    $html.="  </tbody>";
    $html.="  <tfoot></tfoot>";
    $html.=" </table>";
    $html.="</div>";
    $html.=$nodata;
    $html.=buildFooterBrowStd($parameters);
}
echo $html;
?>
<script>$('.browser_controls').each(function() {$(this).find('*').addClass('search-trigger');});</script>
<script>$('.multiselect').selectpicker();</script>
<script>$(".comment").shorten();</script>
