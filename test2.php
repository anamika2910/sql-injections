<?php
 require "dbconnect.php";
 session_start();
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
      <li ><a href="forgotpassword.php">Test-1:Check the Structure</a></li>
      <li class="active"><a href="test2.php">Test-2:Schema field mapping</a></li>
      <li><a href="test3.php">Test-3:Finding the table name </a></li>
      <li ><a href="test4.php">Test-4:Finding some users </a></li>
       <li><a href="test5.php">Test-5:Brute force password testing </a></li>
       <li class=""><a href="test6.php">Test-6:Adding a new member </a></li>
       <li class=""><a href="test7.php">Test-7:Mail me a password </a></li>
    </ul>
    <div class="well"> 
    The first steps are to guess some field names.
   </div> 
    </div>
     
<div class="col-sm-6">
      
      <?php
        if($_GET["try"]!=1){

          ?>

          <div class="row" style="height:100%">
        <form  action="test2.php?try=1" method="post">
          <div class="col-sm-2"></div>
          <div class="col-md-8">
          
            <?php 
            if($_GET["redirect"]||$_GET["check"]){
          
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
      
            
      <div class="card">
        <h4>Vulnerability :</h4>
<div class="well">
      Enter the following in email field : <b>x' AND fieldName IS NULL; -- </b><br>
      NOTE : In MySQL, the --  (double-dash) comment style requires the second dash to be followed by at least one whitespace or control character.
    </div>
  </div>
  <?php
  if(!$_GET["redirect"]&&!$_GET["check"]){
    ?>
  <div class="alert alert-info" role="alert">
   Guess field names ! 
        </div>

        <?php
      }
      if($_GET['check']==1||$_GET['redirect']==1){
        echo "Query Executed:<br><div class=\"well\">".$_SESSION['query']."</div>";
      }
      if($_GET["redirect"]!=null){

        ?>
        <div class="card">
        <div class="alert alert-info" role="alert">
    <strong>Heads up!</strong> SQL is malformed and a syntax error was thrown: it's most likely due to a bad field name.
        </div>
      </div>
      <?php
      
        }
      if($_GET["check"]==1){
         
        ?>
        <div class="card">
        <div class="alert alert-success" role="alert">
        We guessed the name correctly ,keep guessing. 
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
             $msg="Unknown Email Address" ;
             $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/test2.php?check=1";
           header($loc); /* Redirect browser */
            exit();
        } else {
           $msg="<b>Error: </b> ".mysqli_error($conn) ;
           $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/test2.php?redirect=1";
           header($loc); /* Redirect browser */
            exit();
        }

        $conn.close();
      }
      ?>

</body>


</html>
