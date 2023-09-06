const map = L.map("map").setView([51.505, -0.09], 13);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Initialize the geocoder control
const geocoder = L.Control.geocoder({
    defaultMarkGeocode: false,
})
    .on("markgeocode", function (e) {
        var latlng = e.geocode.center;
        // Add a marker at the fetched coordinates
        L.marker(latlng).addTo(map);
    })
    .addTo(map);
