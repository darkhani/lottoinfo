/**
 * 뷰 전환 기능 (테이블/카드/그리드)
 */

(function() {
    const viewControls = document.querySelector('.view-controls');
    const viewButtons = document.querySelectorAll('.view-btn');
    const dataContainer = document.getElementById('lottoDataContainer');
    
    if (!viewControls || !dataContainer) return;
    
    // 저장된 뷰 모드 불러오기
    let currentView = localStorage.getItem('lottoViewMode') || 'table';
    
    // 뷰 전환 함수
    function switchView(viewMode) {
        // 모든 뷰 컨테이너 숨기기
        const viewContainers = dataContainer.querySelectorAll('[data-view]');
        viewContainers.forEach(container => {
            container.style.display = 'none';
        });
        
        // 선택한 뷰 컨테이너 표시
        const selectedContainer = dataContainer.querySelector(`[data-view="${viewMode}"]`);
        if (selectedContainer) {
            selectedContainer.style.display = viewMode === 'table' ? 'block' : 
                                            viewMode === 'card' ? 'flex' : 'grid';
            
            if (viewMode === 'card') {
                selectedContainer.style.flexDirection = 'column';
                selectedContainer.style.gap = '1rem';
            } else if (viewMode === 'grid') {
                selectedContainer.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
                selectedContainer.style.gap = '1.5rem';
            }
        }
        
        // 버튼 활성화 상태 업데이트
        viewButtons.forEach(btn => {
            if (btn.dataset.view === viewMode) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        // 로컬스토리지에 저장
        localStorage.setItem('lottoViewMode', viewMode);
        currentView = viewMode;
    }
    
    // 버튼 클릭 이벤트
    viewButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const viewMode = btn.dataset.view;
            if (viewMode) {
                switchView(viewMode);
            }
        });
    });
    
    // 초기 뷰 설정
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => switchView(currentView));
    } else {
        switchView(currentView);
    }
})();

