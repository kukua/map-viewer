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

$xml = new DOMDocument();
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

header('Content-type: text/xml');
$string = $xml->saveXML();
echo $string;
//echo ($xml->asXML());

//echo "<xmp>".$xml->saveXML()."</xmp>";
