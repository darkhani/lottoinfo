/**
 * 로또 번호 뽑기 기능
 */

(function() {
    const drawButton = document.getElementById('drawButton');
    const resultContainer = document.getElementById('result');
    const saveBtn = document.getElementById('saveBtn');
    const shareBtn = document.getElementById('shareBtn');
    const multiDrawBtn = document.getElementById('multiDrawBtn');
    const savedNumbersContainer = document.getElementById('savedNumbers');
    
    // 고유한 번호 생성
    function generateUniqueNumbers() {
        const numbers = [];
        while (numbers.length < 6) {
            const num = Math.floor(Math.random() * 45) + 1;
            if (!numbers.includes(num)) {
                numbers.push(num);
            }
        }
        return numbers.sort((a, b) => a - b);
    }
    
    // 번호 뽑기 애니메이션
    function drawNumbers() {
        if (!resultContainer) return;
        
        resultContainer.innerHTML = '';
        resultContainer.classList.add('drawing');
        
        // 로딩 애니메이션
        for (let i = 0; i < 6; i++) {
            const ball = document.createElement('div');
            ball.className = 'ball_645 large drawing';
            ball.textContent = '?';
            resultContainer.appendChild(ball);
        }
        
        // 실제 번호 생성 및 표시
        setTimeout(() => {
            const numbers = generateUniqueNumbers();
            const balls = resultContainer.querySelectorAll('.ball_645');
            
            balls.forEach((ball, index) => {
                setTimeout(() => {
                    const num = numbers[index];
                    ball.textContent = num;
                    ball.className = `ball_645 large ${getBallClass(num)} pop-in`;
                }, index * 100);
            });
            
            resultContainer.classList.remove('drawing');
            
            // 저장 버튼 활성화
            if (saveBtn) {
                saveBtn.dataset.numbers = JSON.stringify(numbers);
            }
        }, 1000);
    }
    
    // 번호 저장
    function saveNumbers(numbers) {
        const saved = JSON.parse(localStorage.getItem('lottoNumbers') || '[]');
        saved.push({
            numbers: numbers,
            date: new Date().toISOString()
        });
        localStorage.setItem('lottoNumbers', JSON.stringify(saved));
        displaySavedNumbers();
    }
    
    // 저장된 번호 표시
    function displaySavedNumbers() {
        if (!savedNumbersContainer) return;
        
        const saved = JSON.parse(localStorage.getItem('lottoNumbers') || '[]');
        
        if (saved.length === 0) {
            savedNumbersContainer.innerHTML = '<p class="text-center text-muted">저장된 번호가 없습니다.</p>';
            return;
        }
        
        savedNumbersContainer.innerHTML = saved.slice(-5).reverse().map((item, index) => {
            const date = new Date(item.date);
            const dateStr = `${date.getMonth() + 1}/${date.getDate()} ${date.getHours()}:${String(date.getMinutes()).padStart(2, '0')}`;
            
            return `
                <div class="saved-number-card card fade-in" style="animation-delay: ${index * 0.1}s">
                    <div class="saved-date" style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                        ${dateStr}
                    </div>
                    <div class="saved-numbers-display" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        ${item.numbers.map(n => createBallHTML(n, 'small')).join('')}
                    </div>
                </div>
            `;
        }).join('');
    }
    
    // 여러 게임 뽑기
    function drawMultipleGames(count = 5) {
        const multiResultContainer = document.getElementById('multiResult');
        if (!multiResultContainer) return;
        
        multiResultContainer.innerHTML = '';
        
        for (let i = 0; i < count; i++) {
            const numbers = generateUniqueNumbers();
            const gameCard = document.createElement('div');
            gameCard.className = 'game-card card fade-in';
            gameCard.style.animationDelay = `${i * 0.1}s`;
            gameCard.innerHTML = `
                <div class="game-number" style="font-weight: 600; color: var(--primary-color); margin-bottom: 1rem;">
                    게임 ${i + 1}
                </div>
                <div class="game-numbers" style="display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: center;">
                    ${numbers.map(n => createBallHTML(n, 'medium')).join('')}
                </div>
            `;
            multiResultContainer.appendChild(gameCard);
        }
    }
    
    // 공유 기능
    function shareNumbers(numbers) {
        const text = `로또 예상번호: ${numbers.join(', ')}`;
        
        if (navigator.share) {
            navigator.share({
                title: '로또 예상번호',
                text: text
            }).catch(err => console.log('공유 취소됨'));
        } else {
            // 클립보드에 복사
            navigator.clipboard.writeText(text).then(() => {
                alert('번호가 클립보드에 복사되었습니다!');
            });
        }
    }
    
    // 이벤트 리스너
    if (drawButton) {
        drawButton.addEventListener('click', drawNumbers);
    }
    
    if (saveBtn) {
        saveBtn.addEventListener('click', () => {
            const numbers = JSON.parse(saveBtn.dataset.numbers || '[]');
            if (numbers.length > 0) {
                saveNumbers(numbers);
                alert('번호가 저장되었습니다!');
            }
        });
    }
    
    if (shareBtn) {
        shareBtn.addEventListener('click', () => {
            const numbers = JSON.parse(saveBtn?.dataset.numbers || '[]');
            if (numbers.length > 0) {
                shareNumbers(numbers);
            }
        });
    }
    
    if (multiDrawBtn) {
        multiDrawBtn.addEventListener('click', () => {
            drawMultipleGames(5);
        });
    }
    
    // 페이지 로드 시 저장된 번호 표시
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', displaySavedNumbers);
    } else {
        displaySavedNumbers();
    }
})();

