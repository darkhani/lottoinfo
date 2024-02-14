<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

// // Define the number of records per page
$recordsPerPage = 20;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the offset for the SQL query
$offset = ($currentPage - 1) * $recordsPerPage;

// Select data from the database
// $sql = "SELECT * FROM lottery LIMIT $offset, $recordsPerPage";
$sql = "SELECT * FROM lottery ORDER BY fdate DESC LIMIT $offset, $recordsPerPage";
// $sql = "SELECT * FROM lottery;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Round</th>
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
        echo "<tr>
                <td>{$row['round']}</td>
                <td>{$row['fdate']}</td>
                <td>{$row['number1']}</td> 
                <td>{$row['number2']}</td> 
                <td>{$row['number3']}</td> 
                <td>{$row['number4']}</td> 
                <td>{$row['number5']}</td> 
                <td>{$row['number6']}</td> 
                <td>{$row['bonus']}</td>
              </tr>";
    }
    echo "<tr>";
    echo "<td colspan='9'>";
    // Create pagination links
    $totalRecordsSql = "SELECT COUNT(*) AS total_records FROM lottery";
    $totalRecordsResult = $conn->query($totalRecordsSql);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total_records'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    $range = 2;  // 현재 페이지 주변에 표시할 페이지 범위

    if ($currentPage > 1) {
        echo "<a href='lottoInfo.php?page=1'>1</a>";
        if ($currentPage > ($range + 1)) {
            echo "<span>...</span>";
        }
    }

   // echo "<div class='pagination'>";
    for ($i = max(2, $currentPage - $range); $i <= min($currentPage + $range, $totalPages - 1); $i++) {
    //for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='lottoInfo.php?page=$i' style='padding:4px; margin: 0 4px; border: 1px solid #ddd; text-decoration: none; color: #007bff;'>$i</a>";
    }

    if ($currentPage < $totalPages) {
        if ($currentPage < ($totalPages - $range)) {
            echo "<span>...</span>";
        }
        echo "<a href='lottoInfo.php?page=$totalPages'>$totalPages</a>";
    }
    
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='9'>";
    $countRankingNumberSql = "SELECT number, COUNT(number) AS occurrences FROM (  SELECT number1 AS number FROM lottery  UNION ALL  SELECT number2 FROM lottery  UNION ALL  SELECT number3 FROM lottery  UNION ALL  SELECT number4 FROM lottery  UNION ALL  SELECT number5 FROM lottery  UNION ALL  SELECT number6 FROM lottery) AS all_numbers GROUP BY number ORDER BY occurrences DESC;";
    $resultArr = $conn->query($countRankingNumberSql);
    $medalCount=0; //1~5위만 선정한다.
    echo "상위 노출 5개 숫자 : ";

    for ($j = 0; $j <= 45; $j++) {
        
        $countNumber = $resultArr->fetch_assoc()['number'];
        if ($medalCount < 5 ) {
            echo strval($countNumber).", "; 
        } else if ($medalCount == 5 ) {
            echo strval($countNumber); 
        }

        $medalCount = $medalCount + 1;
    }
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan='9'>";
    echo "<a href='index.html'>홈으로</a>";
    echo "<a href='lottoinfo_jan.php'> 1월 </a>";
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
