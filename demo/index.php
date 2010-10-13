<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Lagler/Switzer Biggest Loser Game</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="biggest loser" />
<meta name="description" content="This is simply a little family game." />
<link href="/styles/alanswitzer.css" rel="stylesheet" type="text/css" />
<link href="styles/challenge.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script> 
<script type="text/javascript"> 
$(document).ready(function(){
function smartColumns() { 
	// a function that calculates the smart columns
        // Reset column size to a 100% once view port has been adjusted
	$("ul.column").css({ 'width' : "100%"});

	var colWrap = $("ul.column").width(); //Get the width of row
	var colNum = Math.floor(colWrap / 200); //Find how many columns of 200px can fit per row / then round it down to a whole number
	var colFixed = Math.floor(colWrap / colNum); //Get the width of the row and divide it by the number of columns it can fit / then round it down to a whole number. This value will be the exact width of the re-adjusted column

	$("ul.column").css({ 'width' : colWrap}); //Set exact width of row in pixels instead of using % - Prevents cross-browser bugs that appear in certain view port resolutions.
	$("ul.column li").css({ 'width' : colFixed}); //Set exact width of the re-adjusted column	
}	

smartColumns();//Execute the function when page loads

$(window).resize(function () { 
	//Each time the viewport is adjusted/resized, execute the function
	smartColumns();
  });
});
</script>
</head>
<body background="../images/background-lines.gif" >

<div id="centerContent">
<div id="contestContainer" class="std-font-std">
  <h2 align="center">Biggest Loser Season 10 Challenge</h2>
  
  <div id="challengeInfo">
<?php
		require 'includes/database.php';
		$adminEmail = "alan@alanswitzer.com";
		
		$sql = "select * from biggestloser where active=1 and player is not null";
    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
        $totalContestants = mysql_num_rows($query);
		echo '<p>Total # of contestants remaining: ' .  $totalContestants . '</p>';

        echo '<p class="Amy">Amy\'s chances of winning: ';
		$sql = "select * from biggestloser where active=1 and player=\"Amy\"";
    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
        $percentage = mysql_num_rows($query) / $totalContestants;
		echo  round($percentage * 100) . '%</p>';

        echo '<p class="Karl">Karl\'s chances of winning: ';
		$sql = "select * from biggestloser where active=1 and player=\"Karl\"";
    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
        $percentage = mysql_num_rows($query) / $totalContestants;
        echo  round($percentage * 100) . '%</p>';

        echo '<p class="Carrie">Carrie\'s chances of winning: ';
		$sql = "select * from biggestloser where active=1 and player=\"Carrie\"";
    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
        $percentage = mysql_num_rows($query) / $totalContestants;
        echo  round($percentage * 100) . '%</p>';

        echo '<p class="Alan">Alan\'s chances of winning: ';
		$sql = "select * from biggestloser where active=1 and player=\"Alan\"";
    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
        $percentage = mysql_num_rows($query) / $totalContestants;
        echo  round($percentage * 100) . '%</p>';
?>
  </div>

<?php
$directory = 'images';

try
{
	require 'classes/ThumbnailImage.php';

	$ctr = 0;
    echo '<p><strong>Contestant Photos:</strong></p>';
	echo '<ul class="column">';
	
	foreach ( new DirectoryIterator($directory) as $item )
	{
		$sql = "select * from biggestloser where image='" . $item . "'";

    	$query = mysql_query($sql) or die ("<br>Query failed - " .  mysql_error() . " Please contact " . $adminEmail);
		$row = mysql_fetch_assoc($query);
		
		if ($item->isFile()) {
			$size = 75;  
			$path = "$directory/".$item; 
		  
			// Call function to create thumbnails during page load - returns binary image 
			echo "<li><div class=\"block ";
			if ($row['active'] == 0)
				echo 'eliminated">';
			else
			    echo $row['player'] . "\">";
            
			echo "<a href=\"$path\" rel=\"lightbox[playoffs]\">";
        	echo "<img src=\"$path\" ".
          		 "alt= \"$item\" title= \"$item\" " .
				 "class=\"" . $row['player'] . "\" />";
		  	echo "</a> Name: " . $row['name'];
			
			if ($row['active'] == 0)
				echo '&nbsp;<span style="opacity: 1.0; color: red;">ELIMINATED</span>';
			
			echo "</div></li>";
		}
	}
}
catch(Exception $e) {
	echo '<p>No images found.</p>';
}
echo '</ul>';
?>

</div>
<br clear="all" /> 

 <div align="center" class="std-font-std">Last updated: 
<?php
$filemod = filemtime(__FILE__);
$filemodtime = date("D, F-j-Y", $filemod);
Print("$filemodtime"); 
?> </div>

<!-- Start of footer -->
<div id="footer" class="std-font-std">
This site has no direct affiliation or connection with NBC, or the
  Biggest Loser network television show.<br />

&copy; 2009-2010 <a href="http://www.decatech.com/" target="_blank">DecaTech
Solutions</a>
</div>
</div>

</body>
</html>