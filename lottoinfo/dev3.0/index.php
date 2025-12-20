<?php
/**
 * 홈 페이지 - 로또 번호 뽑기
 */
$pageTitle = '로또 예상번호';
$includeLottoDraw = true;

require_once 'includes/functions.php';
include 'includes/header.php';
?>

<section class="hero-section">
    <div class="hero-background"></div>
    <div class="hero-content">
        <h1 class="hero-title">로또 예상번호</h1>
        <p class="hero-subtitle">행운의 숫자가 당신을 찾아갑니다</p>
        <div class="hero-cta">
            <button class="btn btn-primary btn-large" id="drawButton">번호 뽑기</button>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="draw-result-section">
            <div class="result-container" id="result" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; min-height: 100px; align-items: center; margin-bottom: 2rem;"></div>
            
            <div class="result-actions" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                <button class="btn btn-secondary" id="saveBtn">저장</button>
                <button class="btn btn-secondary" id="shareBtn">공유</button>
                <button class="btn btn-secondary" id="multiDrawBtn">5게임 뽑기</button>
            </div>
            
            <div id="multiResult" class="grid grid-2" style="margin-bottom: 2rem;"></div>
            
            <div class="saved-numbers-section">
                <h3 style="margin-bottom: 1rem; text-align: center;">저장된 번호</h3>
                <div id="savedNumbers" class="grid grid-2"></div>
            </div>
        </div>
    </div>
</section>

<?php
// 최다 당첨번호 6개 표시
$conn = getDBConnection();
$countRankingNumberSql = "SELECT number, COUNT(number) AS occurrences FROM (  
    SELECT number1 AS number FROM lottery  
    UNION ALL SELECT number2 FROM lottery  
    UNION ALL SELECT number3 FROM lottery  
    UNION ALL SELECT number4 FROM lottery  
    UNION ALL SELECT number5 FROM lottery  
    UNION ALL SELECT number6 FROM lottery
) AS all_numbers GROUP BY number ORDER BY occurrences DESC LIMIT 6";

$resultArr = $conn->query($countRankingNumberSql);
$topNumbers = [];
while ($row = $resultArr->fetch_assoc()) {
    $topNumbers[] = $row['number'];
}
$conn->close();
?>

<section class="section" style="background: var(--bg-secondary);">
    <div class="container">
        <h2 class="section-title">최다 당첨번호 TOP 6</h2>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <?php foreach ($topNumbers as $num): ?>
                <?php echo renderLottoBall($num, 'large'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

