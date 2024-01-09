<?php

include 'index.php';
session_start();

// write에서 넘어온 데이터 저장 및 출력
$userid = $_SESSION['userid'];                 
$title = $_POST[title];               
$content = $_POST['content'];  
$date = date('Y-m-d H:i:s'); 
$bno = $_POST['bno'];

$ref = $_POST['ref'];
$step = $_POST['step'];
$depth = $_POST['depth'];


$URL = '/stairBoard/list.php';

echo "ref : " . $ref . "<br>";
echo "step : " . $step . "<br>";
echo "depth : " . $depth . "<br>";


// 원래는 ref의 max값에서 +1 을 하려고 했는데 그럴 필요가 없음!
// 새글 작성시 ref는 bno의 값과 동일하게 할 수 있도록 max값 찾기
$query2 = "select max(bno) from board";
$result2 = mysqli_query($connect,$query2);    //쿼리전송
$row = mysqli_fetch_array($result2);         // 배열로 저장


// bno의 max + 1 = ref
if($row[0]){ 
    $number = $row[0]+1;
}else{
     $number=1;
}

// 새글일 경우 
if(!$bno){
    $ref = $number;
    $step = 0;
    $depth = 0;    
  
}else{      
    /* 답글일 경우 
        ref : 부모글과 동일
        step : 부모글 ref +=1
        depth" 부모글(step) +=1 */
    // ref, step값이 계속 안나왔는데 submit한 값을 post로 안가져와서 그랬음 !!!!
    $query3 = "update board set step = step +1
                    where ref = $ref and step > $step";
    $result3 = mysqli_query($connect,$query3); 

    $step = $step + 1;
    $depth = $depth + 1; 
    $ref = $ref;

    
 
}

var_dump($query3);


//var_dump($connect->error);


///insert문 통해 db에 form값 저장 
$query = "insert into board(userid,title,content,date,ref,step,depth)
            values('$userid','$title','$content','$date',$ref,$step,$depth)"; 
var_dump($query); 

$result = mysqli_query($connect,$query);    //쿼리전송
?>


<script>
    alert("글이 등록되었습니다.");
    //href:히스토리 기록 / replace:기록x, 뒤로가기 불가
    location.replace("<?php echo $URL?>");
</script>
