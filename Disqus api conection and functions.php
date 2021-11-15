
/* Disqus Comments (API Call and Data save)
 =================================================================================================== */

 function save_comments_count() {
	global $wpdb;
	$postLink = get_permalink();
	$currentTime = current_time( 'mysql' );
	
	//Getting the number of comments of the post
	$request = new WP_Http;
	$messageResponse = $request->request('https://disqus.com/api/3.0/threads/details.json?api_key=OxX80EfDhHRu9rzC68F1LuTvVMChH5v1sDSCWGYwCLVfldWpKPnB5qyshdX826em&forum=joeyoungblood&thread:link='.$postLink);
	$messageCount = json_decode($messageResponse[body])->response->posts;

	//Saving the data in our DB
	$wpdb->query( 
 		"INSERT INTO `wp_disqusComments` (comments, link, date) VALUES('" . $messageCount ."', '" . $postLink ."', '" . $currentTime ."')
			ON DUPLICATE KEY UPDATE comments='" . $messageCount ."', date='" . $currentTime ."'"
    );
} 

function get_comments_count() {
	//Showing number of comments
	global $wpdb;
	$postLink = get_permalink();
	$result= $wpdb->get_var( 'SELECT comments FROM wp_disqusComments WHERE link = "' . $postLink .'"' );
	print_r($result);
}
