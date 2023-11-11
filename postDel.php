<?php
    require_once('dbconnect.php');
    
    if(isset($_POST['no'])){
        $no = $_POST['no'];
    }
    
    $pw = $_POST['pw'];
    
    if(isset($no)){
        $sql = 'select count(b_pw) as cnt from bbs where b_pw =password("'.$pw.'") and b_no='.$no;
        $result = $db->query($sql);
        $row = $result->fetch_array();
        
        //비밀번호가 일치하면 삭제 쿼리를 만든다.
        if($row['cnt']) {
            $sql = 'delete from bbs where b_no = '.$no;
        }else{
        // 비밀번호 불일치하면 메세지 출력
            $msg='비밀번호가 일치하지 않습니다!!';
        ?>
        <script>
            alert('<?=$msg?>');
            history.back();
        </script>
        <?php
            exit;
        }
    }
    
    $result = $db->query($sql);
    
    // 정상적인 쿼리 실행 후
    if($result){
        $msg = '해당 글이 삭제 처리 되었습니다.';
        $replaceURL='./index.php';
    }else{
        $msg = '글 삭제 오류 발생';
     ?>
        <script>
            alert("<?=$msg?>");
            history.back();
        </script>
        <?php
        exit;
    }
?>
        <script>
            alert('<?=$msg?>');
            location.replace("<?=$replaceURL?>");
        </script>

