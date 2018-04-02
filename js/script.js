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

           function  GMapSurnameLocations(surnameLocations, FromDiv, ToDiv){
                        var FromCenter = new google.maps.LatLng(50, 15);
	                var FromMap = new google.maps.Map(document.getElementById(FromDiv), {
		          center : FromCenter, zoom : 6
	                });
                        var FromBounds = new google.maps.LatLngBounds();
                        var FromWindow = new google.maps.InfoWindow;

	                var ToCenter = new google.maps.LatLng(45, -90);
	                var ToMap = new google.maps.Map(document.getElementById(ToDiv), {
		          center : ToCenter,
		          zoom : 6
	                });
                        var ToBounds = new google.maps.LatLngBounds();
                        var ToWindow = new google.maps.InfoWindow;

			for ( var i = 0; i < surnameLocations.length; i++) {
                                var SurnameLocation = surnameLocations[i];
                                var nid = SurnameLocation.nid;
                                var title = SurnameLocation.node_title;
                                var name = title;

                                if (SurnameLocation.location_field_data_field_from_location_lid > 0)
                                {
                                  var type = 'from';
                                  var city = SurnameLocation.location_field_data_field_from_location_city;
                                  var province = SurnameLocation.location_field_data_field_from_location_province;
                                  var postal_code = SurnameLocation.location_field_data_field_from_location_postal_code;
                                  var country = SurnameLocation.location_field_data_field_from_location_country;
                                  var latitude = SurnameLocation.location_field_data_field_from_location_latitude;
                                  var longitude = SurnameLocation.location_field_data_field_from_location_longitude;

                                  AddNodeMarker(FromMap, FromBounds, FromWindow, nid, title, type, latitude, longitude, name, city, province, postal_code, country);
                              }

                                if (SurnameLocation.location_field_data_field_to_location_lid > 0)
                                {
                                  var type = 'to';
                                  var city = SurnameLocation.location_field_data_field_to_location_city;
                                  var province = SurnameLocation.location_field_data_field_to_location_province;
                                  var postal_code = SurnameLocation.location_field_data_field_to_location_postal_code;
                                  var country = SurnameLocation.location_field_data_field_to_location_country;
                                  var latitude = SurnameLocation.location_field_data_field_to_location_latitude;
                                  var longitude = SurnameLocation.location_field_data_field_to_location_longitude;

                                  AddNodeMarker(ToMap, ToBounds, ToWindow, nid, title, type, latitude, longitude, name, city, province, postal_code, country);
                              }
			}				

                        FromMap.fitBounds(FromBounds);
                        ToMap.fitBounds(ToBounds);
		  }

class SurnameMarker {
  constructor(p_surname) {
    this.title = p_surname.node_title;
    this.nid = p_surname.nid;
    this.address = '';
  }
  
	  geocode() {
		var lv_location;
		var geocoder = new google.maps.Geocoder();
		
		if (geocoder) {
			geocoder.geocode({'address' : this.address}, 
			  function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						// what data in results can be used to relate the
						// location to the address?
						lv_location = results[0].geometry.location;
					} 
					markerCounter++;
					if (markerCounter >= 60) finishSurnames();
			});
		}
  }
}

class OriginMarker extends SurnameMarker {
  constructor(p_surname) {
	  super(p_surname);
    this.type = 'from';
	var field_field_surname_city = p_surname.field_field_surname_european_city;
	if (field_field_surname_city.length > 0) {
		this.city = field_field_surname_city[0].raw.value;
		this.address = this.city;
	}

	var field_field_surname_country = p_surname.field_field_surname_european_country;
	if (field_field_surname_country.length > 0) {
		this.country = field_field_surname_country[0].raw.value;
		if (this.address) this.address += ", ";
		this.address += this.country;
	}
	
	this.geocode();
  }
}

function finishSurnames(){
	alert("all surnames processed");
}

function MapSurnameNodes(p_nids, p_fromDiv, p_toDiv) {
	MapNodeSurnameLocations(p_fromDiv, 'from', p_nids);
	MapNodeSurnameLocations(p_toDiv, 'to', p_nids);
}

function MapUserSurnames(uid, p_fromDiv, p_toDiv) {
	MapUserSurnameLocations(p_fromDiv, 'from', uid);
	MapUserSurnameLocations(p_toDiv, 'to', uid);
}

function URLbase() {
	return location.protocol + '//' + location.host
			+ '/Surnames/SurnameLocationXML.php';
}

function MapNodeSurnameLocations(p_div, p_type, p_nodes) {
	var URL = URLbase() + '?type=' + p_type + '&nodes=' + p_nodes;
	MapSurnameLocations(p_div, p_type, URL);
}

function MapUserSurnameLocations(p_div, p_type, p_uid) {
	var URL = URLbase() + '?type=' + p_type + '&uid=' + p_uid;
	MapSurnameLocations(p_div, p_type, URL);
}

function MapSurnameLocationObjects(p_surnames, p_fromDiv, p_toDiv) {
	markers = [];
	markerCounter = 0;
	for ( var i = 0; i < p_surnames.length; i++) {
		var lv_surname = p_surnames[i];
		var lv_origin = new OriginMarker(lv_surname);
	}
}

function locationsCallBack(markers) {
	// alert(markers);
}

function MapSurnameLocations(p_div, p_type, URL) {
	var toCenter = new google.maps.LatLng(45, -90);
	var fromCenter = new google.maps.LatLng(50, 15);
	var mapCenter = fromCenter;
	if (p_type == 'to')
		mapCenter = toCenter;

	var lv_map = new google.maps.Map(document.getElementById(p_div), {
		center : mapCenter,
		zoom : 6
	});

	var infoWindow = new google.maps.InfoWindow;

	downloadUrl(URL, function(locationData) {
		surnameLocationsToMarkers(locationData, lv_map, infoWindow);
	});
}

function surnameLocationsToMarkers(data, p_map, infoWindow) {
	var xml = data.responseXML;
	var locations = xml.documentElement
			.getElementsByTagName('surname_location');
	var mapLatLngBounds = new google.maps.LatLngBounds(); // Map boundaries
	// object

	// For each location ...
	Array.prototype.forEach.call(locations, function(locationElem) {
		createSurnameMarker(p_map, mapLatLngBounds, infoWindow, locationElem);
	});

	if (locations.length > 1)
		p_map.fitBounds(mapLatLngBounds);
}

function AddSurnameToMaps(p_Surname, p_FromMap, p_ToMap) {
  // 
  // Map From Location
  // Map To Location
}

function createSurnameMarker(p_map, boundingBox, infoWindow, markerElem) {
	var nid = markerElem.getAttribute('nid');
	var title = markerElem.getAttribute('title');
	var type = markerElem.getAttribute('type');
	var latitude = parseFloat(markerElem.getAttribute('latitude'));
	var longitude = parseFloat(markerElem.getAttribute('longitude'));
	var name = markerElem.getAttribute('name');
	var city = markerElem.getAttribute('city');
	var province = markerElem.getAttribute('province');
	var postal_code = markerElem.getAttribute('postal_code');
	var country = markerElem.getAttribute('country');

        AddNodeMarker(p_map, boundingBox, infoWindow
          , nid, title, type, latitude, longitude, name, city, province, postal_code, country);
}

function AddNodeMarker(p_map, boundingBox, infoWindow, nid, title, type, latitude, longitude, name, city, province, postal_code, country){

	var point = new google.maps.LatLng(latitude, longitude);

	boundingBox.extend(point);

	var iconLabel = 'O';
	if (type == 'to') iconLabel = 'D';

	var marker = new google.maps.Marker({
		map : p_map,
		position : point,
		label : iconLabel,
		title : title
	});

        var infowincontent = document.createElement('div');
	var strong = document.createElement('strong');
	strong.innerHTML = '<a href="/node/' + nid + '" title = "View this surname."/>' + title + '</a>';
	infowincontent.appendChild(strong);
	infowincontent.appendChild(document.createElement('br'));

	var csz = document.createElement('text');
	csz.textContent = city + ', ' + province + ' ' + postal_code;
	infowincontent.appendChild(csz);
	infowincontent.appendChild(document.createElement('br'));

	var countryText = document.createElement('text');
	countryText.textContent = country;
	infowincontent.appendChild(countryText);

	marker.addListener('click', function() {
		infoWindow.setContent(infowincontent);
		infoWindow.open(p_map, marker);
	});
};
