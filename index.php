<?php
require_once('dbconnect.php');

	if(isset($_GET["page"])){
		$page = $_GET["page"];
	} else {
		$page = 1;
	}

	$sql = " SELECT count(*) as cnt FROM bbs ";
	$result = $db->query($sql);
	$row = $result->fetch_array();

	$allArticle = $row["cnt"]; //전체 게시글 수 

	$displayArticle = 3; //한 페이지당 보여줄 게시글 수 

	$allPage =ceil($allArticle/$displayArticle); // 전체페이지 수 

	if($page < 1 || ($allPage && $page > $allPage)){
	?>
	<script>
		alert("존재하지 않는 페이지입니다.");
		history.back();
	</script>
	<?php
		exit;		
			}
		
		$block = 3; //보여줄 페이지 수 
		$currentBlock = ceil($page/$block); //현재 페이지가 있는 블럭
		$allBlock = ceil($allPage/$block); // 전체 블럭수

		$firstPage = ($currentBlock * $block) - ($block - 1);

		if($currentBlock == $allBlock){
			$lastPage = $allPage;  //현재 블럭이 마지막 블럭이면 $allpage가 마지막
		} else {
			$lastPage = $currentBlock * $block;
		}

		$prevPage = (($currentBlock-1)* $block); //이전

		$nextPage = (($currentBlock+1)* $block)-($block-1); // 다음

		$paging = "<ul>";

		if($page != 1) {
			$paging .='<li class="startPage"><a href="./index.php?page=1"> 처음 </a></li>';
		}

		if($currentBlock != 1){
			$paging .='<li class="prevPage"><a href="./index.php?page='.$prevPage.'">이전</a></li>';
		}

		for($i = $firstPage; $i <= $lastPage; $i++){
			if($i==$page){
				$paging.='<li class="currentPage">'.$i.'</li>';			
			} else {
				$paging .= '<li class="page"><a href="./index.php?page='.$i.'">'.$i.'</a></li>';
			}
		}

		if($currentBlock != $allBlock){
			$paging .= '<li class="nextPage"><a href="./index.php?page='.$nextPage.'">다음</a></li>';
		} 

		if($page != $allPage){
			$paging .='<li class="endPage"><a href="./index.php?page='.$allPage.'">끝</a></li>';
		}
		$paging .='</ul>';

		$currentLimit = ($displayArticle*$page)-$displayArticle; // 3개의 게시글을 가져오기위한 첫번째 위치설정
		$sqlLimit = ' limit '.$currentLimit.','.$displayArticle;
		
		$sql = 'select * from bbs order by b_no desc'.$sqlLimit;// 3개의 게시글을 가져온다.
		$result = $db->query($sql);

		$result = $db->query($sql);
	?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=\, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<title>게시판</title>
	<script>

	</script>
</head>
<body>
	<article class="boardArticle">
		<div id="list">
			<h3>반응형 게시판</h3>
			<table>
				<caption class=""></caption>
				<thead>
					<tr>
						<th class="no">번호</th>
						<th class="subject">제목</th>
						<th class="author">작성자</th>
						<th class="date">작성일</th>
						<th class="hit">조회</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$sql = " SELECT * FROM bbs ORDER BY b_no DESC ";
						$result = $db->query($sql);

						while($row = $result->fetch_array()){

							$datetime = explode(' ', $row['b_date']);
							$date = $datetime[0]; // 년 월 일
							$time = $datetime[1]; // 시 분 초

							if($date == Date('Y-m-d'))
								$row['b_date'] = $time;
							 else 
								$row['b_date'] = $date;							
					?>
					<tr>
						<td class="no"><?php echo $row['b_no'] ?></td>
						<td class="subject"><a href="./view.php?no=<?php echo $row['b_no']?>"><?php echo $row['b_subject'] ?></a></td>
						<td class="author"><?php echo $row['b_id'] ?></td>
						<td class="date"><?php echo $row['b_date'] ?></td>
						<td class="hit"><?php echo $row['b_hit'] ?></td>
					</tr>
					<?php
							}
					?>
				</tbody>
			</table>
			<div class="btnSet">
				<a href="./write.php" class="btnWrite">글쓰기</a>
			</div>
			<div class="paging">
				<?php echo $paging ?>
			</div>
		</div>
	</article>
</body>
</html>