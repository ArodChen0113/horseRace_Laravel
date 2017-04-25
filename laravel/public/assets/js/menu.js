;(function( $, $w, $d, w, d, $b ){
	'use strict';
	
	var tp_function = window.tp_function || {};
	
  	tp_function = (function(){
		function tp_function(element, options){
			var _ = this;			
			
			_.default = {
				element_btn_menu_mobile: '.open-menu-btn',
				class_active_menu_mobile: 'active-menu-mobile',
				element_btn_open_sub_menu: 'li.menu-item-has-children',
				class_active_sub_menu_mobile: 'active-sub-menu',
			};			
			
			if(typeof(options)==='object'){
				_.options = $.extend( {}, _.default, options);
			}else{
				_.options = _.default;
			}
			
			if(typeof(_.options.dataIndex)!=='undefined'){
				_.index = _.options.dataIndex;
			}else{
				_.index = 0;
			}
			
			_.$element_control = element;
			_.init();
		}
		
		return tp_function;
	}());
	
	tp_function.prototype.init = function(){
		var _ = this;
		
		_.openMenuMobile();
		_.openSubMenuMobile();
		
		/*event init*/		
		_.$element_control.trigger('init', []); //[] params array
		/*event init*/
	};
	
	tp_function.prototype.openMenuMobile = function(){
		var _ = this;
		$d.on('click', _.options.element_btn_menu_mobile, function(){
			$b.toggleClass(_.options.class_active_menu_mobile);
			
			/*event menuMobileChange*/		
			_.$element_control.trigger('menuMobileChange', [$b.hasClass(_.options.class_active_menu_mobile)]); //[] params array
			/*event menuMobileChange*/
		});
	};
	
	tp_function.prototype.openSubMenuMobile = function(){
		var _ = this;
		$d.on('click', _.options.element_btn_open_sub_menu, function(){
			var t = $(this);
			t.toggleClass(_.options.class_active_sub_menu_mobile);
			
			/*event subMenuMobileChange*/		
			_.$element_control.trigger('subMenuMobileChange', [t.hasClass(_.options.class_active_sub_menu_mobile)]); //[] params array
			/*event subMenuMobileChange*/
		});
	};
	
	$.fn.tp_function = function(options){
		var $t = $(this);		
		var newFn = new tp_function($t, options);
		return $t;
	};
  	
	$d.ready(function(){
		$b.on('init', function(event){
			//console.log('tp: init'); //tp_function create
		});
		
		$b.tp_function();	
		
		$b.on('menuMobileChange', function(event, openStatus){
			//console.log('Menu Mobile Change: '+openStatus); //Menu Mobile Change
		});
		
		$b.on('subMenuMobileChange', function(event, openStatus){
			//console.log('Sub Menu Mobile Change: '+openStatus); //Menu Mobile Change
		});
	});
	
} (jQuery, jQuery(window), jQuery(document), window, document, jQuery('body')) );