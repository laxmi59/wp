<?php 
global $wpdb;
require_once(dirname(__FILE__) . '/savedata.php');
if($_POST['starttime']){
	list($d,$m,$y)=split("/",$_POST['starttime']);
	$starttime=$y."-".$m."-".$d;
	$sqlins=mysql_query("update `wp_options` set `option_value` ='".$starttime."' where option_name='custom_editor_pick'");
	echo "<script>window.location='/blog/wp-admin/admin.php?page=editor_pick'</script>";
}		
?>
<style>
ul {margin: 0;}
#contentWrap {	width: 700px;	margin: 0 auto;	height: auto;	overflow: hidden;}
#contentTop {	width: 600px;	padding: 10px;	margin-left: 30px;}
#contentLeft {	float: left;	width: 400px;}
#contentLeft li {	list-style: none;	margin: 0 0 4px 0;	padding: 10px;	background-color:#f1f1f1;	border: #CCCCCC solid 1px;	color:#000;}
#contentRight {	float: right;	width: 260px;	padding:10px;	background-color:#336600;	color:#FFFFFF;}
.addRemoveButtons{background: none repeat scroll 0 0 #f1f1f1;  border: 1px solid #ccc; line-height: 50px; padding: 5px;text-decoration: none;}
</style>
<script src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/js/jquery.js"?>" type="text/javascript"></script>
<script src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/js/jquery.js"?>" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery().ready(function() {
	jQuery('#add').click(function() {
	var sellen= jQuery('#select2 option').length;
	var dt=jQuery("#select1 option:selected").val();
	if(sellen < 5 && jQuery("#select2 option[value="+dt+"]").length == 0){
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>",data: 'action1=addRecord&idd='+ dt,
			success: function(res1){
				//alert(res1);
				if(res1 != ''){
					jQuery('#select1 option:selected').remove().appendTo('#select2');
					//window.location.reload(true);
					jQuery('#contentLeft ul').html(res1);
				}
			}
		});
	}else{
		if(sellen >= 5 )
			alert("You have to select up to 5 Article Only");
		else
			alert("Article already exists.")
	}
   	});
	jQuery('#remove').click(function() {
		var dt=jQuery("#select2 option:selected").val();
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>",data: 'action1=removeRecord&idd='+ dt,
			success: function(res1){
				if(res1 != ''){
					jQuery('#select2 option:selected').remove().appendTo('#select1');
					//window.location.reload(true);
					jQuery('#contentLeft ul').html(res1);
				}
			}
		});
    	
   	});
	jQuery(function() {
		//alert("hi");
		jQuery("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action1=updateRecordsListings';
			jQuery.post("<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>", order, function(theResponse){
				jQuery('#contentLeft ul').html(theResponse);
			}); 															 
		}
		});
	});
	jQuery("#get_articles").click(function(){
		dt=jQuery("#starttime2").val();
		//alert(dt);
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>",data: 'action1=getRecords&idd='+ dt,
			success: function(res1){
			//alert(res1);
				if(res1 != ''){
					//alert(res1);
					jQuery("#contentNot #notedit1").html("");
					jQuery("#contentNot #notedit1").html(res1);
				}else{
					jQuery("#contentNot #notedit1").html("");
					alert("No records found");
				}
			}
		});
	});
	jQuery('#add1').click(function() {
	var sellen= jQuery('#notedit2 option').length;
	var dt=jQuery("#notedit1 option:selected").val();
	var pidval=jQuery("#pidvals").val();
	if(jQuery("#notedit2 option[value="+dt+"]").length == 0){
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>",data: 'action1=addRecord1&idd='+ dt +'&pidval='+ pidval,
			success: function(res1){
				//alert(res1);
				if(res1 != ''){
					jQuery('#notedit1 option:selected').remove().appendTo('#notedit2');
				}
			}
		});
	}else{
		alert("Article already exists.")
	}
   	});
	jQuery('#remove1').click(function() {
		var dt=jQuery("#notedit2 option:selected").val();
		var pidval=jQuery("#pidvals").val();
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/editors_pick/savedata.php"?>",data: 'action1=removeRecord1&idd='+ dt +'&pidval='+ pidval,
			success: function(res1){
			//alert(res1);
				if(res1 != ''){
					jQuery('#notedit2 option:selected').remove().appendTo('#notedit1');
					
				}
			}
		});
    	
   	});
});
jQuery('form').submit(function() {  
	jQuery('#select2 option').each(function(i) {  
    	jQuery(this).attr("selected", "selected");  
    });  
});  
function formcheck(){
	var date=document.getElementById('starttime').value;
}
</script>
<div><h2>Editor's Pick</h2></div>
<?php $sqlget1=mysql_fetch_object(mysql_query("select * from wp_options where option_name='custom_editor_pick'"));
$dtchange=date('d/m/Y',strtotime($sqlget1->option_value));?>
<form name="form1" method="post" onsubmit="return formcheck();">
<table>
<tr>
  <td>Editor's Pick widget should appear on Articles published <strong>on or after</strong>::</td>
  <td ><input name="starttime" id="starttime" value="<?php echo $dtchange?>" size="11" ><a href="javascript:void(0)"  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form1.starttime);return false;" ><img class="PopcalTrigger" align="absmiddle" src="../wp-content/plugins/editors_pick/cal/calbtn.gif" width="34" height="22" border="0" alt=""  ></a>
<iframe  width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../wp-content/plugins/editors_pick/cal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe></td>
<td colspan=2><input type="submit" name="submit1" value="Submit" /></td></tr> 
</table> 
</form>
<p>&nbsp;</p>
<div>
<h3>STEP 1 - Manage Articles shown in Editor's Pick</h3>
<table>
<tr><td><strong>Available Articles</strong></td><td><strong>Editor's Pick Articles</strong></td></tr>
<tr>
<td>
  <select id="select1" style="height:200px; width:400px;" size="200">
  <?php $postsel=mysql_query("select post_title, ID from wp_posts where post_status='publish' and post_type='post'");
  while($postrow=mysql_fetch_object($postsel)){?>
  <option value="<?php echo $postrow->ID?>"><?php echo $postrow->post_title?></option>
  <?php }?>
  </select><br /><a href="javascript:void()" id="add" class="addRemoveButtons">Add to Editor's Pick</a>
</td>
<td>
  <select id="select2" style="height:200px; width:400px;" size="200">
  <?php $sel1=mysql_query("SELECT ma.id, wp.post_title, wp.ID as post_id FROM `manage_articles` ma, wp_posts wp where wp.ID= ma.post_id");
while($row1=mysql_fetch_object($sel1)){?>
 <option value="<?php echo $row1->post_id?>"><?php echo $row1->post_title?></option>
	<?php }?>
  </select><br />
  <a href="javascript:void()" id="remove" class="addRemoveButtons">Remove from Editor's Pick</a>
 </td></tr></table>
</div>
<p>&nbsp;</p>
<h3>STEP 2 - Re-order Articles shown in Editor's Pick</h3>
<div id="contentLeft">
<ul>
<?php 
$sel=mysql_query("SELECT ma.id, wp.post_title FROM `manage_articles` ma, wp_posts wp where wp.ID= ma.post_id order by ma.position asc ");
while($row=mysql_fetch_object($sel)){?>
	<li id="recordsArray_<?php echo $row->id?>"><?php echo $row->post_title?></li>
<?php }?>	
</ul>
</div>
<p style="clear:both">&nbsp;</p>
<p style="clear:both">&nbsp;</p>
<div style="clear:both">
<h3>STEP 3 - Manage Articles that Editor's Pick should NOT appear on</h3></div>
<?php $sqlget2=mysql_fetch_object(mysql_query("select * from wp_options where option_name='custom_editor_pick_new_date'"));
$dtchange2=date('d/m/Y',strtotime($sqlget2->option_value));?>
<form name="form2">
<table>
<tr><td>Date:</td><td><input name="starttime2" id="starttime2" value="<?php echo $dtchange2?>" size="11" ><a href="javascript:void(0)"  onClick="if(self.gfPop)gfPop.fPopCalendar(document.form2.starttime2);return false;" ><img class="PopcalTrigger" align="absmiddle" src="../wp-content/plugins/editors_pick/cal/calbtn.gif" width="34" height="22" border="0" alt=""  ></a>
<iframe  width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../wp-content/plugins/editors_pick/cal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<input type="button" name="get_articles" id="get_articles" value="Go" />
</td></tr> 
</table> 
</form>
<div id="contentNot">
<table>
<tr><td><strong>Available Articles</strong></td><td><strong>Articles without Editor's Pick</strong></td></tr>
<tr>
<td>
 <select name='notedit1' id="notedit1" style='height:200px; width:400px;' size='200'>
 <?php $postsel1=mysql_query("select post_title, ID from wp_posts where post_status='publish' and post_type='post'");
  while($postrow1=mysql_fetch_object($postsel1)){?>
  <option value="<?php echo $postrow1->ID?>"><?php echo $postrow1->post_title?></option>
  <?php }?>
 </select>
  <br /><a href="javascript:void()" id="add1" class="addRemoveButtons">Add to without Editor's Pick  &gt;&gt;</a>
</td>
<td><?php $pids= get_option('custom_editor_pick_pids'); ?>
  <select id="notedit2" name="notedit2" style="height:200px; width:400px;" size="200">
  <?php $sel1=mysql_query("SELECT post_title, ID FROM wp_posts where ID in ($pids)");
while($row1=mysql_fetch_object($sel1)){?>
 <option value="<?php echo $row1->ID?>"><?php echo $row1->post_title?></option>
	<?php }?>
  </select><br />
  <a href="javascript:void()" id="remove1" class="addRemoveButtons">&lt;&lt; Remove from without Editor's Pick</a>
  <input type="hidden" name="pidvals" id="pidvals" value="<?php echo $pids;?>" />
 </td></tr></table>
</div>

