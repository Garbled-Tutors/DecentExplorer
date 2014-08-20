<?
include 'php_constants.php';
$file_list_string = 'version ' . constant('CURRENT_VERSION') . "\n";
$file_list_array = explode("\n",constant('ALL_SHARED_FILES'));
for ($i = 0; $i < sizeof($file_list_array); $i++)
{
	$file_name = $file_list_array[$i];
	if ($file_name != constant('PROOFS_FILE_LIST_FILE_NAME'))
	{
		$file_data = file_get_contents(constant('SHARE_DIRECTORY') . '/' . $file_name);
		$hash = hash('ripemd160', $file_data);
		$file_list_string = "$file_list_string$file_name   $hash\n";
	}
}

$pub_key = file_get_contents(constant('PUBLIC_KEY_LOC'));
$pub_key_lines = explode("\n",$pub_key);
$user_dir = $pub_key_lines[1];

file_put_contents(constant('PROOFS_FILE_LIST_LOC'), $file_list_string);
file_put_contents(constant('DATA_DIRECTORY') . "/$user_dir/" . constant('PROOFS_FILE_LIST_FILE_NAME'), $file_list_string);
$file_list_hash = hash('ripemd160', $file_list_string);

$priv_key = file_get_contents(constant('PRIVATE_KEY_LOC'));
openssl_get_privatekey ($priv_key);
openssl_private_encrypt($file_list_hash,$proof,$priv_key);
file_put_contents(constant('PROOFS_SIGNED_HASH_LOC'), $proof);
file_put_contents(constant('DATA_DIRECTORY') . "/$user_dir/" . constant('PROOFS_SIGNED_HASH_FILE_NAME'), $proof);
copy(constant('NOTEWORTHY_WEBPAGES_LOC'), constant('DATA_DIRECTORY') . "/$user_dir/" . constant('NOTEWORTHY_WEBPAGES_FILE_NAME'));
copy(constant('NOTEWORTHY_USERS_LOC'), constant('DATA_DIRECTORY') . "/$user_dir/" . constant('NOTEWORTHY_USERS_FILE_NAME'));
copy(constant('PUBLIC_PROFILE_LOC'), constant('DATA_DIRECTORY') . "/$user_dir/" . constant('PUBLIC_PROFILE_FILE_NAME'));
