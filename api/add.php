<?php

$isbn = $_REQUEST['isbn'];

connect_db();
	
$doadd = true;
    
$getDupes  = "SELECT * FROM cat_advisories.advisory WHERE isbn=$isbn";

$result = mysql_query($getDupes);

if(mysql_num_rows($result) > 0) $doadd = false;
    
if($doadd) {

  $addInput  = "INSERT INTO cat_advisories.advisory (isbn) VALUES ('$isbn')";

  mysql_query($addInput) or die(mysql_error());
    
  print mysql_insert_id();
    
  mysql_close();
    
}
    
function connect_db(){

  require_once('config.php');
	if(!($link=mysql_pconnect($hostName, $userName, $pw))) 
	{
		echo "before error<br />";
		echo "error connecting to host";
		exit;
	}
}
?>