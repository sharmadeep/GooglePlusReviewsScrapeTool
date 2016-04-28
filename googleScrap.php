<?php
//update version for this
ini_set('max_execution_time', 90000);
function curl($url)
{
    
    $proxies = array(); // Declaring an array to store the proxy list
    
    // Adding list of proxies to the $proxies array
    $proxies[] = 'user:password@173.234.11.134:54253'; // Some proxies require user, password, IP and port number
    $proxies[] = 'user:password@173.234.120.69:54253';
    $proxies[] = 'user:password@173.234.46.176:54253';
    $proxies[] = '173.234.92.107'; // Some proxies only require IP
    $proxies[] = '173.234.93.94';
    $proxies[] = '173.234.94.90:54253'; // Some proxies require IP and port number
    $proxies[] = '69.147.240.61:54253';
    
    // Choose a random proxy
    if (isset($proxies)) { // If the $proxies array contains items, then
        $proxy = $proxies[array_rand($proxies)]; // Select a random proxy from the array and assign to $proxy variable
    }
    
    $options = Array(
        CURLOPT_HEADER => FALSE,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_COOKIESESSION => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_AUTOREFERER => TRUE,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",
        CURLOPT_URL => $url
    );
    
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

 //$continue = TRUE;   // Assigning a boolean value of TRUE to the $continue variable
//$url          = "https://plus.google.com/103004898791010616518/about?gl=IN&hl=en-IN";
$url          = $_POST['url'];
 
$results_pages = curl($url);

$results_page = scrape_between($results_pages, "<div class=\"Qxb\">", "<div class=\"fa-Dea\">");
$separate_results = explode("<div class=\"ZWa nAa\">", $results_page);
$separate_ratings = explode("<div class=\"DD XUb VN G7a\">", $results_page);



$i = 0; 
foreach ($separate_results as $separate_result) {
	
	
    //if ($separate_result != "") {
        //$review[] =  scrape_between($separate_result, "<span class=\"GKa oAa\">", "</span>");
		$review[] =  strip_tags(scrape_between($separate_result, "<div class=\"VSb lha\">", "<div class=\"rxa\">"));
		$getrating[] =   explode("<span class=\"b-db-ac b-db-ac-th\" role=\"button\">", $separate_result);
		$calrating[] = count($getrating[$i])-1;
		$i++;

		$author[] =  strip_tags(scrape_between($separate_result, "<span class=\"DQa\"></span>", "<div class=\"DD XUb VN G7a\">"));
		// $rating[] =  scrape_between($separate_result, "<meta itemprop=\"ratingValue\" content=\"", "\">");
		  $date[] =  strip_tags(scrape_between($separate_result, "<span class=\"VUb\">", "<div class=\"VSb lha\">"));
		  
		
   // }
}
$name = scrape_between($results_pages, "<div class=\"rna KXa Xia fn\" guidedhelpid=\"profile_name\">", "</div>");
$overall_rating = scrape_between($results_pages, "<span class=\"ola\">", "</span>");
$overall_reviews = scrape_between($results_pages, "<span class=\"g7 eGa\">", "</span>");

print_r($name);
print_r($overall_rating);
print_r($overall_reviews);
print_r($calrating);
print_r($review);
print_r($author);
print_r($date);


function scrape_between($data, $start, $end)
{
    $data = stristr($data, $start);
    $data = substr($data, strlen($start));
    $stop = stripos($data, $end);
    $data = substr($data, 0, $stop);
    return $data;
}


?>
