<?php
  require("lib/config.php");

  $strLogin    = $_POST['login'];
  $strPassword = $_POST['password'];

  $strSql = "select * from user where password=CONCAT('*', UPPER(SHA1(UNHEX(SHA1('$strPassword'))))) AND login='$strLogin'";
  echo $strSql;

  $stmt=$pdo->query($strSql);
  if ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
    session_start();
  	$_SESSION['user']=$row['name'];
  	$_SESSION['userid']=$row['id'];
    header("Location: index.php");
  }
  else {
    include("lib/header.php");
?>
    <div class="alert alert-danger" role="alert">
    Passwort falsch!
    </div>
    <a class="btn btn-primary" href="login.php" role="button">zurück</a>
<?php
    include("lib/footer.php");
  }

?>
