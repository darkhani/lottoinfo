<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="로또 예상번호 및 당첨번호 조회, 통계 분석">
    <title><?php echo isset($pageTitle) ? $pageTitle : '로또 정보 포털'; ?></title>
    
    <!-- 웹폰트 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pretendard:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/themes.css">
    
    <!-- Chart.js (통계 페이지용) -->
    <?php if (isset($includeCharts) && $includeCharts): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <?php endif; ?>
</head>
<body data-theme="light">
    <?php include 'navigation.php'; ?>

