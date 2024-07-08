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
                <form id="lottoForm" method="GET" action="lottoinfo_search.php">
                    <label for="month">선택:</label>
                    <select id="month" name="month">
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
                    <label for="day">일자:</label>
                    <input type="text" id="day" name="day" maxlength="2" oninput="validateDay()" placeholder="DD" style="width: 50px;">
                    <input type="submit" value="검색">
                </form>
            </div>
        </div>
    </div>

<script>
        function validateDay() {
            var dayInput = document.getElementById('day');
            var day = dayInput.value;

            // 숫자가 아닌 문자는 제거
            day = day.replace(/\D/g, '');
 	    // 일자가 1에서 31 사이인지 확인
            if (day > 31) {
                day = '31';
            }

            dayInput.value = day;
        }

        // JavaScript로 URL에서 쿼리 파라미터를 읽어 선택된 월을 설정하는 함수
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
                        select.value = paramValue;
                    }
                });
            }
        }
  // 페이지 로드 시 선택된 월 설정
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
        
       $month = isset($_GET['month']) ? intval($_GET['month']) : 0;
       $day = isset($_GET['day']) ? intval($_GET['day']) : 0;
       $searchNum = isset($_GET['searchNum']) ? intval($_GET['searchNum']) : '';

        $sqlCountB = "SELECT number AS num, COUNT(*) AS counthoi 
                        FROM (
                            SELECT number1 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT number2 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT number3 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT number4 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT number5 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT number6 AS number FROM lottery WHERE MONTH(fdate) = $month 
                            UNION ALL 
                            SELECT bonus AS number FROM lottery WHERE MONTH(fdate) = $month 
                        ) AS numbers 
                        GROUP BY number 
                        ORDER BY counthoi DESC LIMIT 6";
        
//        $rstCount6 = $conn->query($sqlCountB);
//            if ($rstCount6->num_rows > 0) {
                //echo "<div class='underlogomenu'>";
//                // 각 행의 데이터를 출력
//                while ($rowItem = $rstCount6->fetch_assoc()) {
//                    $countNumber = $rowItem['num'];
//
//                    if ($countNumber <= 10) {
//                        $numClass = 'ball_645 lrg ball1';
//                    } elseif ($countNumber > 10 && $countNumber <= 20) {
//                        $numClass = 'ball_645 lrg ball2';
//                    } elseif ($countNumber > 20 && $countNumber <= 30) {
//                        $numClass = 'ball_645 lrg ball3';
//                    } elseif ($countNumber > 30 && $countNumber <= 40) {
//                        $numClass = 'ball_645 lrg ball4';
//                    } else {
//                        $numClass = 'ball_645 lrg ball5';
//                    }
//
//                    echo "<span class='" . $numClass . "'>" . $rowItem['num'] . "</span>";
//                }
                //echo "</div>";
//            }
        ?>
    </div>

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
            if ($month == 0) {
                if (empty($searchNum)) {
                    $sql = "SELECT round, fdate, fmdate, number1, number2, number3, number4, number5, number6, bonus
                        FROM lottery
                        WHERE 1=1";
                    if ($day > 0) {
                        $sql .= " AND DAY(fdate) = $day";
                    }
                    $sql .= " ORDER BY fdate DESC";
                } else {
                    $sql = "SELECT round, fdate, fmdate, number1, number2, number3, number4, number5, number6, bonus
                        FROM lottery
                        WHERE 1=1";
                    if ($day > 0) {
                        $sql .= " AND DAY(fdate) = $day";
                    }
                    $sql .= " AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
                        ORDER BY fdate DESC";
                }
            } else {
                if (empty($searchNum)) {
                    $sql = "SELECT round, fdate, fmdate, number1, number2, number3, number4, number5, number6, bonus
                        FROM lottery
                        WHERE MONTH(fdate) = $month";
                    if ($day > 0) {
                        $sql .= " AND DAY(fdate) = $day";
                    }
                    $sql .= " ORDER BY fdate DESC";
                } else {
                    $sql = "SELECT round, fdate, fmdate, number1, number2, number3, number4, number5, number6, bonus
                        FROM lottery
                        WHERE MONTH(fdate) = $month";
                    if ($day > 0) {
                        $sql .= " AND DAY(fdate) = $day";
                    }
                    $sql .= " AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
                        ORDER BY fdate DESC";
                }
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table border='0'>
                        <tr>
                            <th>회차</th>
                            <th>일자</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>+</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    // 각 번호의 색상 클래스 설정
                    $numClasses = [];
                    for ($i = 1; $i <= 6; $i++) {
                        $num = $row["number$i"];
                        if ($num <= 10) {
                            $numClasses[$i] = 'ball_645 lrg ball1';
                        } elseif ($num > 10 && $num <= 20) {
                            $numClasses[$i] = 'ball_645 lrg ball2';
                        } elseif ($num > 20 && $num <= 30) {
                            $numClasses[$i] = 'ball_645 lrg ball3';
                        } elseif ($num > 30 && $num <= 40) {
                            $numClasses[$i] = 'ball_645 lrg ball4';
                        } else {
                            $numClasses[$i] = 'ball_645 lrg ball5';
                        }
                    }

                    $bonusClass = $row['bonus'] <= 10 ? 'ball_645 lrg ball1' :
                                  ($row['bonus'] > 10 && $row['bonus'] <= 20 ? 'ball_645 lrg ball2' :
                                  ($row['bonus'] > 20 && $row['bonus'] <= 30 ? 'ball_645 lrg ball3' :
                                  ($row['bonus'] > 30 && $row['bonus'] <= 40 ? 'ball_645 lrg ball4' : 'ball_645 lrg ball5')));

                    echo "<tr>
                            <td>{$row['round']} </td>
                            <td>{$row['fdate']} <p style='color: gray;'>({$row['fmdate']})<p></td>
                            <td><span class='{$numClasses[1]}'>{$row['number1']}</span></td>
                            <td><span class='{$numClasses[2]}'>{$row['number2']}</span></td>
                            <td><span class='{$numClasses[3]}'>{$row['number3']}</span></td>
                            <td><span class='{$numClasses[4]}'>{$row['number4']}</span></td>
                            <td><span class='{$numClasses[5]}'>{$row['number5']}</span></td>
                            <td><span class='{$numClasses[6]}'>{$row['number6']}</span></td>
                            <td><span class='$bonusClass'>{$row['bonus']}</span></td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "검색 결과 없습니다.";
            }

            $conn->close();
        ?>

<div id="caulyDisplay">
   <script src="http://image.cauly.co.kr/websdk/common/lasted/ads.min.js"></script>
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
</body>
</html>
