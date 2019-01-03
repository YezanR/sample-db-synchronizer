<?php
//connect to SQL Server instance 
$mshostname = '192.168.1.117'  ; 
$msdbname = 'flashlab_dev' ; 
$port = '1433';
$msusername = 'sa'; 
$mspwd = 'test'; 
$msDB = null ; 
try {
	$msDB = new PDO ("dblib:host=$mshostname:$port;dbname=$msdbname", "$msusername", "$mspwd");
	echo "\r\n --> connected to MS SQL" ; 
} catch (PDOException $e) {
	die(  "\r\n Ms Failed to get DB handle: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n" ) ; 
}
?>