function loadMap() {
	var pin = {lat: 34.061564, lng: -118.178051};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 14,
		center: pin
	});
	var marker = new google.maps.Marker({
		position: pin,
		map: map
	});
}