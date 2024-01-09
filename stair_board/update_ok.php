<?php

include 'index.php';
session_start();

$bno = $_POST['bno'];
$userid = $_SESSION['userid'];
$title = $_POST['title'];
$content = $_POST['content'];

echo "bno : " . $bno . "<br>";
echo "userid : " . $userid . "<br>";

$URL = '/stairBoard/read.php?bno=';

$query = " update board set title='{$title}', content='{$content}' where bno = '{$bno}'; ";

$result = mysqli_query($connect,$query); 

?>


<script>
    alert("<?php echo "글이 수정되었습니다."?>");
    location.replace("<?php echo $URL.$bno?>");
</script>

