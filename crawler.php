<html>

<head>
	<title>WatChew Database Crawler</title>
</head>

<body>
	<?php
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
			if($conn->query("delete from food;") === TRUE){
				echo "Table cleared. <br>";
			}
			else {
				echo "Error: delete from food;" . "<br>" .$conn->error;
			}
		}

		//Min and Max IDs for foods
		$min_id = 1000;
		$max_id = 1001;
		function crawl_page($url, $id, $conn)
		{
			echo "Crawling: " . $url . "<br>";
		    $seen[$url] = true;

		    $dom = new DOMDocument('1.0');
		    @$dom->loadHTMLFile($url);

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
		    	echo $cur . "<br>";
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
		    	echo $cur . "<br>";
		    	if($cur){
		    		switch($i) {
		    			case 0:
		    				$vitaminA = $cur;
		    				break;
		    			case 1:
		    				$vitaminC = $cur;
		    				break;
		    			case 2:
		    				$calcium = $cur;
		    				break;
		    			case 3:
		    				$iron = $cur;
		    				break;
		    		}
		    		$i++;
		    	}
		    }

		    $sql = "INSERT INTO food (name, serving, vegetarian, ingredients, calories, fat, saturated, cholestrol, sodium, carbohydrate, fibre, sugars, protein, vitaminA, vitaminC, calcium, iron, id) VALUES ('$name', '$serving', '$vegetarian', '$ingredients', '$calories', '$fat', '$saturated', '$cholestrol', '$sodium', '$carbohydrate', '$fibre', '$sugars', '$protein', '$vitaminA', '$vitaminC', '$calcium', '$iron', '$id');";
			echo "Querying DB with: " . $sql . "<br>";
			if($conn->query($sql) === TRUE) {
				echo "Query sucessful, URL: ". $url . " crawled.<br>";
			} else {
				echo "Error: " . $sql . "<br>" .$conn->error;
			}
		}

		for($x = $min_id; $x <= $max_id; $x++) {
			crawl_page("https://uwaterloo.ca/food-services/menu/product/" . $x, $x, $conn);
		}
	?>
</body>

</html>