<?php
include_once('simple_html_dom.php');

/**
* extracts URLs from webpage
*/
class UrlExtract 
{
	var $webpage;
	var $divideon;
	var $url_pattern;
	var $url;
	var $allurls;
	
	function __construct()
	{
		# sets value to split whole page on every <a> tag
		#sets regular expression to scan URLs
		$this->divideon = "<a";
		$this->url_pattern = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
	}
	function getWebpage(){
		#gets html of a webpage
		$this->webpage = file_get_html($this->url);
	}
	function divideHtml(){
		#divides whole html page using a given divider
		return explode($this->divideon, $this->webpage);

	}
	function getAllUrls(){
		#matches pattern and extracts URL in a webpage
		preg_match_all($this->url_pattern, $this->webpage, $matches);
		$this->allurls = $matches[0];
		
	}
	function getHostnames(){
		#parses URLs finds hostnames from URLs
		foreach ($this->allurls as $u) {
		$hostnames[] = parse_url($u, PHP_URL_HOST);
	}
		return array_unique($hostnames);

	}	function getSitePaths(){
		#finds webpages internal links

		$sitepaths = preg_grep('/^(\/)(.*)(\.html|\/)$/', $this->allurls);

		return array_unique($sitepaths);
	}
}





$internallinks[] = 'http://homestead.app/anonymous/proxyindex1.html';

$externallinks = array();
foreach ($internallinks as $l) {
	# creating a instance of UrlExtract class, and providing a URL to gather links from

	
	$proxyindex = new UrlExtract;
	$proxyindex->url = $l;
	$proxyindex->getWebpage();
	$proxyindex->getAllUrls();
	$externallinks = array_merge($externallinks, $proxyindex->getHostnames());
		unset($proxyindex);



}

foreach ($externallinks as $link) {
	# dumping links array for test
	echo $link;
	 var_dump(get_headers("http://".$link));
	

}

   
  
       