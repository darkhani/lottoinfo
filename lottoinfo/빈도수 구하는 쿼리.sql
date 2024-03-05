SELECT number1, COUNT(*) AS Frequency FROM lottery GROUP BY number1 ORDER BY Frequency DESC LIMIT 3;



SELECT number1, COUNT(*) AS Frequency FROM lottery GROUP BY number1 ORDER BY Frequency ASC LIMIT 3;


--첫번째 column에서 제일 적게 나왔던 숫자 구하기.. DESC는 제일 많이 나온 숫자 구하기
SELECT number1, COUNT(*) AS Frequency
FROM lottery
GROUP BY number1
ORDER BY Frequency ASC
LIMIT 3;


--포함하는 숫자가 당첨된 경우 찾기
SELECT round,number1,number2,number3,number4,number5,number6 FROM `lottery` WHERE number1=10 and number2=12 order by round desc;
