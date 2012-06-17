<?php
$addon_name = "MyCollage";
$addon_description = "Creates photodiet collage.";
$addon_version = "0.1";

$debug_string = null; // TODO: remove debug code

if(isset($_GET['x']) && $_GET['x'] == "mycollage")
{
	$thumb_output = "";
	$where = "";
	$user_id = 0; // User name from 'users' table
	$user_name = null;
	$collage_id = 0; 
	$collage_cols_num = 0;
	$collage_datetime = $cdate;
	$collage_showprefix =""; // Prefix for links to next and previous collages
	
	$edit_mode = true;
	
	if(!isset($_SESSION["current_user"]) || !isset($_GET['user']) || $_SESSION["current_user"] != $_GET['user'] || $_GET["_SESSION"]["current_user"] == $_SESSION["current_user"] || $_POST["_SESSION"]["current_user"] == $_SESSION["current_user"] || $_COOKIE["_SESSION"]["current_user"] == $_SESSION["current_user"])
	{
		$edit_mode = false;
	}	
	
	// Get user and collage ID from URL
	if (isset($_GET['user'])) {
		$user_name = $_GET['user'];
		$query = mysql_query("select id from {$pixelpost_db_prefix}users where login = '{$user_name}'");
		$row = mysql_fetch_array($query);
		$user_id = $row[0];
		$collage_showprefix = "./index.php?x=mycollage&user=".$user_name."&collage_id=";		
        $tpl = ereg_replace("<USER_NAME>",$user_name,$tpl);
	} else {
		$collage_showprefix = "./index.php?x=mycollage&collage_id=";
        $tpl = ereg_replace("<USER_NAME>","",$tpl);
        // Get user data and collage ID for latest collage in the DB
		$query = mysql_query("select collages.id, users.id, users.login from pixelpost_pixelpost as collages, pixelpost_users as users where is_collage=1 and users.id = collages.user_id and users.enabled=1 order by datetime desc limit 1");
		$row = mysql_fetch_array($query);
		if (!isset($_GET['collage_id'])) $collage_id = $row[0];
		$user_id = $row[1];
		$user_name = $row[2];
	}
	
	// If collage_id is not set then use recent collage for current user
	if (!isset($_GET['collage_id'])) {
		if ($collage_id == 0) {
			$query = mysql_query("select id from {$pixelpost_db_prefix}pixelpost where user_id = {$user_id} AND is_collage = 1 order by datetime desc limit 1");
			$row = mysql_fetch_array($query);
			$collage_id = $row[0];
		}
	} else {
		$collage_id = $_GET['collage_id'];
	}
	
	if ($collage_id > 0) {
			$row = sql_array("select datetime, headline, body, collage_cols_num from {$pixelpost_db_prefix}pixelpost where id = $collage_id");
			$collage_cols_num = $row['collage_cols_num'];	
			$collage_datetime = $row['datetime'];
	        $collage_datetime_formatted =   strtotime($collage_datetime);
	        $collage_datetime_formatted =   date($cfgrow['dateformat'],$collage_datetime_formatted);
			$collage_title = pullout($row['headline']);
			$collage_notes = ($cfgrow['markdown'] == 'T') ? markdown(pullout($row['body'])) : pullout($row['body']);			
	}
	
	if ($language_abr == $default_language_abr){
 		$headline_selection = 'headline';
  } else  {
  	$headline_selection = 'alt_headline';
 	}
	if ($cfgrow['display_order']=='default')	$display_order = 'DESC';
	else	$display_order = 'ASC';
	
	if(isset($_GET['category'])) { $pp_cat = addslashes($_GET['category']); }else{ $pp_cat = 0; }
	
	if(is_numeric($pp_cat) && $pp_cat != "")
	{
		// Modified from Mark Lewin's hack for multiple categories
		$query = mysql_query("SELECT 1,t2.id,{$headline_selection},image,datetime
													FROM  {$pixelpost_db_prefix}catassoc as t1
													INNER JOIN {$pixelpost_db_prefix}pixelpost t2 on t2.id = t1.image_id
													WHERE t1.cat_id = '".$pp_cat."'
													AND (datetime<='$cdate')
													ORDER BY ".$cfgrow['display_sort_by']." ".$display_order);
		$lookingfor = 1;
	}
	elseif(isset($_GET['archivedate']) && eregi("^[0-9]{4}-[0-9]{2}$", $_GET['archivedate']))
	{
		$archivedate = preg_replace('/[^0-9\-]/', '', $_GET['archivedate']);
		$where = "AND (DATE_FORMAT(datetime, '%Y-%m')='$archivedate')"; //DATE_FORMAT(foo, '%Y-%m-%d')
		$query = mysql_query("SELECT 1,id,{$headline_selection},image, datetime FROM ".$pixelpost_db_prefix."pixelpost WHERE (datetime<='$cdate') $where ORDER BY ".$cfgrow['display_sort_by']." ".$display_order);
		$lookingfor = 1;
	}
	elseif(isset($_POST['category']))
	{
		$lookingfor = 0;
		$where = "(";

		foreach( $_POST['category'] as $cat)
		{
			$cat = clean($cat);
			$where .= "t1.cat_id='$cat' OR ";
			$lookingfor++;
		}

		$where .= " 0)";
		$querystr = "SELECT COUNT(t1.id), t2.id,{$headline_selection},image,datetime
									FROM {$pixelpost_db_prefix}catassoc AS t1
									INNER JOIN {$pixelpost_db_prefix}pixelpost t2 ON t2.id = t1.image_id
									WHERE (datetime<='$cdate') AND
									$where
									GROUP BY t2.id
									ORDER BY ".$cfgrow['display_sort_by']." ".$display_order;
		$query = mysql_query($querystr);
	}
	elseif(isset($_GET['tag']) && eregi("[a-zA-Z 0-9_]+",$_GET['tag']))
	{
		$lookingfor = 1;
		$default_language_abr = strtolower($PP_supp_lang[$cfgrow['langfile']][0]);

  	if ($language_abr == $default_language_abr)
  	{
  		$tag_selection = "AND (t2.tag = '" . addslashes($_GET['tag']) . "')";
	  }
	  else
	  {
  		$tag_selection = "AND (t2.alt_tag = '" . addslashes($_GET['tag']) . "')";
  	}

		$querystr = "SELECT 1, t1.id,t1.{$headline_selection},t1.image, t1.datetime
		FROM {$pixelpost_db_prefix}pixelpost AS t1, {$pixelpost_db_prefix}tags AS t2
		WHERE (t1.datetime<='$cdate')
		$where
		AND (t1.id = t2.img_id)
		$tag_selection
		GROUP BY t1.id
		ORDER BY t1.".$cfgrow['display_sort_by']." ".$display_order;
		$query = mysql_query($querystr);
	}
	else
	{
		$lookingfor = 1;
		if ($collage_id > 0) {
			$query = mysql_query("SELECT 1,id,{$headline_selection},image,datetime FROM {$pixelpost_db_prefix}pixelpost, {$pixelpost_db_prefix}collage_images WHERE (datetime<='$cdate' AND id = image_id AND collage_id = {$collage_id}) ORDER BY order_in_collage");				
		} 
	}

	$rows_count = mysql_num_rows($query);
	$rows_processed = 0;

	while(list($count,$id,$title,$name,$datetime) = mysql_fetch_row($query))
	{
		if( $count != $lookingfor) continue;   // Major hack for the browse filters.

		$title = pullout($title);
		$title = htmlspecialchars($title,ENT_QUOTES);
		$thumbnail = ltrim($cfgrow['thumbnailpath'], "./")."thumb_".$name;
		$thumbnail_extra = getimagesize($thumbnail);
		$local_width = $thumbnail_extra['0'];
		$local_height = $thumbnail_extra['1'];
		$thumb_output .= "<a href=\"$showprefix$id\"><img src=\"$thumbnail\" alt=\"$title\" title=\"$title\" width=\"$local_width\" height=\"$local_height\" class=\"thumbnails\" /></a>";
		$rows_processed++;
		if ($collage_cols_num > 0 && $collage_cols_num <= $rows_processed && $rows_processed % $collage_cols_num == 0) $thumb_output .= "<br/>"; 
	}
	
	if ($edit_mode) {
		$thumb_output .= "<br/><a href=\"admin/index.php?collage_id={$collage_id}\">{$lang_new_image}</a>"; // New image link
		$thumb_output .= "&nbsp;&nbsp;<a href=\"admin/index.php?view=images&x=select_new_image&collage_id={$collage_id}\">{$lang_add_existing_image}</a>"; // Add existing image link
		$thumb_output .= "&nbsp;&nbsp;<a href=\"admin/index.php?view=images&collage_id={$collage_id}\">{$edit_images}</a>"; // Edit images link
		$thumb_output .= "&nbsp;&nbsp;<a href=\"admin/index.php?view=images&id={$collage_id}collage_id={$collage_id}\">{$edit_collage}</a>"; // Edit collage
	}

  $tpl = ereg_replace("<THUMBNAILS>",$thumb_output,$tpl);


	// Build links for previous and next collages
	// Get previous collage id
	if(!isset($_SESSION["pixelpost_admin"]) || isset($_SESSION["current_user"])) {
		//public
		$previous_row = sql_array("SELECT id FROM ".$pixelpost_db_prefix."pixelpost WHERE is_collage = 1 and user_id = {$user_id} and datetime < '$collage_datetime' and datetime<='$cdate' ORDER BY datetime desc limit 0,1");
		$next_row = sql_array("SELECT id FROM ".$pixelpost_db_prefix."pixelpost WHERE is_collage = 1 and user_id = {$user_id} and datetime > '$collage_datetime' and datetime<='$cdate' ORDER BY datetime limit 0,1");
	}else{
		//admin
		$previous_row = sql_array("SELECT id FROM ".$pixelpost_db_prefix."pixelpost WHERE (datetime < '$collage_datetime')  ORDER BY datetime desc limit 0,1");
		$next_row = sql_array("SELECT id FROM ".$pixelpost_db_prefix."pixelpost WHERE (datetime > '$collage_datetime')  ORDER BY datetime limit 0,1");
	}

	$collage_previous_id = $previous_row['id'];

	if ($collage_previous_id == null) {
		$collage_previous_link = "";
	} else {
		$collage_previous_link = "<a href='$collage_showprefix$collage_previous_id'>$lang_previous</a>";
	}

	$collage_next_id = $next_row['id'];

	if ($collage_next_id == null) {
		$collage_next_link = ""; 
	}
	else {
		$collage_next_link  =  "<a href='$collage_showprefix$collage_next_id'>$lang_next</a>";
	}

	// Make Login/Logout link
	$login_url = "/Pixelpost/admin/index.php";
	$logout_url = "/Pixelpost/admin/index.php?x=logout";
	$new_collage_url = $login_url."?x=collage";
	if (isset($_GET['user'])) {
		$login_url = $login_url."?user={$_GET['user']}";
		$logout_url = $logout_url."&user={$_GET['user']}";
	} 
	if (isset($_GET['collage_id'])) {
		if (isset($_GET['user'])) $login_url = $login_url."&collage_id={$_GET['collage_id']}";
		else $login_url = $login_url."?collage_id={$_GET['collage_id']}";
		$logout_url = $logout_url."&collage_id={$_GET['collage_id']}";
	}
	
	if (isset($_SESSION["current_user"]))	{
		$login_logout_link = "<a href=\"{$logout_url}\" title=\"{$lang_logout} - {$_SESSION['current_user']}\">$lang_logout</a>";
		$new_collage_link = "<a href=\"{$new_collage_url}\" title=\"{$add_new_collage}\">$new_collage</a> |";
	}
	else {
		$login_logout_link = "<a href=\"{$login_url}\" title=\"{$lang_login}\">$lang_login</a>";
		$new_collage_link = "";
	}
	
	$tpl = ereg_replace("<LOGIN_LOGOUT_LINK>",$login_logout_link,$tpl);
	$tpl = ereg_replace("<COLLAGE_PREVIOUS_LINK>",$collage_previous_link,$tpl);
	$tpl = ereg_replace("<COLLAGE_NEXT_LINK>",$collage_next_link,$tpl);
	$tpl = ereg_replace("<NEW_COLLAGE_LINK>",$new_collage_link,$tpl);
	
	if ($row['comments'] == 'F'){
	
		$tpl = ereg_replace("<COMMENT_POPUP>","<a href='./index.php?x=mycollage&user=".$user_name."&collage_id=$collage_id' onclick=\"alert('$lang_comment_popup_disabled');\">$lang_comment_popup</a>",$tpl);
	}else{
	
		$tpl = ereg_replace("<COMMENT_POPUP>","<a href='./index.php?x=mycollage&user=".$user_name."&collage_id=$collage_id' onclick=\"window.open('index.php?popup=comment&amp;showimage=$collage_id','Comments','width=480,height=540,scrollbars=yes,resizable=yes');\">$lang_comment_popup</a>",$tpl);
	}
	
	$tpl = ereg_replace("<COLLAGE_TITLE>",$collage_title,$tpl);
	$tpl = ereg_replace("<COLLAGE_DATETIME>",$collage_datetime_formatted,$tpl);
	$tpl = ereg_replace("<COLLAGE_NOTES>",$collage_notes,$tpl);
	
	// get number of comments
	$cnumb_row             =  sql_array("SELECT count(*) as count FROM ".$pixelpost_db_prefix."comments WHERE parent_id='$collage_id' and publish='yes'");
	$collage_comments_number =  $cnumb_row['count'];
	
	if ($collage_comments_number) $tpl = ereg_replace("<COLLAGE_COMMENTS_NUMBER>"," ({$collage_comments_number})",$tpl);
	
}

// build browse menu
// $browse_select = "<select name='browse' onchange='self.location.href=this.options[this.selectedIndex].value;'><option value=''>$lang_browse_select_category</option><option value='?x=browse&amp;category='>$lang_browse_all</option>";
$browse_select = "<select name='browse' onchange='self.location.href=this.options[this.selectedIndex].value;'><option value=''>$lang_browse_select_category</option><option value='index.php?x=browse&amp;category='>$lang_browse_all</option>";
$query = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."categories ORDER BY name");

while(list($id,$name, $alt_name) = mysql_fetch_row($query))
{
	if ($language_abr == $default_language_abr)
	{
  	$name = pullout($name);
	}
	else
	{
  	$name = pullout($alt_name);
  }
//		$browse_select .= "<option value='?x=browse&amp;category=$id'>$name</option>";
	$browse_select .= "<option value='index.php?x=browse&amp;category=$id'>$name</option>";
}
$browse_select .= "</select>";
$tpl = ereg_replace("<BROWSE_CATEGORIES>",$browse_select,$tpl);

$browse_order_by = ($language_abr == $default_language_abr) ? 'name' : 'alt_name';

// build browse checkboxes
$checkboxes = "<form method='post' action='index.php?x=browse'>";
$query = mysql_query("SELECT * FROM ".$pixelpost_db_prefix."categories ORDER BY ".$browse_order_by);

while(list($id,$name,$alt_name) = mysql_fetch_row($query))
{
	if ($language_abr == $default_language_abr)
	{
  	$name = pullout($name);
	}
	else
	{
  	$name = pullout($alt_name);
  }

	$checkbox_checked = "";

	if(isset($category)&&is_array($category)&& in_array($id,$category))	$checkbox_checked = "checked";

	$checkboxes .= "<input type='checkbox' name='category[]' value='$id' $checkbox_checked />$name&nbsp;&nbsp;&nbsp;\n";
}

$checkboxes .= "<input type='submit' value='Filter' /></form>";
$tpl = ereg_replace("<BROWSE_CHECKBOXLIST>",$checkboxes,$tpl);

if ($debug_string != null) $tpl = ereg_replace("<DEBUG_INFO>","<span class='title'>{$debug_string}</span><hr /><br />",$tpl);
else $tpl = ereg_replace("<DEBUG_INFO>",null,$tpl); 


?>