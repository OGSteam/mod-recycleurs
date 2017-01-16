<?php
/**
 * Fichier installation du mod recycleurs
 *
 * @author deusirae
 * @package recycleurs
 * @version 1.0a
 * @link http://ogsteam.fr
 **/

namespace Ogsteam\Ogspy;
//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;

mod_set_option('recy_limit', 10);

define("TABLE_RECYCLEURS", $table_prefix . "recycleurs");
define("TABLE_PHALANGES", $table_prefix . "phalanges");
define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");


mod_create_table(TABLE_RECYCLEURS ,"CREATE TABLE " . TABLE_RECYCLEURS . " (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`user_name` VARCHAR( 255 ) NOT NULL default '0',
			`galaxie` VARCHAR( 1 ) NOT NULL ,
			`systeme` VARCHAR( 3 ) NOT NULL ,
			`position` VARCHAR( 2 ) NOT NULL ,
			`porte` VARCHAR( 50 ) NOT NULL ,
			`nombrerecy` VARCHAR( 255 ) NOT NULL ,
			`time` int(11) NOT NULL default '0',
			PRIMARY KEY ( `id` )) ");

mod_create_table(TABLE_RECYCLEURS, "CREATE TABLE " . TABLE_PHALANGES . " (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`user_name` VARCHAR( 255 ) NOT NULL default '0',
			`galaxie` VARCHAR( 1 ) NOT NULL ,
			`systeme` VARCHAR( 3 ) NOT NULL ,
			`position` VARCHAR( 2 ) NOT NULL ,
			`systemea` VARCHAR( 3 ) NOT NULL ,
			`systemep` VARCHAR( 3 ) NOT NULL ,
			`time` int(11) NOT NULL default '0',
			PRIMARY KEY ( `id` ))");

    // Insertion de la liaison entre Xtense v2 et cdr
// Quelle est l'ID du mod ?
    // On récupère le n° d'id du mod
    $query = "SELECT `id` FROM `" . TABLE_MOD . "` WHERE `action`='recycleurs' AND `active`='1' LIMIT 1";
    $result = $db->sql_query($query);
    $mod_id = $db->sql_fetch_row($result);
    $mod_id = $mod_id[0];

// On regarde si la table xtense_callbacks existe :
    $result = $db->sql_query('SHOW tables LIKE "' . TABLE_XTENSE_CALLBACKS . '"');
    if ($db->sql_numrows($result) != 0) {
        // Maintenant on regarde si recycleurs est dedans
        $result = $db->sql_query("SELECT * FROM " . TABLE_XTENSE_CALLBACKS . " WHERE mod_id = '$mod_id'");
        $nresult = $db->sql_numrows($result);

        // S'il n'y est pas : alors on l'ajoute !

        if ($nresult == 0) {
            $db->sql_query("INSERT INTO " . TABLE_XTENSE_CALLBACKS . " (mod_id, function, type, active) VALUES ('" . $mod_id . "', 'recycleurs_import', 'fleet', '1')");
            $db->sql_query("INSERT INTO " . TABLE_XTENSE_CALLBACKS . " (mod_id, function, type, active) VALUES ('" . $mod_id . "', 'phalanx_import', 'buildings', '1')");
        }


    }

