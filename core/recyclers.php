<?php

/**
 * Created by IntelliJ IDEA.
 * User: Anthony
 * Date: 14/07/2016
 * Time: 18:19
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

function add_recyclers($galaxie = "", $system = "", $position = "", $gate = "", $nb_recyclers = "", $xtense = false)
{
    global $db, $table_prefix, $user_data, $server_config;

    log_('mod', "add_recyclers(" . $galaxie . ", " . $system . " ," . $position . ", " . $gate . ", " . $nb_recyclers . ")");

    // On commence par récupérer les champs

    if ($galaxie < 1) {
        $galaxie = "1";
        
    } elseif ($galaxie > $server_config['num_of_galaxies']) {
        $galaxie = $server_config['num_of_galaxies'];
    }

    if ($system < 1) {
        $system = "1";
    } elseif ($system > $server_config['num_of_systems']) {
        $system = $server_config['num_of_systems'];
    }

    if ($position < 1) {
        $position = "1";
    } elseif ($position > 15) {
        $position = "15";
    }

    // on écrit la requête sql

    $request = "SELECT * from " . $table_prefix . "recycleurs" . " WHERE `galaxie`=" . $galaxie . " AND systeme=" . $system . " AND position='" . $position . "'";

    if ($db->sql_numrows($db->sql_query($request)) != 0) {
        $query = "UPDATE " . $table_prefix . "recycleurs" . " SET `nombrerecy`= '" . $nb_recyclers . "', `porte`= '" . $gate . "', `time` = '" . time() . "' WHERE `galaxie`= '" . $galaxie . "' AND `systeme`='" . $system . "' AND `position` = '" . $position . "'";
    } else {
        $query = "INSERT INTO " . $table_prefix . "recycleurs" . "(`user_name` , `galaxie` , `systeme` , `position` , `porte` , `nombrerecy` , `time`) VALUES ('" . $user_data['user_name'] . "', '$galaxie', '$system', '$position', '$gate', '$nb_recyclers', " . time() . ")";
    }
    $db->sql_query($query);

    if (!$xtense) {
        redirection("index.php?action=recycleurs&sub_action=recycleurs");
    }
}

function del_recyclers($id = "")
{
    global $db, $table_prefix;
    // on écrit la requête sql
    $query = "DELETE from " . $table_prefix . "recycleurs" . " where `id`= '" . $id . "'";

    //insertion formulaire table
    $db->sql_query($query);

    redirection("index.php?action=recycleurs&subaction=recycleurs");
}

function reset_recyclers_table()
{
    global $db, $table_prefix;
    $query = "DELETE from " . $table_prefix . "recycleurs";
    $db->sql_query($query);
}
