<?php
#Programmer: Moses Byanyuma

require('./.env');


// Opens a connection to a mySQL server
try {
	$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME. ';charset=utf8',  DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    echo "An Error occured, could not connect!";
}

$statement = $db->query('SELECT * FROM markers');

$xml = new DOMDocument("1.0");
$xml->formatOutput = true;

$markers = $xml->createElement('markers');
$markers = $xml->appendChild($markers);

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    
     $marker = $xml->createElement('marker');
     $markers->appendChild($marker);
    
     $marker->setAttribute('name', $row['name']);
    $marker->setAttribute('lat', $row['lat']);
    $marker->setAttribute('lng', $row['lng']);
    $marker->setAttribute('address', $row['address']);
    $marker->setAttribute('type', $row['type']);
    
}


echo "<xmp>".$xml->saveXML()."</xmp>";
$xml->save("locations.xml");

/**$str = <<<XML
<xml>
       <marker name="Walvis Bay Live"   lat="-22.956112" lng="14.508056" address="Walvis bay namibia Africa" type="Weather Station"></marker>
       <marker name="Centro Surf Bracciano" lat="11.588599" lng="43.145851" address="djibouti djibouti" type="Weather Station"></marker>
       <marker name="Bashewa Weather" lat="-25.825212" lng="28.312128" address="Garstfontein Rd Pretoria" type="Weather Station"></marker>
       <marker name="Nelspruit Live" lat="-25.475298" lng="30.969416" address="nelspruit south africa" type="Weather Station"></marker>
       <marker name="Richards Bay Live" lat="-28.780727" lng="32.038284" address="richards bay south africa" type="Weather Station"></marker>
       <marker name="Cape Town Live" lat="-33.923775" lng="18.423346" address="cape town south africa" type="Weather Station"></marker>
</xml>
XML;

header("Content-type: text/xml");
echo $str;
exit;
*/

?>