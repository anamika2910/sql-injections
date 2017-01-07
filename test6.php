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
      <li ><a href="test2.php">Test-2:Schema field mapping</a></li>
      <li><a href="test3.php">Test-3:Finding the table name </a></li>
      <li ><a href="test4.php">Test-4:Finding some users </a></li>
      <li class=""><a href="test5.php">Test-5:Brute force password testing </a></li>
       <li class="active"><a href="">Test-6:Adding a new member </a></li>
    </ul>
    <div class="well"> 
  We know the partial structure of the members table, it seems like a plausible approach to attempt adding a new record to that table: if this works, we'll simply be able to login directly with our newly-inserted credentials.
   </div> 
    </div>
     
<div class="col-sm-6">
      
      <?php
        if($_GET["try"]!=1){
          ?>

          <div class="row" style="height:100%">
        <form  action="test6.php?try=1" method="post">
          <div class="col-sm-2"></div>
          <div class="col-md-8">
          
            <?php 
            if($_GET["check"]!=0){
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
      Enter the following in email field : <b>x'; INSERT INTO tablename (fielname,fieldname) VALUES ('fielvalue','fieldvalue');-- </b><br>
    </div>
  </div>
   <?php 
            if($_GET["check"]==1){
            ?>
  <div class="alert alert-info" role="alert">
      The query executed successfully. Return to <a href="loginpage.html">home page </a> and login using the credentials you just entered.
        </div>
        
      <?php
      
        }
        if($_GET["check"]==3){
            
        ?>
  <div class="alert alert-info" role="alert">
         Even if we have actually gotten our field and table names right, several things could get in our way of a successful attack:<br>
    1.We might not have enough room in the web form to enter this much text directly (though this can be worked around via scripting, it's much less convenient).<br>
    2.The web application user might not have INSERT permission on the members table.<br>
    3.There are undoubtedly other fields in the members table, and some may require initial values, causing the INSERT to fail.<br>
    4.Even if we manage to insert a new record, the application itself might not behave well due to the auto-inserted NULL fields that we didn't provide values for.<br>
    5.A valid "member" might require not only a record in the members table, but associated information in other tables (say, "accessrights"), so adding to one table alone might not be sufficient.<br>
    6.Since the server side language here is php , it might not allow multiple query statements to be executed.<br>
        </div>
        <?php
}
        $conn.close();
      }
      else{
        $email=$_POST["email"];
        $sql = sprintf("select email,password from info where email='%s';",$email);

        $result = $conn->query($sql);
        if (mysqli_multi_query($conn, $sql)) {
          if($result->num_rows>0){
            $row = $result->fetch_assoc();
              $msg="The information is sent to ".$row["email"] ;
             $_SESSION['msg']=$msg;
             $loc="Location: http://localhost/test6.php?check=2";
           header($loc); /* Redirect browser */
            exit();
          }
          else{
             $msg="Unknown Email Address" ;
             $_SESSION['msg']=$msg;
           $loc="Location: http://localhost/test6.php?check=1";
           header($loc); /* Redirect browser */
            exit();
          }
        }
        
        else{
          $msg=mysqli_error($conn);
          $_SESSION['msg']=$msg;
          $loc="Location: http://localhost/test6.php?check=3";
           header($loc); 
        }

        $conn.close();
      }
      ?>

</body>


</html>
