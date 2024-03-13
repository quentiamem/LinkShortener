<?
include 'interface/init.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Link Shortener</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
			integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			crossorigin="anonymous"></script>
	<script type="text/javascript" src="script.js"></script>
</head>
<body>
	<div class="container">
		<p>Create shortened link!</p>
		<form name="link-shortener" class="link-shortener">
			<label for="text">URL</label><br>
			<input id="link" type="text" name="link">
			<input type="submit" value="Go">
		</form>
		<div class="result"></div>
	</div>
</body>
</html>
