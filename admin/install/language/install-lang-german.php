<?php

// SVN file version:
// $Id: install-lang-german.php 446 2007-10-21 14:23:53Z piotr.galas $

/*
Pixelpost version 1.7

Version 1.7:
Development Team:
Ramin Mehran, Will Duncan, Joseph Spurling,
Piotr "GeoS" Galas, Dennis Mooibroek, Karin Uhlig, Jay Williams, David Kozikowski

Former members of the Development Team:
Connie Mueller-Goedecke
Version 1.1 to Version 1.3: Linus <http://www.shapestyle.se>

Contact: thecrew (at) pixelpost (dot) org
Copyright 2007 Pixelpost.org <http://www.pixelpost.org>

Pixelpost www:  	http://www.pixelpost.org/
Pixelpost wiki: 	http://wiki.pixelpost.org/
Pixelpost forum: 	http://forum.pixelpost.org
____________________________________________________________________________________

ADMIN INSTALL PANEL LANGUAGE VARIABLES:                                           */

////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : MENU
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_menu_overview    = "�berblick";
$lang_menu_intro       = "Einleitung";
$lang_menu_lic         = "Lizenz";
$lang_menu_support     = "Support";

$lang_menu_install     = "Installation";
$lang_menu_upgrade     = "Upgrade";

$lang_menu_req         = "Systemvoraussetzungen";
$lang_menu_db          = "Datenbank";
$lang_menu_admin       = "Administrator";
$lang_menu_settings    = "Einstellungen";
$lang_menu_config      = "Konfiguration";
$lang_menu_pop         = "Fertigstellen";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : GLOBAL
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install_caption  = "Installationskonsole";
$lang_check_settings   = "�berpr�fe deine Einstellungen:";

$lang_language_btn     = "�ndern";
$lang_verify_btn       = "Details verifizieren";
$lang_proceed_btn      = "Zum n�chsten Schritt";
$lang_test_btn         = "Verbindung testen";
$lang_retest_btn       = "Anforderungen nochmals testen";
$lang_start_btn        = "Beginne Installation";
$lang_up_btn           = "Beginne Upgrade";
$lang_download_btn     = "Konfigurationsfile herunterladen";
$lang_finished_btn     = "Fertig";
$lang_finished_cont_up = "Upgrade fortsetzen";

$lang_cont             = "Installation fortsetzen";
$lang_conn_success     = "Verbindung hergestellt!";
$lang_conn_fail        = "Verbindung gescheitert!";
$lang_db_conn_error    = "Fehler der Datenbankverbindung:";

$lang_yes              = "Ja";
$lang_no               = "Nein";
$lang_passed           = "Bestanden";
$lang_fail             = "Gescheitert";
$lang_value            = "Wert";

$lang_writable_no      = "Nicht beschreibbar";
$lang_writable         = "Beschreibbar";

$lang_not_found        = "Nicht gefunden";
$lang_found            = "Gefunden";

$lang_process          = "Prozess";
$lang_status           = "Status";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : ERROR
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_database_error   = "Aufgrund eines Fehlers in deiner Datenbank konnte der Installer nicht fortgesetzt werden.";
$lang_version_error    = "Grund: Die Tabelle 'version' ist nicht korrekt.";
$lang_config_error     = "Grund:";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : EMAIL MESSAGE
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_email_sent       = "Zugangsdaten erfolgreich gesendet!";
$lang_email_failed     = "Zugangsdaten konnten nicht gesendet werden! Deaktiviere die E-Mail Option oder versuche es nochmal.";
$lang_email_cred       = "Zusenden der Administrator Zugangsdaten:";
$lang_email_cred_msg   = "Wenn du diese Option w�hlst, werden die Zugangsdaten f�r die Datenbank und den Administrationsbereich per E-Mail an die o.a. Adresse gesendet.";

$lang_email_subject    = "Willkommen bei Pixelpost!";
$lang_email_message_0  = "Danke dass du dich f�r Pixelpost entschieden hast!";
$lang_email_message_1  = "Du findest hier deine Zugangsdaten zum Administrationsbereich sowie die Datenbankverbindungsdaten.";
$lang_email_message_2  = "Du kannst dich in der Administrationskonsole hier einloggen:";
$lang_email_footer     = "Bitte verwahre diese Informationen an einer sicheren Stelle.";
$lang_email_signature  = "Team Pixelpost";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : OVERVIEW : INTRODUCTION
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_overview         = "Willkommmen bei Pixelpost!";

$lang_overview_intro_1 = "Pixelpost ist eine freie, standardkonforme, mehrsprachige und voll erweiterbare Photoblog-Anwendung f�r das Web.";
$lang_overview_intro_2 = "Bitte lies unsere";
$lang_overview_intro_3 = "Installationsanleitung";
$lang_overview_intro_4 = "f�r die manuelle Installation von Pixelpost.";
$lang_overview_intro_5 = "Dieser Installationsassistent f�hrt dich durch den Installationsprozess von Pixelpost.";
						 
						 
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : OVERVIEW : LICENSE
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_overview_lic     = "GNU General Public License";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : OVERVIEW : SUPPORT
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_overview_support = "Support";

$lang_overview_sup_1   = "F�r ausf�hrlichen Support besuche bitte Pixelposts";
$lang_overview_sup_2   = "Support Forum";
$lang_overview_sup_3   = "Du findest dort Antworten auf die meisten allgemeinen Fragen, die bei der ersten Installation, bei der Konfiguration und bei der Fehlersuche auftreten. Des weiteren werden im Forum Diskussionen �ber Modifikationen und Erweiterungen gef�hrt.";
$lang_overview_sup_4   = "F�r weitere Unterst�tzung lies bitte die";
$lang_overview_sup_5   = "Online Dokumentation";
						 
						 
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : INTRODUCTION
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install          = "Willkommen zur Installation";

$lang_install_intro_1  = "Bitte halte f�r den n�chsten Schritt die Zugangsdaten zu deiner Datenbank bereit.";
$lang_install_intro_2  = "Wenn du diese Informationen nicht hast, kannst du sie bei deinem Webhoster erfragen.";
$lang_install_intro_3  = "Du brauchst folgendes:";
$lang_install_intro_4  = "Datenbank Hostname oder DSN - die Adresse des Datenbankservers (oft localhost).";
$lang_install_intro_5  = "Datenbank Name - der Name der Datenbank am Server.";
$lang_install_intro_6  = "Datenbank Benutzername und Passwort - die Login-Daten f�r den Datenbankzugriff.";
						 
						 
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : REQUIREMENTS
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install_req      = "Systemvoraussetzungen";

$lang_files_folders    = "Dateien und Verzeichnisse";

$lang_req_msg_1        = "Bevor mit der Installation begonnen wird f�hrt Pixelpost einige Tests auf deinem Server durch um sicherzustellen, dass du Pixelpost installieren und betreiben kannst.";
$lang_req_msg_2        = "Bitte lies dir die Ergebnisse dieser Tests genau durch und fahre nicht fort, bevor alle Tests bestanden sind.";

$lang_req_php          = "PHP Version und Einstellungen";
$lang_req_php_ver      = "PHP version > oder = 4.3.3:";

$lang_req_globals_1    = "PHP Einstellungen";
$lang_req_globals_2    = "register_globals";
$lang_req_globals_3    = "ist deaktiviert:";

$lang_req_globals_msg  = "Pixelpost wird auch laufen, wenn diese Einstellung aktiviert ist, aber es wird empfohlen, aus Sicherheitsgr�nden register_globals in deiner PHP-Installation zu deaktivieren.";
						  
$lang_req_imagesize_1  = "PHP Funktion";
$lang_req_imagesize_2  = "getimagesize()";
$lang_req_imagesize_3  = "ist vorhanden:";

$lang_req_imgsize_msg  = "Damit Pixelpost korrekt funktioniert muss die getimagesize() Funktion vorhanden sein.";
						 
$lang_req_pcre         = "PCRE UTF-8 Unterst�tzung:";
$lang_req_pcre_msg     = "Pixelpost wird nicht korrekt laufen, wenn deine PHP-Installation nicht mit UTF-8 Unterst�tzung in der PCRE Erweiterung kompiliert ist.";

$lang_req_gd           = "GD Grafikunterst�tzung:";
$lang_req_gd_msg       = "Pixelpost l�uft nicht auf einer PHP-Installation ohne GD graphics library.";


$lang_req_required_1   = "Du brauchst mindestens PHP in Version 4.3.3 um Pixelpost zu betreiben.";

$lang_req_required_2   = "Um korrekt zu laufen muss Pixelpost auf einige Dateien und Verzeichnisse zugreifen k�nnen.";

$lang_req_not_found    = "Wenn du 'Nicht gefunden' siehst, mu�t du das entsprechende Verzeichnis anlegen.";
$lang_req_unwritable   = "Wenn du 'Nicht beschreibbar' siehst, mu�t du die Berechtigung (CHMOD) des Verzeichnisses bzw. der Datei �ndern, um Pixelpost Schreibrechte zu geben. (755 or 777)";
$lang_req_unwritable_2 = "Vergiss nicht, die Schreibberechtigung des Verzeichnisses wieder auf den urspr�nglichen Wert zu setzen, sobald die Installation beendet ist!";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : DATABASE
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install_db       = "Datebank Einstellungen";
$lang_db_conf          = "Datenbank Konfiguration";
$lang_db_conn          = "Datenbank Verbindung";
$lang_db_test          = "Teste Verbindung:";

$lang_db_host          = "Datenbank Hostname:";
$lang_db_host_msg      = "Der Name deines Datenbankhost,  oft 'localhost'";

$lang_db_name          = "Datenbank Name:";
$lang_db_name_msg      = "Der Name der Datenbank, die Pixelpost zum Speichern deiner Photoblog Informationen benutzt.";

$lang_db_user          = "Datenbank Benutzername:";
$lang_db_user_msg      = "Der Username, mit dem die Datenbankverbindung hergestellt wird.";

$lang_db_pass          = "Datenbank Passwort:";
$lang_db_pass_msg      = "Das Passwort, mit dem die Datenbankverbindung hergestellt wird.";

$lang_db_prefix        = "Datenbank Prefix:";
$lang_db_prefix_msg    = "Der Prefix wird den Tabellennamen in der Datenbank vorangestellt. Damit k�nnen mehrere Pixelpost-Installationen mit der gleichen Datenbank betrieben werden.";


$lang_db_name_error    = "Kein Datenbankname angegeben.";
$lang_db_host_error    = "Kein Hostname angegeben.";
$lang_db_prefix_char   = "Der angegebene Tabellenprefix kann nicht verwendet werden. Bitte w�hle einen anderen und verwende keine Sonderzeichen au�er dem Unterstrich.";
$lang_db_max_prefix    = "Der angegebene Tabellenprefix ist zu lang. Er darf nicht l�nger als 36 Zeichen sein.";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : CONFIGURATION
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install_config   = "Konfiguration";
$lang_config_config    = "Pixelpost Konfiguration";

$lang_config_open      = "Datei �ffnen:";
$lang_config_open_msg  = "�ffnet die Konfigurationsdatei und bereitet sie zum Schreiben vor.";

$lang_config_write     = "Datei schreiben:";
$lang_config_write_msg = "Schreibt Inhalt in die Konfigurationsdatei.";


$lang_config_chmod     = "Datei CHMOD:";
$lang_config_chmod_msg = "Setzt die Schreibrechte f�r die Konfigurationsdatei (644). Wenn dieser Schritt nicht funktioniert, ist das nicht schlimm. Du kannst die Berechtigung sp�ter manuell �ndern.";


$lang_config_exist     = "Konfiguration existiert:";
$lang_config_exist_msg = "�berpr�ft, ob die Konfigurationsdatei gespeichert wurde.";

$lang_config_conn_msg  = "Versucht eine Datenbankverbindung unter Verwendung der neuen Konfigurationsdatei herzustellen.";

$lang_download_msg_1   = "Etwas ist schiefgegangen beim Versuch, die Konfigurationsdatei zu erstellen, zu speichern oder darauf zuzugreifen.";
$lang_download_msg_2   = "Sieh unten nach Vorschl�gen um das Problem zu korrigieren!";
$lang_download_msg_2_2 = "Wenn das auch nicht klappt, benutze bitte den Download-Link oben um deine Konfigurationsdatei herunterzuladen. Lade sie mit FTP in das Verzeichnis 'include' hoch, nachdem du die Zugangsdaten �berpr�ft bzw. eingetragen hast.";
$lang_download_msg_3   = "Wenn du das getan hast, setzte die Installation bitte fort indem du Verbindung nochmals testest.";

$lang_config_message   = "Deine Konfiguration wurde erfolgreich erstellt und gesichert. Alle Tests wurden bestanden!";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : ADMINISTRATOR
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_install_admin    = "Administrator Details";
$lang_admin_conf       = "Administrator Konfiguration";
$lang_admin_lang       = "Standardsprache Administration:";

$lang_admin_user       = "Administrator Benutzername:";
$lang_admin_user_msg   = "Bitte gib einen Benutzernamen an (L�nge 3-20 Zeichen).";

$lang_admin_pass1      = "Administrator Passwort:";
$lang_admin_pass1_msg  = "Bitte gib ein Passwort an (L�nge 6-30 Zeichen).";

$lang_admin_pass2      = "Best�tige Administrator Passwort:";


$lang_admin_email1     = "Kontakt E-Mail Adresse:";
$lang_admin_email2     = "Best�gige Kontakt E-Mail:";

$lang_admin_test_pass  = "Tests bestanden";
$lang_admin_all_fields = "Du mu�t alle Felder in diesem Block ausf�llen.";
$lang_admin_match_psw  = "Die eingegebenen Passw�rter stimmen nicht �berein.";
$lang_admin_user_short = "Der eingegebene Benutzername ist zu kurz. Die Mindestl�nge ist 3 Zeichen.";
$lang_admin_user_long  = "Der eingegebene Benutzername ist zu lang. Die Maximall�nge ist 20 Zeichen.";
$lang_admin_pass_short = "Das eingegebene Passwort ist zu kurz. Die Mindestl�nge ist 6 Zeichen.";
$lang_admin_pass_long  = "Das eingegebene Passwort ist zu lang. Die Maximall�nge ist 30 Zeichen.";
$lang_admin_mail_match = "Die eingegebenen E-Mail Adressen stimmen nicht �berein.";
$lang_admin_mail_wrong = "Die eingegebene E-Mail Adresse ist ung�ltig.";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : SETTINGS
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_set_title        = "Titel:";
$lang_set_sub_title    = "Untertitel:";
$lang_set_path         = "URL:";

$lang_set_timezone     = "Zeitzone:";
$lang_set_timezone_msg = "W�hle die Zeitzone, die deiner am n�chsten ist. Siehe <a href='http://www.timeanddate.com/' target='_blank'>Timeanddate.com</a> f�r mehr Information.";

$lang_set_tz_dst       = "DST:";
$lang_set_tz_dst_msg   = "Ist gerade Sommerzeit? (Vergiss nicht, das zu �ndern, wenn die Uhren wieder verstellt werden!)";

$lang_set_title_long   = "Der eingegebene Titel / Untertitel ist zu lang. Die Maximall�nger ist 100 Zeichen.";
$lang_set_eos          = "Deine URL muss einen Schr�gstrich am Ende haben (/).";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : INSTALL : FINALIZE
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////					 
$lang_menu_pop_db      = "Datenbank bef�llen";
$lang_dsb_addon_00_01  = "Standardm��ig werden jetzt alle gefundenen Fremd-Addons deaktiviert:";				 
$lang_dsb_addon_01     = "Manche Fremd-Addons wurden deaktiviert:";
$lang_dsb_addon_02     = "Manche Fremd-Addons k�nnten mit dieser Version von Pixelpost nicht mehr ordnungsgem�� funktionieren.";
$lang_dsb_addon_02_1   = "Das Deaktivieren von Fremd-Addons soll verhindern, dass du eine neue Pixelpost-Version bekommst, die pl�tzlich nicht mehr funktioniert.";
$lang_dsb_addon_02_2   = "Pixelposts eigene Standard-Addons bleiben aktiviert / deaktiviert, basierend auf deiner bisherigen Konfiguration.";

$lang_dsb_addon_03     = "Die folgenden Addons wurden deaktiviert:";
$lang_dsb_addon_04     = "Sobald du in Administrationskonsole eingeloggt bist, schalte die deaktivierten Addons eines nach dem anderen  wieder ein und versichere dich, dass Pixelpoxt damit wie erwartet funktioniert.";
$lang_dsb_addon_04_1   = "Falls ein Addon nicht funktioniert, deaktiviere das Addon und bitte den Autor des Addons, es zu aktualisieren.";

$lang_dsb_addon_00     = "Keine Fremd-Addons gefunden. Keine weiteren Addons wurden deaktiviert.";

$show_psw_msg          = "Hier sind deine Login-Daten. Schreibe sie dir auf und verwahre sie an einem sicheren Ort.";
$lang_convert_psw      = "Passwort konvertieren:";
$lang_convert_psw_suc  = "Dein Passwort wurde konvertiert und ist als MD5-Hash gespeichert. Dadurch wurde dein Passwort nicht ge�ndert.";
$lang_convert_psw_err  = "Beim Konvertieren des Passwortes in einen MD5-Hash ist ein Fehler aufgetreten . Dein Passwort wurde dadurch nicht ge�ndert.";

$lang_created          = "Erzeugt";
$lang_populated        = "Bef�llt";
$lang_updated          = "Update durchgef�hrt";
$lang_create_update_to = "Update zu";

$lang_create_populate  = "Konfigurationstabelle geschrieben:";

$lang_create_config    = "Erzeuge Tabelle config:";
$lang_create_cat       = "Erzeuge Tabelle categories:";
$lang_create_pixelpost = "Erzeuge Tabelle pixelpost:";
$lang_create_comments  = "Erzeuge Tabelle comments:";
$lang_create_visitors  = "Erzeuge Tabelle visitors:";
$lang_create_version   = "Erzeuge Tabelle version:";
$lang_create_catassoc  = "Erzeuge Tabelle catassoc:";
$lang_create_addons    = "Erzeuge Tabelle addons:";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : UPGRADE
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_upgrade_msg_1    = "Pixelposts Datenbanktabellen m�ssen upgedatet werden. Das ist n�tig, damit die momentane Version von Pixelpost korrekt funktioniert.";
$lang_upgrade_msg_2    = "Dr�cke den Upgrade-Button um fortzufahren.";


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////
////						LANGUAGE : DB FIX
////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$lang_db_fix_msg       = "Deine Konfigurationsdatei kann keine Datenbankverbindung mehr herstellen. Entweder du oder dein Hosting-Provider haben die Zugangsdaten ge�ndert. Bitte gib die korrekten Zugangsdaten hier ein.";
?>