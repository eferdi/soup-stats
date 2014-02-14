<?php
	require("vendor/autoload.php");

	$mainUrl = "http://<user>.soup.io";
	$loopStop = $mainUrl;
	$url = $mainUrl;
	$next = null;
	$x=1;
	$timeStart = microtime(true);
	while($next != $loopStop)
	{
		if(null !== $next)
		{
			$url = $next;
		}

        echo $url . "\n";

		$html = htmlqp($url);
		//$nextButton = $html->find(".paginationbottom a");
		$nextButton = $html->find("a.more");		

		$nextLink = $nextButton->attr("href");

		$next = explode('?', $nextLink);
		$next = $mainUrl . $next[0];
		//echo "<a href=\"" . $next . "\">" . $next . "</a><br/>";

		/*/
		if($x < 20)
		{
			$x++;
		}
		else
		{
			break;
		}
		//*/		
	}
	$timeEnd = microtime(true);
	$runtime = $timeEnd - $timeStart;
	echo "runtime " . $runtime;
?>
