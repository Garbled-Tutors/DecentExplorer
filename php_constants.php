<?

	//List of acronyms, and words used in comments

		//BTSPass 
		// We will be using Bit Torrent Sync to sync our data with other users, in order to do this we will need to create a read only password with this program and hand it out freely. BTSPass is the read only password

//DIRECTORIES
define('CONFIG_DIRECTORY', '.config'); // This holds your database, private keys, and everything in your profile
define('SHARE_DIRECTORY', '.share'); // This contains every public file, it may be removed in the future as it is mirrored inside the data directory
define('DATA_DIRECTORY', 'data'); // This is your torrent download directory. It contains a copy of your shared folder and a a copy of ever users shared folder that you have downloaded
																	// It contains directories named after the users public key, we may change the directory to the readonly password in future versions as that may be more approriate
define('CACHE_DIRECTORY', '.cache'); // This caches all pages known, their rank, webpage title, and webpage description

//SHARED FILES
define('PUBLIC_PROFILE', constant('SHARE_DIRECTORY') . '/self'); //Sets your non unique handle and your current BTSPass (nessisary for others to see your shared data)
define('PUBLIC_KEY', constant('SHARE_DIRECTORY') . '/pub_key'); //This is given out to anyone who asks, used to verify your lists
define('NOTEWORTHY_WEBPAGES', constant('SHARE_DIRECTORY') . '/webpages');//This is a list of webpages that you have personally voted upon. It is tab seperated
define('NOTEWORTHY_USERS', constant('SHARE_DIRECTORY') . '/users');//This is a list of users and hosts. It is a tab seperated file of every host you personally voted upon
define('CACHED_PAGES', constant('CACHE_DIRECTORY') . '/page_data');// A tab seperated file containing each pages rank, url, title, description, and tags
																																			// In order to prove your public files were written by you without anyone modifying them, we use two files: file_list and proof
define('PROOFS_FILE_LIST', constant('SHARE_DIRECTORY') . '/file_list'); //This is a list of files in your shared directory and a hash of them. People can verify that each file has not been modified by comparing
																																				//a hash of each file to the hash listed in this file. Since this file is not signed, you will still need proof that this has not been modified
define('PROOFS_SIGNED_HASH', constant('SHARE_DIRECTORY') . '/proof'); //This contains a hash of file list that has been signed using the public key. Verifies file list has not been tampered with

//PRIVATE FILES
define('PRIVATE_KEY', constant('CONFIG_DIRECTORY') . '/pub_key'); //	This holds your private key which is used to prove who you are, you will use this to encrypt your lists so users know that no one has made changes
define('PRIVATE_NOTEWORTHY_WEBPAGES', constant('CONFIG_DIRECTORY') . '/webpages'); // In the event you wish to save a pages, but not share this preference or page with the world. Same structure as public file
define('PRIVATE_NOTEWORTHY_USERS', constant('CONFIG_DIRECTORY') . '/users');// In the event you wish to save a user, but not share this preference or page with the world. Same structure as public file

//NOTEWORTHY PAGES
define('NOTEWORTHY_WEBPAGE_USER_VOTE_COL', 0); // Each page is voted upon and the users vote is stored here, this is used to determine the rank of the page
define('NOTEWORTHY_WEBPAGE_URL_COL', 1); // The url of the page.... need some way of handling pages with multiple urls
define('NOTEWORTHY_WEBPAGE_TAGS_COL', 2); // A list of tags categorizing the page. This could be 'technology', 'spam', 'news', or whatever you like. The tags are comma seperated and at the moment spaces are allowed

//NOTEWORTHY USERS
define("NOTEWORTHY_USER_VOTE_COL", 0); // This column expresses your trust in this user, higher indicates more trust. It is supposed to be between -100 and 100, but we may not restrict this number
																			 // We will download shared data at these users and then recursively look through their user list, and the next user list as well.
define("NOTEWORTHY_USER_PUB_KEY_COL", 1); // This is the referenced users public key
define("NOTEWORTHY_USER_BTSPASS_COL", 1); // This is the referenced users current BTSPass (this program should be prepared for this value to change)

//CACHED PAGES
																					//A pages rank is determined by adding the current users vote to the sum of other users votes. Each other users vote is modified by the current users trust in them
define("CACHED_PAGE_MY_VOTE_COL",     0); //This is the current users vote in the referenced page
define("CACHED_PAGE_TOTAL_VOTE_COL",     1);//This is the pages current rank (MY_VOTE + everyone elses vote)
define("CACHED_PAGE_URL_COL",     2); //The current pages url, this column is used as a universal id
define("CACHED_PAGE_TITLE_COL",     3);//The pages most recent title
define("CACHED_PAGE_DESC_COL",     4);//The pages most recent meta description

//FILE LIST

//PUBLIC PROFILE
define("PUBLIC_PROFILE_HANDLE_LINE_NUM",     0); // Your handle will not nessisarily be unique. To get a unique name, we will use your public key as a last name. We will display an abbreviated version
define("PUBLIC_PROFILE_BTSPASS",     1); //See definition of BTSPass above

?>
