<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;

define("TABLE_XTENSE_CALLBACKS", $table_prefix . "xtense_callbacks");

// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM " . TABLE_MOD . " WHERE action='recycleurs'";
$result = $db->sql_query($query);
$mod_id = $db->sql_fetch_row($result);
$mod_id = $mod_id[0];

// On regarde si la table xtense_callbacks existe :
$query = 'SHOW TABLES LIKE "' . TABLE_XTENSE_CALLBACKS . '"';
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
    //Le mod xtense 2 est installé !
    //Maintenant on regarde si cdr est dedans normalement oui mais on est jamais trop prudent...
    $query = 'SELECT * FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE mod_id = ' . $mod_id;
    $result = $db->sql_query($query);
    if ($db->sql_numrows($result) != 0) {
        // Il est  dedans alors on l'enlève :
        $query = 'DELETE FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE mod_id = ' . $mod_id;
        $db->sql_query($query);
    }
}

$mod_uninstall_name = "recycleurs";
$mod_uninstall_table = $table_prefix . "recycleurs" . ',' . $table_prefix . "phalanges";
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);
