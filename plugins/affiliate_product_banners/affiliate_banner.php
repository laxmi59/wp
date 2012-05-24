<?php 
require_once(dirname(__FILE__) . '/js/custom.js.php');
$qry="SELECT * from `wp_custom_banners` order by positionid asc ";
$sel=  mysql_query($qry);
$namearray=array(); $imagearray=array(); $idarray=array();
while($row=mysql_fetch_object($sel)){
    $namearray[]=$row->banner_name;
    $imagearray[]=$row->image;
    $idarray[]=$row->id;
    $positionidarray[]=$row->positionid;
}
?>

<div id="affiliateBannerContainer">
<div class="buttonlinks">
	<a href="javascript:void(0)" class="add_show_hide" >Add New Banner</a>
</div>
<div class="addSlidingDiv">
	<form method="post" action="<?php echo get_bloginfo('wpurl')."/wp-admin/admin.php?page=savebannerdata"?>" enctype="multipart/form-data" onsubmit="return validateCustomForm(this);">
	<?php /*?><form method="post" id="regform" name="regform" enctype="multipart/form-data" onsubmit="return validateCustomForm(this)"><?php */?>
	<table width="100%" cellspacing="15">
	<tr><td><strong>Name</strong>:<br /> <input type="text" name="banner_name" class="required" size="50" /></td></tr>
	<tr><td><strong>Banner Image</strong>:<br /> <input type="file" name="banner_img" class="required image" size="50" /></td></tr>
	<tr><td><strong>Url</strong>:<br /> <input type="text" name="banner_url" class="required url" size="50" /></td></tr>
	<tr><td><strong>Text</strong>: <textarea rows="7" cols="40" class="textareaID" name="banner_text" id="banner_text"></textarea></td></tr>
	<tr><td><br /> <input type="submit" name="addsubmit" value="Save"  />&nbsp;<input type="button" name="cancel" value="Cancel"  class="add_show_hide" /></td>
			<input type="hidden" value="add_banner" name="option" />
	</tr></table>
	</form>
	<hr />
</div>
<div id="contentWrap">
<div id="contentLeft" style="width:500px;">
        <ul class="ui-sortable">
            <?php 
			$pid=0;
			for($i=0;$i<sizeof($imagearray);$i++){ 
			$j=$idarray[$i];
			$pid=$pid+3;
			$pidshow=$pid==3? $pid."<sup>rd</sup>": $pid."<sup>th</sup>";
			?>
		   <li id="recordsArray_<?php echo $j?>">
            <div style="position:relative;">
			<div class="positionstyle" > <?php echo "Position ". $positionidarray[$i]. "(After ".$pidshow." Post)";?></div>
			<div class="sor-img"><?php echo $namearray[$i];?><?php /*?><img src="<?php echo get_bloginfo('wpurl') . '/wp-content/plugins/affiliate_product_banners/banner_img/thumb/'. $imagearray[$i]?>"/><?php */?></div>
			<div class="viewSlidingDiv" id="viewSlidingDiv_<?php echo $j?>"></div>
			<?php /*?><div class="viewSlidingDiv" id="editSlidingDiv_<?php echo $j?>"></div><?php */?>
			
			<div class="viewSlidingDiv" id="editSlidingDiv_<?php echo $j?>">
				<form method="post" action="<?php echo get_bloginfo('wpurl')."/wp-admin/admin.php?page=savebannerdata"?>" enctype="multipart/form-data" onsubmit="return validateCustomFormEdit(this)">
				<table width="100%" cellspacing="15">
				<tr><td valign="top"><strong>Name</strong>:<br /> <input id="editbannerName_<?php echo $j?>" type="text" name="banner_name" size="50px" /></td></tr>
				<tr><td valign="top"><strong>Banner Image</strong>:<br /> <input type="file" name="banner_img"  size="50px" /><br /><span id="editbanimg_<?php echo $j?>"></span></td></tr>
				<tr><td valign="top"><strong>Url</strong>:<br /> <input id="editbannerUrl_<?php echo $j?>"  type="text" name="banner_url" size="50px" /></td></tr>
				<tr><td valign="top"><strong>Text</strong>:<textarea rows="7" cols="40" class="textareaID" name="edit_banner_text" id="edit_banner_text_<?php echo $j?>"></textarea> </td></tr>
				<tr><td valign="top"><br /> <input type="submit" name="addsubmit" value="Save" />&nbsp;<a href="javascript:void(0)" id="clickme1" name="<?php echo $j?>">Cancel</a></td></tr>
				<tr><td><input type="hidden" value="edit_banner" name="option" /><input type="hidden" id="bannerid" name="bannerid" value="<?php echo $j?>" /></tr></table></form>
			</div>
			
			<div class="namestyle"><?php echo "<a href='javascript:void(0)' class='view_show_hide' name='$j'>view</a>"?> <?php //echo "<a href='".$idarray[$i]."'>view</a>"?></div>
			
			</div>
			
			</li>
			

            <?php }?>
        </ul>
    </div>
   
</div>
</div>