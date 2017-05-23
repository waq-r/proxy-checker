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
		# code...
		$this->divideon = "<a";
		$this->url_pattern = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
	}
	function getWebpage(){
		$this->webpage = file_get_html($this->url);
	}
	function divideHtml(){
		return explode($this->divideon, $this->webpage);

	}
	function getAllUrls(){
		preg_match_all($this->url_pattern, $this->webpage, $matches);
		$this->allurls = $matches[0];
		
	}
	function getHostnames(){
		foreach ($this->allurls as $u) {
		$hostnames[] = parse_url($u, PHP_URL_HOST);
	}
		return array_unique($hostnames);

	}	function getSitePaths(){


		$sitepaths = preg_grep('/^(\/)(.*)(\.html|\/)$/', $this->allurls);

		return array_unique($sitepaths);
	}
}





$internallinks[] = 'http://homestead.app/anonymous/proxyindex1.html';

$externallinks = array();
foreach ($internallinks as $l) {
	# code...

	
	$proxyindex = new UrlExtract;
	$proxyindex->url = $l;
	$proxyindex->getWebpage();
	$proxyindex->getAllUrls();
	$externallinks = array_merge($externallinks, $proxyindex->getHostnames());
		unset($proxyindex);



}

foreach ($externallinks as $link) {
	# code...
	echo $link;
	 var_dump(get_headers("http://".$link));
	

}

   
  
       