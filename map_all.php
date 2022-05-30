<?php
  require_once ("lib/config.php");


  
  $query="SELECT d.id as id, d.bezeichnung as bezeichnung, filename, 
      k.bezeichnung as kategorie,k.id as kid, 
      groesse,status,DATE_FORMAT(datum,\"%d.%m.%Y\") as datum,d.sort,
      d.trkpt_count,DATE_FORMAT(trk_date,\"%d.%m.%Y\") as trk_date,d.distance
      FROM datei d, kategorie k
      WHERE d.kategorie=k.id  
            and d.status=1 and k.privat=0
            and (not k.id in (12,18)) 
      ORDER BY d.trk_date";
 //DEBUG:echo $query;

 $arrData = array();
 $arrMeta = array();
 $stmt=$pdo->query($query);
 $index=1;
 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $id = $row['id'];
   $arrMeta[$id] = $row['bezeichnung'];    

   $strSQL = "select lon,lat 
               from tracks 
               where not (lat>51.6 and lat<51.8 and lon>7.7 and lon<7.9) 
                    and track_id=$id";
   $stmt2=$pdo->query($strSQL);

   $arrData[$index]="[";
   while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
     $arrData[$index] .= "[".$row2['lat'].",".$row2['lon']."],";
   }
   $arrData[$index] .= "]";
  $index++;
  }
  include("header-map.php"); 
?>  

<div id="wrapper"><div id="map"></div></div>

<div class="info card">
  <div class="card-header">
    <h3></h3>
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
      
      
      var polyline1 = L.polyline([[51,6],[46,12]], {color: 'yellow'}).addTo(map);
      var polyline2 = L.polyline([[51.6,7.7],[51.8,7.7],[51.8,7.9],[51.6,7.9],[51.6,7.7]], {color: 'yellow'}).addTo(map);
      <?php
         for ($i=1;$i<$max;$i++) {
          echo "L.polyline(latlngs[$i], {color: 'blue'}).addTo(map);";
         }
      ?>   
      // zoom the map to the polyline
      map.fitBounds(polyline1.getBounds());

     
</script>
<?php
include("lib/footer.php");
?>
