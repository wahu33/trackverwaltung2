<?php
    require_once("lib/config.php");
    $numYear = (isset($_GET['year'])) ? (int)$_GET['year'] : date('Y');
    include("lib/header.php");

 
    echo "<h2>".$numYear."</h2>";
    
    $query="SELECT d.id as id, d.bezeichnung as bezeichnung, filename, 
                k.bezeichnung as kategorie,k.id as kid, 
                groesse,status,DATE_FORMAT(datum,\"%d.%m.%Y\") as datum,d.sort,
                d.trkpt_count,DATE_FORMAT(trk_date,\"%d.%m.%Y\") as trk_date,d.distance
                FROM datei d, kategorie k
                WHERE d.kategorie=k.id  
                       and trk_date>='$numYear-01-01' and trk_date<='$numYear-12-31' 
                       and d.status=1 and k.privat=0
                       and (not k.id in (12,18)) 
                ORDER BY d.trk_date";
    //DEBUG:   echo $query;

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-sm mytable'>";
    echo "<thead><tr>";
    echo "<th></th><th>Kategorie</th><th>Track</th><th>Datum</th><th>Entfernung</th>";
    echo "<th></th><th></th><th></th><th></th><th></th></tr></thead>";
    echo "<tbody>";
    $zeile=1;
    $gesamtstrecke=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $strecke=$row['distance'];
        $gesamtstrecke+=$strecke;
        echo "<tr>";
        echo "<td>$zeile.</td>";
        echo "<td><a href =\"list.php?kategorie=".$row['kid']."\">".$row['kategorie']."</a></td>";
        echo "<td><a href=\"map.php?id=".$row['id']."\">".$row['bezeichnung']."</a></td>";
        echo "<td>".$row['trk_date']."</td>";
        echo "<td align='right'>".round($strecke,2)." km</td>";
 
        echo "<td><a href='map.php?id=".$row['id']."' title='Karte'><i class='fa fa-map' aria-hidden='true'></i></a></td>";
        echo "<td><a href='profile.php?id=".$row['id']."' title='Höhenprofil'><i class='fa fa-area-chart' aria-hidden='true'></i></a></td>";
        echo "<td><a href='info.php?id=".$row['id']."' title='Info'><i class='fa fa-info-circle' aria-hidden='true'></i></a></td>";
        echo "<td><a href='gpx.php?id=".$row['id']."' title='GPX-Download'><i class='fa fa-download' aria-hidden='true'></i></a></td>";

        echo "</tr>\n";
        $zeile++;
    }
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</div>\n";
  	echo "<p>Gesamtstrecke $numYear: ".round($gesamtstrecke,1)." km</p>"; 
   

echo "<br />";
echo "<a class=\"btn btn-primary\" href=\"years.php\" role=\"button\">zurück</a>";
include("lib/footer.php");
?>
