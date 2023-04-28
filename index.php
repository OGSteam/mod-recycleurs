<?php
if (!defined('IN_SPYOGAME')) die ('Hacking attempt');

list($version, $root) = $db->sql_fetch_row($db->sql_query("SELECT version, root FROM " . TABLE_MOD . " WHERE action = 'recycleurs'"));

require_once("mod/recycleurs/core/recyclers.php");
require_once("mod/recycleurs/core/phalanx.php");
require_once("mod/{$root}/lang/" . $ui_lang . "/lang_recycleurs.php");

// config OGSpy
$nb_galaxies = $server_config['num_of_galaxies'] + 1;
$nb_systems = $server_config['num_of_systems'] + 1;


if (!isset ($pub_sub_action)) {
    $pub_sub_action = 'index';
}

include_once("views/page_header.php");
?>

    <table width="100%">
        <tr>
            <td>
                <table align="center">
                    <tr align='center'>
                        <?php

                        if ($pub_sub_action != 'recycleurs') {
                            echo "\t\t\t" . "<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&sub_action=recycleurs';\">";
                            echo "<a style='cursor: pointer'><font color:'lime'>Recycleurs</font></a>";
                            echo "</td>";
                        } else {
                            echo "\t\t\t" . "<th width='150'>";
                            echo "<a>Recycleurs</a>";
                            echo "</th>";
                        }

                        if ($pub_sub_action != 'phalanges') {
                            echo "\t\t\t" . "<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&sub_action=phalanges';\">";
                            echo "<a style='cursor: pointer'><font color:'lime'>Phalanges</font></a>";
                            echo "</td>";
                        } else {
                            echo "\t\t\t" . "<th width='150'>";
                            echo "<a>Phalanges</a>";
                            echo "</th>";
                        }

                        if ($user_data['user_admin'] == 1 || $user_data['user_coadmin'] == 1) {
                            if ($pub_sub_action != 'admin') {
                                echo "\t\t\t" . "<td class='c' width='150' onclick=\"window.location = 'index.php?action=recycleurs&sub_action=admin';\">";
                                echo "<a style='cursor: pointer'><font color:'lime'>Administration</font></a>";
                                echo "</td>";
                            } else {
                                echo "\t\t\t" . "<th width='150'>";
                                echo "<a>Administration</a>";
                                echo "</th>";
                            }
                        }

                        ?>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                switch ($pub_sub_action) {
                    case "recycleurs" :
                        require_once("recycleurs.php");
                        break;

                    case "phalanges" :
                        require_once("phalanges.php");
                        break;

                    case "admin" :
                        require_once("admin.php");
                        break;

                    case "add":
                        add_recyclers($pub_galaxie, $pub_systeme, $pub_position, $pub_porte ,$pub_nombrerecy);
                        break;

                    case "addp":
                        add_phalanx($pub_galaxie, $pub_systeme, $pub_position, $pub_niv);
                        break;

                    case "supp":
                        del_recyclers($pub_id);
                        break;

                    case "suppp":
                        del_phalanx($pub_id);
                        break;

                    case "set_recy_limit";
                        mod_set_option('recy_limit', $pub_low_limit);
                        redirection("index.php?action=recycleurs&sub_action=admin");
                        break;
                    case "raz";
                        reset_recyclers_table();
                        reset_phalanx_table();
                        redirection("index.php?action=recycleurs&sub_action=admin");
                        break;
                    default:
                        require_once("recycleurs.php");
                        break;
                }
                ?>
            </td>
        </tr>
    </table>

<?php
echo '<hr width="325px">' . "\n";
echo '<p align="center">MOD Recycleurs & Phalanges | Version '.$version.' | OGSteam</p>' . "\n";

include_once './views/page_tail.php';
