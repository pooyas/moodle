

/**
 * Iplookup utility functions
 *
 */

M.core_iplookup = {};

M.core_iplookup.init3 = function(Y, latitude, longitude, ip) {
    var ipLatlng = new google.maps.LatLng(latitude, longitude);

    var mapOptions = {
        center: ipLatlng,
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
        position: ipLatlng,
        map: map,
        title: ip
    });
};
