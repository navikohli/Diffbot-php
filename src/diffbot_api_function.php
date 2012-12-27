<?php

	/* include the config file */
	include('config.php');

	function getArticles()
	{
		/* Diffbot url and adding token */
		$api_url = "http://www.diffbot.com/api/article?token=".TOKEN."&url=";

		/* tags variable */
		$content_tags = "";

		/* Query links from the table */
		$query = "SELECT * FROM `diffbot_articles` where Processing_Status = 1 and To_Process = 1";

		/* get the results */
		$result = mysql_query( $query );

		/* check results */
		if ( $result )
		{
			/* check return rows if there are links pending. if not will return no record found otherwise it continue. */
			if( mysql_num_rows ( $result ) == 0 )
			{
				echo '<span style="color:#00aa00;"> No record found </span>';
			}
			else
			{
				/* increment variable */
				$inc = 1;

				echo '<br /><span style="color:#00aa00;"> '.mysql_num_rows ( $result ).'. Record / Records Found </span><br /><br />';

				/* loop through records. */
				while($row = mysql_fetch_array ( $result ) )
				{
					$content_tags = "";

					$update_query = "";

					$url = "";

					/* removing &amp; in link if any */
					$url = str_replace("&amp;","&",trim($row['Content_URL']," "));echo "<br /><br />";

					/* adding own url to the diffbot url */
					$url = $url2 = $api_url . $url;

					/* adding &tags=true for returning tags of the article */
					$url .= "&tags=true";

					/* check and get the result through simple_html_dom. */
					if(file_get_html($url))
					{
					$html = file_get_html($url);
					}
					else
					{
					/* update the row in table and set the status to 2*/
						$update_query = "UPDATE  `diffbot_articles` SET ";

						$update_query .= "`Processing_Status` =  '2'";

						$update_query .= " WHERE `Content_ID` =".$row['Content_ID'].";";

						mysql_query($update_query);

						$inc++;

						continue;
					}

					/* getting variables from the result. */
					$data =  json_decode($html, true);

					/* check if result return 404 error */
					if( isset($data['errorCode']) && $data['errorCode'] == "404" )
					{
						/* update the row in table and set the status to 3 */
						$update_query = "UPDATE  `diffbot_articles` SET ";

						$update_query .= "`Processing_Status` =  '3'";

						$update_query .= " WHERE `Content_ID` =".$row['Content_ID'].";";

						mysql_query($update_query);

						$inc++;

						continue;
					}

					/* unset the html variable */
					unset($html);

					$url2 = $url2 . "&html=true";

					/* check and get the result through simple_html_dom. */
					if(file_get_html($url2))
					{
					$html = file_get_html($url2);
					}
					else
					{
					/* update the row in table and set the status to 2 */
						$update_query = "UPDATE  `diffbot_articles` SET ";

						$update_query .= "`Processing_Status` =  '2'";

						$update_query .= " WHERE `Content_ID` =".$row['Content_ID'].";";

						mysql_query($update_query);

						$inc++;

						continue;
					}

					$data_html =  json_decode($html, true);

					/* find domain name */
					$info = parse_url($row['Content_URL']);

					$domain_name = $info['host'];

					/* converting tags into string */
					foreach($data['tags'] as $tags)
					{
						$content_tags .= $tags . ",";
					}
					/* update row of table on final success */
					$update_query = "UPDATE  `diffbot_articles` SET ";

					$update_query .= "`Processing_Status` =  '5',";

					$update_query .= "`Content_URL` =  '".$row['Content_URL']."',";

					$update_query .= "`Website_Domain_Name` =  '".str_replace("'","",isset($domain_name)?$domain_name:'')."',";

					$update_query .= "`Content_Title` =  '".str_replace(array("'","’"),"\'",isset($data['title'])?$data['title']:'')."',";

					$update_query .= "`Content_Image_Path` =  '".str_replace(array("'","’"),"\'",isset($data['media'][0]['link'])?$data['media'][0]['link']:'')."',";

					$update_query .= "`Content_Text` =  '".str_replace(array("'","’"),"\'",isset($data['text'])?$data['text']:'')."',";

					$update_query .= "`Content_Text_HTML` =  '".str_replace(array("'","’"),"\'",isset($data_html['html'])?$data_html['html']:'')."',";

					$update_query .= "`Content_Author_Name` =  '".str_replace(array("'","’"),"\'",isset($data['author'])?$data['author']:'')."',";

					$update_query .= "`Content_Date` =  'No Date',";

					$update_query .= "`Content_Tags` =  '".str_replace(array("'","’"),"\'",isset($content_tags)?$content_tags:'')."' WHERE `Content_ID` =".$row['Content_ID'].";";
					mysql_query($update_query);

					$inc++;

				}
			}
		}
		else
		{
			/* display error if mysql is not connected */
			$error = '<span style="color:#ff0000;">Could not connect: ';

			$error .= mysql_error();

			$error .= '. Please correct database information in connect.php</span>';

			die( $error );
		}
	}

?>