<?php if (isset($_SESSION['username'])) { ?>

<?php 

	$smallEditor = array(
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
			"icon" => "icon-bold",
			"tooltip" => "<b>Bold Text</b>",
			"data-type" => "b",
			"data-tip" => "[b]text[/b]",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-italic",
			"tooltip" => "<em>Italic Text</em>",
			"data-type" => "em",
			"data-tip" => "[em]text[/em]",
			"data-class" => "style"
		),
		array(
			"icon" => "icon-money",
			"tooltip" => "Money",
			"data-type" => "money",
			"data-tip" => "[money]10 000[/money]",
			"data-class" => "style"
		)
	);
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
			"icon" => "icon-header",
			"tooltip" => "Header",
			"data-tip" => "[h]text[/h]",
			"data-type" => "h",
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
		)
	);
	
	
	$btnSelection = $bigEditor;
	
	
 ?>

<div class="containerComment">

	
	
	<div class="comment clearfix">
		<form method="post" class="commentBox" action="">
				<input type="hidden" class="textbox full div-3" name="name" value="<?php echo($_SESSION['username']) ?>" />
				<input type="hidden" name="headID" value="<?php echo($_SESSION['headID']) ?>" />
		
			
			<div class="">
				<div class="modern-header">
					<ul class="comment-icons">
						<?php 
						
							for ($i = 0; $i < count($btnSelection); $i++) {
								if (isset($btnSelection[$i]['break'])) {
									echo("</ul><ul class='comment-icons'>");
								} else {
								echo(" <li");
								
									if (isset($btnSelection[$i]['data-class'])) {
										echo(' data-class="'.$btnSelection[$i]["data-class"].'"');
									}
									if (isset($btnSelection[$i]['data-type'])) {
										echo(' data-type="'.$btnSelection[$i]["data-type"].'"');
									}
									
									if (isset($btnSelection[$i]['data-start'])) {
										echo(' data-start="'.$btnSelection[$i]["data-start"].'"');
									}
									if (isset($btnSelection[$i]['data-close'])) {
										echo(' data-close="'.$btnSelection[$i]["data-close"].'"');
									}
									
									if (isset($btnSelection[$i]['data-tip'])) {
										echo(' data-tip="'.$btnSelection[$i]["data-tip"].'"');
									}
									
									echo(' class="');
									if (isset($btnSelection[$i]['class'])) {
										echo($btnSelection[$i]['class']);
									} else {
										echo("btn-modern btn-no-margin");
									}
									echo('">');
									
									
									if (isset($btnSelection[$i]['icon'])) {
										echo('<i class="'.$btnSelection[$i]["icon"].'"></i>');
									}
									if (isset($btnSelection[$i]['text'])) {
										echo($btnSelection[$i]["text"]);
									}
									if (isset($btnSelection[$i]['tooltip'])) {
										echo('<ul class="tooltip"><li>'.$btnSelection[$i]["tooltip"].'</li></ul>');
									} 
									
									if (isset($btnSelection[$i]['data-class'])) {
										
										if ($btnSelection[$i]['data-class'] == "dropdown") {
										
											
										
											echo("<ul class='dropdown'>");
											for ($j = 0; $j < count($btnSelection[$i]['content']); $j++) {
												echo("<li");
												
													if (isset($btnSelection[$i]['content'][$j]['data-class'])) {
														echo(' data-class="'.$btnSelection[$i]['content'][$j]["data-class"].'"');
													}
													if (isset($btnSelection[$i]['content'][$j]['data-type'])) {
														echo(' data-type="'.$btnSelection[$i]['content'][$j]["data-type"].'"');
													}
													
													echo(' class="');
													if (isset($btnSelection[$i]['content'][$j]['class'])) {
														echo($btnSelection[$i]['content'][$j]['class']);
													} else {
														echo("btn-modern btn-no-margin");
													}
													echo('">');
												
												
													if (isset($btnSelection[$i]['content'][$j]['icon'])) {
														echo('<i class="'.$btnSelection[$i]['content'][$j]["icon"].'"></i>');
													}
													if (isset($btnSelection[$i]['content'][$j]['tooltip'])) {
														echo('<ul class="tooltip"><li>'.$btnSelection[$i]['content'][$j]["tooltip"].'</li></ul>');
													} 
												
												echo("</li>");
											}

												
											echo("</ul>");
											
										}
										
									}
									
								echo("</li>");
								}
							} ?>

						<li id="trash" class="btn-modern btn-no-margin right"><i class="icon-trash"></i>
							<ul class="tooltip">
								<li>Clear</li>
							</ul>
						</li>
					</ul>
				</div>
				<textarea id="editor" name="comment" rows="4"class="modern-textarea full" placeholder="Write a comment about this?"></textarea>
				<div class="modern-footer">
					<div class="left">
						<p id="tip" class="color-dark" style="font-size: 12px;">Scrolldier Editor</p>
					</div>
					<div class="left clear">
						<p class="color-dark" style="font-size: 12px;">BBcode: On</p>
					</div>
					<div class="left">
						<p class="color-dark" style="font-size: 12px;">HTML: Off</p>
					</div>
					<div class="left">
						<p id="len" class="color-dark" style="font-size: 12px;"></p>
					</div>
					<div class="left">
						<p id="words" class="color-dark" style="font-size: 12px;"></p>
					</div>
					<div class="right">
						<input type="submit" class="modern-submit btn-modern-white" name="submit" value="Comment" />
					</div>
					
				</div>
				
			</div>
		</form>
	</div>
</div>
<script src="<?php echo($main."jquery.js") ?>" type="text/javascript"></script>
<script>
$(function() {
	var len_prefix = "Characters: ";
	var word_prefix = "Words: ";
	$("li[data-class='icon']").click(function() {
		changeText("[/"+$(this).attr("data-type")+"]");
		updateStatusBar();
	});
	
	$("li[data-class='style']").click(function() {
		replaceTextBB("editor", $(this).attr("data-type"), $(this).attr("data-type"));
		updateStatusBar();
	});
	
	$("li[data-class='special']").click(function() {
		replaceTextBB("editor", $(this).attr("data-start"), $(this).attr("data-close"));
		updateStatusBar();
	});
	
	$("li[data-tip]").hover(function() {
		$("#tip").text("tip: "+$(this).attr("data-tip"));
	});
	
	$("li[data-class='dropdown']").click(function() {
		$(this).find("ul.dropdown li").toggle();
		$(this).find("ul.dropdown").toggle();
	});
	
	$("#trash").click(function() {
		$("#editor").val("");
		$("#editor").focus();
		updateStatusBar();
	});
	
	$("#editor").keyup(function() {
		updateStatusBar();
	}).keydown(function() {
		updateStatusBar();
	}).change(function() {
		updateStatusBar();
	});;
	
	function updateStatusBar() {
		var editor = $("#editor").val();
		var len = editor.length;
		
		var words = editor.match(/\S+/g).length;
		
		$("#len").text(len_prefix + len);
		$("#words").text(word_prefix + words);
	}
	
	function changeText(text) {
		var output_text = text;
		replaceText("editor", output_text);
	}
	
	function replaceText(id, text) {
		var editor = $("#" + id);
		var len = editor.val().length;
		var start = editor[0].selectionStart;
		var end = editor[0].selectionEnd;
		
		var focusPoint = start + text.length;
		
		var selectedText = editor.val().substring(start, end);
	
		editor.select().val(editor.val().substring(0, start) + text + editor.val().substring(end, len));
	}	
	
	function replaceTextBB(id, tagStart, tagEnd) {
		
		var editor = $("#" + id);
		var len = editor.val().length;
		var start = editor[0].selectionStart;
		var end = editor[0].selectionEnd;
		
		
		var selectedText = editor.val().substring(start, end);
		var text = "[" + tagStart + "]" + selectedText + "[/" + tagEnd + "]";
		console.log("var's set");
		
		editor.select().val(editor.val().substring(0, start) + text + editor.val().substring(end, len));
		console.log("Applying text");
	}
	
	$.fn.selectRange = function(start, end) {
		if (!end) end = start;
		return this.each(function() {
			if (this.setSelectionRage) {
				this.focus();
				this.setSelectionRage(start, end);
			} else if (this.createTextRage) {
				var range = this.createTextRange();
				range.collapse(true);
				range.moveEnd('character', end);
				range.moveStart('character', start);
				range.select();
				
			}
		});
	};
	
});

</script>
<?php } ?>