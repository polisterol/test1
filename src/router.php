<?php

/*
for script need mysql with db: 'test' and table: 'links'
CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `long_link` text,
  `short_link` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

//init
$server = "localhost";
$port = 3306;
$database = "test";
$user = "root";
$password = "";
//-----------------------

//return string contains 6 random simbols
function create_url() 
{ 
    $arr = array('a','b','c','d','e','f', 
                 'g','h','i','j','k','l', 
                 'm','n','o','p','r','s', 
                 't','u','v','w','x','y', 
                 'z','A','B','C','D','E', 
                 'G','H','I','J','K','L', 
                 'M','N','O','P','R','S', 
                 'T','U','V','W','X','Y', 
                 'Z','F','1','2','3','4', 
                 '5','6','7','8','9','0'); 
    $url = ""; 
    for($i = 0; $i < 6; $i++) 
    { 
      $random = rand(0, count($arr) - 1); 
      $url .= $arr[$random]; 
    } 
	return $url; 
} 
//if $short_url(alias) in db return original_link
//else return FALSE
function check_short_url($short_url, $mysqli)
{
	$sql = sprintf("SELECT long_link FROM links WHERE (short_link='%s')", $short_url);
    $result = $mysqli->query($sql);
    $row = $result->fetch_array();

    if ($row){
        return $row["long_link"];
    }
    else{
        return FALSE;
    }
}
//if $long_url(origin) in db return short_link(alias)
//else return FALSE
function check_long_url($long_url, $mysqli)
{
	$sql = sprintf("SELECT long_link, short_link FROM links WHERE (long_link='%s')", $long_url);
    $result = $mysqli->query($sql);
    $row = $result->fetch_array();

    if ($row){
        return $row["short_link"];
    }
    else
    {
        return FALSE;
    }
}
//-----------------------

//db connect
$mysqli = new mysqli($server, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
//-----------------------

//redirect if short_link have in db
if(preg_match('(^/[a-zA-Z0-9]{6}$)', $_SERVER["REQUEST_URI"], $match)){
    $short_link = substr($match[0], 1);
    if($origin_url = check_short_url($short_link, $mysqli)){
        header("location: ".$origin_url);
    }
    else header("location: http://".$_SERVER['SERVER_ADDR']);
}
//-----------------------
else{

    //request for short_link
    if(isset($_GET["longUrl"]) && $_GET["longUrl"]!= ""){

        $long_url = $mysqli->real_escape_string(htmlspecialchars($_GET["longUrl"]));

        if($result = check_long_url($long_url, $mysqli)) print("http://localhost/$result");
        else{
    	   do $tmp_url = create_url();
    	   while(check_short_url($tmp_url, $mysqli));
    	   $sql = sprintf("INSERT INTO links(long_link, short_link) VALUES ('%s', '%s');", $long_url, $tmp_url);
    	   $mysqli->query($sql);
    	   print("http://localhost/$tmp_url");
        }
    }
    //////-----------------------
    else{
        //index
        readfile("client.html");
    }
}
//close db
$mysqli->close();
////-----------------------
?>