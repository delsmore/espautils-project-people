<?php

//include 'conn-local.php';
include 'conn-rir.php';
try{
	
 $dbh = new PDO("sqlsrv:Server=$server;Database=Results", $username, $password);

 $sql = "SELECT   PeopleID, Surname, Firstname,Title, JobTitle, Organisation, Department, Country from  dbo.People";

 
 $i=1;
 $dois = ' PeopleID,Surname,Firstname,Title,JobTitle,Organisation,Department, Country' . PHP_EOL;
  
    foreach ($dbh->query($sql) as $row)    {
	
	
	

	
  	$dois .= '"' . $row['PeopleID'] .  '","' . $row['Surname'] .  '","' . $row['Firstname'] . '","' . $row['Title'] . '","' . $row['JobTitle'] . '","' . $row['Organisation'] . '","' . $row['Department'] . '","' . $row['Country'] .  '"' . PHP_EOL;
	 //	echo $i . ' - ' . $row['doi'] . "<br>";
	 $i++;
        }
$my_file = 'files/people.csv';

if (file_exists($my_file)) {
	
	rename($my_file, "files/people-" . date('Y-m-d'). ".csv");
}

$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file

fwrite($handle, $dois);

//echo 'pubs written to ' . $my_file . '<br><br>';

$dbh = null;
}catch(PDOException $e){
   echo 'Failed to connect to database: ' . $e->getMessage() . "\n";
   exit;
}
print 'people.csv created';
?>