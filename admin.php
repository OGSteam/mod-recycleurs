<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
    redirection("index.php?action=message&id_message=forbidden&info");
}

?>
<form method="POST" action="index.php?action=recycleurs&sub_action=set_recy_limit">
    <table align="center">
        <tr>
            <td>
                <table width="200" style="border:2px #003399 solid;" cellpadding="3">

                    <td align="center" class="c" colspan="2">Flotte minimale de recycleurs à afficher</td>
                    <tr>
                        <th align="center">
                            Nombre: <input type="text" name="low_limit" value="<?php echo mod_get_option('recy_limit');?>"><br>
                    </tr>
                    <th align="center" colspan="2">
                        <input type="submit" value="Envoi">
                    </th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<br>
<form method="POST" action="index.php?action=recycleurs&sub_action=raz">
    <table align="center">
        <tr>
            <td>
                <table width="200" style="border:2px #003399 solid;" cellpadding="3">

                    <td align="center" class="c" colspan="2">Remise à Zéro des tables ?</td>
                    </tr>
                    <tr>
                    <th align="center" colspan="2">
                        <input type="submit" value="Effacer">
                    </th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<br>
		
		

	