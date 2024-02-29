// document.getElementById("drawButton").addEventListener("click", function () {
//     const resultElement = document.getElementById("result");

//     // Simulate lottery logic (e.g., random numbers)
//     const lottoNumbers = [];
//     for (let i = 0; i < 6; i++) {
//         lottoNumbers.push(Math.floor(Math.random() * 45) + 1);
//     }

//     // Display the result
//     resultElement.innerHTML = `예상번호: ${lottoNumbers.join(", ")}`;
// });

document.getElementById("drawButton").addEventListener("click", function () {
    const resultElement = document.getElementById("result");

    let uniqueLottoNumbers = [];
    var uniqueLottoNumbersSet = [];
    // Keep generating random numbers until there are 6 unique numbers
    while (uniqueLottoNumbersSet.length < 6) {
        // Simulate lottery logic (e.g., random numbers)
        const newLottoNumber = Math.floor(Math.random() * 45) + 1;

        // Add the new number to the uniqueLottoNumbers array if it's not already present
        if (!uniqueLottoNumbers.includes(newLottoNumber)) {
            uniqueLottoNumbers.push(newLottoNumber);
        }

         // Remove duplicates using Set
        uniqueLottoNumbersSet = Array.from(new Set(uniqueLottoNumbers));

    }

    // Display the result
    resultElement.innerHTML = `예상번호: ${uniqueLottoNumbers.join(", ")}`+'<br><br> tegine는 바로 당신이 10억의 주인공이 되길 바래요 🌈';
});

document.getElementById("linkButton").addEventListener("click", function () {
    var href = "https://www.tegine.com/lottoinfo/index.html";
    window.location = href;
});

