<?php
    include 'index.php';
    session_start();
    if(!isset($_SESSION['userid']));

    //list 에서 넘어온 글 저장
    $bno = $_GET["bno"];
    $query = "select * from board where bno='{$bno}'";
    //조회수 업데이트
    $query_view = "update board set view = view + 1 where bno = '{$bno}'";

    //쿼리 실행
    $result = mysqli_query($connect,$query);
    $result2 = mysqli_query($connect,$query_view);
    $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>read</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/read.css">
    <link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">

    <!-- 모달관련 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
</head>

<body>
    <div class="main">
        <table id="table">
            <button class="listbtn" onclick="location.href='/stairBoard/list.php'">목록으로</button> <br/><br/>
            <thead>
                <tr class="table_tr">
                    <th colspan="6" class="title"><?php echo $row['title']?></th>
                    <input id="bno" type="hidden" value=<?php echo $row['bno']?>>
                </tr>
                <colgroup>
                    <col width="5%"/>
                    <col width="20%"/>
                    <col width="5%"/>
                    <col width="20%"/>
                    <col width="5%"/>
                    <col width="20%"/>
                </colgroup>
            </thead>
            <tbody>
                <tr>
                    <td class="view1">글쓴이</td>
                    <td class="view"><?php echo $row['userid']?></td>
                    <td class="view1">작성일</td>
                    <td class="view"><?php echo $row['date'] ?></td>
                    <td class="view1">조회수</td>
                    <td class="view"><?php echo $row['view']?></td>
                </tr>
                <tr>
                    <td class="content"><?php echo $row['content']?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <?php
        // 글 작성자만 버튼 활성화
        if($_SESSION['userid'] == $row['userid']){ ?>
        <div class="udbtn">
            <button class="ubtn" onclick="location.href='/stairBoard/update.php?bno=<?=$row['bno'] ?>'">수정</button>

            <!-- 수정버튼과 동일하게 delete.ok로 넘기면 비밀번호를 get방식으로 받게되는데 url에 나타나기 때문에
                보안에 취약, 방지하기 위해 post방식으로 보낸다 ->form 사용  -->
            <form method="post" action="/stairBoard/delete_ok.php">
                <input type="hidden" value="<?php echo $row['bno'] ?>" name=bno>
                <button class="dbtn" type="submit" value="삭제">삭제</button>
            </form>

            <?php } ?>
            <button class="lbtn" onclick="location.href='/stairBoard/write_re.php?bno=<?=$bno?>&ref=<?=$row['ref']?>&step=<?=$row['step']?>&depth=<?=$row['depth']?>'">
                답글쓰기
            </button>
            <br>
        </div>
        <br><br>
        <div id="main2">
            <!-- 댓글 목록-->
            <h1>댓글</h1>

            <?php
                $query_comment = "select * from comment where bno = '$bno'";
                $result_comment = mysqli_query($connect, $query_comment);

                $ctotal = $result_comment->num_rows;

                if($ctotal == 0){
            ?>
            <tr>등록된 댓글이 없습니다</tr>
            <?php
                } else {
                while($row2 = mysqli_fetch_array($result_comment)){
            ?>
            <table class = "comment">

                <colgroup border="1">
                    <col width="10%"/>
                    <col width="60%"/>
                    <col width="15%"/>
                    <col width="6%"/>
                    <col width="6%"/>
                </colgroup>
                <tr>
                    <td> <?php echo $row2['userid'] ?></td>
                    <td id='ccontent'> <?php echo $row2['content'] ?></td>
                    <td> <?php echo $row2['date'] ?></td>

                    <?php
                    // 글 작성자만 버튼 활성화
                    if($_SESSION['userid'] == $row2['userid']){ ?>
                        <td>
                            <button id="modal_btn" name="modal_btn" onclick=openModal('<?=$row2[0]?>')>수정</button>
                        </td>
                        <td>
                            <!-- 
                            <form method="post" action="/stairBoard/c_delete_ok.php">
                                <input type="hidden" value="<?=$row['bno'] ?>" name="bno">
                                <input type="hidden" value="<?=$row2['cno'] ?>" name="cno">
                                <button class="dbtn2" type="submit" value="삭제">삭제</button>
                            </form>
                            -->
                            <button id="modal_btn" name="modal_btn" onclick=deleteComment('<?=$row2[0]?>')>삭제</button>
                        </td>
                    <?php } ?>
                </tr>
            </table>
        <?php
            }
        }
        ?>
            <br> <br> <br>
            <!-- 댓글 작성 -->
            <h1>댓글 작성</h1>
            <form method="post" action="/stairBoard/c_write_ok.php">
                <table class="table">
                    <tr>
                        <td>작성자</td>
                        <td><input type="hidden" name="userid" size="20" required> <?php echo $_SESSION['userid']?> </td>
                        <!--bno 넘길때 value값으로 안주고 그냥 input안에 입력해서 안넘어갔음 ㅠ -->
                        <td>
                            <input type="hidden" value="<?php echo $row['bno'] ?>" name=bno></td>
                    </tr>
                    <tr>
                        <td>내용</td>
                            <td><textarea name=content required></textarea ></td>
                        <td><button class="dbtn" type="submit" value="등록">등록</button>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body> 

<!--모달창 안 내용 -->
<div id="comment_modal" class="modal">
    <form method="post" id="f2" name="f2" action="/stairBoard/c_update_ok.php">
        <input type="hidden" id="modal_bno" name="modal_bno" value="">
        <input type="hidden" id="modal_cno" name="modal_cno" value="">
        <div class="modal-dialog">
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h4 class="modal-title">댓글 수정하기</h4>
                </div>
                <div class="modal-body" style="margin-top:10px; margin-bottom:10px;">
                    <table width="450" style="border-collapse:collapse;" border="1">
                        <tr>
                            <td >작성자</td>
                            <td >
                                <input type="text" name="modal_userid" id="modal_userid" value="">
                            </td>
                        </tr>
                        <tr>
                            <td>내용</td>
                            <td>
                                <textarea name="modal_content" id="modal_content" style="width:360px;"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="">적용</button>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- 모달 관련 -->
<script>
function openModal(no){

    event.preventDefault();

    $("#comment_modal").modal({
        fadeDuration: 250
    });

    var action_type = "comment_info";
    
    $.ajax({
        url: './getCommentInfo.php',
        data: {no:no, action_type:action_type},
        dataType:'json',
        type:'POST',
        success : function (data) {
            var no = data.no;
            var bno = data.bno;
            var content = data.content;
            var userid = data.userid;
            
            $("#modal_userid").val(userid);
            $("#modal_content").append(content);
            $("#modal_bno").val(bno);
            $("#modal_cno").val(no);
            return false;
        },
        error : function(r){
            console.log(r);
        }
    });

}

function deleteComment(no){
    var action_type = "delete_comment";
    
    if(!confirm("정말 삭제하시겠습니까?")){
        return false;
    }else{
        $.ajax({
            url: './getCommentInfo.php',
            data: {no:no, action_type:action_type},
            dataType:'json',
            type:'POST',
            success : function (data) {
                console.log(data);
                
                alert(data.msg);
                location.reload();
            },
            error : function(r){
                console.log(r);
            }
        });    
    }
}
</script>
</html>







