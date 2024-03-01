// script.js
function checkNumbers() {
    const userNumbers = document.getElementById('userNumbers').value;
    const lottoNumbers = [/* 역대 로또 당첨번호 배열 */];

    const userNumberArray = userNumbers.split(',').map(Number);
    const matchingNumbers = userNumberArray.filter(num => lottoNumbers.includes(num));

    const resultElement = document.getElementById('result');
    if (matchingNumbers.length > 0) {
        resultElement.textContent = `Congratulations! You matched ${matchingNumbers.length} number(s): ${matchingNumbers.join(', ')}`;
    } else {
        resultElement.textContent = 'Sorry, no matching numbers.';
    }
}
