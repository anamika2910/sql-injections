<?php
 require "dbconnect.php";
 if($_SESSION['test']!=7)
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
      <li class="active"><a href="forgotpassword.php">Test-1:Check the Structure</a></li>
      <li><a href="test2.php">Test-2:Schema field mapping</a></li>
      <li><a href="test3.php">Test-3:Finding the table name </a></li>
      <li ><a href="test4.php">Test-4:Finding some users </a></li>
      <li><a href="test5.php">Test-5:Brute force password testing </a></li>
      <li class=""><a href="test6.php">Test-6:Adding a new member </a></li>
      <li class=""><a href="test7.php">Test-7:Mail me a password </a></li>
    </ul>
    <div class="well"> 
    The intention of this test is to see if the application constructs an SQL string literally without sanitizing.
   </div> 
  	</div>
    
<div class="col-sm-6">
      
      <?php
        if($_GET["try"]!=1||$_GET["send"]==1){
          //echo $_GET["redirect"]==null;
          ?>

          <div class="row" style="height:100%">
      	<form  action="forgotpassword.php?try=1" method="post">
      		<div class="col-sm-2"></div>
      		<div class="col-md-8">
      		
            <?php 
            if($_GET["redirect"]){
          
            echo "<div class=\"well\">".$_SESSION['msg']."</div><br>";
          
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
     if($_GET["send"]!=1){
     ?>
      <div class="card">
        <h4>Vulnerability :</h4>
<div class="well">
      Enter the following in email field : <b>a@dpost.com'</b>
    </div>
  </div>
  <div class="card">
        <h4>Vulnerability :</h4>
<div class="well">
      Enter the following in email field : <b>anything' or 'x'='x</b>
    </div>
  </div>

        <?php
      }
      if($_GET["redirect"]==1||($_GET["redirect"])==2){
       echo "Query Executed:<br><div class=\"well\">".$_SESSION['query']."</div>";
     }
      if($_GET["redirect"]){
          
        ?>
        <div class="card">
        <div class="alert alert-info" role="alert">
    <strong>Heads up!</strong> This error response is a dead giveaway that user input is not being sanitized properly and that the application is ripe for exploitation. 
        </div>
      </div>
      <?php
       
        }

        $conn.close();
      }
      else{
        $email=$_POST["email"];
        $sql = sprintf("select email,password from info where email='%s';",$email);
        $result = $conn->query($sql);
        $_SESSION['query']=$sql;
        if (mysqli_query($conn, $sql)) {
            echo "<div class=\"row\">";
             if ($result->num_rows == 1) {
            
            echo "<div class=\"well\">The information is sent to ".$email."</div>";
            echo "</div><hr><div class=\"row\" style=\"height:100%\"><h3>What has happened:</h3>";
            echo "<div class=\"well\">";
           
                // output data of each row
                echo "<p>This mail is sent to".$email;
                while($row = $result->fetch_assoc()) {
                    echo "<br>This email is in response to your request for your Intranet log in information.";
                    echo "<br>Your USer ID: " . $row["email"] ."<br>Your password: ". $row["password"]."</p><br>";
                    if($_SESSION['test']==7){
                      ?>
                      <div class="alert alert-success" role="alert">
                          Now,you have full access to an account 
                        </div>
                      <?php
                      $_SESSION['test']==1;
                    }
                }
                  echo "</div>Query Executed:<br><div class=\"well\">".$_SESSION['query']."</div><br>";
            } 
            else if($result->num_rows>0){
                $row = $result->fetch_assoc();
                echo "<div class=\"well\" >The information is sent to ".$row["email"] ."</div>";
            echo "</div><hr><div class=\"row\" style=\"height:100%\"><h3>What has happened:</h3>";
            echo "<div class=\"well\">";
                echo "The response can vary for different applications, however here information ";
                echo "is being sent to first record from the database."."</p><br></div>"; 
            ?>
            <div class="card">
        <div class="alert alert-info" role="alert">
         Unlike the "real" query, which should return only a single item each time, this version will essentially return every item in the members database.
        </div>
      </div>
            <?php
            }
            else{
              $msg="Unknown Email Address"; 
                $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/forgotpassword.php?redirect=2";
           header($loc);
            }
            echo "</div></div></div>";

        } else {
           $msg="<b>Error: </b> ".mysqli_error($conn) ;
           $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/forgotpassword.php?redirect=1";
           header($loc); /* Redirect browser */
            exit();
        }

        $conn.close();
      }
      ?>

</body>


</html>
