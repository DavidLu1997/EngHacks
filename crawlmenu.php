<html>

<head>
	<title>WatChew Database Crawler For Weekly Menu</title>
</head>

<body>
	<?php
		/*
			WatChew Database Crawler
			Written by David Lu
			14/11/2015
			Crawls the UW Food Services website to obtain the current week's menu
		*/

		//MySQL
		$servername = "localhost";
		$username = "watchew";
		$password = "enghacks";
		$dbname = "nutrition";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		echo "Connected suessfully.<br>";

		

		//Clear DB
		$clearDB = 1;
		if($clearDB) {
			if($conn->query("delete from menu;") === TRUE){
				echo "Table menu cleared. <br>";
			}
			else {
				echo "Error: delete from food;" . "<br>" .$conn->error;
			}
		}

		function crawl_page($url, $conn)
		{
			$counter = 0;
			//echo "Crawling: " . $url . "<br>";
		    $seen[$url] = true;

		    $dom = new DOMDocument('1.0');
		    @$dom->loadHTMLFile($url);

		    //Get nutrition information from document
		    $links= $dom->getElementsByTagName('a');
		    foreach($links as $item) {
		    	$cur = $item->getAttribute('href');

		    	if(strpos($cur, "product") != FALSE){
		    		$cur = abs(filter_var($cur, FILTER_SANITIZE_NUMBER_INT));

		    		$sql = "INSERT INTO menu (id) VALUES ('$cur');";
					echo "Querying DB with: " . $sql . "<br>";
					if($conn->query($sql) === TRUE) {
						echo "Query sucessful, URL: ". $url . " crawled.<br>";
					} else {
						echo "Error: " . $sql . "<br>" .$conn->error;
					}

					$counter++;
		    	}
			}
			echo "Crawl complete, " . $counter . " entries crawled.<br>";
		}
		crawl_page("https://uwaterloo.ca/food-services/menu" . $x, $conn);

		$conn->close();

		echo "Have a nice day!<br>";
		echo "<img src='surprise.jpg'>";
	?>
</body>

</html>