<?php

// SVN file version:
// $Id: functions_comments.php 519 2008-01-16 20:17:56Z schonhose $

// ##########################################################################################//
// SAVE COMMENT
// ##########################################################################################//

// variable which says if notofication can be send (SPAM and problem free comment)
// by default it can't
$email_flag = 0;

if(isset($_GET['x'])&&$_GET['x'] == "save_comment")
{
// token check
	if ($cfgrow['token'] == 'T')
	{
		if (isset($_SESSION['token']) && ($_POST['token'] == $_SESSION['token']))
		{
			if ((time() - $_SESSION['token_time']) > ($cfgrow['token_time']*60))
			{
				eval_addon_front_workspace('comment_blocked_waited_too_long');
    		die("You waited more then ".$cfgrow['token_time']." minutes to enter the comment<br /><a href='javascript:history.back()'> Click here to go BACK</a>");
    	} else {
    		// token was good, regenerate a new one
    		$_SESSION['token'] = md5($_SERVER["HTTP_USER_AGENT"].$_SERVER["HTTP_ACCEPT_LANGUAGE"].$_SERVER["HTTP_ACCEPT_ENCODING"].$_SERVER["HTTP_ACCEPT_CHARSET"].$_SERVER["HTTP_ACCEPT"].$_SERVER["SERVER_SOFTWARE"].session_id().uniqid(rand(), TRUE));
    		$_SESSION['token_time'] = time();
    	}
		}
		else
		{
			eval_addon_front_workspace('comment_blocked_token');
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 File Not Found!");
    	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe comment could not be accepted because it got flagged as SPAM by our anti-SPAM measures (ERR: 01).<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n</BODY></HTML>";
    	exit;
		}
	}
	// Get the time of the latest comment in the db
	$comments_time_result = sql_array("SELECT datetime,ip FROM ".$pixelpost_db_prefix."comments WHERE ip LIKE '".$_SERVER['REMOTE_ADDR']."' ORDER BY datetime DESC LIMIT 1");
	$time_latest_comment = strtotime(pullout($comments_time_result['datetime']));

	if ((strtotime($datetime) - $time_latest_comment) < ($cfgrow['comment_timebetween']))
	{
  		if ($cfgrow['comment_timebetween'] > 60){
  			$time_to_wait = floor($cfgrow['comment_timebetween']/60)." minute(s)";
  		} else {
  			$time_to_wait = $cfgrow['comment_timebetween']." seconds";
  		}
  		$spam_flood_message = str_replace("<TIME_TO_WAIT>", $time_to_wait, $lang_spamflood);
  		eval_addon_front_workspace('comment_blocked_flood');
  		die($spam_flood_message."<br /><a href='javascript:history.back()'> Click here to go BACK</a>");
  	}

// $parent_id
	$parent_id = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : "";

	if (eregi("\r",$parent_id) || eregi("\n",$parent_id)){
		eval_addon_front_workspace('comment_blocked_id');
		header("HTTP/1.0 404 Not Found");
		header("Status: 404 File Not Found!");
   	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe comment could not be accepted because it got flagged as SPAM by our anti-SPAM measures. (ERR: 02).<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n<br /><a href='javascript:history.back()'> Click here to go BACK</a></BODY></HTML>";
   	exit;
	}

	if (!is_numeric($parent_id)){
		eval_addon_front_workspace('comment_blocked_intrusion_id');
		header("HTTP/1.0 404 Not Found");
		header("Status: 404 File Not Found!");
   	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe comment could not be accepted because it got flagged as SPAM by our anti-SPAM measures. (ERR: 03).<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n<br /><a href='javascript:history.back()'> Click here to go BACK</a></BODY></HTML>";
   	exit;
	}

	// $message
	$message = isset($_POST['message']) && $_POST['message']!='Type your comment here.' ? $_POST['message'] : "";
	$message = clean_comment($message);
	$message = preg_replace("/((\x0D\x0A){3,}|[\x0A]{3,}|[\x0D]{3,})/","\n\n",$message);
	$message = nl2br($message);

	// $url
	$url = isset($_POST['url']) ? $_POST['url'] : "";
	if(eregi("\r",$url) || eregi("\n",$url))	die("No intrusion! ?? :(");
	if(strpos($url,'https://') === false && strpos($url,'http://') === false && strlen($url) > 0)	$url = "http://".$url;
	$url = clean_comment($url);

	//get site names found in body of comment.
	$regex_url = "/(http:\/\/|https:\/\/|ftp:\/\/|www\.)([^\/\"<\s]*)/im";
	$unwanted_chars="/[$%^&*!~@#+=?<>]/";
	$mk_regex_array = array();
	preg_match_all($regex_url, $message, $mk_regex_array);
	if (count($mk_regex_array[2]) > $cfgrow['max_uri_comments']){
		eval_addon_front_workspace('comment_blocked_maxurl');
		header("HTTP/1.0 404 Not Found");
		header("Status: 404 File Not Found!");
   		echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe comment could not be accepted because it got flagged as SPAM by our anti-SPAM measures. (ERR: 04).<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n<br /><a href='javascript:history.back()'> Click here to go BACK</a></BODY></HTML>";
   		exit;
	}

// check if current image has got enabled comments
	$comments_result = sql_array("SELECT comments FROM ".$pixelpost_db_prefix."pixelpost where id = '$parent_id'");
	$cmnt_setting = pullout($comments_result['comments']);
	if($cmnt_setting == 'F'){
		eval_addon_front_workspace('comment_blocked_disabled');
		header("HTTP/1.0 404 Not Found");
		header("Status: 404 File Not Found!");
   	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe administrator of this blog has disabled comments for this picture. (ERR: 06)<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n<br /><a href='javascript:history.back()'> Click here to go BACK</a></BODY></HTML>";
   	exit;
   }

	$datetime = gmdate("Y-m-d H:i:s",time()+(3600 * $cfgrow['timezone'])) ;
	if($cmnt_setting == 'A')
	{
		$cmnt_moderate_permission='no';
		$cmnt_publish_permission ='yes';
	}
	else
	{
		$cmnt_moderate_permission='yes';
		$cmnt_publish_permission ='no';
	}

// ipaddress
	$ip = $_SERVER['REMOTE_ADDR'];


// $name
	$name = isset($_POST['name']) ? $_POST['name'] : "";
	if (eregi("\r",$name) || eregi("\n",$name))	die("No intrusion! ?? :(");
	$name = clean_comment($name);

// $parent_name
	$parent_name = isset($_POST['parent_name']) ? $_POST['parent_name'] : "";
	if (eregi("\r",$parent_name) || eregi("\n",$parent_name))	die("No intrusion! ?? :(");
	$parent_name = clean_comment($parent_name);


// $email
	$email = isset($_POST['email']) ? clean_comment($_POST['email']) : "";
	if (eregi("\r",$email) || eregi("\n",$email))	die("No intrusion! ?? :(");
	// aditional check by schonhose
	if (!$email==""){
		if (!check_email_address($email)){
			eval_addon_front_workspace('comment_invalid_email');
			header("HTTP/1.0 404 Not Found");
			header("Status: 404 File Not Found!");
	   	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><HTML><HEAD>\n<TITLE>404 Not Found</TITLE>\n</HEAD><BODY>\n<H1>Not Found</H1>\nThe comment could not be accepted because it got flagged as SPAM by our anti-SPAM measures. (ERR: 07).<P>\n<P>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.\n<br /><a href='javascript:history.back()'> Click here to go BACK</a></BODY></HTML>";
  	 	exit;
		}
	}

	// check that only one email-adress entered
	$onlyone = $email;
	$numberofats = substr_count("$onlyone", "@");
	if ($numberofats > 1)	die("only one email-adress allowed");

	// Ramin added more protections
	if (eregi("Content-Transfer-Encoding", $_POST['parent_name'] . $_POST['email'] . $_POST['url'] . $_POST['name'] . $_POST['message'] . $_POST['parent_id']))	die("SPAM Injection Error :(");
	if (eregi ("MIME-Version", $_POST['parent_name'] . $_POST['email'] . $_POST['url'] . $_POST['name'] . $_POST['message'] . $_POST['parent_id']))	die("SPAM Injection Error :(");
	if (eregi ("Content-Type", $_POST['parent_name'] . $_POST['email'] . $_POST['url'] . $_POST['name'] . $_POST['message'] . $_POST['parent_id']))	die("SPAM Injection Error :(");

	if($parent_id == "")	$extra_message = "<b>$lang_message_missing_image</b><p />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	if($message == "" || $message == 'Type your comment here.')	$extra_message = "<b>$lang_message_missing_comment</b><p />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	if($name == "")	$extra_message = "<b>$lang_message_missing_name</b><p />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	if(($parent_id != "") and ($message != "") and ($name != ""))
	{
		// check the comment with banlists
		if (!is_comment_in_blacklist($message,$ip,$name))
		{
			// send it to moderation if contains banned words but not black listed!
			if(is_comment_in_moderation_list($message,$ip,$name))
			{
				$cmnt_publish_permission = 'no';
				$cmnt_moderate_permission ='yes';
			}
			eval_addon_front_workspace('comment_passed');
			// to the job now
			if ($cmnt_moderate_permission =='yes')	$extra_message = "<b>$lang_message_moderating_comment</b><p />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

			$query = "INSERT INTO ".$pixelpost_db_prefix."comments(id,parent_id,datetime,ip,message,name,url,email,publish)
		VALUES(NULL,'$parent_id','$datetime','$ip','$message','$name','$url','$email','$cmnt_publish_permission')";

			mysql_query($query) or die("MySQL error " . mysql_errno() . ": " . mysql_error());

			// if we come here it means comment is in DB now and we can set flag enabling email notification
			$email_flag = 1;

			eval_addon_front_workspace('comment_accepted');
		} // end if is not in the blacklist
		else
		{
			eval_addon_front_workspace('comment_blocked_banlist');
			$extra_message = "<b>$lang_message_banned_comment</b><p />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}

// ##########################################################################################//
// EMAIL NOTE ON COMMENTS
// ##########################################################################################//
	$comment_image_id = intval($_POST['parent_id']);
	$link_to_comment = $cfgrow['siteurl']."index.php?showimage=$comment_image_id";
	if($cfgrow['commentemail'] == "yes" && $email_flag == 1)
	{
		$admin_email = $cfgrow['email'];
		$comment_name = clean_comment($_POST['name']);
		$comment_url  = clean_comment($_POST['url']);

		if(strpos($comment_url,'https://') === false && strpos($comment_url,'http://') === false && strlen($comment_url) > 0)	$comment_url = "http://".$comment_url;

		$comment_message = clean_comment($_POST['message']);
		$comment_message = stripslashes($comment_message);
		$comment_email = clean_comment($_POST['email']);

		$comment_image_name = clean_comment($_POST['parent_name']);
		$link_to_img_thumb_cmmnt = "Thumbnail Link:" .$cfgrow['siteurl'] .ltrim($cfgrow['thumbnailpath'], "./")."thumb_".$comment_image_name;
		$img_thumb_cmmnt = "<img src='" .$cfgrow['siteurl'] .ltrim($cfgrow['thumbnailpath'], "./")."thumb_".$comment_image_name."' >";
		$subject = "$pixelpost_site_title - $lang_email_notification_subject";
		$sent_date = gmdate("Y-m-d",time()+(3600 * $cfgrow['timezone'])) ;
		$sent_time = gmdate("H:i",time()+(3600 * $cfgrow['timezone'])) ;

		if ($cfgrow['htmlemailnote']!='yes')
		{
		// Plain text note email
			$body = "$lang_email_notificationplain_pt1 : $link_to_comment\n\n$lang_email_notificationplain_pt2\n\n$comment_message\n\n$lang_email_notificationplain_pt3: $comment_name";

			if ($comment_email!="")		$body .=  "- $comment_email";

			$body .= "\n\n$lang_email_notificationplain_pt4";
			$headers = "Content-type: text/plain; charset=UTF-8\n";
			$headers .= "Content-Transfer-Encoding: 8bit\n";

			if ($comment_email!="")
			{
				$headers .= "From: $comment_name  <$admin_email>\n";
				$headers .= "Reply-To: $comment_name <$comment_email>\n";
			}
			else $headers .= "From: PIXELPOST <$admin_email>\n";

			$recipient_email = "admin <$admin_email>";
		}
		else
		{
			// HTML note email
			$body = "$lang_email_notification_pt1
      			<a href='$link_to_comment'>$link_to_comment</a><br>
      			$img_thumb_cmmnt<br>
				$lang_email_notification_pt2
      			$comment_message<br>
      			$lang_email_notification_pt3 <a href='$comment_url' >$comment_name</a>  - $comment_email <br>
				$lang_email_notification_pt4";

			////////////
			$headers  = 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\n";

			// Additional headers
			if ($comment_email!="")	$headers .= "From: $comment_name  <$comment_email>\n";
			else $headers .= "From: PIXELPOST <$admin_email>\n";

			$recipient_email = "admin <$admin_email>";
		} // if (cfgrow['htmlemailnote']=='no')

    // Sending notification
		mail($recipient_email,$subject,$body,$headers);
	}

	$comment_redirect_url = (strlen($_SERVER['HTTP_REFERER']) > 0 && eregi($cfgrow['siteurl'],$_SERVER['HTTP_REFERER']) && eregi("popup=comment",$_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $link_to_comment;

	if($_POST['withthankyou'] == 'no')	header('Location: ' . $comment_redirect_url . '#comments');
?>

<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html><head>
	<meta http-equiv="refresh" content="8; URL=<?php echo $comment_redirect_url; ?>" />
	<title><?php echo $lang_comment_page_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="admin/admin_index.css" type="text/css" />
	</head>
	<body>
	<?php
	echo "<p />$lang_comment_thank_you<p />$extra_message<br />";
  	echo "<a href='$_SERVER[HTTP_REFERER]'>$lang_comment_redirect</a><p />";
	echo "</body></html>";



}
?>