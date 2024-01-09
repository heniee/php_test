<?php
include 'index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/login.css">
    <link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<?php
    if(!isset($_SESSION['userid'])) {
?>

<div class = "main"> 

    <h1>Login</h1>
    <form method="post" action="/git_test/login.exe.php" name="loginForm">
    <div class="loginForm">
        <table class="loginTab" >
                <tr class="id">
                    <td>ID</td>
                    <td><input type="text" id="userid" name="userid" placeholder="아이디" required></td>
                </tr>
                <tr>
                    <td>PW</td>
                    <td><input type="password" id="userpw" name="userpw" placeholder="비밀번호" required></td>
                </tr>
        </table>
      

        <div class="btnset">
                <button type="button" class="btnSubmit" onclick="loginChk()">로그인</button>
                <button onclick="location.href='/git_test/join.php'">회원가입</button>
        </div>
    </form>
     </div>
    
</div>   

    <?php } else {
        $userid = $_SESSION['userid'];
        echo "<p>WELCOME $userid($name)"; }
        ?>
</body>
</html>

<script>

    function loginChk(){
        var userid = $('#userid').val()
        var userpw = $('#userpw').val();

       if(userid.length < 1){
           alert('아이디를 입력하세요');
           userid.focus();
           return;
       }else if(userpw.length < 1){
           alert('비밀번호를 입력하세요');
           userpw.focus();
           return;
       }else{
           document.loginForm.submit();
       }
    }

</script>