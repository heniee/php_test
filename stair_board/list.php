<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>List</title>

<link rel="stylesheet" href="/css/list.css">
<link rel="stylesheet" href="/css/index.css">
<link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">

    </head>
    <body>
         <?php
       include 'index.php';

         // 데이터 불러오기 
         $query = "select * from board  "; 
         $result = mysqli_query($connect,$query);    //쿼리전송

         ?>

          <!--페이징 -->

    <?php

        // 페이지를 넘나들때 GET 메소드 사용, page를 받아 할당해주고(해당 페이지 출력) 없으면 1페이지 출력 
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else {
            $page = 1;
        }

        // 글 갯수 구하기
        $total = mysqli_num_rows($result);

        //한페이지에 출력할 글 수 
        $onePage = 10;

        //전체 페이지 수 (글 갯수/한페이지에 출력할 글 수 )
        $totalPage = ceil($total/$onePage);

        //한 블럭 당 보여줄 페이지 수
        $pagesize = 5;

        //전체 블럭 수 (전체 페이지 수 / 한블럭당 페이지 수 )
        $totalBlock = ceil($totalPage / $pagesize);
   
        /*현재 블럭 번호 (현재 페이지 번호 / 블럭 당 페이지 수 )*/
        $nowBlock = ceil($page / $pagesize);
   
        /*블럭당 시작페이지 번호 ((해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1)
        1-5 페이지면 1, 6-10 이면 6, 11-15면  11 
        11페이지일 경우 (3-1)*5+1 = 11  */
        $pageNum_start = ($nowBlock -1) * $pagesize + 1 ;

        /* 블럭당 마지막 페이지 번호 (현재 블럭 번호 * 블럭 당 페이지 수) 
        11페이지일 경우 3*5 =15   */
        $pageNum_end = $nowBlock * $pagesize;
        // 2블럭에서 페이지가 6까지 있으면 6까지만 표시
        if($pageNum_end > $totalPage){
            $pageNum_end = $totalPage; 
        }

        /* 시작 글번호 ((현재 페이지 - 1) * 한페이지 글 수 
            1페이지의 시작번호는 0 */
        $start = ($page - 1) * $onePage ;

        // 글번호 index의 시작행은 0, 출력은 1부터 될 수 있도록 +1 
       $bno2 = $start + 1;

        /* 최종으로 글 가져오는 쿼리
            limit : 몇 번부터 몇 개  start부터 onPage개
            1 페이지 : 0번부터 5개
            2 페이지 : 5번부터 5개 ...*/
        $query_page = "select * from board order by ref desc, step asc limit $start, $onePage";
        $result_page = mysqli_query($connect,$query_page);

        //$query = "select * from board order by ref desc, step asc ";
        ?>
        
        <!-- 리스트 -->
<div id ="table"> 
    <table>
    <a href="/stairBoard/write.php"> <button class="writebtn">글쓰기</button></a>
            
        <thead>

        <colgroup border="1">
            <col width="10%"/>
            <col width="50%"/>
            <col width="10%"/>
            <col width="20%"/>
            <col width="10%"/>
         </colgroup>

        <div class="topth">
            <tr>
                <th>글번호</th>
                <th>제목</th>
                <th>글쓴이</th>
                <th>작성일</th>
                <th>조회수</th>
            </tr>
         </div>    
        </thead>

        <tbody>
            <tr>
                <!-- mysqli_fetch_array는 1회 실행에 한 개의 행만을 가져온다
                    while문을 통해 여러번 패치하여 모든 글 가져오기 -->
                <?php while($row = mysqli_fetch_array($result_page)){ 
                    
                    ?> 
                    <!-- db idex가 아닌 출력용 bno2로 수정 -->
                   
                <td> <?php echo $bno2; ?> </td>
                <td id="tdtitle">
                    <!-- 답글 들여쓰기 -->
                    <?php
                    if($row['depth']>0){
                        echo "<img src='dot.png' height=20 width=".($row['depth']*20).">";
                        echo " ";
                        echo "<img src='re.png' height=20 width=20>";
		} ?> 

                    <a href="/stairBoard/read.php?bno=<?php echo $row['bno']?>">
                    <?php echo $row['title'] ?> </a>

                </td>
                <td> <?php echo $row['userid'] ?> </td>
                <td> <?php echo $row['date'] ?> </td>
                <td> <?php echo $row['view'] ?> </td>
            </tr>
            <?php
                $bno2++;
                };   //while문 종료
            ?>
        </tbody>
    </table>

    
   <!-- 페이징 -->

    
   <div class="page" >
        
        <?php
       
      //이전
        if($page <= 1 ){
            echo "<a href='/git_test/stair_board/list.php?page=1'>처음</a>";
        }   else { 
            $pre = $page - 1;
            echo "<a href='/stairBoard/list.php?page=$pre'> 이전 </a>";
       }; 

       //페이지 번호
       for($print_page =$pageNum_start; $print_page <= $pageNum_end; $print_page++){
        
        // 현재페이지 색상주기!! 
            if($_GET['page'] == $print_page){
                echo "<a class='printPage'> $print_page</a>";
            }else{
            echo "<a href='/stairBoard/list.php?page=$print_page'> $print_page </a>";
            }
        }

        // 다음 
        if($page >= $totalPage){
            echo "<a href='/stairBoard/list.php?page=$totalPage'> 끝 </a> ";
        } else { 
             $next = $page + 1;
            echo "<a href='/stairBoard/list.php?page=$next'>다음</a>";
        };  

        ?>     
            
    </div>
</div>   
</body>
</html>