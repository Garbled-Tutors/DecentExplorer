<?
include '../php_constants.php';
//ini_set('display_errors','on');

if (isset($_GET['i']) and isset($_GET['v']))
{

	$line_number = $_GET['i']; 
	$file = new SplFileObject('../' . constant('CACHED_PAGE_DATA_LOC'));
	$file->seek($line_number);
	//echo $file->current();
	$webpage_data = explode("\t",$file->current());
	$webpage_url = $webpage_data[constant('CACHED_PAGE_URL_COL')];

	$file_data = file_get_contents('../' . constant('NOTEWORTHY_WEBPAGES_LOC'));
	$webpage_list = explode("\n",$file_data);
	$webpage_index = -1;
	$i = 0;
	foreach ($webpage_list as $webpage_string)
	{
		$webpage_data = explode("\t",$webpage_string);
		if (isset($webpage_data[constant('CACHED_PAGE_URL_COL')]))
		{
			if ($webpage_data[constant('CACHED_PAGE_URL_COL')] == $webpage_url)
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
		$webpage_data[constant('CACHED_PAGE_MY_VOTE_COL')] = $_GET['v'];
		$webpage_list[$i] = implode("\t",$webpage_data);
		$all_sites = implode("\n",$webpage_list);
		if (file_put_contents('../' . constant('NOTEWORTHY_WEBPAGES_LOC'), $all_sites))
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
		$new_page_detail_array = array();
		$new_page_detail_array[constant('NOTEWORTHY_WEBPAGE_VOTE_COL')] = $_GET['v'];
		$new_page_detail_array[constant('NOTEWORTHY_WEBPAGE_URL_COL')] = $webpage_url;
		$new_page_detail_array[constant('NOTEWORTHY_WEBPAGE_TAGS_COL')] = '';

		$new_page_details = implode("\t", $new_page_detail_array) . "\n";
		if (file_put_contents('../' . constant('NOTEWORTHY_WEBPAGES_LOC'), $new_page_details, FILE_APPEND))
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
