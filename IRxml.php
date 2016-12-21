<?php

$db = dbconn();
if($db){
  if (isset($_GET['org']) && ($_GET['org'] == 'parents')){
    if (isset($_GET['month'])){
      $month = $_GET['month'];
      $sql = "select orgcode from cases where socid like 'SOC-".$month."%' group by orgcode";
      $res = mysql_query($sql);
      $i=0;
      while($orgs[$i] = mysql_fetch_assoc($res)){
	$count = "select count(*) from cases where orgcode='".$orgs[$i]['orgcode']."' and socid like 'SOC-".$month."%'";
	$ersult = mysql_query($count);
	$casecount = mysql_fetch_row($ersult);
	$orgs[$i]['casecount'] = $casecount[0];
	$i++;
      }
    } else {
      $sql = "select orgcode from cases group by orgcode";
      $result = mysql_query($sql);
      $i=0;
      while($orgs[$i] = mysql_fetch_assoc($result)){
	$count = "select count(*) from cases where orgcode='".$orgs[$i]['orgcode']."'";
	$ersult = mysql_query($count);
	$casecount = mysql_fetch_row($ersult);
	$orgs[$i]['casecount'] = $casecount[0];
	$i++;
      }
      //  dump($orgs);
    }
  }


$i=0;
while ($i < count($orgs)){
  $parentOrg = substr($orgs[$i]['orgcode'], 0, 1);
  if ( $parentOrg == 'A'){ 
    $ACount = $orgs[$i]['casecount'] + $ACount;
    $Aorg = $parentOrg;
  }
  if ( $parentOrg == 'B'){ 
    $BCount = $orgs[$i]['casecount'] + $BCount;
    $Borg = $parentOrg;
  }
  if ( $parentOrg == 'C'){ 
    $CCount = $orgs[$i]['casecount'] + $CCount;
    $Corg = $parentOrg;
  }
  if ( $parentOrg == 'D'){ 
    $DCount = $orgs[$i]['casecount'] + $DCount;
    $Dorg = $parentOrg;
  }
  if ( $parentOrg == 'U'){ 
    $UCount = $orgs[$i]['casecount'] + $UCount;
    $Uorg = "Unknown";
  }
  if ( $parentOrg == 'G'){ 
    $GCount = $orgs[$i]['casecount'] + $GCount;
    $Gorg = "Guest";
  }
  $i++;
}
$Acolor = swatch(1);
$Bcolor = swatch(7);
$Ccolor = swatch(5);
$Dcolor = swatch(10);
$Ecolor = swatch(5);
$Gcolor = swatch(1);
$Ucolor = swatch(12);

if (isset($month)){
echo "<graph caption='".$month."' xAxisName='Org Code' yAxisName='Incidents' showNames='1' decimalPrecision='0' formatNumberScale='0'>\n";
} else {
echo "<graph caption='Incidents by Branch' xAxisName='Org Code' yAxisName='Incidents' showNames='1' decimalPrecision='0' formatNumberScale='0'>\n";
}
if (isset($Aorg)){
  if(isset($month)){
    echo "<set name='".$Aorg."' value='".$ACount."' color='".$Acolor."' link='".urlencode("drilldown.php?org=".$Aorg."&month=".$month)."' />\n";
  } else {
    echo "<set name='".$Aorg."' value='".$ACount."' color='".$Acolor."' link='".urlencode("drilldown.php?org=".$Aorg)."' />\n";
  }
}
if (isset($Borg)){
  if(isset($month)){
echo "<set name='".$Borg."' value='".$BCount."' color='".$Bcolor."' link='".urlencode("drilldown.php?org=".$Borg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Borg."' value='".$BCount."' color='".$Bcolor."' link='".urlencode("drilldown.php?org=".$Borg)."' />\n";
  }
}
if (isset($Corg)){
  if(isset($month)){
echo "<set name='".$Corg."' value='".$CCount."' color='".$Ccolor."' link='".urlencode("drilldown.php?org=".$Corg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Corg."' value='".$CCount."' color='".$Ccolor."' link='".urlencode("drilldown.php?org=".$Corg)."' />\n";
  }
}
if (isset($Dorg)){
  if(isset($month)){
echo "<set name='".$Dorg."' value='".$DCount."' color='".$Dcolor."' link='".urlencode("drilldown.php?org=".$Dorg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Dorg."' value='".$DCount."' color='".$Dcolor."' link='".urlencode("drilldown.php?org=".$Dorg)."' />\n";
  }
}
if (isset($Eorg)){
  if(isset($month)){
echo "<set name='".$Eorg."' value='".$ECount."' color='".$Ecolor."' link='".urlencode("drilldown.php?org=".$Eorg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Eorg."' value='".$ECount."' color='".$Ecolor."' link='".urlencode("drilldown.php?org=".$Eorg)."' />\n";
  }
}
if (isset($Gorg)){
  if(isset($month)){
echo "<set name='".$Gorg."' value='".$GCount."' color='".$Gcolor."' link='".urlencode("drilldown.php?org=".$Gorg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Gorg."' value='".$GCount."' color='".$Gcolor."' link='".urlencode("drilldown.php?org=".$Gorg)."' />\n";
  }
}
if (isset($Uorg)){
  if(isset($month)){
echo "<set name='".$Uorg."' value='".$UCount."' color='".$Ucolor."' link='".urlencode("drilldown.php?org=".$Uorg."&month=".$month)."' />\n";
  } else {
echo "<set name='".$Uorg."' value='".$UCount."' color='".$Ucolor."' link='".urlencode("drilldown.php?org=".$Uorg)."' />\n";
  }
}
echo "</graph>\n";
}

if (isset($_GET['org']) && ($_GET['org'] != 'parents')){
  $db = dbconn();
  if($db){
    $parentOrg = $_GET['org'];
    if(isset($_GET['month'])){
    $sql = "select orgcode from cases where orgcode like '".$parentOrg."%' and socid like 'SOC-".$_GET['month']."%' group by orgcode";
    } else {
      $sql = "select orgcode from cases where orgcode like '".$parentOrg."%' group by orgcode";
    }
    $result = mysql_query($sql);
    $i=0;
    if($result){
      if (isset($_GET['month'])){
      echo "<graph caption='Incidents for $parentOrg Orgs for the month of ".$_GET['month']."' xAxisName='Org Code' yAxisName='Incidents' showNames='1' decimalPrecision='0' formatNumberScale='0'>\n";
      } else {
      echo "<graph caption='Incidents for $parentOrg Orgs' xAxisName='Org Code' yAxisName='Incidents' showNames='1' decimalPrecision='0' formatNumberScale='0'>\n";
      }
      while ($kids[$i] = mysql_fetch_assoc($result)){
	if(isset($_GET['month'])){
	  $count = "select count(*) from cases where orgcode='".$kids[$i]['orgcode']."' and socid like 'SOC-".$_GET['month']."%'";    
	} else {
	  $count = "select count(*) from cases where orgcode='".$kids[$i]['orgcode']."'";    
	}
	$ersult = mysql_query($count);
	$casecount = mysql_fetch_row($ersult);
	$kids[$i]['casecount'] = $casecount[0];
	$kids[$i]['color'] = swatch($kids[$i]['casecount']);
	if(isset($kids[$i]['orgcode'])){
	echo "<set name='".$kids[$i]['orgcode']."' value='".$kids[$i]['casecount']."' color='".$kids[$i]['color']."' />\n";
	}
	$i++;
      }
      echo "</graph>\n";
    }
  }
}

if ((isset($_GET['catData'])) && (isset($_GET['month']))){
  $catdata = getCatData($_GET['month']);
  dump($catdata);
}
?>

<?php // functions

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

function dump($var){
  echo '<table><tr><td><pre style="border: 1px solid black; padding: 5px;">'
    . print_r($var, true)
    . '</pre></td></tr></table>';
  
}

function scrub($var){
  $trimmed = trim($var);
  $scrubbed = mysql_real_escape_string($trimmed);
  $cleansed = str_replace("/", "-", $scrubbed);
  return $cleansed;
}

function swatch($number){
    if ($number < '3'){
      $color = "138300";
    }
    if (($number >= '3') and ($number <= '5')){
      $color = "FBFF00";
    }
    if (($number >= '6') and ($number <= '8')){
      $color = "FFAA00";
    }
    if ($number >= '9'){
      $color = "FF0000";
    }
    return $color;
}

function getCatData($month){
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

?>