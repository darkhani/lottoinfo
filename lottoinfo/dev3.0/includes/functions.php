<?php
/**
 * 공통 유틸리티 함수
 */

/**
 * 데이터베이스 연결
 */
function getDBConnection() {
    $conn = mysqli_connect("localhost","darkhani","a4353488a","darkhani");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
    return $conn;
}

/**
 * 로또 번호에 따른 색상 클래스 반환
 */
function getBallClass($number) {
    if ($number <= 10) {
        return 'ball1';
    } elseif ($number > 10 && $number <= 20) {
        return 'ball2';
    } elseif ($number > 20 && $number <= 30) {
        return 'ball3';
    } elseif ($number > 30 && $number <= 40) {
        return 'ball4';
    } else {
        return 'ball5';
    }
}

/**
 * 로또 번호 HTML 생성
 */
function renderLottoBall($number, $size = 'medium') {
    $class = 'ball_645 ' . $size . ' ' . getBallClass($number);
    return "<span class='{$class}'>{$number}</span>";
}

/**
 * 로또 번호 배열을 HTML로 변환
 */
function renderLottoNumbers($numbers, $size = 'medium', $includeBonus = false) {
    $html = '';
    for ($i = 1; $i <= 6; $i++) {
        if (isset($numbers["number{$i}"])) {
            $html .= renderLottoBall($numbers["number{$i}"], $size);
        }
    }
    if ($includeBonus && isset($numbers['bonus'])) {
        $html .= '<span class="bonus-separator">+</span>';
        $html .= renderLottoBall($numbers['bonus'], $size);
    }
    return $html;
}

/**
 * 날짜 포맷팅
 */
function formatDate($date, $format = 'Y-m-d') {
    return date($format, strtotime($date));
}

/**
 * 페이지네이션 HTML 생성
 */
function renderPagination($currentPage, $totalPages, $baseUrl, $range = 2) {
    $html = '<div class="pagination">';
    
    if ($currentPage > 1) {
        $html .= "<a href='{$baseUrl}?page=1' class='page-link'>처음</a>";
        $html .= "<a href='{$baseUrl}?page=" . ($currentPage - 1) . "' class='page-link'>이전</a>";
        
        if ($currentPage > ($range + 1)) {
            $html .= "<span class='page-ellipsis'>...</span>";
        }
    }
    
    for ($i = max(2, $currentPage - $range); $i <= min($currentPage + $range, $totalPages - 1); $i++) {
        $active = ($i == $currentPage) ? 'active' : '';
        $html .= "<a href='{$baseUrl}?page={$i}' class='page-link {$active}'>{$i}</a>";
    }
    
    if ($currentPage < $totalPages) {
        if ($currentPage < ($totalPages - $range)) {
            $html .= "<span class='page-ellipsis'>...</span>";
        }
        $html .= "<a href='{$baseUrl}?page=" . ($currentPage + 1) . "' class='page-link'>다음</a>";
        $html .= "<a href='{$baseUrl}?page={$totalPages}' class='page-link'>마지막</a>";
    }
    
    $html .= '</div>';
    return $html;
}
?>

