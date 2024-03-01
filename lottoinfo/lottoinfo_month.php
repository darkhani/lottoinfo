<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style3.css">
    <style>
       

        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
            border-spacing: 0;
            /* overflow:auto; */
            
            overflow-y: scroll;
        }

        th, td {
            padding: 0.25rem;
            vertical-align: top;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .pagination {
        margin-top: 10px;
        }

        .pagination a {
            padding: 8px;
            margin: 0 8px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

    </style>
</head>
<body>
    <div>
    <img src="myhitlogo.jpg" width="200" alt="Han In Taek"><br>
<?php
$conn = mysqli_connect("localhost","darkhani","a4353488a","darkhani");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select data from the database
// $sql = "SELECT * FROM lottery LIMIT $offset, $recordsPerPage";
// $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus FROM lottery WHERE fdate LIKE \"%-01-%\" ORDER BY fdate DESC";

// Search term
//$searchTerm = "-01-"; // Replace with your actual search term

// And this is how you can use this function assuming the URL is, http://dummy.com/?technology=jquery&blog=jquerybyexample:

// var tech = GetURLParameter('technology');
// var blog = GetURLParameter('blog');`
$month = $_GET['month'];
// var month = GetURLParameter('month');

// SQL query with LIKE condition
$sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus FROM lottery  WHERE MONTH(fdate) = $month ORDER BY fdate DESC";

// $sql = "SELECT * FROM lottery;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='0'>
            <tr>
                <th>Date</th>
                <th>No1</th>
                <th>No2</th>
                <th>No3</th>
                <th>No4</th>
                <th>No5</th>
                <th>No6</th>
                <th>Bonus</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
         //=== 1번째 숫자 색깔 정의
         if ($row['number1'] < 10) {
            $num1Class = 'ball_645 lrg ball1';
        }

        if ($row['number1'] >= 10 && $row['number1'] < 20) {
            $num1Class = 'ball_645 lrg ball2';
        }

        if ($row['number1'] >= 20 && $row['number1'] < 30) {
            $num1Class = 'ball_645 lrg ball3';
        }

        if ($row['number1'] >= 30 && $row['number1'] < 40) {
            $num1Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number1'] >= 40 && $row['number1'] < 46) {
            $num1Class = 'ball_645 lrg ball5';
        }

        //=== 2번째 숫자 색깔 정의
        if ($row['number2'] < 10) {
            $num2Class = 'ball_645 lrg ball1';
        }

        if ($row['number2'] >= 10 && $row['number2'] < 20) {
            $num2Class = 'ball_645 lrg ball2';
        }

        if ($row['number2'] >= 20 && $row['number2'] < 30) {
            $num2Class = 'ball_645 lrg ball3';
        }

        if ($row['number2'] >= 30 && $row['number2'] < 40) {
            $num2Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number2'] >= 40 && $row['number2'] < 46) {
            $num2Class = 'ball_645 lrg ball5';
        }

        //=== 3번째 숫자 색깔 정의
        if ($row['number3'] < 10) {
            $num3Class = 'ball_645 lrg ball1';
        }

        if ($row['number3'] >= 10 && $row['number3'] < 20) {
            $num3Class = 'ball_645 lrg ball2';
        }

        if ($row['number3'] >= 20 && $row['number3'] < 30) {
            $num3Class = 'ball_645 lrg ball3';
        }

        if ($row['number3'] >= 30 && $row['number3'] < 40) {
            $num3Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number3'] >= 40 && $row['number3'] < 46) {
            $num3Class = 'ball_645 lrg ball5';
        }

         //=== 4번째 숫자 색깔 정의
         if ($row['number4'] < 10) {
            $num4Class = 'ball_645 lrg ball1';
        }

        if ($row['number4'] >= 10 && $row['number4'] < 20) {
            $num4Class = 'ball_645 lrg ball2';
        }

        if ($row['number4'] >= 20 && $row['number4'] < 30) {
            $num4Class = 'ball_645 lrg ball3';
        }

        if ($row['number4'] >= 30 && $row['number4'] < 40) {
            $num4Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number4'] >= 40 && $row['number4'] < 46) {
            $num4Class = 'ball_645 lrg ball5';
        }

         //=== 5번째 숫자 색깔 정의
         if ($row['number5'] < 10) {
            $num5Class = 'ball_645 lrg ball1';
        }

        if ($row['number5'] >= 10 && $row['number5'] < 20) {
            $num5Class = 'ball_645 lrg ball2';
        }

        if ($row['number5'] >= 20 && $row['number5'] < 30) {
            $num5Class = 'ball_645 lrg ball3';
        }

        if ($row['number5'] >= 30 && $row['number5'] < 40) {
            $num5Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number5'] >= 40 && $row['number5'] < 46) {
            $num5Class = 'ball_645 lrg ball5';
        }

        //=== 6번째 숫자 색깔 정의
        if ($row['number6'] < 10) {
            $num6Class = 'ball_645 lrg ball1';
        }

        if ($row['number6'] >= 10 && $row['number6'] < 20) {
            $num6Class = 'ball_645 lrg ball2';
        }

        if ($row['number6'] >= 20 && $row['number6'] < 30) {
            $num6Class = 'ball_645 lrg ball3';
        }

        if ($row['number6'] >= 30 && $row['number6'] < 40) {
            $num6Class = 'ball_645 lrg ball4';
        }
        
        if ($row['number6'] >= 40 && $row['number6'] < 46) {
            $num6Class = 'ball_645 lrg ball5';
        }

        //=== 보너스 숫자 색깔 정의
        if ($row['bonus'] < 10) {
            $bonusClass = 'ball_645 lrg ball1';
        }

        if ($row['bonus'] >= 10 && $row['bonus'] < 20) {
            $bonusClass = 'ball_645 lrg ball2';
        }

        if ($row['bonus'] >= 20 && $row['bonus'] < 30) {
            $bonusClass = 'ball_645 lrg ball3';
        }

        if ($row['bonus'] >= 30 && $row['bonus'] < 40) {
            $bonusClass = 'ball_645 lrg ball4';
        }
        
        if ($row['bonus'] >= 40 && $row['bonus'] < 46) {
            $bonusClass = 'ball_645 lrg ball5';
        }

        echo "<tr>
                <td>{$row['fdate']}</td>
                <td><span class='$num1Class'>{$row['number1']}</span></td> 
                <td><span class='$num2Class'>{$row['number2']}</span></td> 
                <td><span class='$num3Class'>{$row['number3']}</span></td> 
                <td><span class='$num4Class'>{$row['number4']}</span></td> 
                <td><span class='$num5Class'>{$row['number5']}</span></td> 
                <td><span class='$num6Class'>{$row['number6']}</span></td> 
                <td><span class='$bonusClass'>{$row['bonus']}</span></td>
              </tr>";
    }
    echo "<tr>";
    echo "<td colspan='9'>";
    echo "<a href='lottoInfo.php'>전체</a>";
    echo "<a href='lottoinfo_month.php?month=1'> 1월 </a>";
    echo "<a href='lottoinfo_month.php?month=2'> 2월 </a>";
    echo "<a href='lottoinfo_month.php?month=3'> 3월 </a>";
    echo "<a href='lottoinfo_month.php?month=4'> 4월 </a>";
    echo "<a href='lottoinfo_month.php?month=5'> 5월 </a>";
    echo "<a href='lottoinfo_month.php?month=6'> 6월 </a>";
    echo "<a href='lottoinfo_month.php?month=7'> 7월 </a>";
    echo "<a href='lottoinfo_month.php?month=8'> 8월 </a>";
    echo "<a href='lottoinfo_month.php?month=9'> 9월 </a>";
    echo "<a href='lottoinfo_month.php?month=10'> 10월 </a>";
    echo "<a href='lottoinfo_month.php?month=11'> 11월 </a>";
    echo "<a href='lottoinfo_month.php?month=12'> 12월 </a>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='9'>";
    echo "<a href='index.html'>홈으로</a>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "0 results";
}



// Close connection
$conn->close();
?>
</div>
</body>
</html>
