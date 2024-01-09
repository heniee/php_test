<?php
include 'index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>join</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/join.css">
    <link href="//fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
    .checkMsg {
        color: red;
        font-size: 12px;
    }

</style>
<body>
  <div class = "main">
      <h1>JOIN</h1>
      <form id="joinForm" method = "post" action ="/git_test/join.exe.php">
          <input type="hidden" name="mode" value="join">
          <div class="joinForm">    
              <table class="joinIntput">
                  <tr>
                      <td>아이디</td>
                      <td><input type="text" name='userid' id='userid' placeholder="아이디" required></td>
                      <td><input type="hidden" name='decideId' id='decideId'></td>
                      <td><input type='button' id='idcheck' value='ID 중복검사' onclick = "checkid();"></td>
                  </tr>
                  <tr>
                      <td colspan="4" id="idMsg" class="checkMsg" style="display: none;">아이디는 소문자 8-20자로 입력해주세요.</td>
                  </tr>
                  <tr>
                      <td>비밀번호</td>
                      <td><input type="password" name='userpw' id='userpw' placeholder="비밀번호" required></td>
                  </tr>
                  <tr>
                  <tr>
                      <td colspan="4" id="pwMsg" class="checkMsg" style="display: none;">비밀번호는 소문자,대문자,특수문자 포함 8-20자로 입력해주세요.</td>
                  </tr>
                    <td>비밀번호 확인</td>
                    <td><input type="password" name='pwcheck' id='pwcheck' placeholder="비밀번호를 다시 입력해주세요" ></td>
                  </tr>
                  <tr>
                      <td>이름</td>
                      <td><input type="text" name='username' id='username' placeholder="이름" required></td>
                  </tr>
                  <tr>
                      <td colspan="4" id="nameMsg" class="checkMsg" style="display: none;">이름은 필수입력입니다.</td>
                  </tr>
                  <tr>
                      <td>이메일</td>
                      <td><input type="email" name='mail' id='mail' placeholder="이메일" required></td>
                  </tr>
                  <tr>
                      <td colspan="4" id="mailMsg" class="checkMsg" style="display: none;">메일 형식이 잘못되었습니다.</td>
                  </tr>
        </table>

        <div class="btnset">
            <button type="submit" id='join_btn' value="회원가입" disabled=true>회원가입</button>
        </div>
    </div>
    </form>
</div>    
</body>
</html>



<script>
    // 아이디 체크
function checkid(){
    var id = $('#userid').val();
    var isValid  = checkidValid(id);
    var mode = 'idCheck';

    if(isValid) {
        $('#idMsg').hide();
        $.ajax({
            type: 'POST',
            url: '/git_test/join.exe.php',
            data: {
                userid: id,
                mode: mode
            },
            success: function (r) {
                if (r.status === true) {
                    alert('사용 가능한 아이디입니다.');
                    decide();
                } else {
                    alert('이미 등록된 아이디가 있습니다.');
                }
            },
            error: function (r) {
                console.log(r);
            }
        });
    }else{
        $('#idMsg').show();
        $('#userid').focus();
        return false;
    }
}

    function checkidValid(id){
        // 아이디 체크(소문자 8-20)
        var regex = /^(?=.*[a-z])[a-z0-9]{8,20}$/;
        return regex.test(id);
    }

 // 아이디 체크 후 사용할때 수정내용 
 function decide(){
    // 확정한 id를 hideen태그의 value로 넣어주기 
     $('#decideId').val($('#userid').val());
    //회원가입버튼 활성화
     $('#join_btn').prop('disabled', false);
    //아이디폼 비활성화
     $('#userid').prop('disabled', true);
    //중복검사 버튼 바꾸기
     $('#idcheck').val('다른 ID로 변경');
    //다른ID로 변경 버튼의 onclick 함수를 change()로 변경 
     $('#idcheck').attr('onclick', 'change()');
 }

 // 체크아이디 수정할때 -> 초기상태로 
 function change(){
    //회원가입버튼 비활성화
     $('#join_btn').prop('disabled', true);
    //로그인폼 활성화
     $('#userid').prop('disabled', false);
    //로그인폼 비워주기
     $('#userid').val('');
    //다른 ID로 변경 버튼 초기상태로 바꾸기
     $('#idcheck').val('ID 중복검사');
     //다른 ID로 변경 버튼의 onclick 함수를 checkid()로 변경 
     $('#idcheck').attr('onclick', 'checkid()');
 }


    $('#join_btn').click(function(e){
        var userpw = $('#userpw').val();
        var email = $('#mail').val();
        var username = $('#username').val();

        // 비밀번호 소문자,대문자,특수문자 포함 8-20
        // 이메일 체크
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!regex.test(userpw)) {
            $('#pwMsg').show();
            $('#userpw').focus();
          return false;
        }
        $('#pwMsg').hide();

        if(!username){
            $('#nameMsg').show();
            $('#username').focus();
            return false;
        }
        $('#nameMsg').hide();

        if (!emailRegex.test(email)) {
            $('#mailMsg').show();
            $('#mail').focus();
            return false;
        }

        $('#joinForm').submit();
    })

</script>
