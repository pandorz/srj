
app.mapsController = app.mapsController || {};
app.mapsController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        
        if($('.osMap').length) {
            
            $('.osMap').each(function(){
                //var mymap = L.map('mapid').setView([51.505, -0.09], 13);
                //var mymap = L.map('mapid').setView([49.4431, 1.0993], 15);
                var mymap = L.map('mapid').setView([49.43711, 1.09117], 13);


                /**
                 * MISE EN PLACE DE MARQUEURS
                 * avec en option des popups
                 */
                var marker = L.marker([49.4431, 1.0993]).addTo(mymap);
                marker.bindPopup("<b>Test</b><br>Rouen");
                var marker = L.marker([49.421235, 1.075605]).addTo(mymap);
                marker.bindPopup("<b>Popup</b><br>Jardin des plantes");


                /**
                 * COMMENT CENTRER LA MAP EN FONCTION DE DIFFERENTS MARQUEURS
                 * ne fonctionne pas avec un seul marqueur
                 */
                var bounds = new L.LatLngBounds([[49.4431, 1.0993],[49.421235, 1.075605],[49.52758, 1.03924]]);
                mymap.fitBounds(bounds);


                /**
                 * AFFICHAGE DE LA MAP
                 * avec mapbox
                 */
                L.tileLayer('https://api.mapbox.com/styles/v1/alexdupreweb/ciqtcjfy50003c6ngu7gkobbd/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWxleGR1cHJld2ViIiwiYSI6ImNpcXRjaWd1MjAwMHlpM25pd2VjbWFzdHIifQ.YXzsARceS3R8sRpmqOdisw', {
                    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                    maxZoom: 18,
                    id: 'your.mapbox.project.id',
                    accessToken: 'your.mapbox.public.access.token'
                }).addTo(mymap);

                /**
                 * FONCTION POUR RECUPERER LA LOCALISATION AU CLIC
                 */
                /*function onMapClick(e) {
                    document.getElementById("latlngid").innerHTML = e.latlng;
                    //alert("You clicked the map at " + e.latlng);
                }
                mymap.on('click', onMapClick);*/

                /*function onMapClick(e) {
                    //gib_uni();
                    marker = new L.marker(e.latlng, {draggable:'true'});
                    marker.on('dragend', function(event){
                        var marker = event.target;
                        var position = marker.getLatLng();
                        //console.log(position);
                        document.getElementById("latlngid").innerHTML = position;
                        marker.setLatLng(position,{id:uni,draggable:'true'}).bindPopup(position).update();
                    });
                    mymap.addLayer(marker);
                }
                mymap.on('click', onMapClick);*/
            });
        }
    }
};

$(document).ready(function(){
    app.mapsController.defaultAction.init();
});
