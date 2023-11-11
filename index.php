<?php
    require_once("dbConnect.php");
    
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page=1;
    }
    
    $searchString=null;
    $searchColumn=null;
    
    /*검색 처리*/
    if(isset($_GET['searchColumn'])){
        $searchColumn = $_GET['searchColumn'];
        $searchString .= '&amp;searchColumn=' . $searchColumn;
    }
    
    if(isset($_GET['searchWord'])) {
        $searchWord = $_GET['searchWord'];
        $searchString .= '&amp;searchWord=' . $searchWord;
    }    
    
    if(isset($searchColumn) && isset($searchWord)) {
            $searchSql = ' where ' . $searchColumn . ' like "%' . $searchWord . '%"';
    } else {
            $searchSql = '';
    }    
    
    $sql = "select count(*) as cnt from bbs". $searchSql;
    $result = $db->query($sql);
    $row = $result->fetch_array();
    
    $allArticle = $row['cnt']; //전체 게시글 수
    
    if(empty($allArticle)) {
            $emptyData = '<tr><td class="emptyMsg" colspan="5">검색된 글이 없습니다.</td></tr>';
    } else {
    
    
    $displayArticle =3; //한페이지당 보여줄 게시글수
    $allPage =ceil($allArticle/$displayArticle); //전체페이지 수        
    if($page < 1 || ($allPage&&$page > $allPage)){
    ?>
<script>
    alert("존재하지 않는 페이지 입니다!!!");
    history.back();
</script>
<?php
    exit;
    }
    
    $block = 3; //보여줄 페이지 수 1 2 3, 4 5 6    
    $currentBlock = ceil($page/$block); //현재 페이지가 있는 블럭
    $allBlock = ceil($allPage/$block);//전체 블럭수
    
    //현재의 블럭에서 첫페이지
    $firstPage = ($currentBlock * $block) - ($block - 1);
    
    if($currentBlock == $allBlock){
        $lastPage = $allPage; //현재 블럭이 마지막 블럭이면 $allPage가 마지막 페이지이다.
    } else {
        $lastPage = $currentBlock * $block;//
    }
    
    $prevPage = (($currentBlock-1)*$block); // 이전페이지, 블럭이 2블럭일 경우(4 5 6) 이전을 누르면 3페이지로 이동; 
    $nextPage = (($currentBlock+1)*$block)-($block - 1);//다음 페이지로 이동
    
    $paging = '<ul>';
    
    //첫페이지가 아닌 경우에는 처음 버튼을 생성한다.
    if($page !=1 ){
        $paging .='<li class="startPage"><a href="./index.php?page=1'.$searchString.'">처음 </a></li>';
    }
    
    //첫 블럭이 아닌 경우에는 이전 버튼을 생성
    if($currentBlock !=1){
        $paging .='<li class="prevPage"><a href="./index.php?page='.$prevPage. $searchString.'">◀</a></li>';
    }
    
    for($i = $firstPage; $i <=$lastPage; $i++){
        if($i==$page){
            $paging.='<li class="currentPage">'.$i.'</li>';
        }else{
            $paging .='<li class="page"><a href="./index.php?page='.$i.$searchString.'">'.$i.'</a></li>';
        }
    }
    
    //마지막 블럭이 아닌 경우에는 다음 버튼을 생성한다.
    if($currentBlock !=$allBlock){
        $paging.='<li class="nextPage"><a href="./index.php?page='.$nextPage.$searchString.'">▶</a></li>';
    }
    
    //마지막 페이지가 아니라면 끝 버튼을 생성한다.
    if($page !=$allPage){
        $paging .='<li class="endPage"><a href="./index.php?page='.$allPage.$searchString.'"> 끝</a></li>';
    }
    $paging .='</ul>';
    
    $currentLimit = ($displayArticle*$page)-$displayArticle; // 3개의 게시글을 가져오기위한 첫번째 위치설정
    $sqlLimit = ' limit '.$currentLimit.','.$displayArticle;
    
    $sql = 'select * from bbs'.$searchSql.' order by b_no desc'.$sqlLimit;// 3개의 게시글을 가져온다.
    $result = $db->query($sql);
  }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>게시판</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css"/>
    </head>
    <body>
        <article class="boardArticle">
          <div id="list">
            <h3>반응형 게시판 </h3>
            <table>                
                <thead>
                    <tr>
                        <th scope="col" class="no"> 번호</th>
                        <th scope="col" class="subject">제목</th>
                        <th scope="col" class="author">작성자</th>
                        <th scope="col" class="date">작성일</th>
                        <th scope="col" class="hit">조회</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($emptyData)) {
                            echo $emptyData;
                            $paging=null;
                    } else {
                        while($row=$result->fetch_array()){
                            $datetime = explode(' ', $row['b_date']);
                            $date = $datetime[0]; //년월일
                            $time = $datetime[1]; //시분초
                            
                            if($date == Date('Y-m-d'))
                                $row['b_date'] = $time;
                            else
                                $row['b_date'] = $date;                      
                    ?>                    
                    <tr>
                        <td class="no"><?=$row['b_no']?></td>
                        <td class="subject">
                            <a href="./view.php?no=<?=$row['b_no']?>"><?=$row['b_subject']?></a>
                        </td>
                        <td class="author"><?=$row['b_id']?></td>
                        <td class="date"><?=$row['b_date']?></td>
                        <td class="hit"><?=$row['b_hit']?></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>                    
                </tbody>
            </table>
            
            <div class="btnSet">
                <?php
                 if(isset($emptyData)) {?>
                    <a href="./index.php">목록보기</a>
                 <?php } ?>
                <a href="./write.php" class="btnWrite">글쓰기</a>
                
            </div>
            
            <div class="paging">
                <?=$paging?>
            </div>
            
            <div class="search">
                <form action="./index.php" method="get">
                    <select name="searchColumn">
                        <option <?= $searchColumn == 'b_subject'?'selected="selected"':null?> value="b_subject">제목</option>
                        <option <?= $searchColumn == 'b_content'?'selected="selected"':null?> value="b_content">내용</option>
                        <option <?= $searchColumn == 'b_id'?'selected="selected"':null?> value="b_id">아이디</option>
                    </select>
                    <input type="text" name="searchWord" value="<?= isset($searchWord)?$searchWord:null?>"/>
                    <button type="submit">검색</button>
                </form>
            </div>
          </div>  
        </article>
    </body>
</html>


