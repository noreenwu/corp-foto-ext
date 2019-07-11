(function( $ ) {

	// Fixed Header.
	( function() {

		if( $( document ).scrollTop() > 0 ){
			$( '.site-header-main' ).addClass( 'shrink' );
		}

		// Add opacity class to site header
		$( document ).on('scroll', function(){

			if ( $( document ).scrollTop() > 0 ){
				$( '.site-header-main' ).addClass( 'shrink' );

			} else {
				$( '.site-header-main' ).removeClass( 'shrink' );
			}

		});


		$(window).on( 'resize load', function(){
			if ( $( '.site-header-main' ).length ) {
				$( '.below-site-header' ).css( 'padding-top', $( '.site-header-main' ).outerHeight() );
			}
		});

	} )();

	/**
	 * Test if an iOS device.
	*/
	function checkiOS() {
		return /iPad|iPhone|iPod/.test(navigator.userAgent) && ! window.MSStream;
	}

	/*
	 * Test if background-attachment: fixed is supported.
	 * @link http://stackoverflow.com/questions/14115080/detect-support-for-background-attachment-fixed
	 */
	function supportsFixedBackground() {
		var el = document.createElement('div'),
			isSupported;

		try {
			if ( ! ( 'backgroundAttachment' in el.style ) || checkiOS() ) {
				return false;
			}
			el.style.backgroundAttachment = 'fixed';
			isSupported = ( 'fixed' === el.style.backgroundAttachment );
			return isSupported;
		}
		catch (e) {
			return false;
		}
	}

	// Fire on document ready.
	$( document ).ready( function() {
		if ( true === supportsFixedBackground() ) {
			document.documentElement.className += ' background-fixed';
		}
	});

	// Add header video class after the video is loaded.
	$( document ).on( 'wp-custom-header-video-loaded', function() {
		$( 'body' ).addClass( 'has-header-video' );
	});

	$(document).ready(function() {
		/*Search and Social Container*/
		$('.toggle-top').on('click', function(e){
			$(this).toggleClass('toggled-on');
		});

		$('#search-toggle').on('click', function(){
			$('#header-menu-social, #share-toggle').removeClass('toggled-on');
			$('#header-search-container').toggleClass('toggled-on');
		});

		$('#share-toggle').on('click', function(e){
			e.stopPropagation();
			$('#header-search-container, #search-toggle').removeClass('toggled-on');
			$('#header-menu-social').toggleClass('toggled-on');
		});
	});
})( jQuery );
