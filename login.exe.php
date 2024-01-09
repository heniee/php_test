<?php
include 'index.php';

$userid = $_POST[userid];
$userpw = $_POST[userpw];

// 아이디 확인
$query = "select * from `member` WHERE userid = '$userid'";

$res = $db->query($query);
$row = $res->fetch_array();

if(empty($row)){
    echo "<script>alert('아이디를 확인해주세요');
            history.back();
          </script>";
}else {
    $userpw_hash = $row['userpw'];

    //사용자 비밀번호 입력값과 저장된 hash값 비교
    if (password_verify($userpw, $userpw_hash)) {
        // 세션 생성
        $_SESSION['userid'] = $row['userid'];
        echo "window.location.replace('/git_test/list.php');</script>";
    } else {
        echo "<script>alert('비밀번호를 확인해주세요.');
                history.back();
              </script>";
    }
}
?>
