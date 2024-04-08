<!-- 만든이 : 한인택 [테기네닷컴]-->
<!-- 최근작업 : 2024-03-02 -->
<!-- 작업내용 : month로 검색하다가, 사용자의 숫자를 입력 받아봄. 그래서 이름을 lottoinfo_month-> lottoinfo_search로 개명 -->
<!-- RELEASE -->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
       

        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            border-spacing: 0;
            /* overflow:auto; */
            
            overflow-y: scroll;
        }

        th, td {
            padding: 0.25rem;
            vertical-align: top;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .pagination {
        margin-top: 10px;
        }

        .pagination a {
            padding: 8px;
            margin: 0 8px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

    </style>
</head>
<body>
    <div>
    <a href="https://www.tegine.com/lottoinfo/lottoInfo.php?page=1"><img src="myhitlogo.jpg" width="200" alt="Han In Taek"></a><br>
    <label for="month">선택:</label>
    <select id="month" name="month" onchange="handleMonthChange()">
        <option value="1">1월</option>
        <option value="2">2월</option>
        <option value="3">3월</option>
        <option value="4">4월</option>
        <option value="5">5월</option>
        <option value="6">6월</option>
        <option value="7">7월</option>
        <option value="8">8월</option>
        <option value="9">9월</option>
        <option value="10">10월</option>
        <option value="11">11월</option>
        <option value="12">12월</option>
    </select>
    </div>
    <script>
        function handleMonthChange() {
        var selectedMonth = document.getElementById("month").value;
        var currentUrl = "https://www.tegine.com/lottoinfo/lottoinfo_search.php";
        var newUrl = currentUrl +"?month="+selectedMonth;
        window.location.href = newUrl;
    }

    // JavaScript로 11월을 선택하는 함수
    function selectedMonthFirst() {
        var select = document.getElementById("month");
        var queryString = window.location.search;

// 쿼리 문자열이 있는지 확인
if (queryString) {
    // '?' 문자를 제거하고 '&' 문자로 분할하여 배열 생성
    var queryParams = queryString.substring(1).split('&');

    // 각각의 파라미터에 대해 반복
    queryParams.forEach(function(param) {
        // '=' 문자를 기준으로 파라미터 이름과 값 분리
        var parts = param.split('=');
        var paramName = decodeURIComponent(parts[0]);
        var paramValue = decodeURIComponent(parts[1]);

        // 만약 paramName이 'month'인 경우에 해당하는 값을 얻음
        if (paramName === 'month') {
            // 추출된 month 값 사용
            // console.log("Month 값: " + paramValue);
            select.value = paramValue;
        }
    });
}
    }

    // 페이지 로드 시 11월 선택
    window.onload = function() {
        selectedMonthFirst();
    }

    </script>
    <div>
<?php
$conn = mysqli_connect("localhost","darkhani","a4353488a","darkhani");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$month = $_GET['month'];
$searchNum = $_GET['searchNum'];

$sql = "";
if ($month == NULL || $month == "") {
    // SQL query with LIKE condition
    if ($searchNum == NULL || $searchNum == "") {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE 1=1
            ORDER BY fdate DESC";
    } else {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery
            WHERE 1=1  
            AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
            ORDER BY fdate DESC";

        $sqlCount = "SELECT COUNT(*) AS result_count, 
        fdate, 
        number1, 
        number2, 
        number3, 
        number4, 
        number5, 
        number6, 
        bonus 
        FROM lottery  
        WHERE MONTH(fdate) = $month 
        AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
        ORDER BY fdate DESC";
    }
} else {
    // SQL query with LIKE condition
    if ($searchNum == NULL || $searchNum == "") {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE MONTH(fdate) = $month 
            ORDER BY fdate DESC";
    } else {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE MONTH(fdate) = $month 
            AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
            ORDER BY fdate DESC";
    }
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='0'>
            <tr>
                <th>Date</th>
                <th>No1</th>
                <th>No2</th>
                <th>No3</th>
                <th>No4</th>
                <th>No5</th>
                <th>No6</th>
                <th>Bonus</th>
            </tr>";

            $idx = 0;
            $resultDict = Array();
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

        $idx = $idx + 1;
         //=== 1번째 숫자 색깔 정의
         if ($row['number1'] <= 10) {
            $num1Class = 'ball_645 lrg ball1';
        }

        if ($row['number1'] > 10 && $row['number1'] <= 20) {
            $num1Class = 'ball_645 lrg ball2';
        }

        if ($row['number1'] > 20 && $row['number1'] <= 30) {
            $num1Class = 'ball_645 lrg ball3';
        }

        if ($row['number1'] > 30 && $row['number1'] <= 40) {
            $num1Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number1'] > 40 && $row['number1'] < 46) {
            $num1Class = 'ball_645 lrg ball5';
        }

        //=== 2번째 숫자 색깔 정의
        if ($row['number2'] <= 10) {
            $num2Class = 'ball_645 lrg ball1';
        }

        if ($row['number2'] > 10 && $row['number2'] <= 20) {
            $num2Class = 'ball_645 lrg ball2';
        }

        if ($row['number2'] > 20 && $row['number2'] <= 30) {
            $num2Class = 'ball_645 lrg ball3';
        }

        if ($row['number2'] > 30 && $row['number2'] <= 40) {
            $num2Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number2'] > 40 && $row['number2'] < 46) {
            $num2Class = 'ball_645 lrg ball5';
        }

        //=== 3번째 숫자 색깔 정의
        if ($row['number3'] <= 10) {
            $num3Class = 'ball_645 lrg ball1';
        }

        if ($row['number3'] > 10 && $row['number3'] <= 20) {
            $num3Class = 'ball_645 lrg ball2';
        }

        if ($row['number3'] > 20 && $row['number3'] <= 30) {
            $num3Class = 'ball_645 lrg ball3';
        }

        if ($row['number3'] > 30 && $row['number3'] <= 40) {
            $num3Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number3'] > 40 && $row['number3'] < 46) {
            $num3Class = 'ball_645 lrg ball5';
        }

         //=== 4번째 숫자 색깔 정의
         if ($row['number4'] <= 10) {
            $num4Class = 'ball_645 lrg ball1';
        }

        if ($row['number4'] > 10 && $row['number4'] <= 20) {
            $num4Class = 'ball_645 lrg ball2';
        }

        if ($row['number4'] > 20 && $row['number4'] <= 30) {
            $num4Class = 'ball_645 lrg ball3';
        }

        if ($row['number4'] > 30 && $row['number4'] <= 40) {
            $num4Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number4'] > 40 && $row['number4'] < 46) {
            $num4Class = 'ball_645 lrg ball5';
        }

         //=== 5번째 숫자 색깔 정의
         if ($row['number5'] <= 10) {
            $num5Class = 'ball_645 lrg ball1';
        }

        if ($row['number5'] > 10 && $row['number5'] <= 20) {
            $num5Class = 'ball_645 lrg ball2';
        }

        if ($row['number5'] > 20 && $row['number5'] <= 30) {
            $num5Class = 'ball_645 lrg ball3';
        }

        if ($row['number5'] > 30 && $row['number5'] <= 40) {
            $num5Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number5'] > 40 && $row['number5'] < 46) {
            $num5Class = 'ball_645 lrg ball5';
        }

        //=== 6번째 숫자 색깔 정의
        if ($row['number6'] <= 10) {
            $num6Class = 'ball_645 lrg ball1';
        }

        if ($row['number6'] > 10 && $row['number6'] <= 20) {
            $num6Class = 'ball_645 lrg ball2';
        }

        if ($row['number6'] > 20 && $row['number6'] <= 30) {
            $num6Class = 'ball_645 lrg ball3';
        }

        if ($row['number6'] > 30 && $row['number6'] <= 40) {
            $num6Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number6'] > 40 && $row['number6'] < 46) {
            $num6Class = 'ball_645 lrg ball5';
        }

        //=== 보너스 숫자 색깔 정의
        if ($row['bonus'] <= 10) {
            $bonusClass = 'ball_645 lrg ball1';
        }

        if ($row['bonus'] > 10 && $row['bonus'] <= 20) {
            $bonusClass = 'ball_645 lrg ball2';
        }

        if ($row['bonus'] > 20 && $row['bonus'] <= 30) {
            $bonusClass = 'ball_645 lrg ball3';
        }

        if ($row['bonus'] > 30 && $row['bonus'] <= 40) {
            $bonusClass = 'ball_645 lrg ball4';
        }
        
        if ($row['bonus'] > 40 && $row['bonus'] <= 46) {
            $bonusClass = 'ball_645 lrg ball5';
        }

        echo "<tr>
                <td>{$row['fdate']}</td>
                <td><span class='$num1Class'>{$row['number1']}</span></td> 
                <td><span class='$num2Class'>{$row['number2']}</span></td> 
                <td><span class='$num3Class'>{$row['number3']}</span></td> 
                <td><span class='$num4Class'>{$row['number4']}</span></td> 
                <td><span class='$num5Class'>{$row['number5']}</span></td> 
                <td><span class='$num6Class'>{$row['number6']}</span></td> 
                <td><span class='$bonusClass'>{$row['bonus']}</span></td>
              </tr>";
    }
    echo "<tr>";
    echo "<td colspan='9'>";
    // echo "역대 ".$month."월에 ".$searchNum."은 ".$idx."번 나왔었네요~^^";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='9'>";
    // echo "<a href='https://www.tegine.com/lottoinfo/lottoInfo.php?page=1'>전체보기</a>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "검색 결과 없습니다.";
}

// Close connection
$conn->close();
?>
</div>
</body>
</html>
