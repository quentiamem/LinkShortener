<?

//function encodes all non-alphanumeric (except -_) characters in URL, except certain ones that are allowed
function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}

if ($_POST["link"]) {
	$link = myUrlEncode($_POST["link"]);
	if (filter_var($link, FILTER_VALIDATE_URL) && substr($link, 0, 4) == "http") {

		require "lib/ShortLink/class.php";
		$shortLink = new ShortLink($link);

		if ($shortLink->isRecorded()) {
			echo json_encode(["status" => "success", 
				"message" => 'Shortened link for this URL already exists, here it is: <a href="'.$shortLink->getShortlink().'">'.$shortLink->getShortlink().'</a>. It was accessed '.$shortLink->getCounter().' times.']);
		}
		else {
			$shortLink->addShortenedLink();
			echo json_encode(["status" => "success", 
				"message" => 'Shortened link for this URL: <a href="'.$shortLink->getShortlink().'">'.$shortLink->getShortlink().'</a>']);
		}
	}
	else {
		echo json_encode(["status" => "error", "message" => "Invalid URL"]);
	}
}