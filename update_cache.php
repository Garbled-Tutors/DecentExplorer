<?
$all_sites = array();
$all_users = file_get_contents(".config/users");
$user_tsv = explode("\n",$all_users);

foreach ($user_tsv as $user_string)
{
	$user_data = explode("\t",$user_string);
	if (isset($user_data[1]))
	{
		//echo "Reading ${user_data[1]}<br>\n";
		$user_mod = $user_data[0];

		$file_data = file_get_contents("data/${user_data[1]}/webpages");
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

arsort($all_sites);
$fh = fopen('.cache/page_data', 'w') or die("can't open file");
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

	$clean_webpage_url = preg_replace('/[\t]/', ' ', $webpage_url);
	$clean_webpage_title = preg_replace('/[^A-Za-z0-9\-\,\.\'\:\t]/', ' ', $webpage_title);
	$clean_webpage_desc = preg_replace('/[^A-Za-z0-9\-\,\.\'\:\t]/', ' ', $webpage_desc);
	$page_details = "$webpage_rank\t$clean_webpage_url\t$clean_webpage_title\t$clean_webpage_desc\n";

	fwrite($fh, $page_details);
}
fclose($fh);
