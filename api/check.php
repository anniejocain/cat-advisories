<?php

$isbn = $_REQUEST['isbn'];
header('Content-type: application/json');

connect_db();
    
$getDupes  = "SELECT * FROM cat_advisories.advisory WHERE isbn=$isbn";

$result = mysql_query($getDupes);

if(mysql_num_rows($result) > 0) {

  echo '{"advisory_type": "cat"}'; 
    
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