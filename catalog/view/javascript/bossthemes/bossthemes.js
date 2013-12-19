function boss_addToCart(product_id) {
  $.ajax({
      url: 'index.php?route=bossthemes/cart/add',
      type: 'post',
      data: 'product_id=' + product_id,
      dataType: 'json',
      success: function(json) {
          if (json['redirect']) {
              location = json['redirect'];
          }

          if (json['success']) {
              addProductNotice(json['title'], json['thumb'], json['success'], 'success');
			  $('#cart-total').html(json['total']);
          }
      }
  });
}

function boss_addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=bossthemes/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
				addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				$('#wishlist-total').html(json['total']);
			}
		}
	});
}

function boss_addToCompare(product_id) {
	$.ajax({
		url: 'index.php?route=bossthemes/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			if (json['success']) {
                addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				$('#compare-total').html(json['total']);
			}
		}
	});
}

function addProductNotice(title, thumb, text, type) {
    if ($.browser.msie && parseInt($.browser.version) < 8) {
		simpleNotice(title, text, type);
        return false;
    }
    appendNoticeTemplates();
    $("#notification-container").notify("create", "thumb-template", {
        title: title,
        thumb: thumb,
        text:  text,
        type: type
        },{
        expires: 4000
        }
    );
}

function simpleNotice(title, text, type) {
    appendNoticeTemplates();
    $("#notification-container").notify("create", "nothumb-template", {
        title: title,
        text:  text,
        type: type
        },{
        expires: 4000
        }
    );
}

function appendNoticeTemplates() {
  if (!$("#notification-container").length) {
    var tpl = '<div id="notification-container" style="display: none">\
                 <div id="thumb-template">\
                   <a class="ui-notify-cross ui-notify-close boss_button_remove" href="javascript:;"></a>\
                   <h2 class="boss_icon_success"><span class="boss_title">#{title}</span></h2>\
                   <div class="boss_text">\
                     #{thumb}\
                     <h3>#{text}</h3>\
                   </div>\
                 </div>\
                 <div id="nothumb-template">\
                   <a class="ui-notify-cross ui-notify-close boss_button_remove" href="javascript:;"></a>\
                   <h2 class="boss_icon_success"><span class="boss_title">#{title}</span></h2>\
                   <div class="boss_text">\
                     <h3>#{text}</h3>\
                   </div>\
                 </div>\
               </div>';
    $(tpl).appendTo("body");
    $("#notification-container").notify();
  }
}

/* mega boss menu */
$(window).load(function(){
	var menuWidth = 1180;
	var numColumn = 6;
	var currentWidth = $("#boss_menu").outerWidth();
	// responsive
	if (currentWidth < menuWidth) {
		new_width_column = currentWidth / numColumn;
		$('#boss_menu div.dropdown').each(function(index, element) {
			$(this).width(parseFloat($(this).css("width"))/menuWidth*numColumn * new_width_column);
		});
		$('#boss_menu div.option').each(function(index, element) {
			$(this).width(parseFloat($(this).css("width"))/menuWidth*numColumn * new_width_column);
		});
		$('#boss_menu ul.column').each(function(index, element) {
			$(this).width(parseFloat($(this).css("width"))/menuWidth*numColumn * new_width_column);
		});
	}
	
	$('#boss_menu ul > li > a + div').each(function(index, element) {
		var menu = $('#boss_menu').offset();
		var dropdown = $(this).parent().offset();			
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#boss_menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i) + 'px');
		}
	});

	// IE6 & IE7 Fixes
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#boss_menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#boss_menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
});