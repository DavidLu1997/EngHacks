<html>

<head>
	<title>WatChew Database Crawler</title>
</head>

<body>
	<?php
		//Min and Max IDs for foods
		$min_id = 1000;
		$max_id = 1001;
		function crawl_page($url)
		{
		    $seen[$url] = true;

		    $dom = new DOMDocument('1.0');
		    @$dom->loadHTMLFile($url);
		    echo "URL:",$url,PHP_EOL,"CONTENT:",PHP_EOL,$dom->saveHTML(),PHP_EOL,PHP_EOL;
		}

		for($x = $min_id; $x <= $max_id; $x++) {
			crawl_page("https://uwaterloo.ca/food-services/menu/product/" . $x, 0);
		}
	?>
</body>

</html>