<?php
/**
 * 당첨번호 조회 페이지
 */
$pageTitle = '당첨번호 조회';
$includeViewToggle = true;
$includeFilters = true;

require_once 'includes/functions.php';
include 'includes/header.php';

$conn = getDBConnection();

// 페이지네이션 설정
$recordsPerPage = 30;
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// 필터 파라미터
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$number = isset($_GET['number']) ? (int)$_GET['number'] : null;
$dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom'] : null;
$dateTo = isset($_GET['dateTo']) ? $_GET['dateTo'] : null;

// SQL 쿼리 구성
$whereClause = "WHERE 1=1";

if ($year) {
    $whereClause .= " AND YEAR(fdate) = " . (int)$year;
}

if ($month) {
    $whereClause .= " AND MONTH(fdate) = " . (int)$month;
}

if ($number) {
    $whereClause .= " AND (number1 = " . (int)$number . " OR number2 = " . (int)$number . 
                    " OR number3 = " . (int)$number . " OR number4 = " . (int)$number . 
                    " OR number5 = " . (int)$number . " OR number6 = " . (int)$number . 
                    " OR bonus = " . (int)$number . ")";
}

if ($dateFrom) {
    $dateFrom = mysqli_real_escape_string($conn, $dateFrom);
    $whereClause .= " AND fdate >= '$dateFrom'";
}

if ($dateTo) {
    $dateTo = mysqli_real_escape_string($conn, $dateTo);
    $whereClause .= " AND fdate <= '$dateTo'";
}

// 전체 레코드 수
$totalRecordsSql = "SELECT COUNT(*) AS total_records FROM lottery " . $whereClause;
$totalRecordsResult = $conn->query($totalRecordsSql);
$totalRecords = $totalRecordsResult->fetch_assoc()['total_records'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// 현재 페이지 데이터 조회
$offset = ($currentPage - 1) * $recordsPerPage;
$sql = "SELECT * FROM lottery " . $whereClause . " ORDER BY fdate DESC LIMIT $recordsPerPage OFFSET $offset";
$result = $conn->query($sql);

// 최다 당첨번호 6개
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
?>

<section class="section">
    <div class="container">
        <h1 class="section-title">로또 당첨번호 조회</h1>
        
        <!-- 최다 당첨번호 -->
        <div class="card" style="margin-bottom: 2rem; text-align: center;">
            <div class="card-header">최다 당첨번호 TOP 6</div>
            <div class="card-body" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <?php foreach ($topNumbers as $num): ?>
                    <?php echo renderLottoBall($num, 'large'); ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- 필터 패널 -->
        <div class="filters-panel">
            <div class="grid grid-2" style="gap: 1rem;">
                <div class="filter-group">
                    <label for="yearFilter">년도</label>
                    <select id="yearFilter" class="filter-select">
                        <option value="">전체</option>
                        <?php
                        $currentYear = date('Y');
                        for ($y = $currentYear; $y >= 2002; $y--) {
                            $selected = ($year == $y) ? 'selected' : '';
                            echo "<option value='{$y}' {$selected}>{$y}년</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="monthFilter">월</label>
                    <select id="monthFilter" class="filter-select">
                        <option value="">전체</option>
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $selected = ($month == $m) ? 'selected' : '';
                            $monthName = $m . '월';
                            echo "<option value='{$m}' {$selected}>{$monthName}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="numberFilter">번호 검색</label>
                    <input type="number" id="numberFilter" min="1" max="45" 
                           placeholder="1~45 사이 번호" class="filter-input" 
                           value="<?php echo $number ? $number : ''; ?>">
                </div>
                
                <div class="filter-group">
                    <label for="dateFrom">시작일</label>
                    <input type="date" id="dateFrom" class="filter-input" 
                           value="<?php echo $dateFrom ? $dateFrom : ''; ?>">
                </div>
                
                <div class="filter-group">
                    <label for="dateTo">종료일</label>
                    <input type="date" id="dateTo" class="filter-input" 
                           value="<?php echo $dateTo ? $dateTo : ''; ?>">
                </div>
            </div>
            
            <div class="filter-actions">
                <button class="btn btn-primary" id="applyFilters">필터 적용</button>
                <button class="btn btn-secondary" id="resetFilters">초기화</button>
            </div>
        </div>
        
        <!-- 뷰 컨트롤 -->
        <div class="view-controls">
            <button class="view-btn active" data-view="table" title="테이블 뷰">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                </svg>
            </button>
            <button class="view-btn" data-view="card" title="카드 뷰">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <line x1="3" y1="9" x2="21" y2="9"></line>
                </svg>
            </button>
            <button class="view-btn" data-view="grid" title="그리드 뷰">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                </svg>
            </button>
        </div>
        
        <!-- 데이터 컨테이너 -->
        <div id="lottoDataContainer">
            <?php if ($result->num_rows > 0): ?>
                <!-- 테이블 뷰 -->
                <div class="table-view-container" data-view="table">
                    <table class="table-view">
                        <thead>
                            <tr>
                                <th>회차</th>
                                <th>일자</th>
                                <th>번호1</th>
                                <th>번호2</th>
                                <th>번호3</th>
                                <th>번호4</th>
                                <th>번호5</th>
                                <th>번호6</th>
                                <th>보너스</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $result->data_seek(0);
                            while ($row = $result->fetch_assoc()): ?>
                                <tr class="lotto-row">
                                    <td><?php echo $row['round']; ?></td>
                                    <td><?php echo formatDate($row['fdate']); ?></td>
                                    <td><?php echo renderLottoBall($row['number1'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['number2'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['number3'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['number4'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['number5'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['number6'], 'medium'); ?></td>
                                    <td><?php echo renderLottoBall($row['bonus'], 'medium'); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- 카드 뷰 -->
                <div class="card-view-container" data-view="card" style="display: none;">
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <div class="lotto-card">
                            <div class="lotto-card-header">
                                <div class="lotto-card-round"><?php echo $row['round']; ?>회</div>
                                <div class="lotto-card-date"><?php echo formatDate($row['fdate']); ?></div>
                            </div>
                            <div class="lotto-numbers">
                                <?php echo renderLottoNumbers($row, 'medium', true); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- 그리드 뷰 -->
                <div class="grid-view-container" data-view="grid" style="display: none;">
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <div class="lotto-tile">
                            <div class="lotto-tile-header">
                                <div class="lotto-tile-round"><?php echo $row['round']; ?>회</div>
                                <div class="lotto-tile-date"><?php echo formatDate($row['fdate']); ?></div>
                            </div>
                            <div class="lotto-tile-numbers">
                                <?php echo renderLottoNumbers($row, 'medium', true); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- 페이지네이션 -->
                <?php echo renderPagination($currentPage, $totalPages, 'lottoInfo.php'); ?>
                
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center">
                        <p>조회된 결과가 없습니다.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$conn->close();
include 'includes/footer.php';
?>

