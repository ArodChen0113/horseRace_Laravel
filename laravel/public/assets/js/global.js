jQuery(function($){
	
	'use strict';
		// Google Analytics: change UA-XXXXX-X to be your site's ID.
		(function (b, o, i, l, e, r) {
			b.GoogleAnalyticsObject = l;
			b[l] || (b[l] =
				function () {
					(b[l].q = b[l].q || []).push(arguments)
				});
			b[l].l = +new Date;
			e = o.createElement(i);
			r = o.getElementsByTagName(i)[0];
			e.src = 'https://www.google-analytics.com/analytics.js';
			r.parentNode.insertBefore(e, r)
		}(window, document, 'script', 'ga'));
		ga('create', 'UA-XXXXX-X');
		ga('send', 'pageview');


		/*active link*/
		var url = window.location.pathname;
		url = url.toLowerCase();
		if(url.split('/').length>0){
			url = url.split('/')[url.split('/').length-1];
			if($('[href="'+url+'"]').length>0){
				var $elem = $('[href="'+url+'"]').parents('.tp-activated, .tp-has-mega-menu');			
				if($elem.length>0){
					$('#menu > li').removeClass('current-menu-item');
					$elem.addClass('current-menu-item');
				}
			}
		}
		
		//Widget categories
		$('.widget_list_categories_product >ul >li >a').on('click',function() {
			$(this).toggleClass('medusae-add-icon');
		});


		if(jQuery('.blog-masonry').length){
			imagesLoaded(jQuery('.blog-masonry'), function(){
				jQuery('.blog-masonry').masonry({
					columnWidth: 1,
					itemSelector: '.blog-item--top-img',
				});
			});
		}




		//Checked input checkbox my account
		$('.tp-form-checked input[type="checkbox"]').on('click', function(){
			if( $(this).prop('checked') == true ){
				$('.tp-form-chang-detail').slideDown(200);
			} else if($(this).prop('checked') == false){
				$('.tp-form-chang-detail').slideUp(200);
			}
		});


		//Checked input Radio Checkout
		$('.tp-radio-custom  li').on('click', function(){
			if( $(this).find('input[type="radio"]').is(':checked') ){
				$(this).find('.payment_box').slideDown(200);
			} else {
				$('.tp-radio-custom  li .payment_box').slideUp(200);
			}
		});


		//Slider for template
		$('.tp-slider-tpl').each( function() {
			var $this = $(this);
			var defaults = '';
			var params;
			if( typeof( $this.data('params')) !== 'undefined' || typeof($this.data('params')) !== '' ) {
				params = $.extend({}, defaults, $this.data('params'));
			}
			if( params !== '' || params !== 'undefined' ) {
				var slider = new Swiper($this, params);
			} else {
				var slider = new Swiper($this);
			}
		});
		
		var galleryTop = new Swiper('.tp-gallery-top', {
			nextButton: '.tp-button-next',
			prevButton: '.tp-button-prev',
			spaceBetween: 10,
		});
		var galleryThumbs = new Swiper('.tp-gallery-thumbs', {
			spaceBetween: 10,
			centeredSlides: true,
			slidesPerView: 'auto',
			touchRatio: 0.2,
			preloadImages: false,
			slideToClickedSlide: true,
		});
		galleryTop.params.control = galleryThumbs;
		galleryThumbs.params.control = galleryTop;



		// grid-view and list-view Shop page
		$('#tp_list_products').on('click',function(event) {
			event.preventDefault();
			$(this).addClass('active');
			$('#tp_grid_products').removeClass('active');
			$('.grid-item').addClass('list-item').removeClass('grid-item');
		});
		$('#tp_grid_products').on('click',function(event) {
			event.preventDefault();
			$(this).addClass('active');
			$('#tp_list_products').removeClass('active');
			$('.list-item').removeClass('list-item').addClass('grid-item');
		});


	    //qty
	    $('.qty-number-button').on('click', function () {

	    	var $button = $(this);
	    	var oldValue = $button.closest('.woocommerce-variation-add-to-cart').find('input.qty').val();

	    	if ($button.text() == '+') {
	    		var newVal = parseFloat(oldValue) + 1;
	    	} else {
		        // Don't allow decrementing below zero
		        if (oldValue > 0) {
		        	var newVal = parseFloat(oldValue) - 1;
		        } else {
		        	newVal = 0;
		        }
		    }

		    $button.closest('.woocommerce-variation-add-to-cart').find('input.qty').val(newVal);

		});


	    // tabs description product
	    $('ul.tp-tabs li').on('click',function(){
	    	var tab_id = $(this).attr('data-tab');

	    	$('ul.tp-tabs li').removeClass('active');
	    	$('.woocommerce-Tabs-panel').removeClass('active');

	    	$(this).addClass('active');
	    	$('#'+tab_id).addClass('active');
	    })

	    
		//BTN to top
		var offset = 500;
		var duration = 450;
		$('.back-to-top').hide();
		$(window).scroll(function() {
			if ($(this).scrollTop() > offset) {
				$('.back-to-top').fadeIn(duration);
			} else {
				$('.back-to-top').fadeOut(duration);
			}
		});
		$('.back-to-top').on('click',function(event) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, duration);
			return false;
		});



	    // UI slider
	    var woo_price_filter = jQuery('.widget_price_filter');
	    if(woo_price_filter.length){

	    	var price_slider = woo_price_filter.find('.price_slider'),
	    	price_min    = woo_price_filter.find('.from'),
	    	price_max    = woo_price_filter.find('.to');

	    	price_slider.slider({
	    		range: true,
	    		min: 0,
	    		max: 2000,
	    		values: [ 0, 2000 ],
	    		slide: function( event, ui ) {
	    			price_min.text('$' + ui.values[ 0 ]);
	    			price_max.text('$' + ui.values[ 1 ]);
	    		}
	    	});

	    	price_min.text( '$' + price_slider.slider( 'values', 0 ));
	    	price_max.text( '$' + price_slider.slider( 'values', 1 ));
	    }

	    // Change color Shop single
	    if ($('.option_color').length){
	    	$('.option_color .color').on('click',function(e){
	    		var $this = $(this);
	    		var val = $this.data('color');
	    		var $select = $this.closest('.option_color_display').next('select');

	    		$select.val(val).trigger('change');
	    		$('.color').removeClass('active');
	    		$this.addClass('active');
	    		e.preventDefault();
	    	});
	    }

	    //prettyphoto

	    $('a[data-rel^=\'prettyPhoto\']').click(function(e){
	    	e.preventDefault();
	    });

	    if($.fn.prettyPhoto){
	    	
	 	 	$('a[data-rel^=\'prettyPhoto\']').prettyPhoto({
	                social_tools:false,
	                show_title:false,
	                hook: 'data-rel'

	            });  
	 	}

	 	

	 	//btn quickview
		$('.btn-quickview').on('click', function() {
			$('.product-quickview').fadeIn(400);
			$('body').addClass('quickview-open');
		});
		$('.btn-close').on('click', function() {
			$('.product-quickview').slideUp(400);
			$('body').removeClass('quickview-open');
		});
		
		
});

