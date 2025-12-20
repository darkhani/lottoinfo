<?php
/**
 * 통계/분석 페이지
 */
$pageTitle = '로또 통계 분석';
$includeCharts = true;

require_once 'includes/functions.php';
include 'includes/header.php';

$conn = getDBConnection();

// 번호 빈도수 조회
$frequencySql = "SELECT number, COUNT(*) as count FROM (
    SELECT number1 AS number FROM lottery
    UNION ALL SELECT number2 FROM lottery
    UNION ALL SELECT number3 FROM lottery
    UNION ALL SELECT number4 FROM lottery
    UNION ALL SELECT number5 FROM lottery
    UNION ALL SELECT number6 FROM lottery
) AS all_numbers GROUP BY number ORDER BY number";

$frequencyResult = $conn->query($frequencySql);
$frequencyData = [];
$frequencyLabels = [];
$frequencyValues = [];
$frequencyColors = [];

while ($row = $frequencyResult->fetch_assoc()) {
    $num = (int)$row['number'];
    $count = (int)$row['count'];
    $frequencyData[$num] = $count;
    $frequencyLabels[] = $num;
    $frequencyValues[] = $count;
    
    // 색상 결정
    if ($num <= 10) {
        $frequencyColors[] = 'rgba(251, 196, 0, 0.8)';
    } elseif ($num <= 20) {
        $frequencyColors[] = 'rgba(105, 200, 242, 0.8)';
    } elseif ($num <= 30) {
        $frequencyColors[] = 'rgba(255, 114, 114, 0.8)';
    } elseif ($num <= 40) {
        $frequencyColors[] = 'rgba(170, 170, 170, 0.8)';
    } else {
        $frequencyColors[] = 'rgba(176, 216, 64, 0.8)';
    }
}

// 홀짝 비율
$oddEvenSql = "SELECT 
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

$oddEvenResult = $conn->query($oddEvenSql);
$oddEvenRow = $oddEvenResult->fetch_assoc();
$oddCount = (int)$oddEvenRow['odd_count'];
$evenCount = (int)$oddEvenRow['even_count'];

// 구간별 분포
$rangeSql = "SELECT 
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

$rangeResult = $conn->query($rangeSql);
$rangeRow = $rangeResult->fetch_assoc();
$rangeData = [
    '1-10' => (int)$rangeRow['range1_10'],
    '11-20' => (int)$rangeRow['range11_20'],
    '21-30' => (int)$rangeRow['range21_30'],
    '31-40' => (int)$rangeRow['range31_40'],
    '41-45' => (int)$rangeRow['range41_45']
];

$conn->close();
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">로또 통계 분석</h1>
        
        <!-- 탭 메뉴 -->
        <div class="stats-tabs" style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 2px solid var(--border-color);">
            <button class="tab-btn active" data-tab="frequency" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid var(--primary-color); color: var(--primary-color); font-weight: 600; cursor: pointer;">
                번호 빈도
            </button>
            <button class="tab-btn" data-tab="pattern" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid transparent; color: var(--text-secondary); font-weight: 600; cursor: pointer;">
                패턴 분석
            </button>
            <button class="tab-btn" data-tab="prediction" style="padding: 1rem 2rem; background: none; border: none; border-bottom: 3px solid transparent; color: var(--text-secondary); font-weight: 600; cursor: pointer;">
                예측 도구
            </button>
        </div>
        
        <!-- 번호 빈도 탭 -->
        <div class="tab-content active" id="frequency" style="display: block;">
            <div class="card">
                <div class="card-header">번호별 당첨 빈도수</div>
                <div class="card-body">
                    <canvas id="frequencyChart" style="max-height: 400px;"></canvas>
                </div>
            </div>
            
            <!-- 히트맵 -->
            <div class="card" style="margin-top: 2rem;">
                <div class="card-header">번호 빈도 히트맵</div>
                <div class="card-body">
                    <div class="heatmap" style="display: grid; grid-template-columns: repeat(9, 1fr); gap: 0.5rem;">
                        <?php
                        $maxCount = max($frequencyValues);
                        for ($i = 1; $i <= 45; $i++):
                            $count = isset($frequencyData[$i]) ? $frequencyData[$i] : 0;
                            $intensity = $maxCount > 0 ? ($count / $maxCount) : 0;
                            $bgColor = $intensity > 0.7 ? 'rgba(102, 126, 234, ' . $intensity . ')' : 'rgba(200, 200, 200, 0.3)';
                        ?>
                            <div class="heatmap-cell" style="aspect-ratio: 1; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; background: <?php echo $bgColor; ?>; color: <?php echo $intensity > 0.5 ? '#fff' : 'var(--text-primary)'; ?>; transition: transform 0.2s; cursor: pointer;" 
                                 title="<?php echo $i; ?>번: <?php echo $count; ?>회">
                                <?php echo $i; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 패턴 분석 탭 -->
        <div class="tab-content" id="pattern" style="display: none;">
            <div class="grid grid-2">
                <!-- 홀짝 비율 -->
                <div class="card">
                    <div class="card-header">홀짝 비율</div>
                    <div class="card-body">
                        <canvas id="oddEvenChart" style="max-height: 300px;"></canvas>
                        <div style="margin-top: 1rem; text-align: center;">
                            <p>홀수: <?php echo number_format($oddCount); ?>개</p>
                            <p>짝수: <?php echo number_format($evenCount); ?>개</p>
                        </div>
                    </div>
                </div>
                
                <!-- 구간별 분포 -->
                <div class="card">
                    <div class="card-header">구간별 분포</div>
                    <div class="card-body">
                        <canvas id="rangeChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 예측 도구 탭 -->
        <div class="tab-content" id="prediction" style="display: none;">
            <div class="card">
                <div class="card-header">통계 기반 추천 번호</div>
                <div class="card-body">
                    <p style="margin-bottom: 1rem;">최다 당첨번호를 기반으로 추천하는 번호입니다.</p>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                        <?php
                        // 상위 6개 번호
                        arsort($frequencyData);
                        $top6 = array_slice(array_keys($frequencyData), 0, 6);
                        foreach ($top6 as $num):
                            echo renderLottoBall($num, 'large');
                        endforeach;
                        ?>
                    </div>
                    <button class="btn btn-primary" id="generatePrediction" style="display: block; margin: 0 auto;">
                        새로운 추천 번호 생성
                    </button>
                    <div id="predictionResult" style="margin-top: 2rem; text-align: center;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// 탭 전환
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabName = btn.dataset.tab;
        
        // 모든 탭 버튼 비활성화
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active');
            b.style.borderBottomColor = 'transparent';
            b.style.color = 'var(--text-secondary)';
        });
        
        // 클릭한 탭 버튼 활성화
        btn.classList.add('active');
        btn.style.borderBottomColor = 'var(--primary-color)';
        btn.style.color = 'var(--primary-color)';
        
        // 모든 탭 컨텐츠 숨기기
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // 선택한 탭 컨텐츠 표시
        document.getElementById(tabName).style.display = 'block';
    });
});

// 번호 빈도 차트
const frequencyCtx = document.getElementById('frequencyChart').getContext('2d');
new Chart(frequencyCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($frequencyLabels); ?>,
        datasets: [{
            label: '당첨 횟수',
            data: <?php echo json_encode($frequencyValues); ?>,
            backgroundColor: <?php echo json_encode($frequencyColors); ?>,
            borderColor: <?php echo json_encode($frequencyColors); ?>,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.parsed.y + '회';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// 홀짝 비율 차트
const oddEvenCtx = document.getElementById('oddEvenChart').getContext('2d');
new Chart(oddEvenCtx, {
    type: 'doughnut',
    data: {
        labels: ['홀수', '짝수'],
        datasets: [{
            data: [<?php echo $oddCount; ?>, <?php echo $evenCount; ?>],
            backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(255, 114, 114, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// 구간별 분포 차트
const rangeCtx = document.getElementById('rangeChart').getContext('2d');
new Chart(rangeCtx, {
    type: 'bar',
    data: {
        labels: ['1-10', '11-20', '21-30', '31-40', '41-45'],
        datasets: [{
            label: '당첨 횟수',
            data: <?php echo json_encode(array_values($rangeData)); ?>,
            backgroundColor: [
                'rgba(251, 196, 0, 0.8)',
                'rgba(105, 200, 242, 0.8)',
                'rgba(255, 114, 114, 0.8)',
                'rgba(170, 170, 170, 0.8)',
                'rgba(176, 216, 64, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 예측 번호 생성
document.getElementById('generatePrediction')?.addEventListener('click', () => {
    const frequencyData = <?php echo json_encode($frequencyData); ?>;
    const sortedNumbers = Object.entries(frequencyData)
        .sort((a, b) => b[1] - a[1])
        .map(([num]) => parseInt(num));
    
    // 상위 20개 중에서 랜덤으로 6개 선택
    const top20 = sortedNumbers.slice(0, 20);
    const selected = [];
    while (selected.length < 6) {
        const randomIndex = Math.floor(Math.random() * top20.length);
        const num = top20[randomIndex];
        if (!selected.includes(num)) {
            selected.push(num);
        }
    }
    selected.sort((a, b) => a - b);
    
    const resultDiv = document.getElementById('predictionResult');
    resultDiv.innerHTML = `
        <h3 style="margin-bottom: 1rem;">추천 번호</h3>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            ${selected.map(n => createBallHTML(n, 'large')).join('')}
        </div>
    `;
});
</script>

<?php include 'includes/footer.php'; ?>

