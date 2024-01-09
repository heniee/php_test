<?php 
//include 'index.php';

//db연결
$servername = 'localhost';
$user = 'hyehyeon_db';
$password = '1234';
$dbname = 'hyehyeon_db';
$connect = mysqli_connect($servername, $user, $password, $dbname);

session_start();


$no = $_REQUEST['no'];
$action_type = $_REQUEST['action_type'];

if($action_type == 'comment_info'){
    $query = "select * from comment where cno = '{$no}'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    
    $return_arr = array(
        'no' => $row['cno'],
        'userid' => $row['userid'],
        'content' => $row['content'],
        'bno' => $row['bno']
    );

}else if($action_type == "delete_comment"){

    $query_check = "select * from comment where userid='{$userid}'";
    $result_check = mysqli_query($connect,$query_check);
    
    $query = " delete from comment where cno='{$no}' ";
    $result = mysqli_query($connect,$query);

    if($result === true){
        $return_arr = array(
            'msg' => '정상적으로 삭제 되었습니다.',
            'status' => true
        );
    }else{
        $return_arr = array(
            'msg' => '오류가 발생하였습니다.',
            'status' => false
        );
    }
}

$return_arr = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
echo $return_arr;
exit();
?>