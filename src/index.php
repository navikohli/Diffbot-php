<?php

	/* include the our function */
	include('diffbot_api_function.php');

	/* this function call take links from database and search articles with the help of diffbot
	and save article back to database */
	getArticles();

	$a= mysql_fetch_array(mysql_query("SELECT * FROM  `diffbot_articles` where Content_ID=5"));
	//echo $a['Content_Title'];
?>