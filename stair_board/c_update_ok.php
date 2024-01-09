<?php

include 'index.php';
session_start();

$cno = $_POST['modal_cno'];
$userid = $_SESSION['modal_userid'];
$content = $_POST['modal_content'];
$bno = $_POST['bno_modal'];

echo "cno : " . $cno . "<br>";
echo "userid : " . $userid . "<br>";
echo "content : " . $content . "<br>";
echo "bno : " . $bno . "<br>";

$URL = '/stairBoard/read.php?bno=';

$query = " update comment set content='{$content}' where cno = '{$cno}'; ";

$result = mysqli_query($connect,$query); 


?>


<script>
    alert("<?php echo "댓글이 수정되었습니다."?>");
    location.replace("<?php echo $URL.$bno?>");
</script>
