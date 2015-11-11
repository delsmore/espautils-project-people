<?php

//include 'conn-local.php';
include 'conn-rir.php';
try{
	
 $dbh = new PDO("sqlsrv:Server=$server;Database=EDINAImports", $username, $password);

 $sql = "SELECT    * from   dbo.view_ProjectPeople";

 
 $i=1;
 $dois = ' LeadProjectRef,SafeCode, ProjectTitle, PeopleID,ProjectPeopleID,Surname,Firstname,Title,JobTitle,Organisation,Department, Country, RoleName, RoleCode,RoleOrder' . PHP_EOL;
  
    foreach ($dbh->query($sql) as $row)    {
	
	
	$code = strtolower($row['LeadProjectRef']);
	$safecode = str_replace('/','-',$code);
	$ppid = $safecode . '-' . $row['PeopleID'];

	
  	$dois .= '"' . $row['LeadProjectRef']. '","' . $safecode . '","' . $row['ProjectTitle'] . '","' . $row['PeopleID'] . '","' . $ppid . '","' . $row['Surname'] .  '","' . $row['Firstname'] . '","' . $row['Title'] . '","' . $row['JobTitle'] . '","' . $row['Organisation'] . '","' . $row['Department'] . '","' . $row['Country'] . '","' . $row['RoleName'] . '","' . $row['RoleCode'] . '","' . $row['RoleOrder'] . '"' . PHP_EOL;
	 //	echo $i . ' - ' . $row['doi'] . "<br>";
	 $i++;
        }
		
		
$my_file = 'project-people.csv';

if (file_exists($my_file)) {
	
	rename($my_file, "project-people-" . date('Y-m-d'). ".csv");
}

$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); //implicitly creates file

fwrite($handle, $dois);

//echo 'pubs written to ' . $my_file . '<br><br>';

$dbh = null;
}catch(PDOException $e){
   echo 'Failed to connect to database: ' . $e->getMessage() . "\n";
   exit;
}
print 'done';
?>