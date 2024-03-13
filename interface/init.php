<?
//get mysqli instance
function getDB () {
	$dbSettings = include 'settings.php';
	if (!($dbSettings["host"] && $dbSettings["database"] && $dbSettings["login"] && $dbSettings["password"])) {
		throw new Exception('Invalid data base settings.');
	}

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$mysqli =  new mysqli($dbSettings["host"], $dbSettings["login"], $dbSettings["password"], $dbSettings["database"], $dbSettings["port"]);
	if ($mysqli)
		return $mysqli;
	else
	{
		if ($mysqli->connect_errno) {
		    throw new RuntimeException('mysqli connection error: ' . $mysqli->connect_error);
		}
		return false;
	}
}

