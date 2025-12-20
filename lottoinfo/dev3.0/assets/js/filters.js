/**
 * 필터링 및 검색 기능
 */

(function() {
    const yearFilter = document.getElementById('yearFilter');
    const monthFilter = document.getElementById('monthFilter');
    const numberFilter = document.getElementById('numberFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    // 필터 적용
    function applyFilters() {
        const params = new URLSearchParams();
        
        if (yearFilter && yearFilter.value) {
            params.set('year', yearFilter.value);
        }
        if (monthFilter && monthFilter.value) {
            params.set('month', monthFilter.value);
        }
        if (numberFilter && numberFilter.value) {
            params.set('number', numberFilter.value);
        }
        if (dateFrom && dateFrom.value) {
            params.set('dateFrom', dateFrom.value);
        }
        if (dateTo && dateTo.value) {
            params.set('dateTo', dateTo.value);
        }
        
        // 페이지 리로드 또는 AJAX 요청
        const currentUrl = window.location.pathname;
        const newUrl = params.toString() ? `${currentUrl}?${params.toString()}` : currentUrl;
        window.location.href = newUrl;
    }
    
    // 필터 초기화
    function resetFilters() {
        if (yearFilter) yearFilter.value = '';
        if (monthFilter) monthFilter.value = '';
        if (numberFilter) numberFilter.value = '';
        if (dateFrom) dateFrom.value = '';
        if (dateTo) dateTo.value = '';
        
        window.location.href = window.location.pathname;
    }
    
    // 이벤트 리스너
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyFilters);
    }
    
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', resetFilters);
    }
    
    // 엔터키로 필터 적용
    const filterInputs = [yearFilter, monthFilter, numberFilter, dateFrom, dateTo];
    filterInputs.forEach(input => {
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    applyFilters();
                }
            });
        }
    });
    
    // 번호 클릭 시 하이라이트
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('ball_645')) {
            const number = parseInt(e.target.textContent);
            highlightNumber(number);
        }
    });
    
    // 번호 하이라이트 함수
    function highlightNumber(number) {
        // 모든 공에서 해당 번호 찾아서 하이라이트
        document.querySelectorAll('.ball_645').forEach(ball => {
            if (parseInt(ball.textContent) === number) {
                ball.classList.add('highlighted');
                setTimeout(() => ball.classList.remove('highlighted'), 2000);
            }
        });
        
        // 해당 번호가 포함된 행/카드 하이라이트
        const rows = document.querySelectorAll('.lotto-row, .lotto-card, .lotto-tile');
        rows.forEach(row => {
            const numbers = Array.from(row.querySelectorAll('.ball_645'))
                .map(b => parseInt(b.textContent))
                .filter(n => !isNaN(n));
            
            if (numbers.includes(number)) {
                row.classList.add('row-highlighted');
                setTimeout(() => row.classList.remove('row-highlighted'), 2000);
            }
        });
    }
    
    // 실시간 검색 (디바운스 적용)
    if (numberFilter) {
        const debouncedSearch = utils.debounce(() => {
            if (numberFilter.value) {
                applyFilters();
            }
        }, 500);
        
        numberFilter.addEventListener('input', debouncedSearch);
    }
})();

