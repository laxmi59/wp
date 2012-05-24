<?php

$con=mysql_connect("localhost","dev3apdbuser","Rtcik1@x");
mysql_select_db("dev3ap",$con);
/*--------------------------------------------- Add new record to editor list -------------------------------------------------*/
if($_POST['action1']=='addRecord'){
	extract($_POST);
	$qry="SELECT * from `manage_articles` order by position asc ";
	$sel=  mysql_query($qry);
	while($fet=mysql_fetch_object($sel)){
		$pid=$fet->position+1;
		$upd=mysql_query("update `manage_articles` set position=".$pid." where id=".$fet->id);
	}
	$ins=mysql_query("INSERT INTO `manage_articles` (`post_id`, `date`, `position`) VALUES ($idd, now(), 1)");
	//echo 1; exit;
	if($ins){
		$sel=mysql_query("SELECT ma.id, wp.post_title FROM `manage_articles` ma, wp_posts wp where wp.ID= ma.post_id order by ma.position asc ");
		$str="";
		while($row=mysql_fetch_object($sel)){
			$str.='<li id="recordsArray_'.$row->id.'">'. $row->post_title.'</li>';
		}
	}
	echo $str;
}
/*--------------------------------------------- Remove record from editor list -------------------------------------------------*/
if($_POST['action1']=='removeRecord'){
	extract($_POST);
	$ins=mysql_query("delete from `manage_articles` where `post_id` = $idd");
	//echo 1;
	if($ins){
		$sel=mysql_query("SELECT ma.id, wp.post_title FROM `manage_articles` ma, wp_posts wp where wp.ID= ma.post_id order by ma.position asc ");
		$str="";
		while($row=mysql_fetch_object($sel)){
			$str.='<li id="recordsArray_'.$row->id.'">'. $row->post_title.'</li>';
		}
	}
	echo $str;
}
/*-----------------------------------------Manage record positon of editor list -------------------------------------------------*/
if($_POST['action1'] == 'updateRecordsListings'){
	$action 				= $_POST['action1'];
	$updateRecordsArray 	= $_POST['recordsArray'];
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		$query = "UPDATE `manage_articles` SET position = " . $listingCounter . " WHERE id = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;
	}
	$sel=mysql_query("SELECT ma.id, wp.post_title FROM `manage_articles` ma, wp_posts wp where wp.ID= ma.post_id order by ma.position asc ");
	$str="";
	while($row=mysql_fetch_object($sel)){
		$str.='<li id="recordsArray_'.$row->id.'">'. $row->post_title.'</li>';
	}
	echo $str;

}
/*--------------------------------------------- get record list based on date -------------------------------------------------*/
if($_POST['action1'] == 'getRecords'){
$dt=explode("/",$_POST['idd']);
	$dtchange=$dt[2]."-".$dt[1]."-".$dt[0];
	$sel=mysql_query("SELECT post_title, ID FROM wp_posts where post_date >= '".$dtchange."' and post_type='post' and post_status='publish'");
	$str="";
	while($row=mysql_fetch_object($sel)){
		$str.="<option value='".$row->ID."'>".$row->post_title."</option>";
	}
	echo $str;

}
/*------------------------------------------- Add new record to non editor list -------------------------------------------------*/
if($_POST['action1']=='addRecord1'){
	extract($_POST);
	$pids=$pidval;
	if($pids=='')
		$pids.=$idd;
	else
		$pids.=",".$idd;
		
	$upd= mysql_query("update `wp_options` set `option_value` = '".$pids."' where `option_name` ='custom_editor_pick_pids' ");
	echo 1;
}
/*------------------------------------------ Remove record from non editor list -------------------------------------------------*/
if($_POST['action1']=='removeRecord1'){
	extract($_POST);
	$pids=$pidval;
	$pids= str_replace(",".$idd.",","",$pids);
	$pids= str_replace($idd.",","",$pids);
	$pids= str_replace(",".$idd,"",$pids);	
	echo "update `wp_options` set `option_value` = '".$pids."' where `option_name` ='custom_editor_pick_pids' ";
	$upd= mysql_query("update `wp_options` set `option_value` = '".$pids."' where `option_name` ='custom_editor_pick_pids' ");
	if($upd)
		echo 1;
}