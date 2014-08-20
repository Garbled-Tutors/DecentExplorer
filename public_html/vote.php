<?
//ini_set('display_errors','on');

if (isset($_GET['i']) and isset($_GET['v']))
{

	$line_number = $_GET['i']; 
	$file = new SplFileObject('../.cache/page_data');
	$file->seek($line_number);
	//echo $file->current();
	$webpage_data = explode("\t",$file->current());
	$webpage_url = $webpage_data[1];

	$file_data = file_get_contents("../.config/webpages");
	$webpage_list = explode("\n",$file_data);
	$webpage_index = -1;
	$i = 0;
	foreach ($webpage_list as $webpage_string)
	{
		$webpage_data = explode("\t",$webpage_string);
		if (isset($webpage_data[1]))
		{
			if ($webpage_data[1] == $webpage_url)
			{
				$webpage_index = $i;
				break;
			}
		}
		$i = $i + 1;
	}

	if ($webpage_index >= 0)
	{
		//echo "Editing Line $webpage_index";
		$webpage_list[$i];
		$webpage_data = explode("\t",$webpage_list[$i]);
		$webpage_data[0] = $_GET['v'];
		$webpage_list[$i] = implode("\t",$webpage_data);
		$all_sites = implode("\n",$webpage_list);
		if (file_put_contents('../.config/webpages', $all_sites))
		{
			echo "Great Success";
		}
		else
		{
			echo "Ohchen Ploha";
		}
	}
	else
	{
		$new_page_details = "${_GET['v']}\t$webpage_url\t\n";
		if (file_put_contents('../.config/webpages', $new_page_details, FILE_APPEND))
		{
			echo "Great Success";
		}
		else
		{
			echo "Ohchen Ploha";
		}
	}
}
else
{
	echo "Ohchen Ploha";
}

?>
