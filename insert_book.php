<?php
$host = $argv[1];
$database = $argv[2];
$user = $argv[3];
$password = $argv[4];

libxml_use_internal_errors(true);

//table structure
//entry_id, word, text

$db = mysql_connect($host, $user, $password) or die("Not connected to database");
$rs = mysql_select_db($database, $db) or die("No Database");
mysql_query("set names utf8");
mysql_query("DROP TABLE IF EXISTS habba");
mysql_query("CREATE TABLE habba (book_id varchar(10), entry_id varchar(10), book_title varchar(100), text varchar(500000)) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");

$books = scandir('books');
foreach($books as $book)
{
	if($book == '.' || $book == '..') continue;
	$files = scandir('books/'.$book.'');
	foreach($files as $file)
	{
		if($file == '.' || $file == '..') continue;
		$htmlFileName = 'books/' . $book . '/' . $file;
		$name = (explode(".", $file));
		$bookid = $book;
		//~ $bookid = $book . '_' . $name[0];
		
		if ($htmlFileName === false)
		{
			echo "Failed loading XML: ";
			foreach(libxml_get_errors() as $error) 
			{
				echo "<br>", $error->message;
			}
		}
		else 
		{
			$text = file_get_contents($htmlFileName);
			$text = str_replace("\n", "", $text);
			$text = str_replace("\t", "", $text);
			$text = str_replace("<div id=\"getFixed\">", "", $text);
			$text = str_replace("<input type=\"button\" class=\"increase\" value=\" A+ \"/>", "", $text);
			$text = str_replace("<input type=\"button\" class=\"decrease\" value=\" A- \"/>", "", $text);
			$text = str_replace("<input type=\"button\" class=\"resetMe\" value=\" A \"/>", "", $text);
			$text = preg_replace("/<span class=\"pageNum\">(.*?)<\/span>/", "", $text);
			$text = preg_replace("/<span class=\"pageNum left\">(.*?)<\/span>/", "", $text);
			
			preg_match('#<div class="HabbaTitle" id="(.*?)"><span>(.*?)<\/span>#', $text, $match);
			$book_title = $match[2];
			echo $book_title . "\n";
			echo $file . "\n";
			$query = "INSERT INTO habba VALUES('$bookid', '$name[0]', '$book_title', '$text')";
			mysql_query($query) or die("Query Problem" . mysql_error() . "\n");
		}
	}
}
?>
