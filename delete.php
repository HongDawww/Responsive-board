<?php
require_once('./dbconnect.php');

if(isset($_GET["no"])){
	$no = $_GET["no"];
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./css/style.css">
	<title>반응형 게시판</title>
</head>
<body>
	<h3>글삭제</h3>
	<?php
		if(isset($no)){
			$sql = " SELECT count(b_no) as cnt FROM bbs WHERE b_no=".$no;
			$result = $db->query($sql);
			$row = $result->fetch_array();
			if(empty($row["cnt"])){
		?>
		<script>
			alert("삭제할 글이 존재 하지 않습니다");
			history.back();
		</script>		
		<?php
			exit;
				}
				$sql = " SELECT b_subject FROM bbs WHERE b_no=".$no;
				$result = $db->query($sql);
				$row = $result->fetch_array();
		?>
		<div id="boardDelete">
			<form action="./postDel.php" method="post">
				<input type="hidden" name="no" value="<?php echo $no ?>">
				<table>
					<thead>
						<tr>
							<th colsapn="2">게시글 삭제하기</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>제목</th>
							<td> <?php echo $row["b_subject"] ?></td>
						</tr>
						<tr>
							<th><label for="pw">비밀번호</label></th>
							<td><input type="password" nema="pw" id="pw"></td>
						</tr>
					</tbody>
				</table>
					<div class="btnSet">
						<button type="submit" class="btnSumit">삭제</button>
						<a href="./index.php" class="btnList">목록으로</a>
					</div>
			</form>
		</div>
		<?php

			} else {
		?>
			<script>
				alert("비정상 경로입니다");
			</script>
		<?php		
			}
		?>	
</body>
</html>