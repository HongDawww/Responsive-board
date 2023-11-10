<?php
require_once('dbconnect.php');

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=\, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<title>게시판</title>
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
		</div>
	</article>
</body>
</html>