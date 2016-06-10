<?php
#Programmer: Moses Byanyuma

require(__DIR__.'/dbinfo.php');

// Opens a connection to a mySQL server
try {
$db = new PDO('mysql:host=localhost;dbname=map_database;charset=utf8',  'root', 'password');
   // echo "Connected to the database"; //checking for connection
}
catch (PDOException $e)
{
    echo "An Error occured, could not connect!";
}


$statement = $db->query('SELECT * FROM markers WHERE 1');
//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build XML
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
?>