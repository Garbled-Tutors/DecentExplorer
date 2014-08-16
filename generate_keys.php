<?

srand((double) microtime() * 1000000); 

$config = array(
		"digest_alg" => "sha256",
		"private_key_bits" => 512,
		"private_key_type" => OPENSSL_KEYTYPE_RSA,
);
	
// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];
$pubKeyLines = explode("\n",$pubKey);
$userDir = $pubKeyLines[1];

file_put_contents('.config/priv_key', $privKey);
file_put_contents('.config/pub_key', $pubKey);
mkdir("data/$userDir");
file_put_contents("data/$userDir/pub_key", $pubKey);
file_put_contents("data/$userDir/users", '');
file_put_contents("data/$userDir/webpages", '');
echo "Private and public keys created. Use BtSync to share the folder 'data/$userDir', then create .config/self\n";
