<?php
  require_once("lib/config.php");
  include("lib/header.php");
?>

<div class="mylist">
<h2>Kategorien</h2>
<ul class="list-group">
<?php

for ($year=date("Y");$year>=$numStart;$year--) {
    echo "<li class=\"list-group-item\"><strong><a href=\"year.php?year=".$year."\" >".$year."</a></strong>\n";
    echo "<a style='margin-left:5em' href='map_year.php?year=".$year."'><i class='fa fa-map' aria-hidden='true'></i> Karte</a>\n";
    echo "</li>\n";
}
?>
</ul>

<hr>


<a href="map_all.php"> Gesamtkarte</a>


</div>

<?php include("lib/footer.php"); ?>
