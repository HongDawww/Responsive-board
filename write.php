<?php
    require_once("./dbconnect.php");    
    //$_GET['no']이 있을때만 $no변수를 사용할 수 있도록 한다.
    if(isset($_GET['no'])){
        $no=$_GET['no'];
    }
    
    if(isset($no)){
        $sql = 'select b_subject, b_content, b_id from bbs where b_no='.$no;
        $result = $db->query($sql);
        $row = $result->fetch_array();
    }
    
?>

<!DOCTYPE html>

<html>
    <head>
        <title>게시판</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css"/>
        
    </head>
    <body>
        <article class="boardArticle">
            <h3 class="fs-1 m-5">글쓰기</h3>
            <div id="write">
                <form action="./postWrite.php" method="post">
                    <?php
                    // hidden으로 no를 처리한 이유는
                    // form에서 submit을 했을 때 게시글 번호도 함께 전송하기 위해서..
                    // DB수정하고자 하는 글번호를 알 수 있도록 하기 위함.
                    if(isset($no)){
                        echo '<input type="hidden" name="no" value="'.$no.'">';
                    }
                    ?>
                    <table id="boardWrite" class="table mb-5">
                        <tbody>
                            <tr>
                                <th scope="row"><label for="ID" class="form-label">아이디</label></th>
                                <td class="id">
                                    <?php
                                        if(isset($no)){
                                            print $row['b_id'];
                                        }else{?>
                                        <input type="text" name="ID" id="ID" class="form-control">
                                        <?php 
                                        } 
                                        ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="password" class="form-label">비밀번호</label></th>
                                <td class="pw"><input type="text" name="password" id="password" class="form-control"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="subject" class="form-label">제목</label></th>
                                <td class="subject">
                                   <input class="form-control" type="text" name="subject" id="subject" value="<?= isset($row['b_subject'])?$row['b_subject']:null?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="content" class="form-label">내용</label></th>
                                <td class="content"><textarea class="form-control" name="content" id="content"><?=isset($row['b_content'])?$row['b_content']:null?></textarea></td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="btnSet">
                        <button type="submit" class="submitBtn btn btn-outline-dark">
                            <?= isset($no)?'수정하기':'등록하기'?>
                        </button>
                        <a href="./index.php" class="btnList btn btn-outline-dark">목록으로</a>
                    </div>
                </form>
            </div>
        </article>
            
    </body>
</html>
