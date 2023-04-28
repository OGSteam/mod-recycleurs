<?php

/**
 * update.php
 *
 * @package Mod Cdr
 * @author Machine
 * @co-author Capi
 * @version 1.62
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @description Fichier de mise à jour du mod Cdr
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;
$mod_folder = "recycleurs";
$mod_name = "recycleurs";

define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");
define("TABLE_RECYCLEURS", $table_prefix . "recycleurs");
define("TABLE_PHALANGES", $table_prefix . "phalanges");

$result = $db->sql_query("SELECT `version` FROM " . TABLE_MOD . " WHERE `title` = 'recycleurs'");
list($version) = $db->sql_fetch_row($result);

if (version_compare($version, '1.3.4', '<')) {
    $db->sql_query("ALTER TABLE `" . TABLE_RECYCLEURS . "` MODIFY `galaxie` VARCHAR(2)");
    $db->sql_query("ALTER TABLE `" . TABLE_PHALANGES . "` MODIFY `galaxie` VARCHAR(2)");
}

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
        $db->sql_query("INSERT INTO " . TABLE_XTENSE_CALLBACKS . " (mod_id, function, type, active) VALUES ('" . $mod_id . "', 'recycleurs_import', 'fleet', 1)");
        $db->sql_query("INSERT INTO " . TABLE_XTENSE_CALLBACKS . " (mod_id, function, type, active) VALUES ('" . $mod_id . "', 'phalanx_import', 'buildings', '1')");
    }
}

update_mod($mod_folder, $mod_name);
