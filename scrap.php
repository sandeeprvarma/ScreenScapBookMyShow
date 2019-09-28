<?php

$localtion = 'mumbai';
$url = "https://in.bookmyshow.com/$localtion/movies";

function fetchMovies($regex)
{
	global $localtion, $url;
	$html = file_get_contents($url);
	preg_match_all('#'.$regex.'#ims', $html, $movies);
	return $movies;
}

function getNowShowingMovies() 
{
	$now_showing = '{"event":"productClick","ecommerce":{"currencyCode":"INR","click":{"actionField":{"list":"Filter Impression:category\\\/now showing"},"products":\[{"name":"(.*?)","id":"(.*?)","category":"(.*?)","variant":"(.*?)","position":(.*?),"dimension13":"(.*?)"}\]}}}';
	$movies = fetchMovies($now_showing); 
	echo "Tickets are now availanble for these movies:\n";
	array_map(function($movie_name) {
		echo "$movie_name \n";
	}, $movies[1]);
}

function upComingMovies() 
{
	$comingsoon = '{"event":"productClick","ecommerce":{"currencyCode":"INR","click":{"actionField":{"list":"category\\\/coming soon"},"products":{"name":"(.*?)","id":"(.*?)","category":"(.*?)","variant":"(.*?)","position":(.*?),"dimension13":"(.*?)"}}}}';
	
	$movies = fetchMovies($comingsoon); 
	echo "Movies Coming Soon:\n";
	array_map(function($movie_name) {
		echo "$movie_name \n";
	}, $movies[1]);
}

$input = readline("nowshowing(1) or comingmovies(2)? Type 1 or 2: ");
if($input == 1) {
	getNowShowingMovies();
}else if($input == 2) {
	upComingMovies();
}
