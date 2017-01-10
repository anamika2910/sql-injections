

<html>
<body>

<?php
require "dbconnect.php";
$email=$_POST["email"];
$password=$_POST["password"];
$sql = "select password from info where email='".$email."';";
$result = $conn->query($sql);
$flag=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row['password']==$password){
        	echo "Welocome ".$email;
        	$flag=1;
        	break;
        }
    }
    if($flag==0){
    	echo "Wrong Userid/password";
    }
} else {
    echo "Wrong Userid/password";
}

$conn.close();
?>

?><br>
</body>
</html>
