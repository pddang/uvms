
<?php
DEFINE ('DB_USER','2882053_ios');
DEFINE('DB_PASSWORD','Jeremiah2911');
DEFINE('DB_HOST','pdb39.awardspace.net');
DEFINE('DB_NAME','2882053_ios');
$db_connection = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
OR die ('Could not connect to MySQL: '.mysqli_connect_error());
mysqli_set_charset($db_connection,'utf8');
?>
