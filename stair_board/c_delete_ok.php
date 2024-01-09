<?php

include 'index.php';
session_start();

$userid = $_SESSION['userid']; 
$cno = $_POST['cno'];
$bno = $_POST['bno'];  

print($userid);
print($cno);
print($bno);

// 작성자 체크 쿼리
$query_check = "select * from comment where userid=$userid";
$result_check = mysqli_query($connect,$query_check);

$query = "delete from comment where cno=$cno";
$result = mysqli_query($connect,$query);

$URL = '/stairBoard/read.php?bno=';

?>


<script>
    alert("<?php echo "댓글이 삭제되었습니다."?>");
    location.replace("<?php echo $URL.$bno?>");
</script>
