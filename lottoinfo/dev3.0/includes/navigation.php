<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="logo-section">
                <a href="index.php" class="logo-link">
                    <img src="myhitlogo.jpg" alt="로또 정보" class="logo-img">
                </a>
            </div>
            
            <nav class="main-nav" id="mainNav">
                <a href="index.php" class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                    <span>번호 뽑기</span>
                </a>
                <a href="lottoInfo.php" class="nav-link <?php echo $currentPage == 'lottoInfo.php' ? 'active' : ''; ?>">
                    <span>당첨번호</span>
                </a>
                <a href="statistics.php" class="nav-link <?php echo $currentPage == 'statistics.php' ? 'active' : ''; ?>">
                    <span>통계분석</span>
                </a>
            </nav>
            
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle" aria-label="테마 전환">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </button>
                
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="메뉴">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<nav class="mobile-nav" id="mobileNav">
    <a href="index.php" class="mobile-nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">번호 뽑기</a>
    <a href="lottoInfo.php" class="mobile-nav-link <?php echo $currentPage == 'lottoInfo.php' ? 'active' : ''; ?>">당첨번호</a>
    <a href="statistics.php" class="mobile-nav-link <?php echo $currentPage == 'statistics.php' ? 'active' : ''; ?>">통계분석</a>
</nav>

