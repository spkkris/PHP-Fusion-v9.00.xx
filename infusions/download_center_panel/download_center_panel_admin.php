<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2014 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Plik: download_center_panel_admin.php
| Autor: krystian1988
| Wersja: 2.00
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
if (!checkrights("KMFD") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../../index.php"); }
require_once THEMES."templates/admin_header.php";
if (file_exists(INFUSIONS."download_center_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."download_center_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."download_center_panel/locale/Polish.php";
}
include INFUSIONS."download_center_panel/infusion_db.php";
include INFUSIONS."download_center_panel/version_check.php";
include INFUSIONS."download_center_panel/inc.php";
if (isset($_GET['status']) && !isset($message)) {
	if ($_GET['status'] == "su") {
	$message = $locale['ok'];
	} elseif ($_GET['status'] == "nsu") {
	$message = $locale['blad'];
	}elseif ($_GET['status'] == "nsue") {
	$message = $locale['blad1'];
	}
	if ($message) {	echo "<div id='close-message'><div class='admin-message alert alert-info m-t-10'>".$message."</div></div>\n"; }
	}
if (isset($_POST['zapisz'])) {
			
	if (is_numeric($_POST['ile']) &&  is_numeric($_POST['slider'])) {
	$result = dbquery("UPDATE ".DB_KMF_DCP." SET ile='".(isNum($_POST['ile']) ? $_POST['ile'] : "0")."', slider='".(isNum($_POST['slider']) ? $_POST['slider'] : "0")."'");	
	if (!$result) { 
	redirect(FUSION_SELF.$aidlink."&status=nsu");
	} else {
	redirect(FUSION_SELF.$aidlink."&status=su");
	}
	}else{
	redirect(FUSION_SELF.$aidlink."&status=nsue");
	} 
	}
$kmfu_ustawienia = dbarray(dbquery("SELECT * FROM ".DB_KMF_DCP));
	$ile = isNum($kmfu_ustawienia['ile']);
	$slider = isNum($kmfu_ustawienia['slider']);
opentable($locale['admin']);
echo "<div class='panel panel-default'>\n<div class='panel-body'>\n";
echo"<div style='text-align: center;' class='admin-message center'>".$locale['admin']."</div>";
echo openform('kmfu_form', 'kmfu_form', 'post', FUSION_SELF.$aidlink, array('downtime' => 0));
		$ile = array('90' => "90", '60' => "60", '30' => "30", '20' => "20", '10' => "10", '5' => "5", '4' => "4", '3' => "3", '2' => "2", '1' => "1",);
		echo "<div class='m-t-5 m-b-0'/>\n&nbsp;</div>\n";
	echo form_select($locale['019'], 'ile', 'ile', $ile, $kmfu_ustawienia['ile'], array('inline' => 1));
		$opts = array('1' => $locale['wlacz'], '0' => $locale['wylacz'],);
		echo "<div class='m-t-5 m-b-0'/>\n&nbsp;</div>\n";
	echo form_select($locale['023'], 'slider', 'slider', $opts, $kmfu_ustawienia['slider'], array('inline' => 1));
		echo "<div class='m-t-5 m-b-0'/>\n&nbsp;</div>\n";
		echo form_button($locale['zapisz'], 'zapisz', 'zapisz', $locale['zapisz'], array('class' => 'btn-primary pull-right m-l-20'));
		echo closeform();
		echo "</div>\n</div>\n";
		echo autor();
closetable();

require_once THEMES."templates/footer.php";
?>