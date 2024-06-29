<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
        .toplogo {
            padding: 20px;
            height: 100px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        
        .underlogomenu {
            padding: 10px;
            display: inline-block;
            margin-right: 10px;
        }

        .image-container img {
            background-color: #e0e0e0;
            display: block;
            max-width: 100%;
            height: auto;
        }

        .pagination-image {
            width: 24px; /* 원하는 크기로 설정 */
            height: 24px; /* 원하는 크기로 설정 */
        }

        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            border-spacing: 0;
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
        <div class="toplogo">
            <img src="myhitlogo.jpg" width="200" alt="Han In Taek"><br>
            <div>
                <?php
                    $conn = mysqli_connect("localhost", "darkhani", "a4353488a", "darkhani");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $countRankingNumberSql = "SELECT number, COUNT(number) AS occurrences FROM (  SELECT number1 AS number FROM lottery  UNION ALL  SELECT number2 FROM lottery  UNION ALL  SELECT number3 FROM lottery  UNION ALL  SELECT number4 FROM lottery  UNION ALL  SELECT number5 FROM lottery  UNION ALL  SELECT number6 FROM lottery) AS all_numbers GROUP BY number ORDER BY occurrences DESC LIMIT 6;";
                    $resultArr = $conn->query($countRankingNumberSql);
                    $medalCount = 0; //1~6위만 선정한다.
                    echo "<div class='underlogomenu'> 최다당첨번호6개 : ";

                    for ($j = 0; $j <= 45; $j++) {
                        $countNumber = $resultArr->fetch_assoc()['number'];

                        if ($countNumber <= 10) {
                            $numClass = 'ball_645 lrg ball1';
                        } elseif ($countNumber > 10 && $countNumber <= 20) {
                            $numClass = 'ball_645 lrg ball2';
                        } elseif ($countNumber > 20 && $countNumber <= 30) {
                            $numClass = 'ball_645 lrg ball3';
                        } elseif ($countNumber > 30 && $countNumber <= 40) {
                            $numClass = 'ball_645 lrg ball4';
                        } else {
                            $numClass = 'ball_645 lrg ball5';
                        }

                        if ($medalCount < 6) {
                            echo "<span class='" . $numClass . "'>" . $countNumber . "</span>";
                        } 
                        
                        $medalCount++;
                    }
                    echo "</div>";
                ?>
            </div>
        </div>
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
                $recordsPerPage = 30;

                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                    $currentPage = $_GET['page'];
                    $arrowPage = $_GET['page'];
                } else {
                    $currentPage = 1;
                    $arrowPage = 1;
                }
            ?>
            <div class="underlogomenu image-container">
                <?php 
                    $arrowPage = $_GET['page'] - 1;
                    if ($arrowPage <= 0) {
                        $arrowPage = 1;
                    }
                    echo "<a href='./lottoinfo.php?page=$arrowPage'><img src='./lotto_img/angle-left.png' class='pagination-image' alt='left'></a>"; 
                ?>
            </div>
            <?php
                $totalRecordsSql = "SELECT COUNT(*) AS total_records FROM lottery";
                $totalRecordsResult = $conn->query($totalRecordsSql);
                $totalRecords = $totalRecordsResult->fetch_assoc()['total_records'];
                $totalPages = ceil($totalRecords / $recordsPerPage);

                $range = 2;
            ?>
            <div class="underlogomenu image-container">
                <?php 
                    $arrowPage = $_GET['page'] + 1;
                    if ($arrowPage >= $totalPages) {
                        $arrowPage = $totalPages;
                    }
                    echo "<a href='./lottoinfo.php?page=$arrowPage'><img src='./lotto_img/angle-right.png' class='pagination-image' alt='right'></a>";
                ?>
            </div>

            <script>
                function handleMonthChange() {
                    var selectedMonth = document.getElementById("month").value;
                    var currentUrl = "https://www.tegine.com/lottoinfo/lottoinfo_search.php";
                    var newUrl = "";
                    if (selectedMonth == 0) {
                        newUrl = "https://www.tegine.com/lottoinfo/lottoinfo.php?page=1";
                    } else {
                        newUrl = currentUrl + "?month=" + selectedMonth;
                    }
                    window.location.href = newUrl;
                }
            </script>
        </div>

        <?php
            $offset = ($currentPage - 1) * $recordsPerPage;
            $sql = "SELECT * FROM lottery ORDER BY fdate DESC LIMIT $offset, $recordsPerPage";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table border='0'>
                        <tr>
                            <th>Round</th>
                            <th>Date</th>
                            <th>No1</th>
                            <th>No2</th>
                            <th>No3</th>
                            <th>No4</th>
                            <th>No5</th>
                            <th>No6</th>
                            <th>Bonus</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
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
                            <td>{$row['round']}</td>
                            <td>{$row['fdate']}</td>
                            <td><span class='{$numClasses[1]}'>{$row['number1']}</span></td>
                            <td><span class='{$numClasses[2]}'>{$row['number2']}</span></td>
                            <td><span class='{$numClasses[3]}'>{$row['number3']}</span></td>
                            <td><span class='{$numClasses[4]}'>{$row['number4']}</span></td>
                            <td><span class='{$numClasses[5]}'>{$row['number5']}</span></td>
                            <td><span class='{$numClasses[6]}'>{$row['number6']}</span></td>
                            <td><span class='$bonusClass'>{$row['bonus']}</span></td>
                          </tr>";
                }

                echo "<tr>";
                echo "<td colspan='9'>";

                if ($currentPage > 1) {
                    echo "<a href='lottoinfo.php?page=1'>1</a>";
                    if ($currentPage > ($range + 1)) {
                        echo "<span>...</span>";
                    }
                }

                for ($i = max(2, $currentPage - $range); $i <= min($currentPage + $range, $totalPages - 1); $i++) {
                    echo "<a href='lottoinfo.php?page=$i' style='padding:4px; margin: 0 4px; border: 1px solid #ddd; text-decoration: none; color: #007bff;'>$i</a>";
                }

                if ($currentPage < $totalPages) {
                    if ($currentPage < ($totalPages - $range)) {
                        echo "<span>...</span>";
                    }
                    echo "<a href='lottoinfo.php?page=$totalPages'>$totalPages</a>";
                }
                
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='9'>";
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='9'>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            } else {
                echo "0 results";
            }

            $conn->close();
        ?>
    </div>
</body>
</html>
