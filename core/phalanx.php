<?php
/**
 * Created by IntelliJ IDEA.
 * User: Anthony
 * Date: 14/07/2016
 * Time: 18:42
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

function add_phalanx($galaxie = "", $system = "", $position = "", $level = "", $xtense = false)
{
    global $db, $table_prefix, $user_data, $server_config;
    define("TABLE_PHALANGES", $table_prefix . "phalanges");

    if ($position < 1)
        $position = "1";
    elseif ($position > 15)
        $position = "15";

    $arrondi_type = 0;
    $phalanx_range = pow($level, 2) - 1;
    $system_lower_range = $system - $phalanx_range;
    if ($system_lower_range < 1) {
        $system_lower_range = $system_lower_range + $server_config['num_of_systems'];
        $arrondi_type = 1;
    }; //Partie négative : 1:490 -> 1:5
    $system_higher_range = $system + $phalanx_range;
    if ($system_higher_range > $server_config['num_of_systems']) {
        $system_higher_range = $system_higher_range - $server_config['num_of_systems'];
        $arrondi_type = 2;
    };

    $request="SELECT * from ".TABLE_PHALANGES." WHERE `galaxie`=".$galaxie." AND systeme=".$system." AND position='".$position."'";

    if($db->sql_numrows($db->sql_query($request)) != 0)
        $query = "UPDATE ".TABLE_PHALANGES." SET `systemea`= '".$system_higher_range."', `systemep`= '".$system_lower_range."', `time` = '".time()."' WHERE `galaxie`= '".$galaxie."' AND `systeme`='".$system."' AND `position` = '".$position."'";
    else
        $query = "INSERT INTO " . TABLE_PHALANGES . "(`id` , `user_name` , `galaxie` , `systeme` , `position` , `systemea` , `systemep` , `time`) VALUES ('', '" . $user_data['user_name'] . "', '".$galaxie."', '".$system."', '".$position."', '".$system_higher_range."', '".$system_lower_range."', " . time() . ")";

    $db->sql_query($query);
    
    if($xtense != true)
        redirection("index.php?action=recycleurs&sub_action=phalanges");

}

function del_phalanx($id = ""){
    global $db, $table_prefix;
    define("TABLE_PHALANGES", $table_prefix . "phalanges");    
    
    // on écrit la requête sql
    $query = "DELETE from " . TABLE_PHALANGES . " where id= '".$id."'";    
    $db->sql_query($query);
    
    redirection("index.php?action=recycleurs&sub_action=phalanges");

}