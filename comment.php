<?php
    $sql = 'select  * from comment where comment_no=comment_depth and b_no='.$no;
    $result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<div id="commentView">
    <form action="postComment.php" method="post">
        <input type="hidden" name="bNo" value="<?=$no?>">
        
        <?php
            while($row=$result->fetch_array()){
        ?>
    <ul class ="oneDepth">
        <li>
            <div id="comment_<?=$row['comment_no']?>" class="commentSet">
                    <div class="comment_info">
                        <div class="commentID"><span>작성자 아이디 : <?=$row['comment_id']?></span></div>
                        <div class="commentBtn">
                            <a href="#" class="comt Write">댓글</a>
                            <a href="#" class="comt Modify">수정</a>
                            <a href="#" class="comt Del">삭제</a>
                        </div>                            
                    </div>
                    <div class="cContent"><p><?=$row['comment_content']?></p></div>
            </div>
            <?php
                $sql2='select * from comment where comment_no !=comment_depth and comment_depth='.$row['comment_no'];
                $result2 = $db->query($sql2);
                
                while($row2=$result2->fetch_array()){
            ?>
            <ul class="twoDepth">
                <li>
                    <div id="comment_<?=$row2['comment_no']?>" class="commentSet">
                        <div class="comment_info">
                            <div class="commentID"><span>작성자 아이디 : <?=$row2['comment_id']?></span></div>
                            <div class="commentBtn">
                                <a href="#" class="comt Modify">수정</a>
                                <a href="#" class="comt Del">삭제</a>
                            </div>
                        </div>
                        <div class="cContent"><p><?=$row2['comment_content']?></p></div>
                    </div>
                </li>                
            </ul>
                <?php }?>
        </li>
    </ul>
          <?php }?>
    </form>
</div>


<form action="postComment.php" method="post">
    <input type="hidden" name="bNo" value="<?=$no?>"/>
      <table> 
        <tbody>
            <tr>
                <th><label for="commentID" class="form-label">아이디</label></th>
                <td><input class="form-control" type="text" name="commentID" id="commentID"></td>
            </tr>
            <tr>
                <th><label for="cPw" class="form-label" >비밀번호</label></th>   
                    <td><input class="form-control" type="password" name="cPw" id="cPw"></td>
                
            </tr>
            <tr>
                <th><label for="cContent" class="form-label">내용</label></th>
                <td><textarea class="form-control" name="cContent" id="cContent"></textarea></td>
            </tr>
        </tbody>
    </table>
    <div class="btnSet">
        <input class="btn btn-outline-dark" type="submit" value="댓글 작성"/>
    </div>
</form>

<script>
    $(document).ready(function(){
        var action='';
        
        $('#commentView').delegate('.comt', 'click', function() {
            
            var thisParent = $(this).parents('.commentSet');
            
            var commentSet = thisParent.html();
            thisParent.addClass('active');
            
            //댓글 /수정/ 삭제 창을 닫기 위한 취소 버튼
            var commentBtn = '<a href="#" class="addComt close">닫기</a>';
            
            $('.comt').hide();
            $(this).parents('.commentBtn').append(commentBtn);
            
            
            //comment_info의 ID를 가져온다.
            var comment_no=thisParent.attr('id');
            
            //앞의 문자 "comment_"를 뺀 나머지 comment_no를 가져온다.
            comment_no = comment_no.substr(8, comment_no.length);
            
            //초기화
            
            var comment='';  //화면 표시할 레이아웃 변수
            var commentID='';
            var cContent='';
            
            if($(this).hasClass('Write')){
                //댓글 작성
                action='w';
                
                commentID = '<input type="text" name="commentID" id="commentID">';
            }else if($(this).hasClass('Modify')){
                //댓글 수정
                action = 'm';
                commentID = thisParent.find('.commentID').text();
                var cContent = thisParent.find('.cContent').text();
                
            }else if($(this).hasClass('Del')){ 
                //댓글 삭제
                action = 'd';
            }    
            
            comment +='<div class="writeComment">';
            comment +='     <input type="hidden" name="w" value="'+ action +'">';
            comment +='     <input type="hidden" name="comment_no" value="'+ comment_no +'">';
            comment +='  <table>';
            comment +='     <tbody>';
            if(action !='d'){
                comment +='     <tr>';
                comment +='         <th><label for="commentID">작성자 아이디</label></th>';
                comment +='         <td>'+ commentID +'</td>';
                comment +='     </tr>';
            }
            comment +='         <tr>';
            comment +='             <th><label for="cPw">비밀번호</label></th>';
            comment +='             <td><input type="password" name="cPw" id="cPw"></td>';
            comment +='         </tr>';
            if(action !='d'){
                comment +='     <tr>';
                comment +='         <th><label for="cContent">내용</label></th>';
                comment +='         <td><textarea name="cContent" id="cContent">'+cContent+'</textarea></td>';
                comment +='     </tr>';
            }                
            comment +='     </tbod>';
            comment +='  </table>';
            comment +='  <div class="btnSet">';
            comment +='     <input type="submit" value="확인">';
            comment +='  </div>';
            comment +='</div>';
            
            thisParent.after(comment);
            
            return false;
        });
        
        $('#commentView').delegate(".close", "click", function() {
                    $('.writeComment').remove();
                    $('.commentSet.active').removeClass('active');
                    $('.addComt').remove();
                    $('.comt').show();
                return false;
        });
        
    });    
</script>
