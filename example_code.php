<?
$website_list = '4	www.google.com
14	www.yahoo.com
2	www.reddit.com';

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
file_put_contents('privkey', $privKey);
file_put_contents('pubkey', $pubKey);

$data = hash('ripemd160', $website_list);
echo "\ndata - $website_list\n";
echo "hash - $data\n";
//$data = 'plaintext data goes here';

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);

echo $encrypted;

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privKey);

echo $decrypted;
