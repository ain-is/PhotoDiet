<?php

// SVN file version:
// $Id: view_info.php 486 2007-11-13 18:21:06Z schonhose $

if(!isset($_SESSION["pixelpost_admin"]) || $cfgrow['password'] != $_SESSION["pixelpost_admin"] || $_GET["_SESSION"]["pixelpost_admin"] == $_SESSION["pixelpost_admin"] || $_POST["_SESSION"]["pixelpost_admin"] == $_SESSION["pixelpost_admin"] || $_COOKIE["_SESSION"]["pixelpost_admin"] == $_SESSION["pixelpost_admin"]) {
	die ("Try another day!!");
}

// view info
if($_GET['view'] == "info")
{
	echo "<div id='caption'>$admin_lang_general_info</div>";

	// add a workspace (only show when there are items.
	if (count_addon_admin_menus($addon_admin_functions,"info") > 0)
	{
		echo"<div id='submenu'>";
		if (!isset($_GET['infoview']) || $_GET['infoview']=='general')	$submenucssclass = 'selectedsubmenu';
		echo "<a href='index.php?view=info&amp;infoview=general' class='".$submenucssclass."'>$admin_lang_optn_general</a>\n";
		$submenucssclass = 'notselected';
  	echo_addon_admin_menus($addon_admin_functions,"info");
  	echo "</div>\n";
  }
  // get the config row again after updates
  if($cfgquery = mysql_query("select * from ".$pixelpost_db_prefix."config"))	$cfgrow = mysql_fetch_assoc($cfgquery);
  eval_addon_admin_workspace_menu("info","info");
  // end add a workspace	

if ($_GET['infoview']=='general' OR $_GET['infoview']=='')
{
	$mysql_version = mysql_get_server_info();

	if(function_exists('gd_info'))
	{
		$gd_info1 = gd_info();
		$gd_info = $gd_info1['GD Version'];
		if($gd_info == "")	$gd_info = "$admin_lang_info_gd";
		else if ($gd_info1["JPG Support"]) $gd_info .= " $admin_lang_info_gd_jpg";
	}		// func exist

  $version = base64_decode($version);
  $version = stripslashes($version);
  $sess_save_path = ((session_save_path() != '') ? '<b>'.$admin_lang_pp_sess_path.'</b> ' . session_save_path() : '<b style="color:red">' . $admin_lang_pp_sess_path . ' '. $admin_lang_pp_sess_path_emp . '!!</b>');
  echo "<div class='jcaption'>$admin_lang_pixelpostinfo</div>
    <div class='content'>
    $admin_lang_pp_currversion $version<br />
    $admin_lang_pp_version1 <script type=\"text/javascript\" src=\"http://www.pixelpost.org/service/version.js\"></script><script type=\"text/javascript\">if(curr_ver>installed_ver)document.write(message);else document.write('$admin_lang_pp_newest_ver');</script><p />
    $admin_lang_pp_forum: <a href='http://forum.pixelpost.org/'>forum.pixelpost.org</a>
    <br /><br /><a href='http://www.pixelpost.org/donate'><img alt='Click here to lend your support to Pixelpost' src='http://www.pixelpost.org/donate/image' border='0' /></a>
    </div>
    <p />
    <div class='jcaption'>$admin_lang_hostinfo</div>
    <div class='content'>
	<br />
	<b>URL</b> http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."<p />
	<b>PHP-version</b> ".phpversion()." ($admin_lang_pp_min_php: 4.3.0&nbsp;)<p />
	$sess_save_path<p />
	<b>MySQL version</b> ".$mysql_version." ($admin_lang_pp_min_mysql: 3.23.58&nbsp;)<p />
	<b>GD-lib</b> $gd_info<p />
	$admin_lang_fileuploads  ";

	if(ini_get('file_uploads')==0)	echo $admin_lang_pp_fileupload_np;
	else	echo $admin_lang_pp_fileupload_p;

	echo "<p />\n	<b>$admin_lang_serversoft</b> ".$_SERVER['SERVER_SOFTWARE']."<p />
	";

// exif infomation: exifer
	echo "$admin_lang_pp_exif1 <b>exifer v1.5</b> $admin_lang_pp_exif2.";
	echo "</div><p />
	<div class='jcaption'>$admin_lang_pp_path</div>
	<div class='content'>
	<i><b>$admin_lang_pp_imagepath  ";
	 $guess_path = pullout($_SERVER['DOCUMENT_ROOT']);
	 $guess_path .= $_SERVER['PHP_SELF'];
     $guess_path = pathinfo($guess_path);
	 $guess_path = $guess_path['dirname'];
	 $guess_path = eregi_replace("admin","",$guess_path);
     echo $guess_path."images/</b></i><p />
	 <b>$admin_lang_pp_imagepath_conf </b> ".$cfgrow['imagepath']." <p />
	
	<i><b>$admin_lang_pp_thumbnailpath  {$guess_path}thumbnails/</b></i><p />
	<b>$admin_lang_pp_thumbnailpath_conf</b> ".$cfgrow['thumbnailpath']."<p />";
	
	 $work_path = eregi_replace("images/","",$cfgrow['imagepath']);
	
	if(!is__writable($cfgrow['imagepath']))	$chmod_message = "<b><font color=\"red\">ERROR - ".$admin_lang_pp_img_chmod1."</font></b><br />".$admin_lang_pp_img_chmod2." ".$admin_lang_pp_img_chmod3;
	else	$chmod_message = "<b><font color=\"green\">OK</font></b> - ".$admin_lang_pp_img_chmod4;

  if(!is__writable($cfgrow['thumbnailpath']))	$chmod_messagethumb = "<b><font color=\"red\">ERROR - ".$admin_lang_pp_img_chmod5."</font></b><br />".$admin_lang_pp_img_chmod2." ".$admin_lang_pp_img_chmod3;
  else	$chmod_messagethumb = "<b><font color=\"green\">OK</font></b> - ".$admin_lang_pp_img_chmod4;

echo "<b>$admin_lang_pp_imgfolder</b> ";
if(file_exists($cfgrow['imagepath'])) {
	echo $chmod_message." Current CHMOD: ".substr(sprintf('%o', fileperms($cfgrow['imagepath'])), -4)."<p />";
} else {
echo $admin_lang_pp_folder_missing." ".$work_path."images) - ".$chmod_message."<p />";
}

echo "<b>$admin_lang_pp_thumbfolder</b> ";
if(file_exists($cfgrow['thumbnailpath'])) {
	echo $chmod_messagethumb." Current CHMOD: ".substr(sprintf('%o', fileperms($cfgrow['thumbnailpath'])), -4)."<p />";
} else {
echo $admin_lang_pp_folder_missing."  ".$work_path."thumbnails) - ".$chmod_messagethumb."<p />";
}

echo "<b>$admin_lang_pp_langfolder </b> ";
if(file_exists("../language/")) {
	echo "<b><font color=\"green\">OK</font></b><p />";
} else {
	echo "<b><font color=\"red\">ERROR - ".$admin_lang_pp_folder_missing. " ../language/)</font></b><p />";
}

echo "<b>$admin_lang_pp_addfolder</b> ";
if(file_exists("../addons/")) {
	echo "<b><font color=\"green\">OK</font></b><p />";
} else {
echo "<b><font color=\"red\">ERROR - ".$admin_lang_pp_folder_missing. " ../addons/)</font></b><p />";
}

echo "<b>$admin_lang_pp_incfolder</b> ";
if(file_exists("../includes/")) {
	echo "<b><font color=\"green\">OK</font></b><p />";
} else {
	echo "<b><font color=\"red\">ERROR - ".$admin_lang_pp_folder_missing. " ../includes/)</font></b><p />";
}

echo "<b>$admin_lang_pp_tempfolder</b> ";
if(file_exists("../templates/")) {
	echo "<b><font color=\"green\">OK</font></b><p />";
} else {
echo "<b><font color=\"red\">ERROR - ".$admin_lang_pp_folder_missing. " ../templates/)</font></b><p />";
}
echo "</div><p />";
echo "
  <div class='jcaption'>Comment ERROR codes explanation</div>
  <div class='content'>
	<table border=\"0\" cellspacing=\"5\">
	  <tbody><tr>
    <td><b>Errorcode</b></td>
    <td><b>Description</b></td>
  </tr>
  <tr>
    <td>ERR: 01</td>
    <td>The comment was blocked because the token didn't match with the controltoken.</td>
  </tr>
  <tr>
    <td>ERR: 02</td>
    <td>The ID of the image didn't correspond with the image ID in the form.</td>
  </tr>
  <tr>
    <td>ERR: 03</td>
    <td>The comment was blocked on an intrusion ID.</td>
  </tr>
  <tr>
    <td>ERR: 04</td>
    <td>The comment contained more than the allowed maximum of URLS.</td>
  </tr>
  <tr>
    <td>ERR: 05</td>
    <td>The comment contains blacklisted words or IPaddress.</td>
  </tr>
  <tr>
    <td>ERR: 06</td>
    <td>The comment doesn't allow comments (disabled by the administrator).</td>
  </tr>
  <tr>
    <td>ERR: 07</td>
    <td>The comment was blocked because the e-mailaddress failed the check. People are required to fill in either a real e-mailaddress or leave it blank.</td>
  </tr>
</table>";

echo "
  </div>
	<div class='jcaption'>$admin_lang_pp_langs</div>
	<div class='content'>";

echo translation_data();

echo "
  </div>";


// refererlog
echo "
	<div class='jcaption'>$admin_lang_pp_ref_log_title </div>
	<div class='content'>";

    $referer_print = "<ul>";
    // only count referers from the last seven days
    gmdate("Y-m-d H:i:s",time()+(3600 * $cfgrow['timezone'])); // current date+time
    $from_date = mktime(0,0,0,gmdate("m",time()+(3600 * $cfgrow['timezone'])) ,gmdate("d",time()+(3600 * $cfgrow['timezone'])) -7,gmdate("Y",time()+(3600 * $cfgrow['timezone'])));
    $from_date = strftime("%Y-%m-%d", $from_date);
    $from_date = "$from_date 00:00:00";
    $referer = "";
    $query = mysql_query("select distinct referer from ".$pixelpost_db_prefix."visitors where (referer!='') AND (datetime>'$from_date')");
    while(list($nreferer) = mysql_fetch_row($query)) {
       $nreferer = htmlentities($nreferer);
  	    $referer .= "!".$nreferer;
    	}
    $referer = split("!",$referer);
    $ref_biglist = "";
    foreach($referer as $value) {
	    if($value != "") {
	    	$value=mysql_real_escape_string($value);
   	    	$row = sql_array("select count(*) as count from ".$pixelpost_db_prefix."visitors where (referer='$value') AND (datetime>'$from_date')");
       		$refnumb = $row['count'];
	    	$ref_biglist .= "$refnumb@$value!";
            }
	    }
    $ref_biglist = split("!",$ref_biglist);
    rsort($ref_biglist,SORT_NUMERIC);
    foreach($ref_biglist as $value) {
	    list($numb,$referer) = explode("@",$value);
	    if($numb > "0") {
	    	if($numb < "10") { $numb = "0$numb"; }
	    	$referername = $referer;
		$length = strlen($referername);
		if($length > 50) { $referername = substr($referername,0,50); $referername = "$referername..."; }

$referer_print .= "<li><a href='$referer' rel='nofollow'>$numb &nbsp;&nbsp;&nbsp; $referername</a></li>";
		}
	}
	$referer_print .= "</ul>";
	echo $referer_print;
	echo "</div><p />";
//-------------
    }
  }
?>