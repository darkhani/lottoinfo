<?php
/**
 * 통계 데이터 API
 */
header('Content-Type: application/json; charset=utf-8');

require_once '../includes/functions.php';

$conn = getDBConnection();

$type = isset($_GET['type']) ? $_GET['type'] : 'frequency';

$data = [];

switch ($type) {
    case 'frequency':
        // 번호 빈도수
        $sql = "SELECT number, COUNT(*) as count FROM (
            SELECT number1 AS number FROM lottery
            UNION ALL SELECT number2 FROM lottery
            UNION ALL SELECT number3 FROM lottery
            UNION ALL SELECT number4 FROM lottery
            UNION ALL SELECT number5 FROM lottery
            UNION ALL SELECT number6 FROM lottery
        ) AS all_numbers GROUP BY number ORDER BY number";
        
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $data[$row['number']] = (int)$row['count'];
        }
        break;
        
    case 'oddEven':
        // 홀짝 비율
        $sql = "SELECT 
            SUM(CASE WHEN number1 % 2 = 1 THEN 1 ELSE 0 END +
                CASE WHEN number2 % 2 = 1 THEN 1 ELSE 0 END +
                CASE WHEN number3 % 2 = 1 THEN 1 ELSE 0 END +
                CASE WHEN number4 % 2 = 1 THEN 1 ELSE 0 END +
                CASE WHEN number5 % 2 = 1 THEN 1 ELSE 0 END +
                CASE WHEN number6 % 2 = 1 THEN 1 ELSE 0 END) as odd_count,
            SUM(CASE WHEN number1 % 2 = 0 THEN 1 ELSE 0 END +
                CASE WHEN number2 % 2 = 0 THEN 1 ELSE 0 END +
                CASE WHEN number3 % 2 = 0 THEN 1 ELSE 0 END +
                CASE WHEN number4 % 2 = 0 THEN 1 ELSE 0 END +
                CASE WHEN number5 % 2 = 0 THEN 1 ELSE 0 END +
                CASE WHEN number6 % 2 = 0 THEN 1 ELSE 0 END) as even_count
        FROM lottery";
        
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $data = [
            'odd' => (int)$row['odd_count'],
            'even' => (int)$row['even_count']
        ];
        break;
        
    case 'range':
        // 구간별 분포
        $sql = "SELECT 
            SUM(CASE WHEN number1 BETWEEN 1 AND 10 THEN 1 ELSE 0 END + 
                CASE WHEN number2 BETWEEN 1 AND 10 THEN 1 ELSE 0 END +
                CASE WHEN number3 BETWEEN 1 AND 10 THEN 1 ELSE 0 END +
                CASE WHEN number4 BETWEEN 1 AND 10 THEN 1 ELSE 0 END +
                CASE WHEN number5 BETWEEN 1 AND 10 THEN 1 ELSE 0 END +
                CASE WHEN number6 BETWEEN 1 AND 10 THEN 1 ELSE 0 END) as range1_10,
            SUM(CASE WHEN number1 BETWEEN 11 AND 20 THEN 1 ELSE 0 END + 
                CASE WHEN number2 BETWEEN 11 AND 20 THEN 1 ELSE 0 END +
                CASE WHEN number3 BETWEEN 11 AND 20 THEN 1 ELSE 0 END +
                CASE WHEN number4 BETWEEN 11 AND 20 THEN 1 ELSE 0 END +
                CASE WHEN number5 BETWEEN 11 AND 20 THEN 1 ELSE 0 END +
                CASE WHEN number6 BETWEEN 11 AND 20 THEN 1 ELSE 0 END) as range11_20,
            SUM(CASE WHEN number1 BETWEEN 21 AND 30 THEN 1 ELSE 0 END + 
                CASE WHEN number2 BETWEEN 21 AND 30 THEN 1 ELSE 0 END +
                CASE WHEN number3 BETWEEN 21 AND 30 THEN 1 ELSE 0 END +
                CASE WHEN number4 BETWEEN 21 AND 30 THEN 1 ELSE 0 END +
                CASE WHEN number5 BETWEEN 21 AND 30 THEN 1 ELSE 0 END +
                CASE WHEN number6 BETWEEN 21 AND 30 THEN 1 ELSE 0 END) as range21_30,
            SUM(CASE WHEN number1 BETWEEN 31 AND 40 THEN 1 ELSE 0 END + 
                CASE WHEN number2 BETWEEN 31 AND 40 THEN 1 ELSE 0 END +
                CASE WHEN number3 BETWEEN 31 AND 40 THEN 1 ELSE 0 END +
                CASE WHEN number4 BETWEEN 31 AND 40 THEN 1 ELSE 0 END +
                CASE WHEN number5 BETWEEN 31 AND 40 THEN 1 ELSE 0 END +
                CASE WHEN number6 BETWEEN 31 AND 40 THEN 1 ELSE 0 END) as range31_40,
            SUM(CASE WHEN number1 BETWEEN 41 AND 45 THEN 1 ELSE 0 END + 
                CASE WHEN number2 BETWEEN 41 AND 45 THEN 1 ELSE 0 END +
                CASE WHEN number3 BETWEEN 41 AND 45 THEN 1 ELSE 0 END +
                CASE WHEN number4 BETWEEN 41 AND 45 THEN 1 ELSE 0 END +
                CASE WHEN number5 BETWEEN 41 AND 45 THEN 1 ELSE 0 END +
                CASE WHEN number6 BETWEEN 41 AND 45 THEN 1 ELSE 0 END) as range41_45
        FROM lottery";
        
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $data = [
            '1-10' => (int)$row['range1_10'],
            '11-20' => (int)$row['range11_20'],
            '21-30' => (int)$row['range21_30'],
            '31-40' => (int)$row['range31_40'],
            '41-45' => (int)$row['range41_45']
        ];
        break;
}

$conn->close();

echo json_encode([
    'success' => true,
    'type' => $type,
    'data' => $data
], JSON_UNESCAPED_UNICODE);
?>

