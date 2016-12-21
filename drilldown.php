<?php
$chartswf = "FCF_Column3D.swf";

if(isset($_GET['org'])){
  $xmlquery = urlencode("IRxml.php?org=".$_GET['org']);
}
if(isset($_GET['month'])){
  $xmlquery = urlencode("IRxml.php?org=".$_GET['org']."&month=".$_GET['month']);
}
?>

<html>
   <head>
      <title>Incident Data Details</title>
   </head>
   <body bgcolor="#ffffff">
  <table width='100%' height='100%' align='center' border='0'>
<tr><td align='center'>
    <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="800" height="500" id="Column3D" >
         <param name="movie" value="FusionCharts/<?php echo $chartswf ?>" />
         <param name="FlashVars" value="&dataURL=<?php echo $xmlquery ?>&chartWidth=1000&chartHeight=500">
         <param name="quality" value="high" />
         <embed src="FusionCharts/<?php echo $chartswf ?>" flashVars="&dataURL=<?php echo $xmlquery ?>&chartWidth=1000&chartHeight=500" quality="high" width="1000" height="500" name="Column3D" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
      </object>
</td></tr>
<tr><td align='center'><a href='index.php'>Home</a></td></tr>
</table>
</body>
</html>