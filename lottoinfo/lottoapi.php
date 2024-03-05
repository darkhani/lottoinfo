<?php
$conn = mysqli_connect("localhost","darkhani","a4353488a","darkhani");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['number']) && is_numeric($_GET['number'])) {
    $searchNum = $_GET['number'];
}

// // Calculate the offset for the SQL query
// $offset = ($currentPage - 1) * $recordsPerPage;

// Select data from the database
$sql = "";
if($searchNum == ""){
    $sql = "SELECT round,fdate,number1,number2,number3,number4,number5,number6,bonus FROM lottery ORDER BY fdate DESC";
} else {
    $sql = "SELECT fdate, number1, number2, number3, number4, number5, number6, bonus 
            FROM lottery
            WHERE 1=1  
            AND ($searchNum IN (number1, number2, number3, number4, number5, number6)) 
            ORDER BY fdate DESC";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "[";

    $text = "";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
    //    $text = $text +  "{round:"+$row['round']+",fdate:"+$row['fdate']+",number1:"+$row['number1']+",number2:"+$row['number2']+",number3:"+$row['number3']+",number4:"+$row['number4']+",number5:"+$row['number5']+",number6:"+$row['number6']+",bonus:"+$row['bonus']+"},";       
       $text = $text."{\"round\":".$row['round'].
                     ",\"fdate\":\"".$row['fdate']."\"".
                     ",\"number1\":\"".$row['number1']."\"".
                     ",\"number2\":\"".$row['number2']."\"".
                     ",\"number3\":\"".$row['number3']."\"".
                     ",\"number4\":\"".$row['number4']."\"".
                     ",\"number5\":\"".$row['number5']."\"".
                     ",\"number6\":\"".$row['number6']."\"".
                     ",\"bonus\":\"".$row['bonus']."\"".
                     "},";
    //    echo $text;
    }
    
    $modified_text = substr($text, 0, -1);
    echo $modified_text;

    echo "]";
} else {
    echo "[{}]";
}

// Close connection
$conn->close();
?>