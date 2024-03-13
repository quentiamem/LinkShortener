<?require_once $_SERVER['DOCUMENT_ROOT']."/lib/ShortLink/class.php";

$code = $_GET["code"];

//construct whole link
$http = ($_SERVER["HTTPS"] && $_SERVER["HTTPS"] == "on") ? "https" : "http";
$searchShortlink = $http."://".$_SERVER["HTTP_HOST"]."/".$code;

$shortLink = new ShortLink($searchShortlink, true);
//manage redirect and counter increase if record is found, manage 404 otherwise
if ($shortLink->isRecorded()) {
	$shortLink->incrementCounter();
	
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$shortLink->getLink());
	exit();
}
else {
	header("HTTP/1.1 404 Not Found");
	include "404ShortlinkNotFound.php";
}