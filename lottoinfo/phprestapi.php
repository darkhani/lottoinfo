<html>
    <header>
        <meta charset="utf-8">
    </header>
    <body>
        <div>
        HIT <br>
        <?php $me_ch = curl_init(); // cURL 세션 초기화 
$status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE); // cURL 세션을 통해 서버 응답 상태 반환 
$responseArr = json_decode(curl_exec($me_ch), true); // cURL 세션 실행, 서버 응답 데이터를 JSON 형태로 반환 
// $me_headers = array( 'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token']) ); 
$me_headers = array('Content-Type: application/json'); 
print('header');
curl_setopt($me_ch, CURLOPT_URL, "https://www.tegine.com/lottoinfo/lotto_info_1_1099.json"); // cURL 세션 핸들 설정(API 리소스 경로) 
curl_setopt($me_ch, CURLOPT_POST, false); // cURL 세션 핸들 설정(POST 방식 이용여부) 
curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers); // cURL 세션 핸들 설정(HTTP HEADER 설정) 
curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true); // cURL 세션 핸들 설정(서버 응답여부) 
curl_exec($me_ch);
curl_close ($me_ch); // cURL 세션 종료 
print('curl_close');
if($status_code == 200) { 
    print("OK");
    print($responseArr);
} else { 
    print("ERROR");
} 
?>
</div>
    </body>

</html>