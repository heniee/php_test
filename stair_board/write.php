<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>write</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/write.css">
    <link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">

</head>
<body>
    <?php
    include 'index.php';
    $URL = '/stairBoard/login.php';
    session_start();
    if(!isset($_SESSION['userid'])){

    ?>
    
    <!--세션 확인 후 없으면 로그인창 띄우기-->
    <script>
        alert("로그인이 필요합니다");
         location.replace("<?php echo $URL?>");
    </script>
    <?php
    }
    ?>

<!--작성된 내용 저장하는 php로 보내기-->
<div class='main'>

    <form method = "post" action="/stairBoard/write_ok.php" >
        
         <!-- 답글 작성 위해서 데이터 넘기기 -->
        <input type="hidden" name="ref"  size=20 value="<?php echo $_GET['ref']?>">  
        <input type="hidden" name="step"  size=20 value="<?php echo $_GET['step']?>">  
        <input type="hidden" name="depth"  size=20 value="<?php echo $_GET['depth']?>">   

        <table class="table">
            <tr>
                <td>작성자</td>
                <td><input type="hidden" name=userid size=20> <?php echo $_SESSION['userid']?> </td>
            </tr>
            <tr>
                <td>제목</td>
                <td><input type=text name=title size=80 required> </td>
            </tr>
            <tr>
                <td>내용</td>
                <td><textarea name=content></textarea required></td>
            </tr>
        </table>

        <div class=btnset>
            <button type="submit" value="글작성">글작성</button>
            &nbsp;&nbsp;
            <button> <a href="/stairBoard/list.php">목록으로</a></button>
        </div>
    </form>

</div>


</body>
</html>