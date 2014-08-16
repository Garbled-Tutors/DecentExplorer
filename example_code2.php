<?php
/*
 *
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/hosts:BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/users:5      john    BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/websites:5   www.google.com
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/websites:3   www.reddit.com
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/websites:1   www.yahoo.com
 * public_data/john_BICAIT3L72HF5ZOOIXMHQWYQUQHYWCLCH/websites:6   www.wired.com
 */

if ($handle = opendir('/var/www/WebSharing/public_data')) {

		//echo "Directory handle: $handle<br/>\n";
		//echo "Entries:<br/>\n";

		while (false !== ($entry = readdir($handle))) {
			if ($file == '.' || $file == '..' || substr($file,0,1) == '.') {
				echo "$entry<br/>\n";
			}
		}

		closedir($handle);
}

//$files  = array('files'=>array(), 'dirs'=>array());
//$directories  = array();
//$last_letter  = $root[strlen($root)-1];
//$root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;

//$directories[]  = $root;

//while (sizeof($directories)) {
	//$dir  = array_pop($directories);
	//if ($handle = opendir($dir)) {
		//while (false !== ($file = readdir($handle))) {
			//if ($file == '.' || $file == '..' || substr($file,0,1) == '.') {
				//continue;
			//}
			//$file  = $dir.$file;
			//if (is_dir($file)) {
				//$directory_path = $file.DIRECTORY_SEPARATOR;
				//array_push($directories, $directory_path);
				//$files['dirs'][]  = $directory_path;
			//} elseif (is_file($file)) {
				//$files['files'][]  = $file;
			//}
		//}
		//closedir($handle);
	//}
//}

//function read_all_files($root = '.'){
  //$files  = array('files'=>array(), 'dirs'=>array());
  //$directories  = array();
  //$last_letter  = $root[strlen($root)-1];
  //$root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;
 
  //$directories[]  = $root;
 
  //while (sizeof($directories)) {
    //$dir  = array_pop($directories);
    //if ($handle = opendir($dir)) {
      //while (false !== ($file = readdir($handle))) {
        //if ($file == '.' || $file == '..' || substr($file,0,1) == '.') {
          //continue;
        //}
        //$file  = $dir.$file;
        //if (is_dir($file)) {
          //$directory_path = $file.DIRECTORY_SEPARATOR;
          //array_push($directories, $directory_path);
          //$files['dirs'][]  = $directory_path;
        //} elseif (is_file($file)) {
          //$files['files'][]  = $file;
        //}
      //}
      //closedir($handle);
    //}
  //}
 
  //return $files;
//} 
//foreach (read_all_files('/var/www/WebSharing/public_data')['files'] as $file)
//{
	//echo $file;
//}

?>
