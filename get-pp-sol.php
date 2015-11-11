<?php

try{
	
$connect = odbc_connect("EDINAImports", "delsemore", "Edina1210"); 

 $sql = "SELECT    * from   dbo.view_ProjectPeople";

# perform the query
$result = odbc_exec($connect, $sql);
 
 $i=1;
 $dois = ' LeadProjectRef,SafeCode, ProjectTitle, PeopleID,ProjectPeopleID,Surname,Firstname,Title,JobTitle,Organisation,Department, Country, RoleName, RoleCode,RoleOrder' . PHP_EOL;
  
while(odbc_fetch_row($result)) {
	

	
	$code = strtolower(odbc_result($result,'LeadProjectRef'));
	$safecode = str_replace('/','-',$code);
	$ppid = $safecode . '-' . odbc_result($result,'PeopleID');

	
  	$dois .= '"' . odbc_result($result,'LeadProjectRef'). '","' . $safecode . '","' . odbc_result($result,'ProjectTitle') . '","' . odbc_result($result,'PeopleID') . '","' . $ppid . '","' . odbc_result($result,'Surname') .  '","' . odbc_result($result,'Firstname') . '","' . odbc_result($result,'Title') . '","' . odbc_result($result,'Jobtitle') . '","' . odbc_result($result,'Organisation') . '","' . odbc_result($result,'Department') . '","' . odbc_result($result,'Country') . '","' . odbc_result($result,'RoleName') . '","' . odbc_result($result,'RoleCode') . '","' . odbc_result($result,'RoleOrder') . '"' . PHP_EOL;
	 //	echo $i . ' - ' . odbc_result($result,'doi') . "<br>";
	 $i++;
        }
$my_file = '/home/espaweb/public_docs/files/private/project-people.csv';
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