

<html>
<body>

Welcome
<?php
require "dbconnect.php";
$email=$_POST["email"];
echo $email;
$sql = "select password from info where email='".$email."';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<p>id: " . $row["password"] ."</p><br>";
    }
} else {
    #echo "0 results";
}

if (mysqli_query($conn, $sql)) {
    #echo "New record created successfully";
} else {
    #echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn.close();
?>

?><br>
</body>
</html>
