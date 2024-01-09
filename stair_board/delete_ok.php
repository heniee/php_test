<?php
include 'index.php';
session_start();

$userid = $_SESSION['userid']; 
$bno = $_POST['bno'];
$URL = '/stairBoard/list.php';

echo "bno : " . $bno . "<br>";
echo "userid : " . $userid . "<br>";

// 작성자 체크 쿼리
$query_check = "select * from board where userid=$userid";
$result_check = mysqli_query($connect,$query_check);


// 삭제 쿼리문
$query = "delete from board where bno=$bno";
$result = mysqli_query($connect,$query);

var_dump($query)
?>


<script>
    alert("글이 삭제되었습니다.");
    location.replace("<?php echo $URL?>");
</script>

