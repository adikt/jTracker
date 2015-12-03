<?PHP
$localhost = 'monnixsyscom.ipagemysql.com'; //name of server. Usually localhost
$database = 'companies'; //database name.
$username = 'mines'; //database username.
$password = 'Fr33M@n'; //database password.

// connect to db  
$conn = mysql_connect($localhost, $username, $password) or die('Error connecting to mysql');   
$db = mysql_select_db($database,$conn) or die('Unable to select database!');    

?>