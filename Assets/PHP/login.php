<html>
  <head>
    <meta charset="UTF-8">
    <title>BCTC project</title>
  </head>
  <body>
<!-- hello -->
  <?php
  if(isset($_POST['submit'])){
    
    $host = "localhost";
    $host_user = "root";
    $host_pass = "B@ruch123";
    $database = "baruch_donor";
    $table = "credentials";
    $port = "3306";
    $username = $_POST["username"];
    $password = $_POST["password"];
     // connect to mysql
    $mysql = mysqli_connect($host, $host_user, $host_pass);
     if(!$mysql) {
        echo "Cannot connect to database.";
        exit;
      }
      // select the appropriate database
      $selected = mysqli_select_db($mysql, $database);
      if(!$selected) {
        echo "Cannot select database.";
        exit;
      }

      // query the database to see if there is a record which matches
      $query = "select count(*) from $table where username = '$username' and password = '$password' ";
      $result = mysqli_query($mysql, $query);

      if(!$result) {
        echo "Cannot run query.";
        exit;
      }
    
      $row = mysqli_fetch_row($result);
      $count = $row[0];

      if ($count > 0) {
        // visitor's name and password combination are correct
        echo "<h1>Here it is!</h1>
              <p>I bet you are glad you can see this secret page.</p>";
  ?>

  <form method="post" action="../index_page/admin.html">
  </form>
  <?php
    } else {
      // visitor's name and password combination are not correct
      echo "<h1>Go Away!</h1>
            <p>You are not authorized to use this resource.</p>";
    }
  }
  ?>

  </body>
</html>

