<!-- 데이터베이스 연결 및 입력 처리하는 PHP 코드 (insert.php) -->
<?php
$servername = "localhost";
$username = "darkhani";
$password = "a4353488a";
$dbname = "darkhani";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST 데이터 가져오기
$round = $_POST['round'];
$fdate = $_POST['fdate'];
$fmdate = $_POST['fmdate'];
$number1 = $_POST['number1'];
$number2 = $_POST['number2'];
$number3 = $_POST['number3'];
$number4 = $_POST['number4'];
$number5 = $_POST['number5'];
$number6 = $_POST['number6'];
$bonus = $_POST['bonus'];

// 나머지 필드들도 가져오기

// SQL 쿼리 작성 및 실행
$sql = "INSERT INTO lottery (round, fdate,fmdate, winner1, amount1, winner2, amount2, winner3, amount3, winner4, amount4, winner5, amount5, number1, number2, number3, number4, number5, number6, bonus) VALUES ('$round', '$fdate','$fmdate', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '$number1', '$number2', '$number3', '$number4', '$number5', '$number6', '$bonus');
";
//INSERT INTO lottery (round, fdate, winner1, amount1, winner2, amount2, winner3, amount3, winner4, amount4, winner5, amount5, number1, number2, number3, number4, number5, number6, bonus) VALUES ('1', '2002-12-07', '0 ', '0 ', '1 ', '143934100 ', '28 ', '5140500 ', '2537 ', '113400 ', '40155 ', '10000 ', '10', '23', '29', '33', '37', '40', '16');

if ($conn->query($sql) === TRUE) {
    // 데이터 삽입 성공 시 알림 창을 표시하고 관리자 페이지로 리다이렉션
    echo "<script>
            alert('데이터가 정상적으로 추가 되었습니다.');
            window.location.href = 'lottoinfo_admin.html';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 데이터베이스 연결 종료
$conn->close();
?>