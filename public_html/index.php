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
$all_sites = array();
$handle = fopen("../.cache/page_data", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
			$webpage_data = explode("\t",$line);
			array_push($all_sites,$webpage_data);
    }
} 
fclose($handle);
foreach ($all_sites as $site_columns)
{
	$webpage_rank = $site_columns[0];
	$webpage_url = $site_columns[1];
	$webpage_title = $site_columns[2];
	$webpage_desc = $site_columns[3];
?>
<div class='entry'>
	<div class="vote_div">
		<div class='arrow up'></div>
		<div class="score"><? echo $webpage_rank; ?></div>
		<div class="arrow down"></div>
	</div>
	<div style='float: left;width: 700px;padding-left: 10px;'>
	<h3><a href='<? echo $webpage_url ?>'><? echo $webpage_title; ?></a></h3><p><? echo $webpage_desc; ?></p>
	</div>
	<div style='clear: both;'></div>
</div>
<?
}
echo "</div></body></html>";
