<?php

function dbconn(){
  require_once 'DB.php';
  PEAR::setErrorHandling(PEAR_ERROR_DIE);
  $db_host = 'localhost';
  $db_user = 'IRtracker';
  $db_pass = 'sasquatCH';
  $db_name = 'IRtracker';
  $dsn = "mysql://$db_user:$db_pass@$db_host/$db_name";
  $db = DB::connect($dsn);
  $db->setFetchMode(DB_FETCHMODE_OBJECT);
  return $db;
  $db->disconnect();
  }

function fixmonth($m){
  if (strlen($m) < 2){
    $m = "0".$m;
  }
  return $m;
}

$month1 = date('m');
$month1 = fixmonth($month1);
$year = date('Y');

if($month1 == 1){
  $date1 = "$year$month1";
  $year = date('Y')-1;
  $month2 = date('m')+11;
  $date2 = "$year$month2";
  $month3 = date('m')+10;
  $date3 = "$year$month3";
}  
if($month1 == 2){
  $date1 = "$year$month1";
  $month2 = date('m')-1;
  $month2 = fixmonth($month2);
  $date2 = "$year$month2";
  $year = date('Y')-1;
  $month3 = date('m')+10;
  $date3 = "$year$month3";
}
if($month1 >= 3){
  $date1 = "$year$month1";
  $month2 = date('m')-1;
  $month2 = fixmonth($month2);
  $date2 = "$year$month2";
  $month3 = date('m')-2;
  $month3 = fixmonth($month3);
  $date3 = "$year$month3";
}

$chartswf  = "FCF_Pie2D.swf";
$dataurl   = urlencode("IRxml.php?org=parents");
$thismonth = urlencode("IRxml.php?org=parents&month=".$date1);
$lastmonth = urlencode("IRxml.php?org=parents&month=".$date2);
$monthb4   = urlencode("IRxml.php?org=parents&month=".$date3);

function getCatData($month){
  $db = dbconn();
  $sql = "select category from cases group by category";
  $res = mysql_query($sql);
  $i = 0;
  while ($catData[$i] = mysql_fetch_assoc($res)){
    $count = "select caseid from cases where category='".$catData[$i]['category']."' and socid like 'SOC-".$month."%'";
    $thismany = mysql_query($count);
    $catData[$i]['count'] = mysql_num_rows($thismany);
    $i++;
  }
  return $catData;
}
$catData1 = getCatData($date1);
$catData2 = getCatData($date2);
$catData3 = getCatData($date3);


?>
<html>
   <head><link rel='stylesheet' type='text/css' href='styles/dashy.css'>
      <title>Incident Data by Org</title>
   </head>
   <body bgcolor="#ffffff">
  <table width='100%' align='left' border='0'>
<tr>
<td width='50%' align='center'>
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="300" height="300" id="Pie2D" >
         <param name="movie" value="FusionCharts/<?php echo $chartswf ?>" />
         <param name="FlashVars" value="&dataURL=IRxml.php?org=parents&chartWidth=500&chartHeight=500">
         <param name="quality" value="high" />
         <embed src="FusionCharts/<?php echo $chartswf ?>" flashVars="&dataURL=IRxml.php?org=parents&chartWidth=500&chartHeight=500" quality="high" width="500" height="500" name="MmmmBranchPie" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
</td>
<td width='50%' align='left'>
  <table border='0'>
<tr><td>
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="200" height="200" id="Pie2D">
         <param name="movie" value="FusionCharts/<?php echo $chartswf ?>" />
         <param name="FlashVars" value="&dataURL=<?php echo $thismonth ?>&chartWidth=200&chartHeight=200">
         <param name="quality" value="high" />
         <embed src="FusionCharts/<?php echo $chartswf ?>" flashVars="&dataURL=<?php echo $thismonth ?>&chartWidth=200&chartHeight=200" quality="high" width="400" height="200" name="MonthlyPie" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
  </td>
<td>
<?php 
  echo "<table id='catData'>\n";
echo "<th>Category</th><th>Count</th>\n";
  $i=0;
while($i < count($catData1)){
    echo "<tr><td>".$catData1[$i]['category']."</td><td>".$catData1[$i]['count']."</td></tr>";
    $i++;
  }
    echo "</table>\n";
?>
</td>
</tr>
<tr><td>
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="200" height="200" id="Pie2D">
         <param name="movie" value="FusionCharts/<?php echo $chartswf ?>" />
         <param name="FlashVars" value="&dataURL=<?php echo $lastmonth ?>&chartWidth=200&chartHeight=200">
         <param name="quality" value="high" />
         <embed src="FusionCharts/<?php echo $chartswf ?>" flashVars="&dataURL=<?php echo $lastmonth ?>&chartWidth=200&chartHeight=200" quality="high" width="400" height="200" name="MonthlyPie" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
  </td>
<td>
<?php 
  echo "<table id='catData'>\n";
echo "<th>Category</th><th>Count</th>\n";
  $i=0;
while($i < count($catData2)){
    echo "<tr><td>".$catData2[$i]['category']."</td><td>".$catData2[$i]['count']."</td></tr>";
    $i++;
  }
    echo "</table>\n";
?>
</td>
</tr>
<tr><td>
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="200" height="200" id="Pie2D">
         <param name="movie" value="FusionCharts/<?php echo $chartswf ?>" />
         <param name="FlashVars" value="&dataURL=<?php echo $monthb4 ?>&chartWidth=200&chartHeight=200">
         <param name="quality" value="high" />
         <embed src="FusionCharts/<?php echo $chartswf ?>" flashVars="&dataURL=<?php echo $monthb4 ?>&chartWidth=200&chartHeight=200" quality="high" width="400" height="200" name="MonthlyPie" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
  </td>
<td>
<?php 
  echo "<table id='catData'>\n";
echo "<th>Category</th><th>Count</th>\n";
  $i=0;
while($i < count($catData3)){
    echo "<tr><td>".$catData3[$i]['category']."</td><td>".$catData3[$i]['count']."</td></tr>";
    $i++;
  }
    echo "</table>\n";
?>
</td>
<td align='center'>
<table id='catList'>
<tr><th>Category</th><th>Description</th></tr>
<tr><td>0</td><td>Exercise/Network Defense Testing</td></tr>
<tr><td>1</td><td>Unauthorized Access</td></tr>
<tr><td>2</td><td>Denial of Service (DoS)</td></tr>
<tr><td>3</td><td>Malicious Code</td></tr>
<tr><td>4</td><td>Improper Usage</td></tr>
<tr><td>5</td><td>Scans/Probes/Attempted Access</td></tr>
<tr><td>6</td><td>Investigations</td><tr>
<tr><td>7</td><td>Non-Incident</td></tr>
</table>
</td>
</tr>
  </table>
</td>
</tr>
</table>
</body>
</html>