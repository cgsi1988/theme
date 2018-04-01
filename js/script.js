// Javascript for CGSI theme
/*
jQuery.noConflict();
 
jQuery( document ).ready(function( jQuery ) {
    // You can use the locally-scoped jQuery in here as an alias to jQuery.
    jQuery( "div" ).hide();
});

*/

// The jQuery variable in the global scope has the prototype.js meaning.
window.onload = function(){
    var mainDiv = jQuery( "main" );
    //var mainDiv = $jQuery( "main" );
}
//removed in Drupal 7: if (Drupal.jsEnabled) {
  jQuery(document).ready(function(){
		// Hover emulation for IE 6.
    if (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6) {
      jQuery('.menu li').hover(function() {
        jQuery(this).addClass('iehover');
      }, function() {
        jQuery(this).removeClass('iehover');
      });
    }
		
		// Search field on top of all pages
    jQuery('#edit-search-theme-form-1').val('Search');

    jQuery('#edit-search-theme-form-1').focus(function(){
      if (jQuery(this).val() == 'Search') {
        jQuery(this).val('');
      }
    })

    jQuery('#edit-search-theme-form-1').blur(function(){
      if (jQuery(this).val() == '') {
        jQuery(this).val('Search');
      }
    })
		
		// Search field on top of all pages
    jQuery('#edit-search-block-form--2').val('Search');

    jQuery('#edit-search-block-form--2').focus(function(){
      if (jQuery(this).val() == 'Search') {
        jQuery(this).val('');
      }
    })

    jQuery('#edit-search-block-form--2').blur(function(){
      if (jQuery(this).val() == '') {
        jQuery(this).val('Search');
      }
    })
		
		// On the Members lending library view we collapse the description
    // field onload, and let users toggle it open with a click.
    jQuery('.lending-library-table div.description').hide();
    jQuery('.toggle a').click(function(){
      var id = jQuery(this).attr('href');
      id = id.replace('toggle-', '');
      jQuery(id).slideToggle('fast');
      return false;
    });
    
    // Membership application, hide the 2nd household name fields
    // until someone selects a household/sponsor membership type.
    if (jQuery('.page-signup').length) {
      jQuery('.page-signup .form-item-profile-first-name-2').hide();
      jQuery('.page-signup .form-item-profile-last-name-2').hide();
      jQuery('.page-signup input[name="membership_choices"]').change(function() {
        var pattern = /^cgsi_signup_cgsi_signup_[a-z]{2,}_[0-9]_([0-9])_nid/i;
        var val = jQuery(this).val().match(pattern);
        if (val[1] == '1' || val[1] == '2') {
          jQuery('.form-item-profile-first-name-2').show();
          jQuery('.form-item-profile-last-name-2').show();
        }
        else {
          jQuery('.form-item-profile-first-name-2').hide();
          jQuery('.form-item-profile-last-name-2').hide();
        }
      });

      // Don't hide them if the household/sponsor level is already choosen.
      if (jQuery('.page-signup input[name="membership_choices"]:checked').length) {
        var pattern = /^cgsi_signup_cgsi_signup_[a-z]{2,}_[0-9]_([0-9])_nid/i;
        var val = jQuery('.page-signup input[name="membership_choices"]:checked').val().match(pattern);
        if (val[1] == '1' || val[1] == '2') {
          jQuery('.form-item-profile-first-name-2').show();
          jQuery('.form-item-profile-last-name-2').show();
        }
      }

      // Don't hide them if they have errors though.
      jQuery('.page-signup .form-item-profile-first-name-2:has(.error)').show();
      jQuery('.page-signup .form-item-profile-last-name-2:has(.error)').show();
    }


    // Link to toggle all descriptions.
    jQuery('#expand-all').click(function(){
      if (jQuery(this).html() == 'Expand all descriptions') {
        // Expand all
        jQuery('.lending-library-table .description').show();
        jQuery(this).html('Collapse all descriptions');
      }
      else {
        // Collapse all
        jQuery('.lending-library-table .description').hide();
        jQuery(this).html('Expand all descriptions');
      }
      return false;
    });
    
    // Links that should open a new window.
    jQuery('a.popup').click(function() {
      window.open(jQuery(this).attr('href'), 'cgsi_window');
      return false;
    });
    
    // Open these ul.menu links in a new window.
    // Lending Library > Tapes
    jQuery("a[hrefjQuery='members/library/tapes/search/popup']").click(function() {
      window.open(jQuery(this).attr('href'), 'cgsi_window');
      return false;
    });
    // Lending Library > Books
    jQuery("a[hrefjQuery='members/library/books/search/popup']").click(function() {
      window.open(jQuery(this).attr('href'), 'cgsi_window');
      return false;
    });
    
    // On popup page, check if it's a window.
    if (window.name == 'cgsi_window') {
      jQuery('a.popup-close').click(function(){
        window.close();
        return true;
      }).html('Close this window');
    }
  });
//}