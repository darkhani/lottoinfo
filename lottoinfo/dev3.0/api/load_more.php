<?php
/**
 * 무한 스크롤용 데이터 로드 API
 */
header('Content-Type: application/json; charset=utf-8');

require_once '../includes/functions.php';

$conn = getDBConnection();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 30;
$offset = ($page - 1) * $limit;

// 필터 파라미터
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$number = isset($_GET['number']) ? (int)$_GET['number'] : null;
$dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom'] : null;
$dateTo = isset($_GET['dateTo']) ? $_GET['dateTo'] : null;

// SQL 쿼리 구성
$sql = "SELECT * FROM lottery WHERE 1=1";

if ($year) {
    $sql .= " AND YEAR(fdate) = " . (int)$year;
}

if ($month) {
    $sql .= " AND MONTH(fdate) = " . (int)$month;
}

if ($number) {
    $sql .= " AND (number1 = " . (int)$number . " OR number2 = " . (int)$number . 
            " OR number3 = " . (int)$number . " OR number4 = " . (int)$number . 
            " OR number5 = " . (int)$number . " OR number6 = " . (int)$number . 
            " OR bonus = " . (int)$number . ")";
}

if ($dateFrom) {
    $dateFrom = mysqli_real_escape_string($conn, $dateFrom);
    $sql .= " AND fdate >= '$dateFrom'";
}

if ($dateTo) {
    $dateTo = mysqli_real_escape_string($conn, $dateTo);
    $sql .= " AND fdate <= '$dateTo'";
}

$sql .= " ORDER BY fdate DESC LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

echo json_encode([
    'success' => true,
    'data' => $data,
    'hasMore' => count($data) === $limit,
    'page' => $page
], JSON_UNESCAPED_UNICODE);
?>

