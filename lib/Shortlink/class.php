<?require_once $_SERVER['DOCUMENT_ROOT']."/interface/init.php";

//each instance correspondes to a single link specified in the constructor's parameter, representing table row if it is present already
class ShortLink {
	private static $tableName = "Shortlinks";

	private $id;
	private $link = "";
	private $shortlink = "";
	private $accessCounter;
	private $isRecorded = false;

	private $mysqli;

	//constructor accepts either link or shortened link if $isShortened passed as true
	public function __construct($link, $isShortened = false) {
		if ($isShortened)
			$this->shortlink = $link;
		else
			$this->link = $link;

		$this->connectDB();
		$this->seekDBRecord();
	}

	public function isRecorded() {
		return $this->isRecorded;
	}
	public function getLink() {
		return $this->link;
	}
	public function getShortlink() {
		return $this->shortlink;
	}
	public function getCounter() {
		return $this->accessCounter;
	}

	private function connectDB() {
		$this->mysqli = getDB();

		//create table for the first time
		$tableName = $this::$tableName;
		
		$this->mysqli->query("CREATE TABLE IF NOT EXISTS $tableName (
			id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
			URL varchar(255),
			shortlink varchar(255),
			counter int
		)");
	}

	//checks if this URL or shortened link is present in the table, in case it does, fills instance's properties
	public function seekDBRecord() {
		$tableName = $this::$tableName;

		//search for URL by default, for shortlink otherwise if it is set
		$search = $this->link;
		$fieldName = "URL";
		if ($this->shortlink) {
			$search = $this->shortlink;
			$fieldName = "shortlink";
		}

		$search = $this->mysqli->real_escape_string($search);
		$res = $this->mysqli->query("SELECT * FROM $tableName 
			WHERE $fieldName='$search'");

		if ($row = $res->fetch_object()) {
			//flag this instance as corresponding to present record in DB
			$this->isRecorded = true;

			$this->id = $row->id;
			$this->link = $row->URL;
			$this->shortlink = $row->shortlink;
			$this->accessCounter = $row->counter;
		}
	}

	//calls for generation of a shortlink and insert a new record to the table
	public function addShortenedLink() {
		$tableName = $this::$tableName;
		$url = $this->mysqli->real_escape_string($this->link);

		$shortlink = $this->generateShortenedLink($url);

		$this->mysqli->query("INSERT INTO $tableName (URL, shortlink, counter)
			VALUES ('$url', '$shortlink', 0)");

		$this->shortlink = $shortlink;
	}

	//generates a short code from given URL, and attaches it to server origin to create a shortlink
	//a code consist of two parts:
	// * a symbol that is most common in the last bit of a path of given URL
	// * last 3 digits of nanoseconds of a timestamp given by hrtime()
	public function generateShortenedLink($link) {
		//take the last not-empty bit of the path of url, strip it of most common symbols
		$path = array_filter(explode("/", $link));
		$lastPhrase = end($path);
		$lastPhrase = str_replace(["+", "-", "_", "%", "&", "=", "."], "", $lastPhrase);

		// split the string per character and count the number of occurrences
		$totals = array_count_values(str_split($lastPhrase));
		// sort the totals so that the most frequent letter is first
		arsort($totals);
		// get which letter occurred the most frequently
		$letterCode = array_keys($totals)[0];

		//get timestamp
		$time = hrtime();
		//get nanoseconds bit
		$time = $time[1];
		//get last 3 numbers
		$numberCode = substr($time, -3, 3);

		$http = ($_SERVER["HTTPS"] && $_SERVER["HTTPS"] == "on") ? "https" : "http";
		$code = $http."://".$_SERVER["HTTP_HOST"]."/".$letterCode.$numberCode;

		return $code;
	}

	//increase the access counter property and reflect this change in db
	public function incrementCounter() {
		$counter = ++$this->accessCounter;
		$id = $this->id;

		$tableName = $this::$tableName;
		$this->mysqli->query("UPDATE $tableName	
			SET counter=$counter
			WHERE id=$id");
	}
}