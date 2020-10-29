<?php
/**
 * @package rb_name_gen
 * @version 1.0.0
 */
/*
Plugin Name: Name generator
Plugin URI: http://www.getuwired.com
Description: Will generate names for content suggestion and link to godaddy availability 
Author: RB
Version: 1.0.0
*/

	
$verbs = file('./termlist.list');
$adjs = file('./adj.list');




function adjectivfy($word){
	
	?>

	<style type="text/css" media="screen">
	
		body{
			text-align: center;
		}
	
		ol li {
			margin: 10px 0;
		}
	
		a{
		     color: purple;
		     font-family: Comic Sans MS;
		     font-size: 20px;
		     text-decoration: none;
		}
	
	</style>
	<?php	
	

	$mystic = array('able', 'ible', 'al', 'ful', 'ic', 'ive', 'less', 'i', 'y', 'ly', 'ous', 'ness' );
	
	$index = rand(0, count($mystic) );
	
	$ending = $mystic[$index];
	
	$lastLetter = substr($word, -1);
	
	
	
	switch($ending){
		case 'al':
			if($lastLetter == 'e'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'y':
			if($lastLetter == 'e'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'full':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1).'i';
			}
			break;
		case 'ous':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'ius':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'ic':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'y':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1);
			}
			break;
		case 'ly':
			if($lastLetter == 'y'){
				$word = substr($word,0,  -1);
			}
			break;
			default: break;
	}
	
	
	
	
	return $word.$ending;
}


function printList(){
	$articles = array('The', 'A', 'One');


	$numWords = 100;

	echo '<ol>';
	for ($i=0; $i < $numWords; $i++) { 
	
		$domain = '';
	
		$verbIndex = rand(0, count($verbs));
		$adjIndex = rand(0, count($adjs));
	
		$adj = $adjs[$adjIndex];
		$verb = $verbs[$verbIndex];
	
		$adjectivfy = rand(0,1);
	
		if($adjectivfy){
			$verb = adjectivfy($verb);
		}
	
	
		$useArticle = rand(0,1);
	
		if($useArticle){
		
			$articleIndex = rand(0, count($articles));
			$article = $articles[$articleIndex];
		
		
			$domain = $article.$adj.$verb;	
		
		}else {
			$domain = $adj.$verb;
		}
	
	
		$domain = preg_replace('/\s+/', '', $domain).'.com';
		$domain = '<a target="_BLANK" href="https://www.godaddy.com/domains/searchresults.aspx?checkAvail=1&domainToCheck='.$domain.'">'.$domain.'</a>';
	
		echo '<li>'.$domain.'</li>';
	
	}
	echo '</ol>';
}



?>