function geocode_adress(map, geocoder, address, titre) {
	var infowindow = null;
	if (!empty(titre)) {
		var infowindow = new google.maps.InfoWindow({
			content : titre
		});
	}
	if (!empty(address)) {
		geocoder.geocode({
			'address' : address
		}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map : map,
					position : results[0].geometry.location
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map, marker);
				});
			} else {
				alert('Geocode was not successful for the following reason: ' + status);
			}
		});
	}
}