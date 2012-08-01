!function($) {
	var is_loading = true;
	$(function() {
		var logo_padding = 185,
			page_width_min = 990,
			$win = $(window),
			$header = $('#header'),
			$carousel_main = $('#carousel-main'),
			$quilt = $('#quilt'),
			da_is_ie7 = $('html').hasClass('ie7'),
			da_is_ie8 = $('html').hasClass('ie8');

		/* Keep Logo and Navbars centered */
			$win.resize(function() {
			var win_width = $(this).width();
			if(win_width > page_width_min) {
				var padding_adjusted = logo_padding + Math.floor( (win_width - page_width_min) / 2);
				$header.find('.body').css('padding-left', padding_adjusted);
				$('#site-name').css('left', padding_adjusted);
			}
			
			// Add navigation treatment on load
			if(is_loading) {
				$('#nav-main, #nav-sub').hide().css({visibility: 'visible'}).fadeIn(50);
			}
		});
		$win.trigger('resize');
		
		
		
		// Fade in Navigation dropdowns
		$('.nav-donor li').each(function () {
			var $my_nav_item = $(this);
			
			$my_nav_item.hover(
				function () { $(this).find('.sub-menu-container').fadeIn(100); },
				function () { $(this).find('.sub-menu-container').fadeOut(100); }
			);
		});
		// Fade in Navigation dropdowns
		$('.nav-social .icon').click(function () {
			$(this).closest('li').find('.sub-menu').toggle('fast');
		});
		
		if ($carousel_main.length > 0) {
			var $pagination = $carousel_main.find('.pagination'),
				$slide_content = $carousel_main.find('.slide-content'),
				cycle_args = {};
			

			cycle_args.cleartypeNoBg = true;
			cycle_args.fx = 'fade';
			cycle_args.pager = $pagination;
			cycle_args.pause = 1;
			cycle_args.pauseOnPagerHover = 1;
			cycle_args.speed = 1000;
			cycle_args.sync = 1;
			cycle_args.timeout = 9000;

			// Flash and Cycle crossfade are not playing nicely in IE7 and IE8.
			// Remove transition effect in this case.
			if (da_is_ie7 || da_is_ie8) { cycle_args.fx = 'none'; }

			$carousel_main.find('ul').cycle( cycle_args );
			
			/* Center Pagination in content area of slide */
			$pagination.css( 'right', ($slide_content.width() - $pagination.outerWidth()) / 2 );
			$carousel_main.hide().css('visibility', 'visible').fadeIn(100);

		}
		
		if ($quilt.length > 0) {
			var quilt_ease_speed = 50;



			// Animate quilt items
			$('#quilt a').hover(
				function() {
					var $quilt_link = $(this),
						$quilt_link_container = $quilt_link.closest('li');

					$quilt_link.find('.overlay').hide();
					$quilt_link.animate({
						left: '-45px',
						paddingBottom: '36px',
						top: '-45px',
						width: '250px'
					},
					quilt_ease_speed);
					$quilt_link.addClass('shadow');

					if ( da_is_ie7 ) {
						$quilt_link_container.css('z-index', 1000);
					}
				},
				function() {
					var $quilt_link = $(this),
						$quilt_link_container = $quilt_link.closest('li');

					$quilt_link.removeClass('shadow');
					$quilt_link.animate({
						left: '0',
						paddingBottom: '0',
						top: '0',
						width: '161px'
					},
					quilt_ease_speed);
					$quilt_link.find('.overlay').show();

					if ( da_is_ie7 ) {
						$quilt_link_container.css('z-index', 0);
					}
				}
			);
			
			// Prevent "Title" tooltips from appearing
			$('#quilt a img').removeAttr('title');
		}
		
		$('a[title="new-window"]').attr('target', '_blank');
		$('.form-newsletter input[type="text"]').watermark('Sign up for our newsletter');
		
		// Reset tab stops
		$('input, select, textarea').each(function(indexInArray, valueOfElement) {
			$(this).attr('tabindex', 1000 + indexInArray);
		});

		is_loading = false;
	});
}(jQuery);