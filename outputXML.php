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

$str = <<<XML
<xml>
       <marker name="test"   lat="-4.8199534" lng="38.35222" address="Test street 1" type="1"></marker>
       <marker name="test 2" lat="-4.8199534" lng="38.34222" address="Test street 2" type="1"></marker>
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
