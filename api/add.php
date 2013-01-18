<?php

if($_REQUEST['isbn']) {
  $isbn = $_REQUEST['isbn'];
}
elseif($_REQUEST['url']) {

  $url = $_REQUEST['url'];
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
}

connect_db();
	
$doadd = true;
    
$getDupes  = "SELECT * FROM cat_advisories.advisory WHERE isbn=$isbn";

$result = mysql_query($getDupes);

if(mysql_num_rows($result) > 0) $doadd = false;
    
if($doadd) {

  $addInput  = "INSERT INTO cat_advisories.advisory (isbn, count) VALUES ('$isbn', '1')";

  mysql_query($addInput) or die(mysql_error());
    
  print mysql_insert_id();
    
  mysql_close();
    
}else {
  
  while ($row = mysql_fetch_array($result)) {
    $count = $row[4] + 1;
    $id = $row[0];
  }
  $updateInput = "UPDATE cat_advisories.advisory SET advisory.count = '$count' WHERE advisory.id = '$id'";
  echo $updateInput;
  
  mysql_query($updateInput) or die(mysql_error());
    
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