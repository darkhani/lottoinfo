<?php
$month = isset($_GET['month']) ? intval($_GET['month']) : 0;
$day = isset($_GET['day']) ? intval($_GET['day']) : 0;
$searchNum = isset($_GET['searchNum']) ? intval($_GET['searchNum']) : '';

$sql = "";
if ($month == NULL || $month == "") {
    // LIKE 조건이 있는 SQL 쿼리
    if ($searchNum == NULL || $searchNum == "") {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE 1=1";
        if ($day > 0) {
            $sql .= " AND DAY(fdate) = $day";
        }
        $sql .= " ORDER BY fdate DESC";
    } else {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery
            WHERE 1=1";
        if ($day > 0) {
            $sql .= " AND DAY(fdate) = $day";
        }
        $sql .= " AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
            ORDER BY fdate DESC";
    }
} else {
    // LIKE 조건이 있는 SQL 쿼리
    if ($searchNum == NULL || $searchNum == "") {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE MONTH(fdate) = $month";
        if ($day > 0) {
            $sql .= " AND DAY(fdate) = $day";
        }
        $sql .= " ORDER BY fdate DESC";
    } else {
        $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery  
            WHERE MONTH(fdate) = $month";
        if ($day > 0) {
            $sql .= " AND DAY(fdate) = $day";
        }
        $sql .= " AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
            ORDER BY fdate DESC";
    }
}


$rst = $conn->query($sql);

if ($rst->num_rows > 0) {
    echo "<div class='underlogomenu'>";
    // 각 행의 데이터를 출력
    while ($rowItem = $rst->fetch_assoc()) {
        $countNumber = $rowItem['num'];

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

        echo "<span class='" . $numClass . "'>" . $rowItem['num'] . "</span>";
    }
    echo "</div>";
}

// echo $sql; // 디버깅 목적으로 출력
?>
