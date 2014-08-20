<? include '../php_constants.php'; ?> <html>
	<head>
		<title>iShared - Internet Shared</title>
		<script>
			function vote(element_id, vote)
			{
				//window.confirm(element_id);
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() 
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						//window.confirm(xmlhttp.responseText);
						if (true)//xmlhttp.responseText == 'Great Success')
						{
							if (vote < 0)
							{
								document.getElementById('up_arrow_' + element_id).className='arrow up';
								document.getElementById('dn_arrow_' + element_id).className='arrow dnmod';
							}
							else
							{
								document.getElementById('up_arrow_' + element_id).className='arrow upmod';
								document.getElementById('dn_arrow_' + element_id).className='arrow down';
							}
						}
					}
				}
				xmlhttp.open("GET","vote.php?i=" + element_id + "&v=" + vote,true);
				xmlhttp.send();
			}
			function upvote(element_id) {
				vote(element_id,1);
			}
			function downvote(element_id) {
				vote(element_id,-1);
			}
		</script>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<h1>iShared</h1>
		<h2>Decentralized Internet Sharing Algorithm</h2>
		<div style='margin-left: 50px;width: 800px;'>
<?
//This will open up the cache to see each pages rank, url, title, meta description and tags
//This file will likely get unwieldy real fast and a better method will have to be created, but for now it will do
$i = 0;
$handle = fopen('../' . constant('CACHED_PAGE_DATA_LOC'), "r");
if ($handle)
{
	while (($line = fgets($handle)) !== false)
	{
		$webpage_data = explode("\t",$line);
		$webpage_rank_self = $webpage_data[constant('CACHED_PAGE_MY_VOTE_COL')];
		$webpage_rank_total = $webpage_data[constant('CACHED_PAGE_TOTAL_VOTE_COL')];
		$webpage_url = $webpage_data[constant('CACHED_PAGE_URL_COL')];
		$webpage_title = $webpage_data[constant('CACHED_PAGE_TITLE_COL')];
		$webpage_desc = $webpage_data[constant('CACHED_PAGE_DESC_COL')];
?>
<div class='entry'>
	<div class="vote_div">
		<div class='my_vote' id='my_vote<? echo $i; ?>'><? echo $webpage_rank_self; ?></div>
		<div id='up_arrow_<? echo  $i; ?>' class='arrow up' onClick='upvote("<? echo  $i; ?>");'></div>
		<div class="score"><? echo $webpage_rank_total; ?></div>
		<div id='dn_arrow_<? echo  $i; ?>' class="arrow down" onClick='downvote("<? echo  $i; ?>");'></div>
	</div>
	<div style='float: left;width: 700px;padding-left: 10px;'>
	<h3><a href='<? echo $webpage_url ?>'><? echo $webpage_title; ?></a></h3><p><? echo $webpage_desc; ?></p>
	</div>
	<div style='clear: both;'></div>
</div>
<?
	$i = $i + 1;
	}
} 
fclose($handle);

echo "</div></body></html>";
