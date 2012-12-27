<?php

/* include simple_html_dom file */
include('simple_html_dom.php');

/* set the time to infinite */
set_time_limit(0);

/* use recursive looping */
ini_set('xdebug.max_nesting_level', 1000);

/* diffbot Token key. Replace with your own key. */
define("TOKEN","yourDiffBotToken");

define("HOST","databasehost"); // Database Host link.

define("USER","dbuser"); // Database username.

define("PASSWORD","dbpassword"); // Database password.

define("DATABASE","dbname"); // Database name.


$con = mysql_connect ( HOST , USER , PASSWORD ); /* Connection to database environment. */

$db = mysql_select_db ( DATABASE , $con ); /* Selecting database. */

if ( !$con )

  {
  die( 'Could not connect: ' . mysql_error() ); /* error if connection failed. */
  }

?>