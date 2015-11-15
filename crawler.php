<html>

<head>
	<title>WatChew Database Crawler</title>
</head>

<body>
	<?php
	//Disable timeout
	set_time_limit(0);
		/*
			WatChew Database Crawler
			Written by David Lu
			14/11/2015
			Crawls the UW Food Services website to obtain nutritional information for all menu items
		*/
		//MySQL connection
		$servername = "localhost";
		$username = "watchew";
		$password = "enghacks";
		$dbname = "nutrition";

		//Connect
		$conn = new mysqli($servername, $username, $password, $dbname);

		//Checks for connection
		if($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		echo "Connected sucessfully.<br>";

		//Clear DB
		$clearDB = 1;
		if($clearDB) {
			if($conn->query("delete from food;") === TRUE){
				//echo "Table cleared. <br>";
			}
			else {
				//echo "Error: delete from food;" . "<br>" .$conn->error;
			}
		}

		//Min and Max IDs for foods
		$min_id = 0;
		$max_id = 4000;
		function crawl_page($url, $id, $conn)
		{
			//echo "Crawling: " . $url . "<br>";
		    $seen[$url] = true;

		    //Load HTML file using DOM
		    $dom = new DOMDocument('1.0');
		    @$dom->loadHTMLFile($url);

		    //Initialize variables
		    $name = 'NAME';
		    $serving = 0;
		    $vegetarian = 0;
		    $ingredients = 'INGREDIENTS';
		    $calories = 0;
		    $fat = 0;
		    $saturated = 0;
		    $cholestrol = 0;
		    $sodium = 0;
		    $carbohydrate = 0;
		    $fibre = 0;
		    $sugars = 0;
		    $protein = 0;
		    $vitaminA = 0;
		    $vitaminC = 0;
		    $calcium = 0;
		    $iron = 0;

		    //Get nutrition information from document
		    $i = 0; //Ghetto counter
		    $nutrition_info = $dom->getElementsByTagName('th');
		    foreach($nutrition_info as $item) {
		    	$cur = $item->nodeValue;
		    	//Rip out + sign
		    	str_replace('+', '', $cur);
		    	$cur = max(-1, filter_var($item->nodeValue, FILTER_SANITIZE_NUMBER_INT));
		    	//echo $cur . "<br>";
		    	if($cur){
		    		switch($i) {
		    			case 0:
		    				$calories = $cur;
		    				break;
		    			case 1:
		    				$fat = $cur;
		    				break;
		    			case 2:
		    				$saturated = $cur;
		    				break;
		    			case 3:
		    				$cholestrol = $cur;
		    				break;
		    			case 4:
		    				$sodium = $cur;
		    				break;
		    			case 5:
		    				$carbohydrate = $cur;
		    				break;
		    			case 6:
		    				$fibre = $cur;
		    				break;
		    			case 7:
		    				$sugars = $cur;
		    				break;
		    			case 8:
		    				$protein = $cur;
		    				break;
		    		}
		    		$i++;
		    	}
		    }

		    //Get minerals
		    $i = 0;
		    $minerals = $dom->getElementsByTagName('td');
		    foreach($minerals as $item) {
		    	$cur = $item->nodeValue;
		    	//Rip out + sign
		    	str_replace('+', '', $cur);
		    	$cur = max(-1, filter_var($item->nodeValue, FILTER_SANITIZE_NUMBER_INT));
		    	//echo $cur . "<br>";
		    	if($cur){
		    		switch($i) {
		    			case 0://fat %
		    				$serving = $cur;
		    				break;
		    			case 1:
		    				
		    				break;
		    			case 2://sat %
		    				
		    				break;
		    			case 3://sodium %
		    				
		    				break;
		    			case 4://carb %
		    				
		    				break;
		    			case 5://fibre %
		    				
		    				break;
		    			case 6:
		    				$vitaminA = $cur;
		    				break;
		    			case 7:
		    				$vitaminC = $cur;
		    				break;
		    			case 8:
		    				$calcium = $cur;
		    				break;
		    			case 9:
		    				$iron = $cur;
		    				break;
		    		}
		    		$i++;
		    	}
		    }

		    //Name
		    $title = $dom->getElementsByTagName('h1');
		    foreach($title as $item) {
		    	//echo $item->nodeValue . "<br>";
		    	$name = $item->nodeValue;
		    	break; //GHETTO
		    }
		    $name = str_replace('Product Information: ', '', $name);

		    //Vegetarian and ingredients
		    $i = 0;
		    $vege = $dom->getElementsByTagName('dd');
		    foreach($vege as $item) {
		    	//echo $item->nodeValue . "<br>";
		    	switch($i){
		    		case 0: //Serving size
		    			
		    			break;
		    		case 1:
		    			$vegetarian = $item->nodeValue;
		    			break;
		    		case 2:
		    			$ingredients = $item->nodeValue;
		    			break;
		    	}
		    	$i++;
		    }
		    $vegetarian = $vegetarian == "Vegetarian";

		    $sql = "INSERT INTO food (name, serving, vegetarian, ingredients, calories, fat, saturated, cholestrol, sodium, carbohydrate, fibre, sugars, protein, vitaminA, vitaminC, calcium, iron, id) VALUES ('$name', '$serving', '$vegetarian', '$ingredients', '$calories', '$fat', '$saturated', '$cholestrol', '$sodium', '$carbohydrate', '$fibre', '$sugars', '$protein', '$vitaminA', '$vitaminC', '$calcium', '$iron', '$id');";
			//echo "Querying DB with: " . $sql . "<br>";
			if($conn->query($sql) === TRUE) {
				//echo "Query sucessful, URL: ". $url . " crawled.<br>";
			} else {
				//echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}

		for($x = $min_id; $x <= $max_id; $x++) {
			crawl_page("https://uwaterloo.ca/food-services/menu/product/" . $x, $x, $conn);
		}

		//Delete empty
		$sql = "DELETE from food where name = 'NAME'";
		if($conn->query($sql) === TRUE) {
				//echo "Removed null entries.<br>";
		} else {
				//echo "Error: " . $sql . "<br>" .$conn->error;
		}

		//Sort database by name
		$sql = "SELECT * FROM food ORDER BY name";
		if($conn->query($sql) === TRUE) {
			//echo "Sorted database.<br>";
		} else {
			//echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();

		//Display complete message
		echo "Crawl complete, " . ($max_id - $min_id + 1) . " entries crawled.<br>";
		echo "Have a nice day!<br>";
		echo "<img src='surprise.jpg width='600px' height='900px'>";
	?>
</body>

</html>