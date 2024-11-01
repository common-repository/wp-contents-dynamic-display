(function( $ ) {
	'use strict';

})( jQuery );
jQuery(document).ready( function($){
	'use strict';
	console.debug( wpcdd_localized );
	var $wpcdd_posts = wpcdd_localized[0];
	var $wpcdd_post_cat = wpcdd_localized[1];
	var $wpcdd_pages = wpcdd_localized[2];
	var $wpcdd_page_templates = wpcdd_localized[3];
	

	console.debug( $wpcdd_posts );
	// Make all rules sortable
	$( '#wpcdd-rules' ).sortable({
		placeholder: 'wpcdd-placeholder',
		forcePlaceholderSize: true,
		update: function( event, ui ){ // Assign a new order to the items
			$( '.wpcdd-rule-priority' ).each( function( index ){
				$( this ).text( index + 1 );
			});
		}
	});
	$( '#wpcdd-rules' ).disableSelection();
	
	// Add new rule
	$( '#wpcdd-add' ).on( 'click', function() {
		console.log('add');
		var wpcddID = Math.floor( Math.random() * 0x100000 ).toString(16);
		var count = $( '#wpcdd-count' ).val();
		count++;
		var $wpcdd_rule = $('\
		<div class="wpcdd-rule">\
			<div class="wpcdd-control-bar">\
				<div class="wpcdd-drag"><i class="fa fa-arrows"></i></div>\
				<div class="wpcdd-rule-title"><p>Rule Priority <span class="wpcdd-rule-priority">' + count + '</span></p></div>\
				<div class="wpcdd-remove"><i class="fa fa-times"></i> Remove</div>\
			</div>\
			<div class="wpcdd-content-section">\
				<h3>Content</h3>\
				<select class="wpcdd-select wpcdd-content-type" name="wpcdd[' + wpcddID + '][content][type]">\
					<option value="text-single" selected="">Text (1 line)</option>\
				</select>\
				<input type="text" class="wpcdd-text wpcdd-content-value" name="wpcdd[' + wpcddID + '][content][value]" maxlength="180" value="">\
			</div>\
			<div class="wpcdd-rules-section">\
				<h3>Conditions</h3>\
				<select class="wpcdd-select wpcdd-rule-type" name="wpcdd[' + wpcddID + '][condition][type]">\
					<option value="page" selected>Page</option>\
					<option value="page-template">Page Template</option>\
					<option value="post">Post</option>\
					<option value="post-category">Post Category</option>\
				</select>\
				<select class="wpcdd-select wpcdd-rule-boolean" name="wpcdd[' + wpcddID + '][condition][bool]">\
					<option value="is" selected>is</option>\
					<option value="not">is not</option>\
				</select>	\
				<div class="wpcdd-conditionals">\
					<select class="wpcdd-select wpcdd-rule-terms wpcdd-sol" name="wpcdd[' + wpcddID + '][condition][terms][]" multiple="multiple">\
					</select>\
				</div>\
			</div>\
		</div>\
		');
		$wpcdd_rule.appendTo( '#wpcdd-rules' );
		var $wpcdd_condition = $wpcdd_rule.find( 'select.wpcdd-rule-terms' );
		$.each( $wpcdd_pages, function( index, value ){ // add new options
			$wpcdd_condition.append( $( '<option>', {
				value: index,
				text: value
			}));
		});
		$wpcdd_condition.searchableOptionList();
		//console.log( 'count ' + count );
		
		$( '#wpcdd-count' ).val( count );
	});
	
	// Remove the rule
	$( document ).on( 'click', '.wpcdd-remove', function(){
		$( this ).parent().parent().remove();
		
		// Reset the rule order
		$( '.wpcdd-rule-priority' ).each( function( index ){
			$( this ).text( index + 1 );
		});
	});
	
	$( '.wpcdd-sol' ).searchableOptionList(); // initialize sol
	
	$( document ).on( 'change', '.wpcdd-rule-type', function(){
		var $type = $( this ).val();
		var $condition_field = $( this ).siblings( '.wpcdd-conditionals' );
		var $options = $condition_field.children( 'select.wpcdd-rule-terms' );
		$condition_field.children( '.sol-container' ).remove(); // remove initialized sol
		if ( $type == 'page' ){
			$options.empty(); // empty the existing optoins
			$.each( $wpcdd_pages, function( index, value ){ // add new options
				$options.append( $( '<option>', {
					value: index,
					text: value
				}));
			});
			$options.searchableOptionList(); // reinitialize sol with new sets of data - customized sol.js
		} else if( $type == 'page-template' ){
			$options.empty(); // empty the existing optoins
			$.each( $wpcdd_page_templates, function( index, value ){ // add new options
				$options.append( $( '<option>', {
					value: index,
					text: value
				}));
			});
			$options.searchableOptionList(); // reinitialize sol with new sets of data - customized sol.js
		} else if( $type == 'post'){
			$options.empty(); // empty the existing optoins
			$.each( $wpcdd_posts, function( index, value ){ // add new options
				$options.append( $( '<option>', {
					value: index,
					text: value
				}));
			});
			$options.searchableOptionList(); // reinitialize sol with new sets of data - customized sol.js
		} else if( $type == 'post-category' ){
			$options.empty(); // empty the existing optoins
			$.each( $wpcdd_post_cat, function( index, value ){ // add new options
				$options.append( $( '<option>', {
					value: index,
					text: value
				}));
			});
			$options.searchableOptionList(); // reinitialize sol with new sets of data - customized sol.js
		}
	});
	
	// Shortcode copy meta box
	$( '.wpcdd-shortcode-select' ).on( 'click', function() {
		$( this ).select();
	});
	
	//Admin Custom Post Type Publish Section Follow Scroll
	// Check if plugin specific custom post type page
	if( $( 'body.post-type-wpcdd' )[0] && $( "#poststuff" ).length ){ //if part of the plugin page
		var $icanwpBody = $( 'body.post-type-wpcdd' ); //get body
		var $icanwpTitle = $icanwpBody.find( '#poststuff' );
 		var $mainWidth = $icanwpTitle.outerWidth(); 
		var $contentWidth = $icanwpBody.find( '#titlediv' ).outerWidth() + 270;
		var $sideBar = $( '.postbox-container:has(#submitdiv)' ); //get sidebar that contains the submit button
		var $offSetY = $icanwpTitle.offset().top;
		
		// When the container size in the custom post admin page width decreases to trigger a media query to remove sidebar, the metabox for "publish" / "update" button will disengage from following scroll behavior
		if( $mainWidth > $contentWidth ){
			$sideBar.addClass( 'wpcdd-sticky-metabox' );
		} else {
			$sideBar.removeClass( 'wpcdd-sticky-metabox' );
			if( $( window ).scrollTop() > $offSetY ) {
				$sideBar.addClass( 'topzero' );
			}
		}
		/*
		 * Detect Change in Windows size and adjust the offset for the wordpress default meta box containing "publish" / "update" button
		 */
		var resizeDone; //timer to use on resize done
		$( window ).on( 'resize', function( event ) {
			clearTimeout( resizeDone );
			resizeDone = setTimeout( function(){
				$mainWidth = $icanwpBody.find( '#poststuff' ).outerWidth();
				$contentWidth = $icanwpBody.find( '#titlediv' ).outerWidth() + 199;
				if( $mainWidth > $contentWidth ){
					$sideBar.addClass( 'wpcdd-sticky-metabox' );
				} else {
					$sideBar.removeClass( 'wpcdd-sticky-metabox' );
					$sideBar.removeClass( 'topzero' );
				}
				$offSetY = $icanwpTitle.offset().top;
			}, 300 );
		});
		// Detect Scrolling on window and makes the default metabox for "publish" / "update" button follow the scroll
		$( window ).on( 'scroll', function(){
			if( $( window ).scrollTop() < $offSetY ){
				$sideBar.removeClass( 'topzero' );
			} else {
				$sideBar.addClass( 'topzero' );
			}
		} );
	}
});