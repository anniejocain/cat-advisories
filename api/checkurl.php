<?php

$url = $_REQUEST['url'];

header('Content-type: application/json');

$reg = '#(?:http://(?:www\.){0,1}amazon\.com(?:/.*){0,1}(?:/dp/|/gp/product/))(.*?)(?:/.*|$)#';

$matches = array();
preg_match_all($reg,$url, $matches);


foreach($matches[1] as $match) {
  if(strlen($match) == 10 || strlen($match) == 13)
    $isbn = $match;
}

$reg = '#(?:https://(?:www\.){0,1}amazon\.com(?:/.*){0,1}(?:/dp/|/gp/product/))(.*?)(?:/.*|$)#';

$matches = array();
preg_match_all($reg,$url, $matches);


foreach($matches[1] as $match) {
  if(strlen($match) == 10 || strlen($match) == 13)
    $isbn = $match;
}

connect_db();
    
$getDupes  = "SELECT * FROM cat_advisories.advisory WHERE isbn=$isbn";

$result = mysql_query($getDupes);

if(mysql_num_rows($result) > 0) {

  echo '{"advisory_type": "cat"}'; 
    
}
else {
  echo '{"advisory_type": "none"}';
}

mysql_close();
    
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