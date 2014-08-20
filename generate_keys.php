<?
//TODO: Test this code to make sure it is working as expected
include 'php_constants.php';

srand((double) microtime() * 1000000); 

$config = array(
		"digest_alg" => constant('ENCRYPTION_ALG'),
		"private_key_bits" => constant('PRIVATE_KEY_BIT_COUNT'),
		"private_key_type" => constant('PRIVATE_KEY_TYPE'),
);
	
// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $priv_key
openssl_pkey_export($res, $priv_key);

// Extract the public key from $res to $pub_key
$pub_key = openssl_pkey_get_details($res);
$pub_key = $pub_key["key"];
$pub_key_lines = explode("\n",$pub_key);
$user_dir = $pub_key_lines[1];

file_put_contents(constant('PRIVATE_KEY_LOC'), $priv_key);
file_put_contents(constant('PUBLIC_KEY_LOC'), $pub_key);
mkdir(constant('DATA_DIRECTORY') . "/$user_dir");
file_put_contents(constant('DATA_DIRECTORY') . "/$user_dir/" . constant('PUBLIC_KEY_FILE_NAME'), $pub_key);
file_put_contents(constant('DATA_DIRECTORY') . "/$user_dir/" . constant('NOTEWORTHY_USERS_FILE_NAME'), '');
file_put_contents(constant('DATA_DIRECTORY') . "/$user_dir/" . constant('NOTEWORTHY_WEBPAGES_FILE_NAME'), '');
echo "Private and public keys created. Use BtSync to share the folder '" . constant('DATA_DIRECTORY') . "/$user_dir', then create " . constant('PUBLIC_PROFILE_LOC') . "\n";
