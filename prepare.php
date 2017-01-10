<?php
 require "dbconnect.php";
 session_start();
 $_SESSION['msg']==null;
?>
<!DOCTYPE html>

  <html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="demo.css">
  </head>
  <body>
  	<div class="page-header">
  	<h1 align="center" class="text-muted" >SQL-Injection Attacks</h1>
  	</div>
  	<div class="row">
  	<div class="col-sm-3">
  	<ul class="nav nav-pills nav-stacked">
      <li><a href="loginpage.html">Home</a></li>
      <li class=""><a href="forgotpassword.php">Test-1:Check the Structure</a></li>
      <li><a href="test2.php">Test-2:Schema field mapping</a></li>
      <li><a href="test3.php">Test-3:Finding the table name </a></li>
      <li ><a href="test4.php">Test-4:Finding some users </a></li>
      <li><a href="test5.php">Test-5:Brute force password testing </a></li>
      <li class=""><a href="test6.php">Test-6:Adding a new member </a></li>
      <li class=""><a href="test7.php">Test-7:Mail me a password </a></li>
    </ul>
    
  	</div>
    
<div class="col-sm-6">
      <div class="row" style="height:100%">
        <form  action="prepare.php?try=1" method="post">
          <div class="col-sm-2"></div>
          <div class="col-md-8">
      <?php
       if($_GET['try']!=1){
          if($_GET['redirect']==1){
            echo "<div class=\"well\">".$_SESSION['msg']."</div>";
          }
              
          ?>  <div class="input-group">
      		    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      		    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
      		</div>
          <br>
          <div class="center">
      		<input type="submit" name="submit" value="Send me the password" class="btn btn-info" />
      		</div>
      	</form>
      </div>
      </div>
        
      <?php

        $conn.close();
      }
      else{
        
        $stmt = $conn->prepare("select email,password from info where email= ?");
        $stmt->bind_param("s",$email);
        $email=$_POST["email"];
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($email,$password);
        $stmt->store_result();
        $stmt->bind_result($column1, $column2);
        $flag=0;
while($stmt->fetch())
{
  $flag=1;
    echo "<div class=\"row\">";
            echo "<div class=\"well\">The information is sent to  ".$email."</div>";
            echo "</div><hr><div class=\"row\" style=\"height:100%\"><h3>What has happened:</h3>";
            echo "<div class=\"well\">";
           
                // output data of each row
                echo "<p>This mail is sent to".$email;
               
                    echo "<br>This email is in response to your request for your Intranet log in information.";
                    echo "<br>Your USer ID: " . $column1 ."<br>Your password: ". $column2."</p><br>";
}
if($flag==0)
{
  $flag=0;
  $msg="Unknown Email Address"; 
                $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/prepare.php?redirect=1";
           header($loc);
           
}



        $_SESSION['query']=$stmt;
       
        $stmt.close();
        $conn.close();
      }
      ?>

</body>


</html>
