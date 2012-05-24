<?php
/*
Plugin Name: Affiliate Product Banners
Author : ritwik
*/

function affiliate_product_banners_init(){
	add_menu_page("Affiliate Banners", "Affiliate Banners", 5, "affiliate_banners", "show_banner_page");
	add_submenu_page( "", "save data", "saved data", 5, "savebannerdata", "save_banner_data" );
	add_submenu_page( "", "Required js", "Required js", 5, "requiredjs", "required_js_fun" );
}
function show_banner_page(){
	include "affiliate_banner.php";
}

function save_banner_data(){
	include "savedate.php";
}
function required_js_fun(){
	include "custom.js.php";
}
add_action('admin_menu', "affiliate_product_banners_init");
?>