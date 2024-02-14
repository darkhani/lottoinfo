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

// Select data from the database
// $sql = "SELECT * FROM lottery LIMIT $offset, $recordsPerPage";
// $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus FROM lottery WHERE fdate LIKE \"%-01-%\" ORDER BY fdate DESC";

// Search term
$searchTerm = "-05-"; // Replace with your actual search term

// SQL query with LIKE condition
$sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus FROM lottery  WHERE fdate LIKE '%" . $searchTerm . "%' ORDER BY fdate DESC";

// $sql = "SELECT * FROM lottery;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'>
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
        echo "<tr>
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
    echo "<a href='lottoInfo.php'>전체</a>";
    echo "<a href='lottoinfo_jan.php'> 1월 </a>";
    echo "<a href='lottoinfo_feb.php'> 2월 </a>";
    echo "<a href='lottoinfo_mar.php'> 3월 </a>";
    echo "<a href='lottoinfo_apr.php'> 4월 </a>";
    echo "<a href='lottoinfo_may.php'> 5월 </a>";
    echo "<a href='lottoinfo_jun.php'> 6월 </a>";
    echo "<a href='lottoinfo_jul.php'> 7월 </a>";
    echo "<a href='lottoinfo_aug.php'> 8월 </a>";
    echo "<a href='lottoinfo_sep.php'> 9월 </a>";
    echo "<a href='lottoinfo_oct.php'> 10월 </a>";
    echo "<a href='lottoinfo_nov.php'> 11월 </a>";
    echo "<a href='lottoinfo_dec.php'> 12월 </a>";
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
