<?php
/***************************************************************************
 *    filename    : recycleurs.php
 *    desc.        : fichier principal du mod
 *    Author : DeusIrae
 *    created : 25/08/07
 *    modified    : 12/02/2008
 ***************************************************************************/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

?>

    <div id="recy" name="recy">
        <form method="POST" action="index.php?action=recycleurs&sub_action=add">
            <table align="center">
                <tr>
                    <td>
                        <table width="450" style="border:2px #003399 solid;" cellpadding="3">

                            <td align="center" class="c" colspan="4">Formulaire d'envoi des recycleurs</td>
                            <tr>
                                <th align="center">Coordonnées :</th>
                                <th align="center">
                                    <i>Galaxie :</i> &nbsp; <input type="text" name="galaxie" maxlength="1"
                                                                   size="5"><br>
                                    <i>Système :</i> &nbsp; <input type="text" name="systeme" maxlength="3"
                                                                   size="5"><br>
                                    <i>Position :</i> &nbsp; <input type="text" name="position" maxlength="2"
                                                                    size="5"><br></th>
                                <th align="center">Porte :</th>
                                <th align="center">
                                    Oui:<input type="radio" name="porte" value="P"><br>
                                    Non:<input type="radio" name="porte" value="">
                            </tr>
                            <tr>
                                <th align="center">Nombres de recycleurs :</th>
                                <th align="center">
                                    <input type="text" name="nombrerecy" maxlength="6" size="20"><br></th>
                                <th align="center" colspan="2">
                                    <input type="submit" value=" &nbsp; &nbsp; Envoi &nbsp; &nbsp; ">
                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<?php
echo '<br><br>';
echo '<center>
	<table border="2" width="90%">
	<tr >
	<td width="20%" align="center" class="c"><span  style="color: #FFFFFF; font-size: medium; "><b>Coordonnées</b></span></td>
	<td width="20%" align="center" class="c"><span  style="color: #FFFFFF; font-size: medium; "><b>Noms</b></span></td>
	<td width="20%" align="center" class="c"><span  style="color: #FFFFFF; font-size: medium; "><b>Nombre Recycleurs (Avec PdS ?)</b></span></td>
	<td width="20%" align="center" class="c"><span  style="color: #FFFFFF; font-size: medium; "><b>MAJ</b></span></td>
	<td width="15%" align="center" class="c"><span  style="color: #FFFFFF; font-size: medium; "><b>Options</b></span></td>
	</tr>';
for ($i = 1; $i < $nb_galaxies; $i++) {

    echo '<b><td colspan="6" class="c"><span  style="font-size: large; color: #FFFFFF; "><a name=' . $i . '>G' . $i . '</a></span></b></tr>';

	echo '<tr>';
    $req = "SELECT * FROM " . $table_prefix . "recycleurs WHERE galaxie=" . $i . " ORDER BY systeme ASC";
    $result = $db->sql_query($req);
    while ($rows = $db->sql_fetch_assoc($result)) {
        echo '<th width="20%" align="center"><b>' . $rows['galaxie'] . ':' . $rows['systeme'] . ':' . $rows['position'] . '</b></th>';
        echo '<th width="20%" align="center"><b>' . $rows['user_name'] . '</b></th>';
        echo '<th width="20%" align="center"><b>' . $rows['nombrerecy'] . '&nbsp;&nbsp;&nbsp; <font color="#FF0000"><b> ' . $rows['porte'] . ' </b></font><b/></th>';
        $time = $rows["time"];
        $time = strftime("%d %b %Y", $time);
        echo '<th width="20%" align="center"><b>' . $time . '</b></th>';
        if ($rows['user_name'] == $user_data['user_name'] || $user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
            echo '<th width="15%" align="center"><form method="POST" action="index.php?action=recycleurs&sub_action=supp">
			<input type="hidden" name="sub_action" value="supp">
			<input type="hidden" value="suppression" name="suppression">
			<input type="hidden" value=' . $rows['id'] . ' name="id">
			<input type="submit" value="Supprimer" name="supprimer">
			</form>
			</tr></th>';
        } else {
            echo '<td></tr></td>';
        }
    }

}
echo '</table><br><br>';

?>