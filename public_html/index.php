<?
/*
 cat ../data/MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAL8r79tJed91f5PUkA88wajzHi5MxK42/websites
5       www.google.com
3       www.reddit.com
1       www.yahoo.com
6       www.wired.com
 */
$all_sites = array();

if ($handle = opendir('../data')) {
		$file_list = '';
		while (false !== ($filename = readdir($handle))) {
			if (substr($filename,0,1) != '.') {
				$file_data = file_get_contents("../data/$filename/webpages");
				$webpage_list = explode("\n",$file_data);
				foreach ($webpage_list as $webpage_string)
				{
					$webpage_data = explode("\t",$webpage_string);
					if (isset($webpage_data[1]))
					{
						if (isset($all_sites[$webpage_data[1]]))
						{
							$all_sites[$webpage_data[1]] += $webpage_data[0];
						}
						else
						{
							$all_sites[$webpage_data[1]] = $webpage_data[0];
						}
					}
				}
			}
		}
		closedir($handle);
		echo "<html><head><title>iShared - Internet Shared</title></head><body>\n";
		echo "<h1>iShared</h1><h2>Decentralized Internet Sharing Algorithm</h2>";
		echo "<div style='margin-left: 50px;width: 800px;'>\n";
		arsort($all_sites);
		foreach ($all_sites as $webpage_url => $webpage_rank)
		{
			$doc = new DOMDocument();
			@$doc->loadHTMLFile("http://$webpage_url");
			$xpath = new DOMXPath($doc);
			$webpage_title = $xpath->query('//title')->item(0)->nodeValue;
			$webpage_desc = $xpath->query('/html/head/meta[@property="og:description"]/@content')->item(0)->nodeValue;
			if ($webpage_desc == '')
			{
				$webpage_desc = $xpath->query('/html/head/meta[@name="description"]/@content')->item(0)->nodeValue;
			}

			$clean_webpage_url = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_url);
			$clean_webpage_title = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_title);
			$clean_webpage_desc = preg_replace('/[^A-Za-z0-9\-\,\.\'\:]/', ' ', $webpage_desc);
			echo "<h3><a href='$clean_webpage_url'>$clean_webpage_title</a></h3><p>$clean_webpage_desc</p>\n";
		}
		echo "</div></body></html>";
}
