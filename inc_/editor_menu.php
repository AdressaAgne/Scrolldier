<?php
	//helpers: class => split, break => break
	$bigEditor = array(
		array(
			"icon" => "icon-order",
			"tooltip" => "Order Icon",
			"data-tip" => "The Order Faction Icon",
			"data-type" => "order",
			"data-class" => "icon"
		),
		array(
			"icon" => "icon-growth",
			"tooltip" => "Growth Icon",
			"data-tip" => "The Growth Faction Icon",
			"data-type" => "growth",
			"data-class" => "icon"
		),
		array(
			"icon" => "icon-energy",
			"tooltip" => "Energy Icon",
			"data-tip" => "The Energy Faction Icon",
			"data-type" => "energy",
			"data-class" => "icon"
		),
		array(
			"icon" => "icon-decay",
			"tooltip" => "Decay Icon",
			"data-tip" => "The Decay Faction Icon",
			"data-type" => "decay",
			"data-class" => "icon"
		),
		array(
			"icon" => "icon-wild",
			"tooltip" => "Wild Icon",
			"data-tip" => "The Wild Faction Icon",
			"data-type" => "wild",
			"data-class" => "icon"
		),
		array(
			"class" => "split"
		),
		array(
			"icon" => "icon-shard",
			"tooltip" => "Shard Icon",
			"data-tip" => "In-game Shard icon",
			"data-type" => "shard",
			"data-class" => "icon"
		),
		array(
			"icon" => "icon-coin",
			"tooltip" => "Coin Icon",
			"data-tip" => "In-game Money Icon",
			"data-type" => "coin",
			"data-class" => "icon"
		),
		array(
			"class" => "split"
		),
		array(
			//"text" => "Badges",
			"icon" => "icon-more",
			"tooltip" => "Caller Badges",
			"data-tip" => "All in-game caller badges",
			"data-class" => "dropdown",
			"content" => array(
				array(
					"icon" => "icon-Adventurer",
					"tooltip" => "Adventurer Badge",
					"data-type" => "Adventurer",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Adept",
					"tooltip" => "Adept Badge",
					"data-type" => "Adept",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Trickster",
					"tooltip" => "Trickster Badge",
					"data-type" => "Trickster",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Sorcerer",
					"tooltip" => "Sorcerer Badge",
					"data-type" => "Sorcerer",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Apprentice-Caller",
					"tooltip" => "Apprentice Caller Badge",
					"data-type" => "Apprentice-Caller",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Caller",
					"tooltip" => "Caller Badge",
					"data-type" => "Caller",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Accomplished-Caller",
					"tooltip" => "Accomplished Caller Badge",
					"data-type" => "Accomplished-Caller",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Master-Caller",
					"tooltip" => "Master Caller Badge",
					"data-type" => "Master-Caller",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Exalted-Caller",
					"tooltip" => "Exalted Caller Badge",
					"data-type" => "Exalted-Caller",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Grand-Master",
					"tooltip" => "Grand-Master Badge",
					"data-type" => "Grand-Master",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Aspect-Commander",
					"tooltip" => "Aspect Commander Badge",
					"data-type" => "Aspect-Commander",
					"data-class" => "icon"
				),
				array(
					"icon" => "icon-Ascendant",
					"tooltip" => "Ascendant Badge",
					"data-type" => "Ascendant",
					"data-class" => "icon"
				)
			)
		),
		array(
			"break" => "break"
		),
		array(
			"icon" => "icon-money",
			"tooltip" => "Money",
			"data-tip" => "[money]10 000[/money]",
			"data-type" => "money",
			"data-class" => "style"
		),
		
		
		array(
			"icon" => "icon-bold",
			"tooltip" => "<b>Bold Text</b>",
			"data-tip" => "[b]text[/b]",
			"data-type" => "b",
			"data-class" => "style"
		),
		
		array(
			"icon" => "icon-italic",
			"tooltip" => "<em>Italic Text</em>",
			"data-tip" => "[em]text[/em]",
			"data-type" => "em",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-strike",
			"tooltip" => "<span class='strike'>Strikeout Text</span>",
			"data-tip" => "[s]text[/s]",
			"data-type" => "s",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-header",
			"tooltip" => "Header",
			"data-tip" => "[h]text[/h]",
			"data-type" => "h",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-header-2",
			"tooltip" => "Header 2, Small Size",
			"data-tip" => "[h2]text[/h2]",
			"data-type" => "h2",
			"data-class" => "style"
		),
		
		array(
			"class" => "split"
		),
		array(
			"icon" => "icon-align-left",
			"tooltip" => "Align Text Left",
			"data-tip" => "[left]text[/left]",
			"data-type" => "left",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-align-center",
			"tooltip" => "Align Text Center",
			"data-tip" => "[center]text[/center]",
			"data-type" => "center",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-align-right",
			"tooltip" => "Align Text Right",
			"data-tip" => "[right]text[/right]",
			"data-type" => "right",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-block-1",
			"tooltip" => "1 column",
			"data-tip" => "Make 1/1 Column: [block-1]text[/block-1]",
			"data-type" => "block-1",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-block-2",
			"tooltip" => "2 columns",
			"data-tip" => "Make 1/2 Column: [block-2]text[/block-2]",
			"data-type" => "block-2",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-block-3",
			"tooltip" => "3 columns",
			"data-tip" => "Make 1/3 Column: [block-3]text[/block-3]",
			"data-type" => "block-3",
			"data-class" => "style"
		),
		array(
			"class" => "split"
		),
		array(
			"icon" => "icon-tab",
			"tooltip" => "Tab",
			"data-tip" => "[/t]text",
			"data-type" => "t",
			"data-class" => "icon"
		),
		array(
			"class" => "split"
		),
		array(
			"icon" => "icon-link-h",
			"tooltip" => "URL",
			"data-tip" => "[url=http://url]text[/url] or [url]http://url[/url]",
			"data-start" => "url=",
			"data-close" => "url",
			"data-class" => "special"
		),
		array(
			"icon" => "icon-img",
			"tooltip" => "Image",
			"data-tip" => "[img]http://imageurl[/img]",
			"data-type" => "img",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-code",
			"tooltip" => "Code",
			"data-tip" => "[code]script[/code]",
			"data-type" => "code",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-youtube-white",
			"tooltip" => "Youtube video",
			"data-tip" => "[youtube]https://www.youtube.com/watch?v=<b>YcaFw9_EVYM</b>[/youtube], or [youtube]<b>YcaFw9_EVYM</b>[/youtube]",
			"data-type" => "youtube",
			"data-class" => "style"
		)
//		array(
//			"icon" => "icon-deck-white",
//			"tooltip" => "Scrolldier Deck",
//			"data-tip" => "[deck]deckID[/deck] or [deck=DeckID]text[/deck]",
//			"data-start" => "deck",
//			"data-close" => "deck",
//			"data-class" => "special"
//		)
	);
	