<?php

include 'conn.php';

try{
	
 $dbh = new PDO("sqlsrv:Server=$server;Database=ESPA_Replicated", $username, $password);

 $sql = "SELECT    * from   dbo.view_ProjectCountry";

 
 $i=1;
 $dois = ' ProjectCode,SafeCode,uid,CountryName,Alpha2,Lat,Lon,ProjectTitle' . PHP_EOL;
  
    foreach ($dbh->query($sql) as $row)    {
	
	
	$code = strtolower($row['ProjectCode']);
	$safecode = str_replace('/','-',$code);
	$uid = $safecode . '-' . $row['CountryName'];
	$alpha2 = strtolower($row['Alpha2']);
	$lat = $row['LatAverage'];
	$lon = $row['LonAverage'];
	
  	$dois .= '"' . $code . '","' . $safecode . '","' . $uid . '","' . $row['CountryName'] .   '","' .$alpha2 . '","' . $lat . '","' . $lon . '","' . $row['ProjectTitle'] . '"' . PHP_EOL;
	 //	echo $i . ' - ' . $row['doi'] . "<br>";
	 $i++;
        }
$my_file = 'project-country.csv';
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