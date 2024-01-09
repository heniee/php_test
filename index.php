
<?php
include 'lib/common.lib.php';

/*
DB 접속정보
host : localhost
id : hyehyeon_db
pw : 1234
db : hyehyeon_db
*/
session_start();

//db연결
$servername = 'localhost';
$user = 'hyehyeon_db';
$password = '1234';
$dbname = 'hyehyeon_db';
$db = mysqli_connect($servername, $user, $password, $dbname);

if (!$db) {
$error = mysqli_connect_error();
$errno = mysqli_connect_errno();
echo "$errno: $error\n";
exit();
}

?>
