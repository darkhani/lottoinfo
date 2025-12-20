/**
 * 메인 JavaScript
 * 공통 기능
 */

// 다크 모드 토글
(function() {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    
    // 저장된 테마 불러오기
    const savedTheme = localStorage.getItem('theme') || 'light';
    body.setAttribute('data-theme', savedTheme);
    
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = body.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            body.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
})();

// 모바일 메뉴 토글
(function() {
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.getElementById('mobileNav');
    
    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
        
        // 메뉴 링크 클릭 시 메뉴 닫기
        const mobileNavLinks = mobileNav.querySelectorAll('.mobile-nav-link');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
            });
        });
    }
})();

// 로또 공 색상 클래스 반환 함수
function getBallClass(number) {
    if (number <= 10) return 'ball1';
    if (number > 10 && number <= 20) return 'ball2';
    if (number > 20 && number <= 30) return 'ball3';
    if (number > 30 && number <= 40) return 'ball4';
    return 'ball5';
}

// 로또 공 HTML 생성
function createBallHTML(number, size = 'medium') {
    const ballClass = `ball_645 ${size} ${getBallClass(number)}`;
    return `<span class="${ballClass}">${number}</span>`;
}

// 유틸리티 함수
const utils = {
    formatDate: (date) => {
        const d = new Date(date);
        return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
    },
    
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    showLoading: (element) => {
        if (element) {
            element.classList.add('loading');
        }
    },
    
    hideLoading: (element) => {
        if (element) {
            element.classList.remove('loading');
        }
    }
};

// 전역으로 내보내기
window.utils = utils;
window.getBallClass = getBallClass;
window.createBallHTML = createBallHTML;

