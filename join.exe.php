<?php
include 'index.php';

$request_arr           = $_POST;
//$request_arr['userid'] = $_POST['userid'];

if($_POST['mode'] == 'idCheck'){
  $res = idCheck($request_arr);
}else{
    $res = joinCheck($request_arr);
}


// id중복체크
function idCheck($request_arr){
    global $db;

    $userid = $request_arr['userid'];

    $query = "SELECT count(*) AS count FROM member WHERE user_id = '{$userid}'";

    $res = $db->query($query);
    $row = $res->fetch_assoc();

    $status = ($row['count'] >= 1) ? false : true;

    $response = array(
        'status' => $status
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 회원가입
function joinCheck($request_arr){
    global $db;

    $userpw  = $request_arr['userpw'];
    $pwcheck = $request_arr['pwcheck'];

    //비밀번호 암호화(비밀번호 값이 매번 달라짐)
    $userpw_hash = password_hash($userpw, PASSWORD_DEFAULT);

    if ($pwcheck != $userpw) {
      msg("비밀번호를 확인해주세요.", 'back');
    }

    $query = "INSERT INTO member (user_id,user_pw,user_name,user_mail,reg_date)
                VALUES ('{$request_arr['decideId']}','{$userpw_hash}','{$request_arr['username']}','{$request_arr['mail']}',NOW())";

    $res = $db->query($query);

    if($res){
        msg("회원가입이 완료되었습니다.",'/git_test/login.php');
    }else{
        msg('오류가 발생했습니다. 다시 시도해주세요','back');
    }
}