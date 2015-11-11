<?php


try{
	
$connect = odbc_connect("ESPA", "delsemore", "Edina1210"); 

 $sql = "SELECT   PeopleID, Surname, Firstname,Title, JobTitle, Organisation, Department, Country from  dbo.People";

 # perform the query
$result = odbc_exec($connect, $sql);
 $i=1;
 $dois = ' PeopleID,Surname,Firstname,Title,JobTitle,Organisation,Department, Country' . PHP_EOL;
  
while(odbc_fetch_row($result)) {
	
	
	
$dois .= '"' . odbc_result($result,'PeopleID') .  '","' . odbc_result($result,'Surname') .  '","' . odbc_result($result,'Firstname') . '","' . odbc_result($result,'Title') . '","' . odbc_result($result,'Jobtitle') . '","' . odbc_result($result,'Organisation') . '","' . odbc_result($result,'Department') . '","' . odbc_result($result,'Country') .  '"' . PHP_EOL;
	 //	echo $i . ' - ' . odbc_result($result,'doi') . "<br>";
	 $i++;
        }
$my_file = '/home/espaweb/public_docs/files/private/people.csv';
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