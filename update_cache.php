<?
//TODO: NEEDS TESTING and you need to add tags to the cache
include 'php_constants.php';

$pub_key = file_get_contents(constant('PUBLIC_KEY_LOC'));
$pub_key_lines = explode("\n",$pub_key);
$current_users_directory = $pub_key_lines[1];

$all_pages = array();
$current_users_pages = array();
$pub_users = file_get_contents(constant('NOTEWORTHY_USERS_LOC'));
$priv_users = file_get_contents(constant('PRIVATE_NOTEWORTHY_USERS_LOC'));
$all_users = "$pub_users\n$priv_users"; // It is expected that the current user included his own information in either public or the private user file. We may add a check in case he does not do this
$user_tsv = explode("\n",$all_users);

foreach ($user_tsv as $user_string)
{
	$user_data = explode("\t",$user_string);
	if (isset($user_data[constant('NOTEWORTHY_USER_PUB_KEY_COL')]))
	{
		$user_directory = $user_data[constant('NOTEWORTHY_USER_PUB_KEY_COL')];
		$user_trust = $user_data[constant('NOTEWORTHY_USER_VOTE_COL')];

		$user_webpage_list_string = file_get_contents(constant('DATA_DIRECTORY') . "/$user_directory/" . constant('NOTEWORTHY_WEBPAGES_FILE_NAME'));
		$user_webpage_list_array = explode("\n",$user_webpage_list_string);
		foreach ($user_webpage_list_array as $webpage_data_string)
		{
			$webpage_data_array = explode("\t",$webpage_data_string);
			if (isset($webpage_data_array[constant('NOTEWORTHY_WEBPAGE_URL_COL')]))
			{
				$current_url = $webpage_data_array[constant('NOTEWORTHY_WEBPAGE_URL_COL')];
				if (!isset($all_pages[$current_url]))
				{
					$all_pages[$current_url] = 0;
				}

				$current_page_vote = $webpage_data_array[constant('NOTEWORTHY_WEBPAGE_VOTE_COL')];
				if ($user_trust > 0)
				{
					$all_pages[$current_url] += ($current_page_vote * $user_trust);
				}
				elseif ($current_page_vote > 0)
				{
					$all_pages[$current_url] += $user_trust;
				}
				if ($current_users_directory == $user_directory)
				{
					$current_users_pages[$current_url] = $current_page_vote;
				}
			}
		}
	}
}

arsort($all_pages);
$fh = fopen(constant('CACHED_PAGE_DATA_LOC'), 'w') or die("can't open file");
foreach ($all_pages as $webpage_url => $webpage_rank)
{
	$doc = new DOMDocument();
	echo "Downloading $webpage_url\n";
	@$doc->loadHTMLFile("$webpage_url");
	$xpath = new DOMXPath($doc);
	$webpage_title = $xpath->query('//title')->item(0)->nodeValue;
	$webpage_desc = '';
	$webpage_desc_data = $xpath->query('/html/head/meta[@property="og:description"]/@content')->item(0);
	if ($webpage_desc_data)
	{
		$webpage_desc = $webpage_desc_data->nodeValue;
	}
	if ($webpage_desc == '')
	{
		$webpage_desc_data = $xpath->query('/html/head/meta[@name="description"]/@content')->item(0);
		if ($webpage_desc_data)
		{
			$webpage_desc = $xpath->query('/html/head/meta[@name="description"]/@content')->item(0)->nodeValue;
		}
	}

	$clean_webpage_url = preg_replace('/[\t]/', ' ', $webpage_url);
	$clean_webpage_title = preg_replace('/[^A-Za-z0-9\-\,\.\'\:\t]/', ' ', $webpage_title);
	$clean_webpage_desc = preg_replace('/[^A-Za-z0-9\-\,\.\'\:\t]/', ' ', $webpage_desc);
	$page_detail_array = array();
	if (isset($current_users_pages[$current_url]))
	{
		$page_detail_array[constant('CACHED_PAGE_MY_VOTE_COL')] = $current_users_pages[$current_url];
	}
	else
	{
		$page_detail_array[constant('CACHED_PAGE_MY_VOTE_COL')] = 0;
	}
	$page_detail_array[constant('CACHED_PAGE_TOTAL_VOTE_COL')] = $webpage_rank;
	$page_detail_array[constant('CACHED_PAGE_URL_COL')] = $clean_webpage_url;
	$page_detail_array[constant('CACHED_PAGE_TITLE_COL')] = $clean_webpage_title;
	$page_detail_array[constant('CACHED_PAGE_DESC_COL')] = $clean_webpage_desc;
	$page_detail_string = implode("\t",$page_detail_array) . "\n";
	//$page_details = "$webpage_rank\t$clean_webpage_url\t$clean_webpage_title\t$clean_webpage_desc\n";

	fwrite($fh, $page_detail_string);
}
fclose($fh);
