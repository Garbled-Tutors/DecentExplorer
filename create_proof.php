<?
if ($handle = opendir('.config')) {

		$file_list = '';
		while (false !== ($filename = readdir($handle))) {
			if (substr($filename,0,1) != '.'  && substr($filename,0,2) != 'pr' && $filename != 'file_list') {
				$file_data = file_get_contents(".config/$filename");
				$hash = hash('ripemd160', $file_data);
				$file_list = "$file_list$filename   $hash\n";
			}
		}
		closedir($handle);
		file_put_contents('.config/file_list', $file_list);
		$file_list_hash = hash('ripemd160', $file_list);

		$priv_key = file_get_contents(".config/priv_key");
		openssl_get_privatekey ($priv_key);
		openssl_private_encrypt($file_list_hash,$proof,$priv_key);
		file_put_contents('.config/proof', $proof);
}
