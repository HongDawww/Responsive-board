<?php
require_once("./dbconnect.php");

$no = $_GET['no'];

if(!empty($no) && empty($_COOKIE["bHit".$no])) {
	$sql = " UPDATE bbs SET b_hit=b_hit+1 WHERE b_no =".$no;
	$result = $db->query($sql);
	if(empty($result)){
?>
	<script>
		alert("문제 발생");
		history.back();
	</script>
<?php
	} else {
		setcookie("bHit".$no,TRUE,time()+(60*60*24));
	}
}

$sql = "SELECT b_subject, b_content, b_date, b_hit, b_id FROM bbs WHERE b_no =". $no;
$result = $db->query($sql);
$row = $result->fetch_array();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="./css/style.css">
	<title>게시판</title>
</head>
<body>
	<article class="boardArticle">
		<h2>게시글 보기</h2>
		<div id="boardView">
			<div id="bSubject">
				<h3><?php echo $row["b_subject"]; ?></h3>
			</div>
			<div id="bInfo" class="table">
				<span  id="ID">작성자 : <?php echo $row["b_id"]; ?></span>
				<span  id="bDate">작성일 : <?php echo $row["b_date"]; ?></span>
				<span  id="bHit">조회수 : <?php echo $row["b_hit"]; ?></span>
				<div id="bContent"><?php echo $row["b_content"]; ?></div>
			</div>
			<div class="btnSet">
				<a class="btn btn-outline-dark" href="./write.php?no=<?php echo $no ?>">수정</a>
				<a class="btn btn-outline-dark" href="./delete.php?no=<?php echo $no ?>">삭제</a>
				<a class="btn btn-outline-dark" href="./">목록으로</a>
			</div>
			<div id="comment">
				<?php 
					require_once("./comment.php");
				?>	
			</div>
		</div>
	</article>
</body>
</html>
