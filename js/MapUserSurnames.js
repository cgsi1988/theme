

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
		createSurnameMarker(locationElem, p_map, infoWindow, mapLatLngBounds);
	});

	if (locations.length > 1)
		p_map.fitBounds(mapLatLngBounds);
}

function createSurnameMarker(markerElem, p_map, infoWindow, boundingBox) {
	var id = markerElem.getAttribute('nid');
	var name = markerElem.getAttribute('name');
	var title = markerElem.getAttribute('title');
	var city = markerElem.getAttribute('city');
	var province = markerElem.getAttribute('province');
	var postal_code = markerElem.getAttribute('postal_code');
	var country = markerElem.getAttribute('country');
	var type = markerElem.getAttribute('type');
	var nid = markerElem.getAttribute('nid');
	var point = new google.maps.LatLng(parseFloat(markerElem
			.getAttribute('latitude')), parseFloat(markerElem
			.getAttribute('longitude')));

	boundingBox.extend(point);

	var infowincontent = document.createElement('div');
	var strong = document.createElement('strong');
	strong.innerHTML = '<a href="https://www.cgsi.org/node/' + nid
			+ '" title = "View this surname."/>' + title + '</a>';
	infowincontent.appendChild(strong);
	infowincontent.appendChild(document.createElement('br'));

	var csz = document.createElement('text');
	csz.textContent = city + ', ' + province + ' ' + postal_code;
	infowincontent.appendChild(csz);
	infowincontent.appendChild(document.createElement('br'));

	var countryText = document.createElement('text');
	countryText.textContent = country;
	infowincontent.appendChild(countryText);

	var customLabel = {
		from : {
			label : 'O'
		},
		to : {
			label : 'D'
		}
	};

	var icon = customLabel[type] || {};
	var marker = new google.maps.Marker({
		map : p_map,
		position : point,
		label : icon.label,
		title : title
	});

	marker.addListener('click', function() {
		infoWindow.setContent(infowincontent);
		infoWindow.open(p_map, marker);
	});
}