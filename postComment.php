<?php
    require_once('./dbconnect.php');
    
    $w ='';
    $comment_no ='null';
    
    if(isset($_POST['w'])){
        $w = $_POST['w'];
        $comment_no = $_POST['comment_no'];
    }
    
    
    $no = $_POST['bNo'];
    //$commentID=$_POST['commentID'];
    $cPw = $_POST['cPw'];
    //$cContent = $_POST['cContent'];
    
    if($w !='d'){
        $cContent = $_POST['cContent'];
        if($w !='m'){
            $commentID = $_POST['commentID'];
        }
    }
    
    if(empty($w) || $w == 'w'){ //$w 가 비어있는 경우는 1depth 댓글, $w='w' 인경우에는 2depth
        $msg = '작성';
        $sql = 'insert into comment values(null, '.$no.','.$comment_no.',"'.$cContent.'","'.$commentID.'",password("'.$cPw.'"))';
        
        if(empty($w)){
            $result = $db->query($sql);
            $comment_no=$db->insert_id;
            $sql='update comment set comment_depth = comment_no where comment_no='.$comment_no;
        }
    }else if($w =='m'){
        $msg = '수정';
        
        $sql = 'select count(*) as cnt from comment where comment_pw=password("'.$cPw.'") and comment_no ='.$comment_no;
        $result = $db->query($sql);
        $row = $result->fetch_array();
        
        if(empty($row['cnt'])){
    ?>
    <script>
        alert('비밀번호가 일치하지 않습니다!!!');
        history.back();
    </script>
    <?php
        exit;
        }    
    $sql = 'update comment set comment_content = "'.$cContent. '" where comment_pw=password("'.$cPw.'") and comment_no ='.$comment_no;
    
    }else if($w == 'd'){
        $msg = '삭제';
        $sql = 'select count(*) as cnt from comment where comment_pw = password("'.$cPw.'") and comment_no = '.$comment_no;
        $result = $db->query($sql);
        $row = $result->fetch_array();
        
        if(empty($row['cnt'])){
    ?>
    <script>
        alert('비밀번호가 일치하지 않습니다!!!');
        history.back();
    </script>
  <?php
            exit;
        }
        $sql = 'delete from comment where comment_pw = password("'.$cPw.'") and comment_no = '.$comment_no;
    }else{
    ?>
        <script>
            alert("정상적인 경로를 이용하시길 바랍니다.");
            history.back();
        </script>
    <?php
    exit;
    }    
    $result = $db->query($sql);
    
    if($result){
?>
<script>
    alert('댓글이 <?=$msg?> 되었습니다!!');
    location.replace("./view.php?no=<?=$no?>");
</script>
<?php }else{
?>
    <script>
        alert('댓글 <?=$msg?>에 실패했습니다!!' );
        history.back();
    </script>
<?php 
exit;
}
?>



