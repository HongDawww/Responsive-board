<?php
require_once("./dbconnect.php");

$no = $_GET['no'];

$sql = "SELECT b_subject, b_content, b_date, b_hit, b_id FROM bbs WHERE b_no =". $no;
$result = $db->query($sql);
$row = $result->fetch_array();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			<div id="bInfo">
				<span id="ID">작성자 : <?php echo $row["b_id"]; ?></span>
				<span id="bDate">작성일 : <?php echo $row["b_date"]; ?></span>
				<span id="bHit">조회수 : <?php echo $row["b_hit"]; ?></span>
				<div id="bContent"><?php echo $row["b_content"]; ?></div>
			</div>
			<div class="btnSet">
				<a href="./write.php?no=<?php echo $no ?>">수정</a>
				<a href="./delete.php?no=<?php echo $no ?>">삭제</a>
				<a href="./">목록으로</a>
			</div>
		</div>
	</article>
</body>
</html>
