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
       
       .toplogo{
            padding: 20px; /* padding 설정 */
            height: 100px; /* height 설정 */
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            box-sizing: border-box; /* padding과 border를 포함하여 요소의 크기를 조정 */
        }
        
        .underlogomenu{
            padding: 10px; /* padding 설정 */
            display: inline-block; /* div를 인라인 블록 요소로 변경하여 한 줄에 표시합니다. */
            margin-right: 10px; /* 각 div 요소 사이의 간격을 조절합니다. */
        }

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
    <div class="toplogo">
    <a href="https://www.tegine.com/lottoinfo/lottoinfo.php?page=1"><img src="myhitlogo.jpg" width="200" alt="Han In Taek"></a><br>
         <div class="align-items-center">
            <div class="underlogomenu">
                <label for="month">선택:</label>
                <select id="month" name="month" onchange="handleMonthChange()">
                    <option value="0">전체</option>    
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

            <?php 
        $conn = mysqli_connect("localhost","darkhani","a4353488a","darkhani");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $month = $_GET['month'];
        $searchNum = $_GET['searchNum'];

        $sqlCountB = "SELECT number AS num, COUNT(*) AS counthoi 
                    FROM ( SELECT number1 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT number2 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT number3 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT number4 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT number5 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT number6 AS number FROM lottery WHERE MONTH(fdate) = $month UNION ALL SELECT bonus AS number 
                    FROM lottery WHERE MONTH(fdate) = $month ) AS numbers 
                    GROUP BY number 
                    ORDER BY counthoi 
                    DESC LIMIT 6";
        
        $rstCount6 = $conn->query($sqlCountB);
        if ($rstCount6->num_rows > 0) {
            $rstDict = Array();
            echo "<div class='underlogomenu'> ";
            // Output data of each row
            while ($rowItem = $rstCount6->fetch_assoc()) {

                $countNumber =$rowItem['num'];

                if ($countNumber<= 10) {
                    $numClass = 'ball_645 lrg ball1';
                }
        
                if ($countNumber > 10 && $countNumber <= 20) {
                    $numClass = 'ball_645 lrg ball2';
                }
        
                if ($countNumber  > 20 && $countNumber <= 30) {
                    $numClass = 'ball_645 lrg ball3';
                }
        
                if ($countNumber > 30 && $countNumber <= 40) {
                    $numClass = 'ball_645 lrg ball4';
                }
                
                if ($countNumber > 40 && $countNumber < 46) {
                    $numClass = 'ball_645 lrg ball5';
                }

                echo "<span class='" . $numClass . "'>" . $rowItem['num'] . "</span>";
            }
            echo "</div>";
        }

    ?>

        </div>
    </div>    
    <script>
        function handleMonthChange() {
        var selectedMonth = document.getElementById("month").value;
        var currentUrl = "https://www.tegine.com/lottoinfo/lottoinfo_search.php";
        var newUrl = "";
        if (selectedMonth == 0) {
            newUrl = "https://www.tegine.com/lottoinfo/lottoinfo.php" +"?page=1";
        } else {
            newUrl = currentUrl +"?month="+selectedMonth;
        }

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

    echo "</table>";
} else {
    echo "검색 결과 없습니다.";
}

// Close connection
$conn->close();
?>

<div id='caulyDisplay'>
   <script src='http://image.cauly.co.kr/websdk/common/lasted/ads.min.js'></script>
   <script>
     // Advertiser Id 를 저장하는 메소드
    function saveAdvertiserId(adid) {
      try {
        if (!!window.localStorage) {
          localStorage.removeItem("caulyad_adid");
          localStorage.setItem("caulyad_adid", adid);
          return true;
        } else if (navigator.cookieEnabled) {
          var date = new Date();
          date.setTime(date.getTime() + (365*24*60*60*1000));
          document.cookie = "caulyad_adid=" + adid + ";path=/;expire=" + date.toUTCString() + ";domain=" + location.hostname + ";";
          return true;
        } else {
          return false;
        }
      } catch(e) {
        return false;
      }
    }

    // 매체사에서 추출한 Advertiser Id 를 저장
    saveAdvertiserId("ADID 정보");

    // Cauly SDK 초기화
    var cauly_ads = new CaulyAds({
       app_code: 'UK7q3Bo4',
       placement: 1,
       displayid: 'caulyDisplay',
       passback: function () { },
       success: function () { }
     });
   </script>
</div>	

</div>
          
</body>
</html>
