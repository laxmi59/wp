<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/css/affiliate_banner.css"?>" type="text/css" />
<script src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/js/jquery.js"?>" type="text/javascript"></script>
<script src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/js/jquery.min.js"?>" type="text/javascript"></script>
<script src="<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/js/jquery-ui.min.js"?>" type="text/javascript"></script>

<script type="text/javascript">
jQuery(document).ready(function(){


	// add drop down
	jQuery(".addSlidingDiv").hide();
     
    jQuery('.add_show_hide').click(function(){
    	jQuery(".addSlidingDiv").slideToggle();
		jQuery(".editSlidingDiv").slideUp();
		jQuery(".viewSlidingDiv").slideUp();
		jQuery(".add_show_hide").slideDown();
		jQuery("#banner_text").addClass("mceEditor");
if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
tinyMCE.execCommand("mceAddControl", false, "banner_text");
}
    });
	// Updation of records while drag and drop
	jQuery("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
		jQuery(".addSlidingDiv").slideUp();
		jQuery(".editSlidingDiv").slideUp();
		jQuery(".viewSlidingDiv").slideUp();
		var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
		jQuery.post("<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/savedate.php"?>", order, function(theResponse){
			jQuery("#contentRight").html(theResponse);
			window.location.reload(true);
		}); 															 
	}	 
	});
	// view drop down
	jQuery(".viewSlidingDiv").hide();
   
	jQuery('.view_show_hide').click(function(){
		//alert($(this).attr('name'));
		jQuery(".editSlidingDiv").slideUp();
		jQuery(".addSlidingDiv").hide();
		var dt=$(this).attr('name');
	
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/savedate.php"?>",data: 'action1=getViewRecord&idd='+ dt,
			success: function(res1){
			//alert(res1);
			var res = eval('(' + res1 + ')');
				if(res != ''){
					var banimg="<img src='<?php echo get_bloginfo('wpurl')?>/wp-content/plugins/affiliate_product_banners/banner_img/"+res.bannerImage+"'  width='200' height='75' />";
					
				jQuery("#viewSlidingDiv_"+dt).html("");
				jQuery("#viewSlidingDiv_"+dt).append("<table width='100%' cellspacing='15'><tr><td><strong>Title</strong>:<br>"+res.bannerName+"</td></tr><tr><td><strong>Banner Image</strong>:<br>"+banimg+"</td></tr><tr><td><strong>Banner Url</strong>:<br>"+res.bannerUrl+"</td></tr><tr><td><strong>Banner Text</strong>:<br>"+res.bannerText+"</td></tr><tr><td><a href='javascript:void(0)' id='clickme' name='"+dt+"'>Edit</a>&nbsp;<input type='button' onclick='deltefunc("+dt+")' name='Delete' value='Delete' /></td><input type='hidden' id='bannerid' name='bannerid' value='"+dt+"' /></tr></table>");
					jQuery(".editSlidingDiv").slideUp();
					jQuery(".viewSlidingDiv").slideUp();
					
					jQuery("#viewSlidingDiv_"+dt).slideDown();
			
				}
			}
		});
    	
    });
	
	// edit drop down
	jQuery(".editSlidingDiv").hide();
       
	jQuery('#clickme').live('click',function() {
		//alert("test");
 		jQuery(".viewSlidingDiv").slideUp();
		
		var dt=$(this).attr('name');
		jQuery.ajax({type: "POST",url: "<?php echo get_bloginfo('wpurl')."/wp-content/plugins/affiliate_product_banners/savedate.php"?>",data: 'action1=getViewRecord&idd='+ dt,
			success: function(res1){
			//alert(res1);
			var res = eval('(' + res1 + ')');
				if(res != ''){
					var banimg="<?php echo get_bloginfo('wpurl')?>/wp-content/plugins/affiliate_product_banners/banner_img/"+res.bannerImage;
					jQuery("#edit_banner_text_"+dt).addClass("mceEditor");
if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
tinyMCE.execCommand("mceAddControl", false, "edit_banner_text_"+dt);
}

					
					jQuery("#editbannerName_"+dt).val("");
					jQuery("#editbanimg_"+dt).html("");
					jQuery("#editbannerUrl_"+dt).val("");
					
					
					jQuery("#editbannerName_"+dt).val(res.bannerName);
					jQuery("#editbanimg_"+dt).html("<a href='"+banimg+"'>"+res.bannerImage+"</a>");
					jQuery("#editbannerUrl_"+dt).val(res.bannerUrl);
					jQuery("#edit_banner_text_"+dt).attr("value", res.bannerText);
					
				
					
					jQuery("#editSlidingDiv_"+dt).slideDown();
		//jQuery(".editSlidingDiv").slideDown();
				}
			}
		});
 
	});
	
	jQuery('#clickme1').live('click',function() {
		//alert("test");
		var dt=$(this).attr('name');
 		jQuery("#editSlidingDiv_"+dt).slideUp();
	});

});


function deltefunc(bid){
	if(confirm('Do you really want to delete this banner?')) {
		window.location='<?php echo get_bloginfo('wpurl')."/wp-admin/admin.php?page=savebannerdata&bid="?>'+bid;
	}
}
// JavaScript Document
function trimfun(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function isNotEmpty(fname,txt){
	if(trimfun(fname.value)=="")	{
		alert(txt);
		fname.focus();
		return true;
	}
	return false;
}
function webUrl(reg){
	var e=reg.value;
	var ee=	"www."+reg.value;
	var e1=/^(http:\/\/|https:\/\/|www.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(([0-9]{1,5})?\/.*)?$/;
	if(e.match(e1) || ee.match(e1))	{
		return false;
	}else{
		alert("Invalid Url");
		reg.focus();
		return true;
	}
}
function validateCustomForm(reg){
//alert("test");
	//reg=document.Registration_form;
	if(isNotEmpty(reg.banner_name,"Name should not be Empty")){return false}
	
	if(isNotEmpty(reg.banner_img,"Banner Image should not be Empty")){return false}
	
	if(isNotEmpty(reg.banner_url,"Url should not be Empty")){return false}
	if(webUrl(reg.banner_url)){return false}
	
	if(isNotEmpty(reg.banner_text,"Text should not be Empty")){return false}
}
function validateCustomFormEdit(reg){
//alert("test");
	//reg=document.Registration_form;
	if(isNotEmpty(reg.banner_name,"Name should not be Empty")){return false}
	
	if(isNotEmpty(reg.banner_url,"Url should not be Empty")){return false}
	if(webUrl(reg.banner_url)){return false}
	
	if(isNotEmpty(reg.banner_text,"Text should not be Empty")){return false}
}
</script>
