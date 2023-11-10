<?php
    require_once('./dbconnect.php'); 
    
    //$_POST['no'] 있으면 $no를 생성한다.
    if(isset($_POST['no'])){
        $no = $_POST['no'];
    }
    
    //$no 없으면 수정이 아니라 글쓰기 처리를 한다.
    if(empty($no)){
        $id = $_POST['ID'];
        $date = date('Y-m-d H:i:s');
    }    
    
    $pw = $_POST['password'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    // get, post방식과 상관없이 값을 전달 받을 수 있는 변수는 $_REQUEST['']    
    //$content = $_REQUEST['content'];
    
    //글수정 로직
    if(isset($no)){
        //입력할 비밀번호와 DB에 있는 비밀번호가 일치하는 체크
        $sql = 'select count(b_pw) as cnt from bbs where b_pw=password("'.$pw.'") and b_no ='. $no;
        $result=$db->query($sql);
        $row = $result->fetch_array();
        
        //비밀번호가 일치하면 수정 쿼리 작성을 통해 수정처리한다.
        if($row['cnt']){
            //update sql 작성하기
            $sql ='update bbs set b_subject="'.$subject.'",b_content="'.$content.'" where b_no='.$no;
            $msgState = '수정';
            
         }else{
            //비밀번호가 일치하지 않으면 $row['cnt']값은 0이 된다.
            $msg='비밀번호가 일치하지 않습니다!!';            
            ?>
                <script>
                     alert("<?=$msg?>");   
                     history.back();
                </script>
        <?php
            exit; // exit 처리를 하지 않으면 프로그램이 끝까지 실행된다.
        }
    
    // 글등록 로직    
    }else{    
    //mysql에는 자체적으로 입력받은 문자열을 해시화 해주는 함수가 있는데 그것이 password('비밀번호')
    $sql = 'insert into bbs (b_no, b_subject, b_content, b_date, b_hit, b_id, b_pw)'
            . ' values(null, "'.$subject.'","'.$content.'","'.$date.'",0,"'.$id.'",password("'.$pw.'"))';
     $msgState = '등록';
    }
   
    //메시지가 없을 경우(비밀번호가 일치하는 경우)
    if(empty($msg)){
        $result = $db->query($sql);
        
        //쿼리가 정상적으로 실행되었으면
        if($result){
            $msg = '정상적으로 글이 '.$msgState.'되었습니다!!';
            if(empty($no)){
                $no = $db->insert_id;
            }
            $replaceURL = './view.php?no='.$no;    
        }else{
            $msg = '글 '.$msgState.' 처리 하지 못했습니다.!!';
?>
                <script>
                    alert("<?=$msg?>");
                    history.back();
                </script>
<?php
    exit;
    }
}   
?>
<script>
    alert("<?=$msg?>");
    location.replace("<?php echo $replaceURL ?>");
</script>


