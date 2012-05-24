<?php 
include_once("include/dbconn.php");
	include_once("include/functions.php");

//echo "SELECT * FROM  `wp_posts` WHERE  `post_status` =  'publish' AND  `post_type` =  'post' AND  `featured` =  'yes'";
$query=mysql_query("SELECT * FROM  `wp_posts` WHERE  `post_status` =  'publish' AND  `post_type` =  'post' AND  `featured` =  'yes'");
while($row=mysql_fetch_object($query)){
	echo "insert into wp_postmeta (post_id,	meta_key, meta_value) values ($row->ID, 'featured_article', 'checkbox_on')";
	$ins=mysql_query("insert into wp_postmeta (post_id,	meta_key, meta_value) values ($row->ID, 'featured_article', 'checkbox_on')");
	echo mysql_insert_id();
	echo "<br>";
}
?>