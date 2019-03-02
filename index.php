<?php
	// Change the language of the UI here
	define("LANGUAGE", "en");
	
	// You have to get an API key from the OMDb API (it's free, you only have to provide a working email address).
	// You can register for an API key here: http://www.omdbapi.com/apikey.aspx and insert it below.
	define("API_KEY", "PLACE_YOUR_API_KEY_HERE");

	// The array containing all languages strings
	// Feel free to add another subarray for your language
	$i18n = Array(
		"fr" => Array(
			"You need to get an API key for the OMDb API. Don\'t worry, it\'s very simple!\nPlease read the instructions at the top of this file." => "Il vous faut une clé pour accéder à l'API d'OMDb. Pas de panique, c'est très simple !\nMerci de consulter les instructions dans les premières lignes de ce fichier.",
			"Benflix needs JavaScript enabled to work." => "Benflix a besoin que JavaScript soit activé.",
			"Go to the IMDb page" => "Voir la fiche sur IMDb",
			"Watch the trailer on YouTube" => "Voir la bande-annonce",
			"Download the movie" => "Télécharger le film",
			"You can play the movie before its downloaded<br />by opening the .part or .crdownload file with VLC." => "Vous pouvez lire le film avant la fin du téléchargement<br />en ouvrant le fichier .part ou .crdownload avec VLC.",
			"Genre:" => "Genre :",
			"Runtime:" => "Durée :",
			"Directed by:" => "Réalisé par :",
			"With:" => "Avec :",
			"IMDB rating:" => "Note IMDb :",
			"Search for a movie..." => "Chercher un film...",
			"No movie matches criteria" => "Aucun film correspondant",
			"Deactivate some filters" => "Désactivez certains filtres",
			"By" => "Par",
			"Bugs? Ideas? Tell me more on" => "Bugs ? Idées ? Faites-m'en part sur",
			"The project page on Github" => "La page du projet sur Github",
			"Close" => "Fermer",
			"All" => "Tous",
			"Search for a movie" => "Rechercher un film",
			"Filter by IMDb score" => "Filtrer par note IMDb",
			"Filter by movie length" => "Filtrer par durée",
			"Filter by category" => "Filtrer par catégorie",
			"About this app" => "À propos de Benflix",
			"Close this modal" => "Afficher les résultats",
			"Search" => "Rechercher",
			"Order by..." => "Trier par...",
			"Alphabetical" => "Alphabétique",
			"Date added" => "Ajouts",
			"Date released" => "Diffusion",
			"Runtime" => "Durée",
			"IMDb rating" => "Note IMDb",
			"Genre" => "Genre"
		)
	);

	// Returns the translated string if it exists (or the English string otherwise)
	function translate($string){
		global $i18n;
		if(isset($i18n[LANGUAGE]) and isset($i18n[LANGUAGE][$string])){
			return $i18n[LANGUAGE][$string];
		}
		else {
			return $string;
		}
	}

	// Converts an array in UTF-8
	function utf8ize($mixed) {
		if (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = utf8ize($value);
			}
		} else if (is_string ($mixed)) {
			return utf8_encode($mixed);
		}
		return $mixed;
	}

	// Handle Ajax calls
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && !empty($_POST['action'])){
		switch($_POST['action']){
			case 'getAvailableMovies':
				die(json_encode(utf8ize(get_video_files()));
				break;
			case 'getMovieInfo':
				die(get_movie_info($_POST['movieName']));
				break;
			default:
				// Do nothing
				break;
		}
	}

	function get_video_files(){
		$allFiles = scandir("./");
		$files = Array();
		foreach($allFiles as $file){
			if(($file != '.') && ($file != '..') && ($file != basename($_SERVER["PHP_SELF"])) && ($file[0] != '.')){
				$files[] = Array('name' => $file, 'time' => filectime($file));
			}
		}
		return $files;
	}

	function get_movie_info($movieName){
		// This movie requires to be written with a / so the API can recognize it
		// Of course the filename can't have a / in it...
		if($movieName == '50-50'){
			$movieName = '50/50';
		}
		$movieName = rawurlencode($movieName);
		$json = get_url_contents('http://www.omdbapi.com/?apikey='.API_KEY.'&t='.$movieName.'&r=json');
		return $json;
	}

	function get_url_contents($url) {
		$crl = curl_init();

		curl_setopt($crl, CURLOPT_URL, $url);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);
		#curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

		$ret = curl_exec($crl);
		curl_close($crl);
		return $ret;
	}

	// The logo is in base64 so that the file is not dependant on anything
	define('BENFLIX_LOGO', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIwAAAAyCAQAAAAkCfuwAAASDUlEQVRo3rWbd3Rc1Z3HP69ML5JGxSpWl9wrtgGDARNIXMjJmrZpm4SQTUggsOkJkOTkpGxom4RiUjZZkoWEJGQ5sARTAgYbG9yxJVkuskG2+ozaNE197+0f82b0ZjSSJVv78zl+M3ee77v3e+/v+/v9vvdZWPzBwbUDcVRSJlfG5x8YfXMOlTwBbCTKZlbhQwDK2Xb5/Zu0AAaTrA2jyx8xE2WQDVzHKBJ27v3My/WM6be45x269NnWlZ03jgQA29qh6x47jJkTxPkcIVSKaLvsic3xrH6RmqR1DxcEFyITIYQEeNh+3Z/WEgCs6/yfetiECRUFDTcmFAQESnj8pqeXEQLBsabzn58w04mNejTGMCPx5J1vFREFXDe0rf6LheXsXPzDjxEEhAZH0R+vOpFkFAfymQ8X3bVaTWrp4YiJrvZTL1708AIvgAAMkv7RRP/VpffWKMnM6EUS0umxZQfLd7cyHz+vkEDESt8Xmy91KTra0khH0bN9Hte9jYpCUuoI7zp+8LUgVlx0U8AYNnquLL23wtAviGK/8Kp55fc3YSJEG1FMKPTdUH1rmaKSkE5GHum4bFsBMYJEuZyFBBAQEPB9snpLqSIQlDq8vdvnnFnJEIfRSCIh0Xfb4sUWBQLS3s6u168cdHJ4fcl3axUFE6clpenDnyigGwdyyPIZHhWVNC6ETKeX/335g3fGb7c+FQXsvMsSPIQQEDhuvpN7JcUATD9V9h071i6Rj6+glxfxYyWO37WdWkkFBATWNP/uV6G37uebkkqCQsfL/+Bq3jTjYz8biZOg3fJ1vmLoFySuYPf3yvprHzcRI8F+IM5Z20PcLKkkKLB5X1x1yeA+H00k8TEfEQ2IM2T/NRskeJfVZT/bV7bopaHf8GtW08gQVoZ7/rb4Kgn8eOp69l48L6jsvuTf+bykAhWc+fj3urZ8ez0vIRJ1ICDrfwRcrOC7vOFqezL+TQtgZoSD2ADQEGJOw90yIsVYGJRe2OueoyCzgjJKKcEaciMiIyMhMp/QbfymSBOQsFIA8AZXmnDSTj8uRMSYK6tfGQEncHjrQ9f/Dy9xAhsyAlLETaoXD/D6zrcb7TTQTJwBLACoSGMFiIi4Acp8e1SpCuhjEYtYgbD3LCIiRSyDhufe2I7TchUCEiP4gN3fevprxfQgQpyJdhGPoTygft1KApm9nMSp75Bozp0WnUde3+MrL6aGEqIIQMhwTymAPSYAZOhsh3q1nVGOYM7bL5gB+N2zv/jQXnYxhhkQdOKKoQI9lpP7XHUCAjCAiqDv0DCA/rfW9O03dzmhhwMsoY6a1n16//OBniu2PVvY3AjAHr295T++9undhfL4QH7EEYrYzPUA3MF3CD3U593y5Fz8OHPgU7iLESREIqSYYbDuLz9c/YUAItYJUJeTz5LfN79hZ4wkkqH1AQ7qUB3QW0J/GinxUkJlvk48ex7xfGSECGHmIWZiiNG2r+NLPAjH+QgK5e3v6+2LUpfrPaRAOJIeF8/9ofyrBmB+y1ngt/yNGwFYwxu889/rOj675wxhfFkP1Xh8wgBC1vcJUEbRNIERRgREfV+M21O05gKY9DJMHDFvL2GLjyBhrJPAAoAj5WSnCCF0DIZS239hNkAZYKCmZcMew9Pq9euT+rUagF+9cp/5Mbbiw2WcFBUTnm6NOHEi5xlecf7hKlom3o1bzYQWKWLFgpTnXgDzmAUzFkxMYVGAMUJEKY0PH0/tmTQw6evRzO0lO+378iyDkJ4oAEH3rjsvYwE2kkxto/ZuzjKWZ4iVXIiF3BHCJCfZMdO3QaLYKCV8tA2AZp035wMwQkfmzqoWj5rnaaYMj6Qs+PFiqmESYOxqdcykWBWrtiT0Jb7BUgazuAig5DymIWkFSWvSqljVklEXRVhRLhAYM1YETEhHTwBgY55hx7SRyNzZ1FqPfO4Ou+qfM40mVrAu/+O2ffnWVeYOVLE2eDEufkSIosyvfbhxU4o9kwZP1wr6fnpxoeoXNUFOWrDSy0Ae952JKTRQg4n9J9JOs4BDVFOV40i2hKm9dzrAqHbFbRkaIWqYsMGB/A/4HuYyjiISZAc7KDNg30U5bhxUcmqG0xCV3h4PDQSQsKIydsGuFKUdO1Hs7V4D7U6k3sJj3kDvdJ6magFhlMBkP1uH+CzvUEEEiR3Es4LvIKNT0e8UJot+aQedaARJ0sno1PQ6LRviGEdRT/X5Ehl2adZ/G4+FniNOxOkAI2iiJiJlSHmiJbiLNtbxLgcpyYpKIfwAlM14EhpWVA4yTCERfBPC+vkBkyRKAd5jJzPANOpu1p65a0nbP7HhgvenbnG+yi4OouSsa5ihKTKZc0FjQ+UgfvxEpuPz57QINiSKCB8/DkBdJik5ycg4u7WcoXu2gIEkN3KEypwsJqDHqJLz6lPDhsYB+vXU4ULNTQ1VNOI5mtofLpYzB4DDhpjsPtLL6KwshAEcecIaBVOZAUySoJ3boRLEME+e1c4okxGxIFPals5ZPqoDMx6TijrFvmGUfMAkMoX/zMyCPGHycbwZ8lXPCxgNadKsd6Y2wvsE8WI61qe3fFN3mbbxrPdoJSNo+VxJzbmec+y6xdAmELSKD4CKGQOj4kQmQpw4yhTEP7Ols2FBoqFvsCtV/cs6AOPB2tHSRw9ZeUw6BfuIfu09B92m+XUhH2YfY9SgEMtBWtJ7qSC/vDG5uZInlEI+QBgTAwRmJSqNYMVGknL2tLdWrzWkoZ2Zz3WHClHAOA8LIHEbn9O/7zKsnpqz3tp4XnO1+dHLzZdQwRKcE8oGWSdfz7SBSQ/xPedTNydNH2IJpRRdcDmQTh4GCDBCgvD+I4b2PYY6MXH0BN10G3fMnwng1hNk+HRm6oqUFFOSsyEvZSdRZCQGaq7/8vfWNF8qM4CEhJLFTRZ6UpQGxKY1+O9wFAsCYvHWv7560LXawpXMZ4QRXUW8MFdqwEaUMhxj4aygkTanv6gjVS0agKnSQYnzXZ6ibzy1VZaNJSjOiisilxqKs9ZLjm27fbMZK0l6s+QJC2OoiEjIeTS6fPYvmU/7eWHVg69tuvYTOBjm7VmJmjFk4oSwLF5saF82Tr1tS5Mh1GxXGt9O5qyqyD5gDUewYp4kNohActOO3y/ji9xFRVbxYAXdmUpnyDH6Ol7T9bSGiaVUz7gMzbdjDvA6u/krweblhva6zGLWHVpABVVUZYfrVB5i4sf8mDsyGt2KPxTgzXElleeJIiAzom/EI595pe2KhzzUc8pAlBbASxlQaSgtpzI/ESQETERSgfRjt/RUfcPHgky5d/7mwEYQkahY3liRBVijnuIte6dY14oNwHyUXRTwQX6OCGzlT4wiIr0d+8nLJFmdE0xvmPDYHWu/gh875QankUEP2KXTDNe38CISArIODOz/t7Pf8FGM7YKTvAQiZmTGamv0qnYbqykDmnRgBhM79CLG4EpH6eUYj3C//n0d4Bpde7krmaCCkiyOEPKUheKgF29OVSNlgKma5uCHSRAlQjBDic6eeppwTXPHTWUNbOEabqKk3qO3vKAnoI369+4Vbhw4cBiBKckJ03OAoLPrqSUsp4ChnPJwYl6cFIKESGTRlgg6jZelD1rOlb/kSSFzY+L510qjDDPKYGNaWd6nH/M0pIuG5g466aQzH/laDZNS5fc/+fYdlUBkkhJhvAN32bVsYG7WiRLAgA7M+YbbpH5ydOHmp4P3aKdnXrNe4h7SQ0MamOH6EEkSJPLVSlJOSdBze91WJ45Joopj/6ZHLfKIEDGtb7sNM7/g73iyhPVeXXgIz2gS9ggvKJpNUCSbVxFiWnwWhAArVuyI2BtqMrn9sC6M6ylgkyS5lUQ2+U5mvXVv2eKRctbkXbdgW9uTn0LiFGUkaGOPAZY0a6QcdXhGk6j0rv/o88hYkYgiUkrygjU8Kz5CjGFrXKALr9APwFxK8QHhIm+t9b14/jxmwlaWTjtP855+BDrRcdv5OUPIBLCznYEJ2kmv7t/2maXv8gKuJYgfjSANzJ/gojO3GMOE6LAU1Zemyo5MCSLpzqSSbCjFjXs6wIiKpApTSptefk+CRk7wTo60mRIUAQpTh/kzqK4HpaVs0t+NWTrVOeO0rZBGGnDUV7hT308D3fpv6ePGWEM5RRRNz3HFc4rDA/wZib0M56FYHxGgYIbypoDKEMvYhI9KGglcMAGbmIuLKqL1c/SWU7o7ATSlRztvlFH8s6fgBfkyl06QNlO67wB1FOnq6kyhWUqMarRZ0GRMWPDjItiYHsn7QCcJTAb6HWw+Q2B6HDNd62J0Em3WC5jPQxAXUBlhJXX4ZyFgJ+iljzMM6cE6zvvAqL5n0ileor6aempnExjbpMeovtzqYwbQQJj4rAzTih0TCs7GWgDO6Ec7XVmuNNrgstdRme+JsfPUfCN5pM3paIHT0X2nMjMhvPg5VxpYRjkWFIrrGzKONC6NzdGLlrCjs2YIX75ltOQAdM4YiJNSVMwwyY4Z5v/PTLEoSynAjHKOuCXhQqbH4arzZIK1UTNs0EW1gaaC4wEjMGlp6vYMZ0xlfePFjWVJ7GZCCLTjw55nfXtmHQ6N9Plzu2vE8dfwpeynH2lKaMJ40TjbWK8HzonAvJXK5Zsuzz5XugIThdzJej2P2JfvKCBj1+JDRCRxXUuX/xZtW4IoNvKfHg3OOjAS1zCIiEByY0v3Q/cs+OVa5uCbkossdAOnm9cbgrVxA8zTr/1NfdnA/Darm4czmaYqRsU4sawpS/xD/xQVHaXHXmxZ4z2wnht5gpY8gsTA7DsQr2WSrHmFzz/+/PCbf4lyhA9MIaBWs5wkbzekBZD0jjmjX9MB+1TTgRTd50P5ON8aRzpZF5lLDSJanoMoFRPw5K4DjbUsZD2SrqPIBgLvyzo3yO8akiEOTb1X8kUu/nzyqmK26+92Snnv1LAgY2lIUa+ScaEuvbxNx6VEQxINEdE5Yap/ZJVBObeOLA4tpAEVhaSYq5ekKiDNMrjPXyexkXUMoiAIqezSM8GVxDwDVkkK7kzQz1ceKKioJEkKRZNA9dU37rm4j9040URPRk/KtjO0IjRfrUsO/kz0SKnUK1PvMOKv1QpcyHh+R0uGtAQStObQ7pwjHiIIgExtwc94xeBUArG0sub5rx/EbokwioMCOqo24ELQK5FBNmFBAwQUw3sFoOmvSNcU/oRn0BAMZzzje0kghgBouMq+Qk0Oj6VGGxa2bV2yJo4H05x/ZS5kJp62uViwS33X3IhNTzrTdhWL0DIHwVFzXf2aw/LGX79e/9xlU23eDb+cS4JiSiin/qlnPn/Knf++Tn7FMEtpRsZy3/ZHjZN7edLoApWYaXx6xxePufPfEWYDFfgRaGRg633XvTtJXyWxECJ1FD700jMH8/zejQeZ+b989UvZ7U17hoaf32xsOdHkOCwufGvD5eZ3J4elbuf8bYfoph8ZGf/hyuXVk0RfZ2wutSRJImB+bN5njS4jqov2inmFzGN0U07wcP3yirP5OSVAP4uop445FL1Uuq50sgQrVsD/coKSv1VtzidxtCEiKTfdvvS+7Hal5afXrdxtbDnY9CqilyjCWsMLRdnZ4v6bN/oZJsAoSTSCeDrvWGE6mTfzNZ3Fy3FaUfCz7vd3bzGwhLjm1o/fOiFlxYyfnQgEcXc+tqK4PY/CSiE7OYxEEJUemnd/boX+/lru3rLYOMuzSNS+9Ol1WafFcirNbMVOmPK7533LyGQWQeH+dfWG7KRs0Sqb6MSBPda8ZkHO24MO5h5Y+vX1F9sjQQQ0PeGWGMU0uGZl2aGJA6s33cktfJ4t2IkQou75mmtcGWl/T6PlicJncmIuKsUcppUifMwZuWxV4SEDbEI6/wizWxc+JMLIx8tXlnTn2VsmO83sZB8ynt0rLvIM5YbCg4TQGGDLgxu/MP7vyk+8y1keXTs/4zdnVry1RL6ICI0sG3v5nuPXGvjKMte/8pXobhjDpf8XqZTHCyS4csx6z/YbctitoOK1mziLgIUXGEPDS/V2yz3BRoIIOBPewyR/wBAhnePcvJNCZ4h+rEj0syg6cveuGwgANnxpjtWw0Y1fFzZjWNnc2XL34BU5z3cJLXZkYgxQi8yHWl+5Z/giAkBB+uAjgI9KVJIo/0k9TqKAW90VwMd6dfW9J7bgB5x9XX2B/wO1CEJ51zFvzwAAAABJRU5ErkJggg==');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Benflix</title>
		<meta name=viewport content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="author" lang="fr" content="benji1000">

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAyklEQVQ4jcWSyw2DMBBEX6IUQAURJVBBBB1QQT6XaQNRAfc9pgI6gFQASgVRKqCEHDCR5UTAjZFWXq/X4/FoYWvswoKkK3AJygPwAGoze/kH+z+kRyANIgcqoJMULxFM6IHMReFqEXD2mw4zBIOZtS5vJd2AOGyaI4gkpS4/eZefawkSoPEVAZWZ1X7TnAcD0Lp4Mf6/lJSvVdCbWTZtJHVOVQF8Vcwp+CF0a7JWgW9izDgL+K8vEYQmwuhLuUTwZjQuRAPcw1HeHh8kSTJnDU8pPQAAAABJRU5ErkJggg=="/>
		
		<style>
			/* GLOBAL STYLES */
			body {
				background-color: #171717;
			}
			#wall {
				width: 100%;
				text-align: center;
				padding-top: 60px;
			}

			/* SPINNER */
			.spinner {
				margin-top: 9px;
				width: 70px;
				text-align: center;
			}
			.spinner > div {
				width: 18px;
				height: 18px;
				background-color: #7D7D7D;
				border-radius: 100%;
				display: inline-block;
				-webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
				animation: sk-bouncedelay 1.4s infinite ease-in-out both;
			}
			.spinner .bounce1 {
				-webkit-animation-delay: -0.32s;
				animation-delay: -0.32s;
			}
			.spinner .bounce2 {
				-webkit-animation-delay: -0.16s;
				animation-delay: -0.16s;
			}
			@-webkit-keyframes sk-bouncedelay {
				0%, 80%, 100% { -webkit-transform: scale(0) }
				40% { -webkit-transform: scale(1.0) }
			}
			@keyframes sk-bouncedelay {
				0%, 80%, 100% {
					-webkit-transform: scale(0);
					transform: scale(0);
				} 40% {
				-webkit-transform: scale(1.0);
					transform: scale(1.0);
				}
			}

			/* MOVIE LIST */
			#nothing {
				display: none;
			}
			.big-error-message {
				font-size: 72px;
				position: absolute;
				top: 40%;
				text-align: center;
				left: 0;
				right: 0;
			}
			.error-message-subtext{
				font-size: 35px;
			}
			.img-thumbnail {
				height: 300px !important;
				width: 210px !important;
				margin: 12px;
				transition: all 0.5s ease;
				opacity: 0.8;
			}
			.img-thumbnail:hover {
				opacity: 1;
				cursor: pointer;
				transform: scale(1.07);
			}

			/* MOVIE MODAL */
			.modal-body > .container {
				max-width: 100%;
			}
			#extended-infos > p > .btn {
				width: 340px;
				max-width: 100%;
			}
			.modal {
				text-align: left;
			}
			.col-md-4 > img {
				max-width: 100%;
			}
			#extended-infos {
				text-align: center;
			}
			#extended-infos p{
				padding-top: 20px;
			}
			@media (min-width: 992px){
				.col-md-5 {
					width: 38%;
				}
			}

			/* SEARCH MODAL */
			#search-modal p {
				margin-top: 10px;
				text-align: center;
				margin-bottom: 0;
			}#search-modal h1 {
				font-size: 18px;
				text-align: center;
				margin-top: 0;
				margin-bottom: 15px;
			}
			#search-modal .form-group {
				margin-bottom: 0;
			}

			/* ABOUT MODAL */
			#about-modal .modal-body {
				text-align: center;
				margin-top: 20px;
			}
			#about-modal .modal-footer img {
				float: left;
			}

			/* TOP NAVBAR */
			.nav-bar {
				margin-right: auto;
				margin-left: auto;
				padding: 5px 30px;
				width: 100%;
				top: 0;
				position: fixed;
				z-index: 8;
				background: #1d1d1d;
				font-size: 1.3em;
				color: #7d7d7d;
				border-bottom: 1px solid #2f2f2f;
				backface-visibility: hidden;
				height: 50px;
			}
			.nav-logo img {
				margin-top: 5px;
				margin-right: 20px;
				height: 30px;
			}
			#about-div {
				display: inline-block;
			}
			#about-div .btn {
				width: 22px;
			}
			.buttons-topbar {
				margin-left: 10px;
				margin-top: 9px;
			}
			.dropdown-menu {
				z-index: 9999;
				min-width: 0px !important;
				width: 130px;
			}
			.dropdown-menu > li > a > strong {
				font-variant: all-small-caps;
				font-size: 16px;
			}
			@media (max-width: 725px){
				.big-screens {
					display: none;
				}
			}
			@media (max-width: 992px){
				.img-thumbnail {
					height: 140px !important;
					width: 95px !important;
					margin: 5px 10px;
					transition: all 0.5s ease;
					opacity: 0.8;
				}

				#modal-poster {
					display: none;
				}
			}
		</style>

		<script>
			var genresAvailable = new Array();
		
			function getMovieInfo(fileName, changeTime, id){
				$.ajax({
					url : '<?php echo basename($_SERVER["PHP_SELF"]); ?>',
					type : 'POST',
					data : 'action=getMovieInfo&movieName='+encodeURIComponent(fileName.replace(/\.[^/.]+$/, "")),
					dataType: 'json',
					success: function(movieInfo){
						if(movieInfo.Response == 'True'){
							$('#movieList').append('<img class="img-thumbnail poster" src="'+movieInfo.Poster+'" data-id="movie-'+id+'" data-title="'+movieInfo.Title+'" data-file="'+fileName+'" data-actors="'+movieInfo.Actors+'" data-director="'+movieInfo.Director+'" data-year="'+movieInfo.Year+'" data-released="'+new Date(movieInfo.Released)+'" data-added="'+new Date(changeTime*1000)+'" data-runtime="'+parseInt(movieInfo.Runtime)+'" data-title="'+movieInfo.Title+'" data-genre="'+movieInfo.Genre+'" data-imdbid="'+movieInfo.imdbID+'" data-imdbrating="'+movieInfo.imdbRating+'" data-toggle="modal" data-target="#modal" alt="" />');
						
							// Set an array of available genres
							var genres = movieInfo.Genre.split(', ');
							genres.forEach(function(genre){
								if(genresAvailable.indexOf(genre) < 0){
									genresAvailable.push(genre)
								}
							});
						}
						else {
							console.log("Couldn't get the movie info for file: " + fileName);
						}
					},
					error : function(result, status, error){
						console.log("Couldn't get the movie info for file: " + fileName);
					}
				});
			}

			function search(searchString){
				var movies = document.getElementsByClassName('img-thumbnail');
				var found = 0;
				for(var i = 0; i < movies.length; i++){
					if(movies.item(i).dataset.title.toLowerCase().search(searchString) < 0){
						$('.img-thumbnail[data-title="'+movies.item(i).dataset.title+'"]').fadeOut();
					}
					else {
						$('.img-thumbnail[data-title="'+movies.item(i).dataset.title+'"]').fadeIn();
						found += 1;
					}
				}

				// If no movie matches the criteria, display a warning
				if(found == 0){
					$('#nothing').show();
				}
				else {
					$('#nothing').hide();
				}
			}

			$(window).load(function() {
				// Check that the user has an API key
				if(("<?php echo API_KEY; ?>" == 'PLACE_YOUR_API_KEY_HERE') || ("<?php echo API_KEY; ?>" == '')){
					alert("<?php echo translate('You need to get an API key for the OMDb API. Don\'t worry, it\'s very simple!\nPlease read the instructions at the top of this file.'); ?>");
				}
				else {
					// Request all movies available on the server at page load
					var promise = $.ajax({
						url : '<?php echo basename($_SERVER["PHP_SELF"]); ?>',
						type : 'POST',
						data : 'action=getAvailableMovies',
						dataType: 'json',
						success : function(fileList, status){
							var id = 0;
							fileList.forEach(function(file){
								getMovieInfo(file.name, file.time, id);
								id++;
							});
						},
						error : function(result, status, error){
							console.log("Couldn't get the list of available movies.");
						}
					});
				}
				
				// Hide the spinner and show the filters
				$('.spinner').fadeOut('slow', function() {
					$('#controls').fadeIn('fast');
				});

				// Handle a click on a poster
				$("#movieList").on('click', '.poster', function(e){
					$("#modal-title").html($(this).data('title') + ' <small>' + $(this).data('year') + '</small>');
					$("#modal-poster").html('<img src="' + $(this).attr('src') + '" alt="" />');
					$("#modal-genre").text($(this).data('genre'));
					$("#modal-director").text($(this).data('director'));
					$("#modal-actors").text($(this).data('actors'));
					$("#modal-imdbLink").attr('href', 'http://www.imdb.com/title/'+$(this).data('imdbid'));
					$("#modal-trailerLink").attr('href', 'https://www.youtube.com/results?search_query=' + encodeURI($(this).data('title')) + ' trailer vost');
					$("#modal-fileLink").attr('href', '/Films/'+$(this).data('file'));

					// Display the rating in a Bootstrap label
					var htmlRating = '';
					if($(this).data('imdbrating') >= 7.5){
						htmlRating = '<span class="label label-success">' + $(this).data('imdbrating') + '</span>';
					}
					else if($(this).data('imdbrating') >= 5){
						htmlRating = '<span class="label label-warning">' + $(this).data('imdbrating') + '</span>';
					}
					else {
						htmlRating = '<span class="label label-danger">' + $(this).data('imdbrating') + '</span>';
					}
					$("#modal-rating").html(htmlRating);

					// Display the runtime in (lazy) human-readable format
					var runtime = $(this).data('runtime');
					var hours = Math.floor(runtime/60);
					var minutes = Math.floor(runtime%60/10)*10;
					$("#modal-runtime").text(hours + 'h' + ("0" + minutes).slice(-2));
				});

				// Enable search when pressing Ctrl+F
				$(window).keypress(function(event){
				    if (!(event.which == 115 && event.ctrlKey) && !(String.fromCharCode(event.which).toLowerCase() == 'f')) return true;
				    $('.modal').not('#search-modal').modal('hide');
					$('#search-modal').modal('toggle');
				    event.preventDefault();
				    return false;
				});

				// Reset the search field when the modal is shown
				$('#search-modal').on('show.bs.modal', function(e){
					$('#search-input').val('');
					search('');
				});
				$('#search-modal').on('shown.bs.modal', function(e){
					$('#search-input').focus();
				});

				// Handle the search field
				$('#search-input').on('keyup',function(){
					search($(this).val().toLowerCase());
				});
				
				// Handle a filter button
				$('.buttons-topbar').on('click','.dropdown-menu li a',function(){
					//Adds active class to selected item
					$(this).parents('.dropdown-menu').find('li').removeClass('active');
					$(this).parent('li').addClass('active');
   
					// Handle the styling of a filter button
					var text = $(this).text();
					var value = $(this).data('value');
					var button = $(this).parents('.btn-group');
					var id = button.attr('id');
					var icon = '';
					switch(id) {
						case 'order-selector':
							icon = '<span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>';
							defaultText = '<?php echo translate('Order by...'); ?>';
							break;
						case 'runtime-selector':
							icon = '<span class="glyphicon glyphicon-time" aria-hidden="true"></span>';
							defaultText = '<?php echo translate('Runtime'); ?>';
							break;
						case 'imdb-selector':
							icon = '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
							defaultText = 'IMDb';
							break;
						case 'genre-selector':
							icon = '<span class="glyphicon glyphicon-th" aria-hidden="true"></span>';
							defaultText = 'Genre';
							break;
					}
					if((value == '*') || (value == 'title')){
						button.find('.dropdown-toggle').html(icon + ' ' + defaultText + ' <span class="caret"></span>').removeClass('btn-warning');
					}
					else {
						button.find('.dropdown-toggle').html(icon + ' ' + text + ' <span class="caret"></span>').addClass('btn-warning');
					}
					button.data('value', value);
					
					// Get the values of ALL dropdowns
					var runtime = $('#runtime-selector').data('value');
					var imdb = $('#imdb-selector').data('value');
					var genre = $('#genre-selector').data('value');
					var order = $('#order-selector').data('value');
					
					// Hide all movies then pick only relevant ones
					var showed = 0;
					var movies = new Array();
					$('.img-thumbnail').each(function(i, img){
						$(img).hide();
						if(
							((runtime == '*') || ($(img).data('runtime') <= runtime))
							&& ((imdb == '*') || ($(img).data('imdbrating') >= imdb))
							&& ((genre == '*') || ($(img).data('genre').indexOf(genre) >= 0))
						){
							movies.push({characteristic:$(img).data(order),id:$(img).data('id')});
							showed++;
						}
					});
					
					// Order relevant movies according to what the user asked
					if(order == 'title'){
						movies.sort(function(a,b){
							if (a.characteristic < b.characteristic){
								return -1;
							}
							if (a.characteristic > b.characteristic){
								return 1;
							}
							return 0;
						});
					}
					else {
						movies.sort(function(a,b) {
							return new Date(b.characteristic).getTime() - new Date(a.characteristic).getTime();
						});
					}
					
					// Show relevant movies according to what the user asked
					movies.forEach(function(movie){
						var img = $('.img-thumbnail[data-id='+movie.id+']');
						$('#movieList').append(img);
						img.show();
					});
					
					// If no movie matches the criteria, display a warning
					if(showed == 0){
						$('#nothing').show();
					}
					else {
						$('#nothing').hide();
					}
				});
			});
			
			$(document).ajaxStop(function () {
				// Populate the genres selector
				genresAvailable.sort().forEach(function(genre){
					$('#genre-selector').find('ul').append($('<li>').append($('<a>').attr('href','#').attr('title', '').attr('data-value', genre).text(genre)));
				});
			});
		</script>
	</head>

	<body>
		<header class="nav-bar">
			<div class="nav-logo pull-left">
				<img src="<?php echo BENFLIX_LOGO; ?>" alt="Benflix"/>
			</div>
			<div class="pull-right">
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
				
				<div id="controls" style="display: none">
					<button type="button" class="btn btn-default buttons-topbar btn-xs btn-success" data-toggle="modal" data-target="#search-modal" title="<?php echo translate('Search for a movie'); ?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo translate('Search'); ?></button>
					
					<div id="order-selector" class="btn-group buttons-topbar" data-value="title">
						<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo translate('Order by...'); ?>"><span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span> <?php echo translate('Order by...'); ?> <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li class="active"><a href="#" title="" data-value="title"><?php echo translate('Alphabetical'); ?></a></li>
							<li><a href="#" title="" data-value="added"><?php echo translate('Date added'); ?></a></li>
							<li><a href="#" title="" data-value="released"><?php echo translate('Date released'); ?></a></li>
						</ul>
					</div>
					
					<div id="runtime-selector" class="btn-group buttons-topbar big-screens" data-value="*">
						<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo translate('Filter by movie length'); ?>"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo translate('Runtime'); ?> <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li class="active"><a href="#" title="" data-value="*"><strong><strong><?php echo translate('All'); ?></strong></strong></a></li>
							<li><a href="#" title="" data-value="90">< 1h30</a></li>
							<li><a href="#" title="" data-value="120">< 2h</a></li>
							<li><a href="#" title="" data-value="180">< 3h</a></li>
						</ul>
					</div>
					
					<div id="imdb-selector" class="btn-group buttons-topbar big-screens" data-value="*">
						<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo translate('Filter by IMDb score'); ?>"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <?php echo translate('IMDb rating'); ?> <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li class="active"><a href="#" title="" data-value="*"><strong><?php echo translate('All'); ?></strong></a></li>
							<li><a href="#" title="" data-value="9">IMDb > 9</a></li>
							<li><a href="#" title="" data-value="8">IMDb > 8</a></li>
							<li><a href="#" title="" data-value="7">IMDb > 7</a></li>
							<li><a href="#" title="" data-value="6">IMDb > 6</a></li>
							<li><a href="#" title="" data-value="5">IMDb > 5</a></li>
						</ul>
					</div>
					
					<div id="genre-selector" class="btn-group buttons-topbar big-screens" data-value="*">
						<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php echo translate('Filter by category'); ?>"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> <?php echo translate('Genre'); ?> <span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li class="active"><a href="#" title="" data-value="*" selected><strong><strong><?php echo translate('All'); ?></strong></strong></a></li>
						</ul>
					</div>
					
					<button type="button" class="btn btn-default buttons-topbar btn-xs btn-info" data-toggle="modal" data-target="#about-modal" title="<?php echo translate('About this app'); ?>"><strong>?</strong></button>
				</div>
			</div>
		</header>
		<div class="container" id="wall">
			<!-- Modal which displays the details of a movie -->
			<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="modal-title"><span class="glyphicon glyphicon-film" aria-hidden="true"></span></h4>
						</div>
						<div class="modal-body">
							<div class="container">
								<div class="row">
									<div class="col-md-5">
										<span id="modal-poster"></span>
									</div>
									<div class="col-md-7">
										<p><strong><?php echo translate('Genre:'); ?></strong> <span id="modal-genre"></span><br />
										<strong><?php echo translate('Runtime:'); ?></strong> <span id="modal-runtime"></span></p>
										<p><strong><?php echo translate('Directed by:'); ?></strong> <span id="modal-director"></span><br />
										<strong><?php echo translate('With:'); ?></strong> <span id="modal-actors"></span><br />
										<strong><?php echo translate('IMDB rating:'); ?></strong> <span id="modal-rating"></span></p>
										<div id="extended-infos">
											<p><a id="modal-imdbLink" href="" title="<?php echo translate('Go to the IMDb page'); ?>" target="_blank" type="button" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> <?php echo translate('Go to the IMDb page'); ?></a></p>
											<p><a id="modal-trailerLink" href="" title="<?php echo translate('Watch the trailer on YouTube'); ?>" target="_blank" type="button" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> <?php echo translate('Watch the trailer on YouTube'); ?></a></p>
											<p><a id="modal-fileLink" href="" title="<?php echo translate('Download the movie'); ?>" type="button" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> <?php echo translate('Download the movie'); ?></a></p>
											<p><em><?php echo translate('You can play the movie before its downloaded<br />by opening the .part or .crdownload file with VLC.'); ?></em></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo translate('Close'); ?></button>
						</div>
					</div>
				</div>
			</div>

			<!-- Search modal -->
			<div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-body">
							<h1><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?php echo translate('Search for a movie'); ?></h1>
							<div class="form-group">
								<input type="text" class="form-control" id="search-input" autofocus="autofocus">
							</div>
							<p><a href="#" title="<?php echo translate('Close this modal'); ?>" data-dismiss="modal" class="close-search-modal"><?php echo translate('Close'); ?></a></p>
						</div>
					</div>
				</div>
			</div>

			<!-- About modal -->
			<div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<img src="<?php echo BENFLIX_LOGO; ?>" alt="Benflix"/>
							<h2><?php echo translate('By'); ?> <a href="https://twitter.com/b3nji1000" title="Twitter" target="_blank">@benji1000</a></h2>
							<p><?php echo translate('Bugs? Ideas? Tell me more on'); ?> <a href="https://github.com/benji1000/benflix" title="<?php echo translate('The project page on Github'); ?>" target="_blank" rel="noreferrer">Github</a>.</p>
						</div>
						<div class="modal-footer">
							<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/" title="Creative Commons BY-NC-SA" target="_blank"><img src="data:image/png;base64,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" alt="Creative Commons BY-NC-SA" /></a>
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo translate('Close'); ?></button>
						</div>
					</div>
				</div>
			</div>

			<!-- Container for the list of available movies -->
			<div id="movieList" class="row">
				<div id="nothing" class="big-error-message"><?php echo translate('No movie matches criteria'); ?><br /><span class="error-message-subtext">(<?php echo translate('Deactivate some filters'); ?>)</span></div>
				<noscript><div class="big-error-message"><?php echo translate('Benflix needs JavaScript enabled to work.'); ?></div></noscript>
			</div>
		</div>
	</body>
</html>