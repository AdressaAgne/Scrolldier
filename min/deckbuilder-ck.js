$(function() {
	var finalJSON = "";
	var totalScrolls = 0;
	
	$("#clearDeck").click(function() {
		totalScrolls = 0;
		setTotalScrolls();
		$("#fullDeck").html("");
	});
	
	$("#saveBtn").click(function() {
		location.href="../new/import/in-game/"+finalJSON;
	});
	
	$("#deckName").keyup(function() {
		JSONlink();
	});
	
	function setTotalScrolls() {
		$("#totalScrolls").text("Total: "+totalScrolls);
	}
	
	$("[id$='checkbox']").change(function() {
		if ($(this).is(":checked")) {
			console.log($(this).attr("data-for")+" checked");
			$("#scroll[data-scrolls-type='"+$(this).attr("data-for")+"']").removeClass("isHidden");
		} else {
			console.log($(this).attr("data-for")+" disabled");
			$("#scroll[data-scrolls-type='"+$(this).attr("data-for")+"']").addClass("isHidden");
			$("#scroll[class*='isHidden']").hide();
		}
		 		search();
	});
	

	
	function JSONlink() {
		totalScrolls = 0;
		var JSONstring = "";
		var deckName = $("#deckName").val();
		var scrolls = {"deck": deckName.replace(/'/g, "\'") ,"author":"","types":[]};
		
		for (var i = 0; i < $("#fullDeck > #scroll-in-deck").length; i++) {
				var f = sprintf("#scroll-in-deck:nth-of-type(%d)",i+1)
				var	scrollInDeck = $(f);
				var id = $(scrollInDeck).attr("scroll-in-deck-id");
				var count = parseInt($(scrollInDeck).find("#quantity").text());
				
				for (var j = 0; j < count; j++) {
					scrolls["types"].push(parseInt(id));
					totalScrolls++;
					
				}
				
		}
		setTotalScrolls();
		finalJSON = JSON.stringify(scrolls);
		$("#jsonOUTPUT").val(JSON.stringify(scrolls));
	}
	
	$("[id='scroll']").click(function() {
		
		var html = $("#fullDeck").html();
		var id = $("[scroll-in-deck-id='" + $(this).attr("data-scrolls-id") + "']");
		if ($(id).length) {
			
			if (parseInt($(id).find("#quantity").text()) < 3) {
				$(id).find("#quantity").text(parseInt($(id).find("#quantity").text())+1);
				console.log("2+ -> " + $(this).attr("data-scrolls-name"));
				//updateCurve( parseInt($(this).attr("data-scrolls-cost")), $(this).attr("data-scrolls-type"), true );
				JSONlink();
			}
			
		} else {
			$("#fullDeck").html($("#fullDeck").html() + '\n<div id="scroll-in-deck" scroll-in-deck-id="' + $(this).attr('data-scrolls-id') + '" class="deckScrollList mR" style="overflow: hidden;">\n<span class="left">\n<span class="resource"><i class="icon-' + $(this).attr('data-scrolls-type') + ' small"></i> ' + $(this).attr('data-scrolls-cost') + '</span>\n</span>\n\n<span class="left" id="scroll-in-deck-name">' + $(this).attr('data-scrolls-name') + '</span>\n\n<span class="right">\n\n<img class="listScroll" src="../resources/cardImages/' + $(this).attr('data-scrolls-image') + '.png" alt="" /></a>\n</span><span class="right" id="quantity" style="margin-right: 20px;">1</span><span class="right">x</span>\n</div>');
			console.log("1 -> " + $(this).attr("data-scrolls-name"));
			//updateCurve( parseInt($(this).attr("data-scrolls-cost")), $(this).attr("data-scrolls-type"), true );
			JSONlink();
		} 
		
	});
	
	$("#fullDeck").on('click', '[scroll-in-deck-id]', function() {
		if (parseInt($(this).find("#quantity").text()) > 1) {
			$(this).find("#quantity").text(parseInt($(this).find("#quantity").text())-1);
			JSONlink();
		} else if (parseInt($(this).find("#quantity").text()) == 1) {
			$(this).remove();
			JSONlink();
		}
		console.log("Removed one " + $(this).find("#scroll-in-deck-name").text());
	});
	
	$("div[id^='scroll']").hover(function() {
		showScrollStats($(this));
	});
	
	$("#fullDeck").on('hover', '#scroll-in-deck', function() {
		alert(1);
//		showScrollStats($("div[data-scroll-id*='"+$(this).attr("scroll-in-deck-id")+"']"));
	});
	
	
	function showScrollStats(id) {
		$("#scroll-name").text($(id).attr("data-scrolls-name"));
		$("#scroll-desc").text($(id).attr("data-scrolls-desc"));
		$("#scroll-cost").text($(id).attr("data-scrolls-cost"));
		$("#scroll-types").text($(id).attr("data-scrolls-types"));
		$("#scroll-kind").text($(id).attr("data-scrolls-kind")+": ");
		$("#scroll-type").html("<i class='icon-"+ $(id).attr("data-scrolls-type") + "'></i>");
		
		if ($(id).attr("data-scrolls-statsbar") == 1) {
			$("#scroll-ap").text($(id).attr("data-scrolls-attack"));
			$("#scroll-ac").text($(id).attr("data-scrolls-cd"));
			$("#scroll-hp").text($(id).attr("data-scrolls-hp"));
			$(".scrolls_statsbar").show();
		} else {
			$(".scrolls_statsbar").hide();
		}
		
		if ($(id).attr("data-scrolls-passive-1") != "") {
			$("#scroll-passive-1").text("*"+$(id).attr("data-scrolls-passive-1"));
			$("#scroll-passive-1").show();
		} else {
			$("#scroll-passive-1").hide();
		}
		if ($(id).attr("data-scrolls-passive-2") != "") {
			$("#scroll-passive-2").text("*"+$(id).attr("data-scrolls-passive-2"));
			$("#scroll-passive-2").show();
		} else {
			$("#scroll-passive-2").hide();
		}
		if ($(id).attr("data-scrolls-passive-3") != "") {
			$("#scroll-passive-3").text("*"+$(id).attr("data-scrolls-passive-3"));
			$("#scroll-passive-3").show();
		} else {
			$("#scroll-passive-3").hide();
		}
	}
	
	function search() {
		var search = $("#scrollSearch");
		if ($(search).val().length == 0) {
			$('.deckbuilderContainer').find("div#scroll:not(.isHidden)").show();
			console.log("Value none");
		} else {
			console.log("Searched for: "+$(search).val());
			$('.deckbuilderContainer').find("div#scroll").hide();
			//Types t:
			
			if ($(search).val().match("^t:") || $(search).val().match("^t: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-types']:contains('" + $(search).val().replace("t: ","").replace("t:","").toLowerCase() + "'):not(.isHidden)").parent().show(); 	
				
			//.prop('checked', true);
				
			//cost: c:
			} else if ($(search).val().match("^c:") || $(search).val().match("^c: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-cost']:contains('" + $(search).val().replace("c: ","").replace("c:","").toLowerCase() + "')").parent().show(); 
				
			} else if ($(search).val().match("^d:") || $(search).val().match("^d: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-desc']:contains('" + $(search).val().replace("d: ","").replace("d:","").toLowerCase() + "')").parent().show(); 
				
			} else if ($(search).val().match("^hp:") || $(search).val().match("^hp: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-hp']:contains('" + $(search).val().replace("hp: ","").replace("hp:","").toLowerCase() + "')").parent().show(); 
			} else if ($(search).val().match("^ap:") || $(search).val().match("^ap: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-ap']:contains('" + $(search).val().replace("ap: ","").replace("ap:","").toLowerCase() + "')").parent().show(); 
			} else if ($(search).val().match("^cd:") || $(search).val().match("^cd: ")) {
				console.log("Searched type");
				$("div[id*='scroll-top-cd']:contains('" + $(search).val().replace("cd: ","").replace("cd:","").toLowerCase() + "')").parent().show(); 
				
			} else {
				$("div[id*='scroll-top-name']:contains('" + $(search).val().toLowerCase() + "'):not(.isHidden)").parent().show(); 	
			}		
		}
		$("#scroll[class*='isHidden']").hide();
		$('.deckbuilderContainer').find("div#scroll-top-name").hide();
	
	}
	
	// $('*:contains("I am a simple string")');
	$("#scrollSearch").keyup(function() {
		search();
	});
	
	
	
function sprintf() {
  //  discuss at: http://phpjs.org/functions/sprintf/
  // original by: Ash Searle (http://hexmen.com/blog/)
  // improved by: Michael White (http://getsprink.com)
  // improved by: Jack
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Dj
  // improved by: Allidylls
  //    input by: Paulo Freitas
  //    input by: Brett Zamir (http://brett-zamir.me)
  //   example 1: sprintf("%01.2f", 123.1);
  //   returns 1: 123.10
  //   example 2: sprintf("[%10s]", 'monkey');
  //   returns 2: '[    monkey]'
  //   example 3: sprintf("[%'#10s]", 'monkey');
  //   returns 3: '[####monkey]'
  //   example 4: sprintf("%d", 123456789012345);
  //   returns 4: '123456789012345'
  //   example 5: sprintf('%-03s', 'E');
  //   returns 5: 'E00'

  var regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuideEfFgG])/g;
  var a = arguments;
  var i = 0;
  var format = a[i++];

  // pad()
  var pad = function(str, len, chr, leftJustify) {
    if (!chr) {
      chr = ' ';
    }
    var padding = (str.length >= len) ? '' : new Array(1 + len - str.length >>> 0)
      .join(chr);
    return leftJustify ? str + padding : padding + str;
  };

  // justify()
  var justify = function(value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
    var diff = minWidth - value.length;
    if (diff > 0) {
      if (leftJustify || !zeroPad) {
        value = pad(value, minWidth, customPadChar, leftJustify);
      } else {
        value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
      }
    }
    return value;
  };

  // formatBaseX()
  var formatBaseX = function(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
    // Note: casts negative numbers to positive ones
    var number = value >>> 0;
    prefix = prefix && number && {
      '2': '0b',
      '8': '0',
      '16': '0x'
    }[base] || '';
    value = prefix + pad(number.toString(base), precision || 0, '0', false);
    return justify(value, prefix, leftJustify, minWidth, zeroPad);
  };

  // formatString()
  var formatString = function(value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
    if (precision != null) {
      value = value.slice(0, precision);
    }
    return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
  };

  // doFormat()
  var doFormat = function(substring, valueIndex, flags, minWidth, _, precision, type) {
    var number, prefix, method, textTransform, value;

    if (substring === '%%') {
      return '%';
    }

    // parse flags
    var leftJustify = false;
    var positivePrefix = '';
    var zeroPad = false;
    var prefixBaseX = false;
    var customPadChar = ' ';
    var flagsl = flags.length;
    for (var j = 0; flags && j < flagsl; j++) {
      switch (flags.charAt(j)) {
        case ' ':
          positivePrefix = ' ';
          break;
        case '+':
          positivePrefix = '+';
          break;
        case '-':
          leftJustify = true;
          break;
        case "'":
          customPadChar = flags.charAt(j + 1);
          break;
        case '0':
          zeroPad = true;
          customPadChar = '0';
          break;
        case '#':
          prefixBaseX = true;
          break;
      }
    }

    // parameters may be null, undefined, empty-string or real valued
    // we want to ignore null, undefined and empty-string values
    if (!minWidth) {
      minWidth = 0;
    } else if (minWidth === '*') {
      minWidth = +a[i++];
    } else if (minWidth.charAt(0) == '*') {
      minWidth = +a[minWidth.slice(1, -1)];
    } else {
      minWidth = +minWidth;
    }

    // Note: undocumented perl feature:
    if (minWidth < 0) {
      minWidth = -minWidth;
      leftJustify = true;
    }

    if (!isFinite(minWidth)) {
      throw new Error('sprintf: (minimum-)width must be finite');
    }

    if (!precision) {
      precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type === 'd') ? 0 : undefined;
    } else if (precision === '*') {
      precision = +a[i++];
    } else if (precision.charAt(0) == '*') {
      precision = +a[precision.slice(1, -1)];
    } else {
      precision = +precision;
    }

    // grab value using valueIndex if required?
    value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

    switch (type) {
      case 's':
        return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
      case 'c':
        return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
      case 'b':
        return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
      case 'o':
        return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
      case 'x':
        return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
      case 'X':
        return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad)
          .toUpperCase();
      case 'u':
        return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
      case 'i':
      case 'd':
        number = +value || 0;
        number = Math.round(number - number % 1); // Plain Math.round doesn't just truncate
        prefix = number < 0 ? '-' : positivePrefix;
        value = prefix + pad(String(Math.abs(number)), precision, '0', false);
        return justify(value, prefix, leftJustify, minWidth, zeroPad);
      case 'e':
      case 'E':
      case 'f': // Should handle locales (as per setlocale)
      case 'F':
      case 'g':
      case 'G':
        number = +value;
        prefix = number < 0 ? '-' : positivePrefix;
        method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
        textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
        value = prefix + Math.abs(number)[method](precision);
        return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
      default:
        return substring;
    }
  };

  return format.replace(regex, doFormat);
}
});