<html>

<link rel="stylesheet" type="text/css" href="final.css">
<link rel="shortcut icon" href="http://www.cloud9assist.com/wp-content/uploads/2015/11/Favicon-Cloud-9-Assist.png">

<body>
<title>aurora</title>
past results 
</body>
</html>

<?php
	$host = "host=ec2-54-235-155-172.compute-1.amazonaws.com";
	$database = "dbname=d42vc9uuq4onvt";
	$user = "user=mnmyxcvgmagfor";
	$port = "port=5432";
	$password = "password=5UtVVXFzzSYzI9iSBezqU57CIo";
	$db = pg_connect($host." ".$database." ".$user." ".$port." ".$password." ".$db);

	if (!$db){
		echo "Could not connect";
	}

	//create a table
// 	$query = <<<EOF
// 			 CREATE TABLE results(
// 			 Time varchar(255),
// 			Name varchar(255),
// 			Weather varchar(255)
// 			)
// EOF;

	//insert things into table 
	 $query="INSERT INTO results(Time, Name, Weather) VALUES ('$_POST[t]', '$_POST[n]', '$_POST[w]')";

	$val = pg_query($db,$query);
	if(!$val){
		echo pg_last_error($db);
	}
	else{
		echo "";
	}
	
	//show table 
	$query = 'select * from results';

	$result = pg_query($db, $query);
	
	$i = 0;
	echo '<html><body><table><tr>';
	while ($i < pg_num_fields($result))
	{
		$fieldName = pg_field_name($result, $i);
		echo '<td>' . $fieldName . '</td>';
		$i = $i + 1;
	}
	echo '</tr>';
	$i = 0;
	
	while ($row = pg_fetch_row($result)) 
	{
		echo '<tr>';
		$count = count($row);
		$y = 0;
		while ($y < $count)
		{
			$c_row = current($row);
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '</tr>';
		$i = $i + 1;
	}
	pg_free_result($result);
	
	echo '</table></body></html>';
?>