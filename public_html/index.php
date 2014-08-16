<?
/*
 cat ../data/MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAL8r79tJed91f5PUkA88wajzHi5MxK42/websites
5       www.google.com
3       www.reddit.com
1       www.yahoo.com
6       www.wired.com
 */
$all_sites = array();

$all_users = file_get_contents("../.config/users");
$user_tsv = explode("\n",$all_users);

foreach ($user_tsv as $user_string)
{
	$user_data = explode("\t",$user_string);
	if (isset($user_data[1]))
	{
		//echo "Reading ${user_data[1]}<br>\n";
		$user_mod = $user_data[0];

		$file_data = file_get_contents("../data/${user_data[1]}/webpages");
		$webpage_list = explode("\n",$file_data);
		foreach ($webpage_list as $webpage_string)
		{
			$webpage_data = explode("\t",$webpage_string);
			if (isset($webpage_data[1]))
			{
				$filter_page = 0;
				if (isset($_GET['r']))
				{
					$webpage_tags = explode(",",$webpage_data[2]);
					if (!in_array($_GET['r'],$webpage_tags))
					{
						$filter_page = 1;
					}
				}
				if ($filter_page == 0)
				{
					if (!isset($all_sites[$webpage_data[1]]))
					{
						$all_sites[$webpage_data[1]] = 0;
					}

					if ($user_mod > 0)
					{
						$all_sites[$webpage_data[1]] += ($webpage_data[0] * $user_mod);
						//echo "${webpage_data[1]} += ${webpage_data[0]} * $user_mod<br>\n";
					}
					elseif ($webpage_data[0] > 0)
					{
						$all_sites[$webpage_data[1]] += $user_mod;
						//echo "${webpage_data[1]} += $user_mod<br>\n";
					}
				}
			}
		}
	}
}
?>
<html><head><title>iShared - Internet Shared</title>
<style>
.arrow.up {
	background-image: url("images/sprite-reddit.jzJhk9_9j8Q.png");
	background-position: -42px -818px;
	background-repeat: no-repeat;
}
.arrow {
	background-position: center center;
	background-repeat: no-repeat;
	cursor: pointer;
	display: block;
	height: 14px;
	margin: 2px auto 0;
	outline: medium none;
	width: 15px;
}
.arrow.down {
	background-image: url("images/sprite-reddit.jzJhk9_9j8Q.png");
	background-position: 0 -818px;
	background-repeat: no-repeat;
}
.score {
	color: #c6c6c6;
	text-align: center;
}
.vote_div {
	float: left;
	padding: 25px;
}
.entry {
	vertical-align: middle;
	height: 100px;
	overflow: hidden;
}
</style>
</head><body>
<h1>iShared</h1><h2>Decentralized Internet Sharing Algorithm</h2>
<div style='margin-left: 50px;width: 800px;'>
<?
arsort($all_sites);
foreach ($all_sites as $webpage_url => $webpage_rank)
{
	$doc = new DOMDocument();
	@$doc->loadHTMLFile("$webpage_url");
	$xpath = new DOMXPath($doc);
	$webpage_title = $xpath->query('//title')->item(0)->nodeValue;
	$webpage_desc = $xpath->query('/html/head/meta[@property="og:description"]/@content')->item(0)->nodeValue;
	if ($webpage_desc == '')
	{
		$webpage_desc = $xpath->query('/html/head/meta[@name="description"]/@content')->item(0)->nodeValue;
	}

	//$clean_webpage_url = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_url);
	$clean_webpage_title = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_title);
	$clean_webpage_desc = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_desc);
?>
<div class='entry'>
	<div class="vote_div">
		<div class='arrow up'></div>
		<div class="score">3506</div>
		<div class="arrow down"></div>
	</div>
	<div style='float: left;width: 700px;padding-left: 10px;'>
	<h3><a href='$webpage_url'><? echo $clean_webpage_title; ?></a></h3><p><? echo $clean_webpage_desc; ?></p>
	</div>
	<div style='clear: both;'></div>
</div>
<?
}
echo "</div></body></html>";
