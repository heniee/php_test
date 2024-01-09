<?php
 
$servername = 'localhost';
$user = 'hyehyeon_db';
$password = '1234';
$dbname = 'hyehyeon_db';
$connect = mysqli_connect($servername, $user, $password, $dbname);


$userid = $_GET['userid'];

$query = "select * from member where userid = '$userid'";
$result= mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);



if(!$row){
   echo "$uid 는 사용 가능한 아이디입니다.";
    ?> 
    <!--부모창의 decide() 함수 호출 후 창 닫기 -->
    <p><input type='button' value='이 아이디 사용' onclick='opener.parent.decide(); window.close();'></p>
 <?php } 
else {
    echo "$uid 는 사용중인 아이디입니다.";
    ?>
    <p><input type='button' value='다른 아이디 사용' onclick="opener.parent.change(); window.close();"></p>
<?php  }
    


?>


