<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_numberball.css">
    <title>숫자야구 게임</title>
</head>
<body>

<div class="container">
    <h1>숫자야구 게임</h1>

    <?php
    session_start();

    // 게임 초기화
    if (!isset($_SESSION['answer'])) {
        $_SESSION['answer'] = generateAnswer();
        $_SESSION['attempts'] = 0;
    }

    // 사용자 입력 처리
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $guess = $_POST['guess'];
        $result = checkGuess($guess, $_SESSION['answer']);
        $_SESSION['attempts']++;
    }
    ?>

    <form method="post" action="">
        <label for="guess">숫자를 입력하세요:</label>
        <input type="text" id="guess" name="guess" pattern="\d{3}" maxlength="3" required>
        <button type="submit">확인</button>
    </form>

    <?php
    // 게임 결과 출력
    if (isset($result)) {
        echo "<p>결과: $result</p>";
    }

    // 게임 초기화 버튼
    echo "<p>시도 횟수: {$_SESSION['attempts']}</p>";
    echo '<form method="post" action=""><button type="submit" name="reset">게임 초기화</button></form>';

    // 게임 초기화 버튼 클릭 시 세션 초기화
    if (isset($_POST['reset'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }

    function generateAnswer()
    {
        // 중복되지 않는 3자리 숫자 생성
        $numbers = range(0, 9);
        shuffle($numbers);
        return implode(array_slice($numbers, 0, 3));
    }

    function checkGuess($guess, $answer)
    {
        $result = '';
        for ($i = 0; $i < 3; $i++) {
            if ($guess[$i] == $answer[$i]) {
                $result .= '스트라이크 ';
            } elseif (strpos($answer, $guess[$i]) !== false) {
                $result .= '볼 ';
            }
        }

        // 결과가 없으면 아웃
        if ($result === '') {
            $result = '아웃';
        }

        // 정답을 맞췄을 경우 메시지 출력
        if ($result == '스트라이크 스트라이크 스트라이크 ') {
            $result = '축하합니다! 정답을 맞췄습니다!';
        }

        return trim($result);
    }
    ?>
</div>

</body>
</html>
