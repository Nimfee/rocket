/**
 * Created by aleks on 18.10.16.
 */

var markers = [];
var map;
var markerCluster = null;
var users;
function initMap() {
	var myLatLng = {lat: 51.5085300, lng: -0.1257400};

	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 10,
		center: myLatLng
	});
}

function setMarkers(locations) {
	for (var i = 0; i < locations.length; i++) {
		console.log(locations[i]);
		var marker = setOptions(locations[i], marker);
		markers.push(marker);
	}
	console.log(markers);
}

function setOptions(location) {

	var myLatLng = new google.maps.LatLng(location.lat, location.lng);
	var marker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		icon: 'https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png'
	});

	var box_html = '<div><strong>' + location.description + '</strong></div>';

	var infowindow = new google.maps.InfoWindow({
		content: box_html,
		maxWidth:150
	});

	google.maps.event.addListener(marker, 'click', function () {
		infowindow.open(map, marker);
	});

	return marker;
}

function clearMarkers() {
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(null);
	}
	markers = [];

	if(markerCluster != null) {
		markerCluster.clearMarkers();
	}
}


$("#find").click(function() {
	$.ajax({
			url: "/app_dev.php/rocket/getByCode/" + $('#code').val(),
			type: "GET",
			dataType: 'json'
		})
		.complete(function(data) {
			data = $.parseJSON(data.responseText);
			clearMarkers();

			if (data.result == 'OK') {
				setMarkers(data.items);
			} else {
				alert(data.result);
			}

		});
});