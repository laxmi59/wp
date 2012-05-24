<?php
$con=mysql_connect("localhost","dev3apdbuser","Rtcik1@x");
mysql_select_db("dev3ap",$con);
require_once(dirname(__FILE__) . '/js/specialchars.php');
//echo test;exit;
/*--------------------------------------------- getting single banner using id--------------------------------------------------*/
if($_POST['action1']=='getViewRecord'){
	//echo test;exit;
	//echo "select * from wp_custom_banners where id=".$_POST[id];exit;
	$sel=mysql_fetch_object(mysql_query("select * from wp_custom_banners where id=".$_POST[id]));
	//echo $sel->banner_text;
	echo '{"bannerName":'.json_encode($sel->banner_name).',"bannerImage":'.json_encode($sel->image).', "bannerUrl":'.json_encode($sel->banner_url).', "bannerText":'.json_encode(nl2br($sel->banner_text)).', "id":'.json_encode($sel->id).'}';
}
/*--------------------------------------------- update banners on swaping ----------------------------------------------------*/
if($_POST['action']){
	$action 				= $_POST['action'];
	$updateRecordsArray 	= $_POST['recordsArray'];
	print_r($_POST);
	if ($action == "updateRecordsListings"){
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			//echo $query = "UPDATE records SET listid = " . $listingCounter . " WHERE id = " . $recordIDValue;
			$query = "UPDATE `wp_custom_banners` SET positionid = " . $listingCounter . " WHERE id = " . $recordIDValue;
			mysql_query($query) or die('Error, insert query failed');
			$listingCounter = $listingCounter + 1;
		}
		echo '<pre>';
		print_r($updateRecordsArray);
		echo '</pre>';
		echo 'If you refresh the page, you will see that records will stay just as you modified.';
	}
}

/*--------------------------------------------- Adding and editng banner --------------------------------------------------*/
if(isset($_POST['addsubmit'])=='Save'){
	extract($_POST);
	//if (strpos($banner_url, "http://") == false) {
		//$url="http://".$banner_url;
  	//}
	$url =$banner_url;
	if($option=='edit_banner'){
		foreach ($sq_html_ent_table as $key => $value) {
        	$edit_banner_text=str_replace($key,$value,$edit_banner_text);
    	}
		$updbanner="update `wp_custom_banners` set banner_name='".$banner_name."', banner_text='".$edit_banner_text."', banner_url='".$url."' where id=".$bannerid;
		mysql_query($updbanner);
		$iid=$bannerid;
	}else{
		foreach ($sq_html_ent_table as $key => $value) {
        	$banner_text=str_replace($key,$value,$banner_text);
    	}
		$qry="SELECT * from `wp_custom_banners` order by positionid asc ";
		$sel=  mysql_query($qry);
		while($fet=mysql_fetch_object($sel)){
			$pid=$fet->positionid+1;
			$upd=mysql_query("update `wp_custom_banners` set positionid=".$pid." where id=".$fet->id);
		}
		$insBanner="insert into `wp_custom_banners` (banner_name, banner_text, banner_url, positionid)values('".$banner_name."', '".$banner_text."', '".$url."', 1)";
		mysql_query($insBanner);
		$iid=mysql_insert_id();
	}
	define ("MAX_SIZE",1000000);
	define ("WIDTH","100"); //set here the width you want your thumbnail to be
	define ("HEIGHT","33"); //set here the height you want your thumbnail to be.
	define ("WIDTH2","200"); //set here the width you want your thumbnail to be
	define ("HEIGHT2","75");
	
	$fileArray = array();
	global $wpdb;
	
	$dir = WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/';
	$dir1 = WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/thumb/';
	$file = $_FILES['banner_img'];
	$fileName = $_FILES['banner_img']['name'];
	$basename = '';
	
	if(!empty($fileName)){
		$postID = $_POST['post_ID'];
		$extension = getExtension($fileName);
		$extension = strtolower($extension);
		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")){
			echo $mmg="error";exit;
		}else{
			$basename = $iid.".".$extension;
			$target_path = $dir;
			$target_path = $target_path . $basename;
			$target_path1 = $dir1;
			$target_path1 = $target_path1 . $basename;
			//move_uploaded_file($_FILES['img_thumbnail_photo']['tmp_name'], $target_path);
			$image=$basename;
			set_time_limit(0);
			$filename = $basename;
			
			chmod($dir, 777);
			chmod($dir1, 777);
			//echo $target_path1;exit;
			$copied = copy($_FILES['banner_img']['tmp_name'], $target_path);
			$copied1 =copy($_FILES['banner_img']['tmp_name'], $target_path1);
			//if (!$copied) {
				//echo 'Copy unsuccessfull!';exit;
				$errors=1;
			//}else{
				$image = new SimpleImage();
				$image->load(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/'.$basename);
				$size = getimagesize(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/'.$basename);
				//print_r($size);
				$image->save(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/'.$basename);
				/*if($size[0] >= WIDTH2 && $size[1] >= HEIGHT2){
					$image->resize(WIDTH2,HEIGHT2);
					$image->save(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/'.$basename);
					$bigImage=1;
				}
				if($size[0] > WIDTH && $size[1] > HEIGHT){
					$image->resize(WIDTH,HEIGHT);
					$image->save(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/thumb/'.$basename);
					$smallImage=1;
				}
				if($bigImage != 1){
					$image->save(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/'.$basename);
				}
				if($smallImage != 1){
					$image->save(WP_CONTENT_DIR . '/plugins/affiliate_product_banners/banner_img/thumb/'.$basename);
				}*/
				$insBannerImg="update wp_custom_banners set image='".$basename."' where id=".$iid;
				mysql_query($insBannerImg);
			//}//else
		}//extention chk
	}
	echo "<script>window.location='".get_bloginfo('wpurl')."/wp-admin/admin.php?page=affiliate_banners'</script>";
	
}
/*--------------------------------------------- Deleting banner --------------------------------------------------------------*/
if($_REQUEST['bid']){
	$delrec= mysql_fetch_object(mysql_query("SELECT * from `wp_custom_banners` where id =".$_REQUEST['bid']));
	$qry="SELECT * from `wp_custom_banners` where id not in(".$_REQUEST['bid'].") and positionid >".$delrec->positionid." order by positionid asc ";
	$sel=  mysql_query($qry);
	while($fet=mysql_fetch_object($sel)){
		$pid=$fet->positionid-1;
		$upd=mysql_query("update wp_custom_banners set positionid=".$pid." where id=".$fet->id);
	}
	$delBanner="delete from wp_custom_banners where id=".$_REQUEST['bid'];
	if(mysql_query($delBanner))
		echo "<script>window.location='".get_bloginfo('wpurl')."/wp-admin/admin.php?page=affiliate_banners'</script>";

}
/*--------------------------------------------- banner sizing functions --------------------------------------------------*/
function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}	
class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
}
 


?>