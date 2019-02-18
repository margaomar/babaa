(function() {
   tinymce.create('tinymce.plugins.fik_shortcodes', {
      init : function(ed, url) {

          ed.addButton('fik_shortcodes', {
              id : 'fik_shortcode_button',
              title : 'Fik Shortcodes',
              image : url+'/fik_shortcodes.svg',
              onclick : function() {

                  jQuery("#fik_shortcode_form_wrapper").remove();

                  var shortcodes_visible = jQuery("#fik_shortcodes_menu_holder").length;

                  if (shortcodes_visible){
                      jQuery("#fik_shortcodes_menu_holder").remove();
                  } else{

                      var container_element = "";
                      var id = jQuery(this).attr("id");

						if(jQuery('#fik_shortcode_button').length && !jQuery('#wp-wpb_tinymce_content-wrap').length){
						  container_element = jQuery('#fik_shortcode_button').closest(".mce-toolbar-grp");
						} else if (jQuery("#"+id+"_toolbargroup").length){
						  container_element = jQuery("#"+id+"_toolbargroup");
						} else if (jQuery('#wp-wpb_tinymce_content-wrap #fik_shortcode_button').length){
							container_element = jQuery('#wp-wpb_tinymce_content-wrap');
						}

						if(container_element != ""){
						  container_element.append("<div id='fik_shortcodes_menu_holder' style='position: absolute;margin-top: -1px;margin-left:5px;padding: 7px;border: 1px solid #dedede;background-color: #f5f5f5;'></div>");
						}

                      jQuery('#fik_shortcodes_menu_holder').load(url + '/fik_shortcodes_popup.php', function(){

                          var y = 0;
                          var x = 0;

							if(jQuery('#fik_shortcode_button button').length && !jQuery('#wp-wpb_tinymce_content-wrap').length){
							  x = parseInt(jQuery("#fik_shortcode_button button").offset().left) - parseInt(jQuery("#adminmenuwrap").width()) + 10;
							} else if (jQuery("#content_fik_shortcodes").length){
							  x = parseInt(jQuery("#content_fik_shortcodes").offset().left) - parseInt(jQuery("#adminmenuwrap").width()) + 10;
							} else if (jQuery('#wp-wpb_tinymce_content-wrap').length){
								y = 70;
								x = 0;
							}

                          jQuery("#fik_shortcodes_menu_holder").css({top: y, left: x});

//                        Insert Fik shortcodes

                        jQuery("#sc_row").click(function(){
							var shortcode = "[fik_row]Columns here[/fik_row]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_col_1-2").click(function(){
							var shortcode = "[fik_col_1-2]Your content[/fik_col_1-2]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_col_1-3").click(function(){
							var shortcode = "[fik_col_1-3]Your content[/fik_col_1-3]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_col_1-4").click(function(){
							var shortcode = "[fik_col_1-4]Your content[/fik_col_1-4]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_col_2-3").click(function(){
							var shortcode = "[fik_col_2-3]Your content[/fik_col_2-3]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_col_3-4").click(function(){
							var shortcode = "[fik_col_3-4]Your content[/fik_col_3-4]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_button").click(function(){
							var shortcode = "[fik_button text='Button' color='primary' link='']";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_latest-posts").click(function(){
							var shortcode = "[fik_latest_posts category_name='' quantity='2']";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_products-grid").click(function(){
							var shortcode = "[fik_products columns='4' quantity='4' section='']";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_special-title").click(function(){
							var shortcode = "[fik_special_title][/fik_special_title]";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

                        jQuery("#sc_slider").click(function(){
							var shortcode = "[fik_slider ids='24,27,43' link24='http://yourfirstpage.com' link27='http://yoursecondpage.com' link43='http://yourthirdpage.com' indicators='true' navigation='true' captions='true']";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

//                        Plugin shortcodes

                        jQuery("#sc_google-map").click(function(){
							var shortcode = "[flexiblemap address='Maria de Molina, 31, Madrid' title='FikStores' description='Lorem ipsum dolor sit amet' link='http://example.com/' width='100%' height='400px' showinfo='true']";
							ed.execCommand('mceInsertContent', false, shortcode);
							jQuery("#fik_shortcodes_menu_holder").remove();
						})

					})
				}
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Shortcodes",
            author : 'FikStores',
            authorurl : 'http://www.fikstores.com/',
            infourl : 	'http://www.fikstores.com/',
            version : "0.1"
         };
      }
   });
   tinymce.PluginManager.add('fik_shortcodes', tinymce.plugins.fik_shortcodes);
})();
