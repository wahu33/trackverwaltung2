<?php
  require_once ("lib/config.php");


  $numYear   = (is_numeric($_GET['year']))?$_GET['year']:2021;
  $numKategorie = (is_numeric($_GET['cat']))?$_GET['cat']:1;
  $query="SELECT d.id as id, d.bezeichnung as bezeichnung, filename, 
      k.bezeichnung as kategorie,k.id as kid, 
      groesse,status,DATE_FORMAT(datum,\"%d.%m.%Y\") as datum,d.sort,
      d.trkpt_count,DATE_FORMAT(trk_date,\"%d.%m.%Y\") as trk_date,d.distance
      FROM datei d, kategorie k
      WHERE d.kategorie=k.id  
            and trk_date>='$numYear-01-01' and trk_date<='$numYear-12-31' 
           -- and d.status=1 and k.privat=0
           -- and (not k.id in (12,18)) 
            and d.kategorie=$numKategorie
      ORDER BY d.trk_date";
 //DEBUG:echo $query;

 $arrData = array();
 $arrMeta = array();
 $stmt=$pdo->query($query);
 $index=1;
 $first=true;
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $arrMeta[$id] = $row['bezeichnung']; 
    $strKategorie = $row['kategorie'];   

    $strSQL = "select lon,lat from tracks where track_id=$id";
    $stmt2=$pdo->query($strSQL);

        
    $arrData[$index]="[";
    
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        if ($first) {
            $bound_min_lat=$row2['lat'];
            $bound_max_lat=$row2['lat'];
            $bound_min_lng=$row2['lon'];
            $bound_max_lng=$row2['lon'];
            $first=false;
        }
     $arrData[$index] .= "[".$row2['lat'].",".$row2['lon']."],";
     $bound_min_lat=min($bound_min_lat,$row2['lat']);
     $bound_max_lat=max($bound_max_lat,$row2['lat']);
     $bound_min_lng=min($bound_min_lng,$row2['lon']);
     $bound_max_lng=max($bound_max_lng,$row2['lon']);
   }
   $arrData[$index] .= "]";
  $index++;
  }
  include("header-map.php"); 
?>  

<div id="wrapper"><div id="map"></div></div>

<div class="info card">
  <div class="card-header">
    <h2><?=$strKategorie?></h2> 
    <h3><?=$numYear?></h3>
    <?php
       foreach($arrMeta as $key => $val) {
         echo "<a style='font-size:9pt' href='map.php?id=".$key."'><i class='fa fa-map' aria-hidden='true'></i> ".$val."</a><br>";
       }
    ?>

  </div>


<script type="text/javascript">
      var latlngs = [];
      <?php
        $i=1;
        foreach ($arrData as $data) {
          echo "latlngs[".$i."]=".$data."\n";
          $i++;
        }
        $max = $i;
      ?>
  

      var map = L.map('map');
      var mbUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
      L.tileLayer(mbUrl, {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
      
      
      var polyline1 = L.polyline(latlngs[1], {color: 'blue'}).addTo(map);
      <?php
         for ($i=2;$i<$max;$i++) {
          echo "L.polyline(latlngs[$i], {color: 'blue'}).addTo(map);";
         }
      ?>   
      // zoom the map to the polyline
      var bounds = [[<?=$bound_max_lat?>, <?=$bound_max_lng?>], [<?=$bound_min_lat?>, <?=$bound_min_lng?>]];
      map.fitBounds(bounds);

     
</script>
<?php
include("lib/footer.php");
?>
