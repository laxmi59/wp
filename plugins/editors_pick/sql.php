<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<?php 
$sql = "CREATE TABLE `manage_articles` (
`id` INT NULL AUTO_INCREMENT PRIMARY KEY ,
`post_id` INT NOT NULL ,
`date` DATE NOT NULL
) ENGINE = MYISAM ";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);
?>
<body>
</body>
</html>
