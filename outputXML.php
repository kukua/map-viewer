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
//$result = $statement->fetchAll(PDO::FETCH_ASSOC);

/**
$xmlWriter = new XMLWriter();
$xmlWriter->openUri('php://stdout');

$xmlWriter->startDocument();
$xmlWriter->setIndent(2);
$xmlWriter->startElement('markers');
foreach ($statement as $row) {
  $xmlWriter->startElement('marker');
  $xmlWriter->writeAttribute('name', $row['name']);
  $xmlWriter->writeAttribute('address', $row['address']);
  $xmlWriter->writeAttribute('lat', $row['lat']);
  $xmlWriter->writeAttribute('lng', $row['lng']);
  $xmlWriter->writeAttribute('type', $row['type']);
  $xmlWriter->endElement();
}
header('Content-type: text/xml');
$xmlWriter->endElement();
$xmlWriter->endDocument();
*/




$str = <<<XML
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



/**
$xml = new SimpleXMLElement('<xml/>');

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	$node = $xml->addChild('marker');
	$node->addAttribute('name', $row['name']);
	$node->addAttribute('address', $row['address']);
	$node->addAttribute('lat', $row['lat']);
	$node->addAttribute('lng', $row['lng']);
	$node->addAttribute('type', $row['type']);
}

header('Content-type: text/xml');
print($xml->asXML());
exit;
*/
