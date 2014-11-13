<?php
	require_once(dirname(__FILE__).'/library/PHP-PDO-Wrapper/PdoWrapper.class.php');
	require_once(dirname(__FILE__).'/library/ts3delete.class.php');
	require_once(dirname(__FILE__).'/ts3delete.settings.php');

	$ts3del = new ts3delete(settingsSQL::HostName, settingsSQL::DataBase, settingsSQL::CharSet, settingsSQL::UserName, settingsSQL::PassWord, settingsSQL::Table);

	$dbChannelList = $ts3del->getDbAllData();
	$body          = '';

	if ( is_array($dbChannelList) )
	{
		foreach ( $dbChannelList as $key => $value )
		{
			if ( (time() - $value['lastTime']) >= settingsTS3::WarnTime )
			{
				$time  = date('Y/m/d H:i:s', $value['lastTime'] + settingsTS3::DeleteTime);
				$name  = htmlspecialchars($value['channelName'], ENT_QUOTES, 'UTF-8');
				$body .= "<tr><td>${value['channelID']}</td><td>${name}</td><td>${time}</td></tr>";
			}
		}
	}

	$body = $body === '' ? '<tr><td></td><td>Did not exist.</td><td></td></tr>' : $body;
?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		<meta name="robots" content="noindex, nofollow">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css">

		<link rel="shortcut icon" href="./img/logo.png">
		<link rel="apple-touch-icon" href="./img/logo.png">
		<link rel="apple-touch-icon-precomposed" href="./img/logo.png">

		<title>TeamSpeak3 Auto Channel Deleter</title>
		<style>
			body {
				background-color: #111;
				color: #fff;
			}

			header {
				text-align: center;
			}

			footer {
				padding-top: 15px;
			}

			footer > .container {
				width: 100%;
				height: 120px;
				background-color: #1a1a1a;
				padding-top: 30px;
				padding-left:50px;
			}

			.table-hover > tbody > tr:hover > td {
				background-color: #383838;
			}

			.sorthead {
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<header>
			<h1>Your Server Name</h1>
			<p>TeamSpeak3 Auto Channel Deleter</p>
		</header>

		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
						<table class="table table-hover" id="channelList">
							<thead>
								<th class="sorthead" data-sort="int">Channel ID</th>
								<th class="sorthead" data-sort="string">Channel Name</th>
								<th class="sorthead" data-sort="string">Delete Date</th>
							</thead>
							<tbody>
								<?php echo $body ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<footer id="footer">
			<div class="container">
				<p class="text-muted credit">
					Powered by <a href="https://php.net">php</a> &amp; <a href="https://www.mysql.com">MySQL</a> &amp; <a href="http://ts3admin.info">ts3admin.class</a><br>
					Created by <a href="http://hoshinoa.me">k725</a> / View on <a href="https://github.com/k725/TeamSpeak3-ChannelDelBot">Github</a>
				</p>
			</div>
		</footer>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/stupidtable/0.0.1/stupidtable.min.js"></script>
		<script>
			$('#channelList').stupidtable();
			/* footerFixed.js MIT-style license. 2007 Kazuma Nishihata [to-R] http://blog.webcreativepark.net */
			new function(){function h(){document.getElementsByTagName("body");document.getElementById(a).style.top="0px";var d=document.getElementById(a).offsetTop,b=document.getElementById(a).offsetHeight;if(window.innerHeight){var f=window.innerHeight}else{document.documentElement&&0!=document.documentElement.clientHeight&&(f=document.documentElement.clientHeight)}d+b<f&&(document.getElementById(a).style.position="relative",document.getElementById(a).style.top=f-b-d-1+"px")}function c(g){var f=document.createElement("div"),i=document.createTextNode("S");f.appendChild(i);f.style.visibility="hidden";f.style.position="absolute";f.style.top="0";document.body.appendChild(f);var d=f.offsetHeight;setInterval(function(){d!=f.offsetHeight&&(g(),d=f.offsetHeight)},1000)}function e(f,g,j){try{f.addEventListener(g,j,!1)}catch(i){f.attachEvent("on"+g,j)}}var a="footer";e(window,"load",h);e(window,"load",function(){c(h)});e(window,"resize",h)};
		</script>
	</body>
</html>
