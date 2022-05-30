<?php
  session_start();
  $strName=(isset($_SESSION['user'])) ? $_SESSION['user'] : "" ;
  $numUserId=(isset($_SESSION['userid'])) ? $_SESSION['userid'] : "";
  $boolLogin = (!empty($numUserId));
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="GPX-Trackverwaltung">
  <meta name="author" content="Walter Hupfeld">

  <title>GPX-Trackverwaltung</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="js/leaflet.js"></script>
  <style>
    .mytable {max-width: 45em;}
    .mytable tr > *:nth-child(1) { width:3em; }
    .mytable tr > *:nth-child(2) { width:25em; }
    .myform  {max-width: 40em;}
    .mylist  {max-width: 50em;}
    .nav-link {font-size:smaller;}
    .list-group-item {padding-top:0.25em; padding-bottom: 0.25em;}
    a:link, a:visited {color:darkred;}
    a.btn:visited  {color:white;}
    a.btn:link  {color:white;}
  </style>
</head>
<body>

  <!--  Navbar -->
  <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php">GPX-Trackverwaltung</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
<?php
        if ($boolLogin) {
?>
            <li class="nav-item">
              <a class="nav-link" href="new_category.php">Neue Kategorie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="upload_file.php">Upload</a>
            </li>
<?php
          }
?>
        <li class="nav-item">
         <?php  echo ($boolLogin) ?  "<a class=\"nav-link\" href=\"logout.php\">Logout</a>" :   "<a class=\"nav-link\" href=\"login.php\">Login</a>"; ?>
            </li>
<?php
        if ($boolLogin) echo "<li class='nav-item'><a class='nav-link'>(".$strName.")</a></li>";
?>
          </ul>

          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>

     <nav>
    <div class="container-fluid" style="margin-top:5em;">
         <div class="row">
           <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul  class="nav nav-pills flex-column">
            <li  class="nav-item"><a href="index.php"><strong>Übersicht</strong></a></li>
            <li  class="nav-item"><a class="nav-link" href="years.php"><strong>Radtouren nach Jahren</strong></a></li>
            

            <?php
            require_once("config.php");
            $query_kauswahl="SELECT id,bezeichnung,plural,kommentar FROM kategorie WHERE privat<1 ORDER BY sort";
            $stmt=$pdo->query($query_kauswahl);

            while ($row_kauswahl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li  class='nav-item'><a  class='nav-link'  href=\"list.php?kategorie=".$row_kauswahl['id']."\">".$row_kauswahl['plural']."</a></li>\n";
            }
            echo "<li><hr style=\"width:80%\" /></li>";
            ?>
           </nav>

          <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
          <!-- <h1><?php echo $strTitle ?></h1> -->
