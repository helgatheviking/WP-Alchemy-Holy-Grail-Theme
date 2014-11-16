/*-----------------------------------------------------------------------------------*/
/* KIA Metabox scripts
/*
/* upload media buttons, sort, repeatable tinyMCE fields 
/* requires WordPress 3.9
/*
/* © Kathy Darling http://www.kathyisawesome.com
/* 2012-03-07. */
/*-----------------------------------------------------------------------------------*/


;(function ($) {

var KIA_metabox = {

	/*-----------------------------------------------------------------------------------*/
	/* All the matching text areas 
	/*-----------------------------------------------------------------------------------*/

	textareas: {},

	/*-----------------------------------------------------------------------------------*/
	/* tinyMCE settings
	/*-----------------------------------------------------------------------------------*/

	tmc_settings: {},

	/*-----------------------------------------------------------------------------------*/
	/* tinyMCE defaults
	/*-----------------------------------------------------------------------------------*/

	tmc_defaults: {
		theme: 'modern',
		menubar: false,
		wpautop: true,
		indent: false,
		toolbar1: 'bold,italic,underline,blockquote,strikethrough,bullist,numlist,alignleft,aligncenter,alignright,undo,redo,link,unlink,fullscreen',
		plugins: 'fullscreen,image,wordpress,wpeditimage,wplink'
	},

	/*-----------------------------------------------------------------------------------*/
	/* quicktags settings
	/*-----------------------------------------------------------------------------------*/

	qt_settings: {},

	/*-----------------------------------------------------------------------------------*/
	/* quicktags defaults
	/*-----------------------------------------------------------------------------------*/

	qt_defaults: {
		buttons: 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,fullscreen'
	},

	/*-----------------------------------------------------------------------------------*/
	/* Launch TinyMCE-enhanced textareas
	/*-----------------------------------------------------------------------------------*/

	runTinyMCE: function() {

		// get the #content's tinyMCE settings or use default
		var init_settings = typeof tinyMCEPreInit == 'object' && 'mceInit' in tinyMCEPreInit && 'content' in tinyMCEPreInit.mceInit ? tinyMCEPreInit.mceInit.content : KIA_metabox.tmc_defaults;

		// get the #content's quicktags settings or use default
		KIA_metabox.qt_settings = typeof tinyMCEPreInit == 'object' && 'qtInit' in tinyMCEPreInit && 'content' in tinyMCEPreInit.qtInit ? tinyMCEPreInit.qtInit.content : KIA_metabox.qt_defaults;

		var custom_settings = {
			setup : function(ed) {
				ed.on('change', function(e) {
					KIA_metabox.changeName( ed );
				}); 
			}
		}

		// merge our settings with WordPress' and store for later use
		KIA_metabox.tmc_settings = $.extend( {}, init_settings, custom_settings );

		//all custom text areas, except the one to copy
		KIA_metabox.textareas = $('div.wpa_group:not(.tocopy) textarea.wp-editor-area'); 
		
		//give each a unique ID, TinyMCE will need it later
		KIA_metabox.textareas.each( function( i ) {  
			var id = $(this).attr( 'id' );
			if ( !id) {
				id = 'mceEditor-' + ( i );
				$( this ).attr( 'id', id );
			}  
			
			// for some reason in WP I am required to do this in the loop 
			// KIA_metabox.tmc_settings.selector is insufficient, anyone who can tell my why gets a margarita
			var tmc_settings = $.extend( {}, KIA_metabox.tmc_settings, { selector : "#" + id } );

			var qt_settings = $.extend( {}, KIA_metabox.qt_settings, { id : id } );

			// add our copy to he collection in the tinyMCEPreInit object because switch editors
			// will look there for an wpautop setting specific to this editor
			// similarly quicktags will product a toolbar with no buttons: https://core.trac.wordpress.org/ticket/26183
			if ( typeof tinyMCEPreInit == 'object' ){
				tinyMCEPreInit.mceInit[id] = tmc_settings;
				tinyMCEPreInit.qtInit[id] = qt_settings;
			}

			// turn on the quicktags editor for each
			quicktags( qt_settings );

			// turn on tinyMCE for each
			tinymce.init( tmc_settings );

			// fix media buttons
			$(this).closest('.customEditor').find('a.insert-media').data( 'editor', id );

		});  //end each	

	} , //end runTinyMCE text areas 

	/*-----------------------------------------------------------------------------------*/
	/* Apply TinyMCE to new textareas
	/*-----------------------------------------------------------------------------------*/

	newTinyMCE: function( clone ) { 

		// count all custom text areas, except the one to copy
		count = KIA_metabox.textareas.length;
			
		// assign the new textarea an ID
		id = 'mceEditor-' + count;
		$new_textarea = clone.find( 'textarea.wp-editor-area' ).attr( 'id', id );

		// add new textarea to collection
		KIA_metabox.textareas.push( $new_textarea );
		 
		// Merge new selector into settings
		var tmc_settings = $.extend( {}, KIA_metabox.tmc_settings, { selector : "#" + id } );

		var qt_settings = $.extend( {}, KIA_metabox.qt_settings, { id : id } );

		// add our copy to he collection in the tinyMCEPreInit object because switch editors
		if ( typeof tinyMCEPreInit == 'object' ){
				tinyMCEPreInit.mceInit[id] = tmc_settings;
				tinyMCEPreInit.qtInit[id] = qt_settings;
		}

		try { 
			// turn on the quicktags editor for each
			quicktags( qt_settings );
			
			// attempt to fix problem of quicktags toolbar with no buttons
			QTags._buttonsInit();

			// turn on tinyMCE
			tinyMCE.init( tmc_settings );

		} catch(e){}
			
		
	} , //end runTinyMCE text areas 
			

	/*-----------------------------------------------------------------------------------*/
	/* Meta Fields Sorting
	/*-----------------------------------------------------------------------------------*/
	
	sortable: function(){

		var textareaID;
		$('.wpa_loop').sortable({
			//cancel: ':input,button,.customEditor', // exclude TinyMCE area from the sort handle
			handle: 'h3.handle',
			axis: 'y',
			opacity: 0.5,
			tolerance: 'pointer',
			start: function(event, ui) { // turn TinyMCE off while sorting (if not, it won't work when resorted)
				textareaID = $(ui.item).find('textarea.wp-editor-area').attr('id');
				try { tinyMCE.execCommand('mceRemoveEditor', false, textareaID); } catch(e){}
			},
			stop: function(event, ui) { // re-initialize TinyMCE when sort is completed
				try { tinyMCE.execCommand('mceAddEditor', false, textareaID); } catch(e){}
	//			$(this).find('.update-warning').show();
			}
		});
		
	}, //end of sortable

	/*-----------------------------------------------------------------------------------*/
	/* A Simple Toggle switch 
	/*-----------------------------------------------------------------------------------*/

	toggleGroups : function(){

		$( '.wpa_loop' ).on( 'click', '.toggle', function() { 

			$group = $(this).parents('.wpa_group'); console.log($group);
			$toggle = $group.find('.toggle_state'); console.log($toggle);
			$inside = $group.find('.group-inside'); console.log($inside);
			
			$inside.toggle( 'slow', function() {
			    $toggle.prop( 'checked', ! $toggle.prop( 'checked' ) );
			    $group.find( '.group-wrap' ).toggleClass( 'closed', $toggle.prop( 'checked' ) );
			});

		});

	}, //end toggleGroups

	/*-----------------------------------------------------------------------------------*/
	/* Change Group Name via TinyMCE callback
	/*-----------------------------------------------------------------------------------*/

	changeName : function( ed ){

		$('#' + ed.id ).closest('.wpa_group').find('.handle').html( ed.getContent({format : 'text'}).substring(0,30)  );

	}, //end changeName

	/*-----------------------------------------------------------------------------------*/
	/* Group Name
	/*-----------------------------------------------------------------------------------*/

	groupName : function( ed ){

		$( '.wpa_loop' ).on( 'change', 'textarea.wp-editor-area', function() {

			$group = $(this).parents('.wpa_group');

			$group.find('.handle').html( $(this).val().substring(0,30)  );

		});

	}, //end groupName

	/*-----------------------------------------------------------------------------------*/
	/* Switch Editors
	/*-----------------------------------------------------------------------------------*/

	switchEditors : function(){

		$( '.wpa_loop' ).on( 'click', '.wp-switch-editor', function() { 

			$wrapper = $(this).closest('.wp-editor-wrap');
			$wrapper.toggleClass('html-active tmce-active');

			id = $wrapper.find('textarea.wp-editor-area').attr('id');
			mode = $(this).data('mode');

			switchEditors.go(id, mode);

		});

	} //end switchEditors

}; // End KIA_metabox Object // Don't remove this, or there's no guacamole for you

/*-----------------------------------------------------------------------------------*/
/* Execute the above methods in the KIA_metabox object.
/*-----------------------------------------------------------------------------------*/
  
	$(document).ready(function () {
		
		KIA_metabox.runTinyMCE();
		KIA_metabox.sortable();
		KIA_metabox.toggleGroups();
		KIA_metabox.groupName();
		KIA_metabox.switchEditors();

		//create a div to bind to
		if ( ! $.wpalchemy ) {
			$.wpalchemy = $('<div/>').attr('id','wpalchemy').appendTo('body');
		};
		
		// run our tinyMCE script on textareas when copy is made
		$( document.body ).on( 'wpa_copy', $.wpalchemy, function( event, clone ) { 		
			KIA_metabox.newTinyMCE( clone );
		});
			
	});
  
})(jQuery);