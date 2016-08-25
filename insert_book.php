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
mysql_query("CREATE TABLE habba (book_id varchar(10), text varchar(500000)) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");

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
			$doc = new DOMDocument();
			$doc->loadHTMLFile($htmlFileName);
			$text = addslashes($doc->saveHTML());
			$query = "INSERT INTO habba VALUES('$bookid', '$text')";
			mysql_query($query) or die("Query Problem" . mysql_error() . "\n");
		}
	}
}
?>
