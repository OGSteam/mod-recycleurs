<?php

/***************************************************************************
 *   filename    : _xtense.php
 *   desc.       : liaison avec xtense2
 *   Author      : AirBAT
 *   created     : 06/07/2016
 *   by          : Darknoon
 *   modified    : -
 *   last modif. : created
 ***************************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix, $user, $xtense_version;
$xtense_version = "2.6.0";

define("TABLE_RECYCLEURS", $table_prefix . "recycleurs");

// TEST XTENSE2

if (class_exists("Callback")) {
    /**
     * Class cdr_Callback
     */
    class recycleurs_Callback extends Callback
    {
        public $version = '2.6.0';

        /**
         * @param $system
         * @return int
         */
        public function recycleurs_import($system)
        {
            global $io;
            if (recycleurs_import($system))
                return Io::SUCCESS;
            else
                return Io::ERROR;
        }

        /**
         * @return array
         */
        public function getCallbacks()
        {
            return array(array('function' => 'recycleurs_import', 'type' => 'fleet'));
        }
    }
}
/**
 * @param $system
 * @return bool
 */
function recycleurs_import($data)
{
    global  $user_data, $db, $table_prefix;


    // données a traiter
    // timestamp actuel
    $date = time();
    $player_galaxy = $data['coords'][0];
    $player_system = $data['coords'][1];
    $player_position = $data['coords'][2];

    $isMoon = $data['planet_type'];
    $planet_name = $data['planet_name'];

    $nb_recycleurs = $data['fleet']['REC'];

    if($nb_recycleurs > 0){

        $request="SELECT `galaxie` , `systeme` , `position`, `nombrerecy` from ".TABLE_RECYCLEURS." WHERE `galaxie`=".$player_galaxy." AND systeme=".$player_system." AND position='".$player_position."'";

        if($db->sql_numrows($db->sql_query($request)) != 0)
            $query = "UPDATE ".TABLE_RECYCLEURS." SET `porte`= '0', `nombrerecy`= '".$nb_recycleurs."', `time` = '".$date."' WHERE `galaxie`= '".$player_galaxy."' AND `systeme`='".$player_system."' AND `position` = '".$player_position."'";
        else
            $query = "INSERT INTO " . TABLE_RECYCLEURS . "(`id` , `user_name` , `galaxie` , `systeme` , `position` , `porte` , `nombrerecy` , `time`) VALUES ('', '" . $user_data['user_name'] . "', '".$player_galaxy."', '".$player_system."', '".$player_position."', '0', '".$nb_recycleurs."', '" . $date . "')";


        $db->sql_query($query);
    }

    return true;
}