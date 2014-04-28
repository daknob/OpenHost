<?php

	/*
		Checking my code, eh?
		I hope you like it..
		How awesome is it, right?
		To see more of it, go to
		github.com/DaKnOb
		and
		daknob.net

		Thanks fellow code guy ;)
	*/

	$checks = file_get_contents("session");
	$hosts	= file_get_contents("hosts");
	$hsts 	= explode("\n", $hosts);
	unset($hosts);
	$output = "<table><tr><th style='background-color:rgb(200,200,200);'>Hostname</th><th style='background-color:rgb(200,200,200);'>Uptime</th><th>Status</th><th>Users</th><th>Filesystem</th><th>RAM</th></tr>";
	$tm = time();
	foreach ($hsts as $host) {
		if ($host=="")continue;
		$pcnt = round(100 * intval(file_get_contents("uptimes/$host")) / intval($checks), 2);
		$r = round(255-$pcnt*2.5,0);
		$g = round($pcnt*2.5,0);
		$b = 0;	/* Future Support */
		$live = file_get_contents("status/$host");
		$output = $output . "<tr><td style='background-color:rgb(220,220,220);'>$host</td><td style='color:#fff;background-color:rgb($r,$g,$b);'>" . $pcnt  . "%</td>";
		if($live=="1\n"){
			$output = $output . "<td style='color:#fff;background-color:#0a0;'>Online</td>";
		}else{
			$output = $output . "<td style='color:#fff;background-color:#a00;'>Offline</td>";
		}
		$users = file_get_contents("uid/$host");
		$r = round( intval($users) * 12.5  ,0);
		$g = round( 255 - intval($users) * 12.5  ,0);
		$output = $output . "<td style='color:#fff;background-color:rgb($r,$g,$b);'>$users</td>";
		
		if($host == "hostwithoutmount1" || $host == "hostwithoutmount2" || $host == "host3"){
			$output = $output . "<td style='color:#fff;background-color:#e18e00;'>Unmounted</td>";
		}elseif($tm - filemtime("uid/$host") > 120){
			$output = $output . "<td style='color:#fff;background-color:#a00;'>Unmounted<br/>(Since " . date("d/m/Y G:i:s",filemtime("uid/$host"))  .")</td>";
		}else{
			$output = $output . "<td style='color:#fff;background-color:#0a0;'>Mounted</td>";	
		}
	
		try{
			$f = explode("@", file_get_contents("ram/$host"));
			if($f[0] == 0){
				$output .= "<td style='color:#fff;background-color:#e18e00;'>?</td>";
			}else{
				$g = round(255 * floatval($f[0]) / floatval($f[1]),0);
				$r = 255-$g;
				$output .= "<td style='color:#fff;background-color:rgb($r,$g,0);'>$f[0] / $f[1] GB</td>";
			}
		}catch (Exception $err){
			$output .= "<td style='color:#fff;background-color:#aa0;'>?</td>";
		}

		$output = $output . "</tr>";
}
	$output = $output . "<tr><th style='background-color:rgb(200,200,200);'>Checks</th><td style='background-color:#5ac8fb' colspan='5'>$checks</td></tr></table>";

	/* 
		Psst! Still here?
		Don't worry. This is not how
		I normally write code.
		It's just that I am from my
		mobile phone now :)
	*/
?>
<html>
	<head>
		<title>OpenHost :: DaKnOb</title>
		<style>
			body{
				background-color:rgb(240,240,240);
			}
			a{
				text-decoration:none;
				color:rgb(55,200,0);
			}
			th{
				background-color:rgb(200,200,200);
			}
			td{
				padding:2px;
				text-align:center;
			}
		</style>
	</head>
	<body>
		<center>
		<h2>CSD Computer Uptimes</h2>
		<?php
			print $output;
		?>
		<br/><br/>Made by <a href="http://daknob.net/">DaKnOb</a>.<br/> Running since <em>The Big Bang</em>.
		</center>
	</body>
</html>
