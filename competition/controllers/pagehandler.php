<?php 
//declaring page structures

class Base {
	public $pagestructure = array(
		"/" => array( 						//url extension
			"title" 	=> "Scrolldier",	//title
			"page" 		=> "main", 			//file name without .php
			"menu" 		=> true, 			//if its included in the menu or not
			"name" 		=> "Scrolldier", 			//name of the page
			"style" 	=> "" 				//additional styles
		),
	
		"/decks" => array(
			"title" 	=> "Scrolldier - Decks",
			"page" 		=> "deck/deck",
			"menu" 		=> true,
			"name" 		=> "Decks",
			"style" 	=> ""
		),
		
		"/deck" => array(
			"title" 	=> "Scrolldier - Deck",
			"page" 		=> "deck/view_deck",
			"menu" 		=> false,
			"name" 		=> "Deck",
			"style" 	=> ""
		),
		
		"/deckcomp" => array(
			"title" 	=> "Scrolldier - Deck Building Competition",
			"page" 		=> "deck/submit_deck",
			"menu" 		=> true,
			"name" 		=> "Deck Building Competition",
			"style" 	=> ""
		),
		
		"/post" => array(
			"title" 	=> "Scrolldier - Blog",
			"page" 		=> "post",
			"menu" 		=> false,
			"name" 		=> "Blog",
			"style" 	=> ""
		),
		
		"/keywords" => array(
			"title" 	=> "Scrolldier - In-game Keywords",
			"page" 		=> "data/keywords",
			"menu" 		=> false,
			"name" 		=> "In-game Keywords",
			"style" 	=> ""
		),
		
		"/login" => array(
			"title" 	=> "Scrolldier - Login",
			"page" 		=> "login",
			"menu" 		=> false,
			"name" 		=> "Login",
			"style" 	=> ""
		),
		
		"/guide" => array(
			"title" 	=> "Scrolldier - Deck guides",
			"page" 		=> "guide",
			"menu" 		=> true,
			"name" 		=> "Deck Guides",
			"style" 	=> ""
		),
		
		"/atmaz" => array(
			"title" 	=> "Scrolldier - The Atmaz Guessing game",
			"page" 		=> "atmaz",
			"menu" 		=> false,
			"name" 		=> "The Atmaz Guessing Game",
			"style" 	=> ""
		),
		
		"/terms" => array(
			"title" 	=> "Scrolldier - Terms and Conditions",
			"page" 		=> "info/terms_and_conditions",
			"menu" 		=> false,
			"name" 		=> "Terms and Conditions",
			"style" 	=> ""
		),
		
		
		"/new" => array(
			"title" 	=> "Scrolldier - Deckbuilder",
			"page" 		=> "deck/new_deck",
			"menu" 		=> false,
			"name" 		=> "New Deck",
			"style" 	=> ""
		),
		"/deckbuilder" => array(
			"title" 	=> "Scrolldier - Deckbuilder",
			"page" 		=> "deck/deckbuilder",
			"menu" 		=> false,
			"name" 		=> "DeckBuilder",
			"style" 	=> ""
		),
		
		"404" => array(
			"title" 	=> "404 Error",
			"page" 		=> "404",
			
			"name" 		=> "Error 404, page does not exist",
			"style" 	=> ""
		)
	);
}