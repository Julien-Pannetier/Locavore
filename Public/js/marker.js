class Marker
{

	constructor(map) 
	{
        this.map = map; // Objet carte

        this.eventListener();
	}

    eventListener()
    {
        this.map.addCustomEvent(this.map.map, 'click', this.mapClick.bind(this));
        document.querySelector('#city').addEventListener("blur", this.getCity.bind(this));
    }

	// Récupération des coordonnées du point de vente
	mapClick(e) 
	{
        // Récupération des coordonnées du clic
        let position = e.latlng;

        // Suppression des marqueurs
        if(this.map.marker != undefined){
            this.map.removeMarkers();
        }

        // Personnalisation de l'icône du marqueur
        let icon = L.icon({
            iconUrl: '/public/assets/img/mapMarkerDarken.png',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
        });

        // Ajout du marqueur à la carte
        this.map.addMarkers(position.lat, position.lng, {
			draggable: true,
            icon: icon
        });

        // Affichage des coordonnées dans le formulaire
        document.querySelector("#lat").value = position.lat;
        document.querySelector("#lng").value = position.lng;

        /* MARKER.on('dragend', function(e){
            let position = e.target.getLatLng();
            document.querySelector("#lat").value = position.lat;
            document.querySelector("#lng").value = position.lng;
        }); */
    }

    getCity()
    {
        // Fabrication de l'adresse
        let address = document.querySelector("#address").value + ", " + document.querySelector("#zipCode").value + ", " + document.querySelector("#city").value;
        
        // Initialisation de la requête Ajax
        let xmlhttp = new XMLHttpRequest

        xmlhttp.onreadystatechange = () => {
            if(xmlhttp.readyState == 4){
                if(xmlhttp.status == 200){
                    let response = JSON.parse(xmlhttp.response);
                    
                    let lat = response[0]["lat"];
                    let lng = response[0]["lon"];

                    // Personnalisation de l'icône du marqueur
                    let icon = L.icon({
                        iconUrl: '/public/assets/img/mapMarkerDarken.png',
                        iconSize: [50, 50],
                        iconAnchor: [25, 50],
                    });

                    // Ajout du marqueur à la carte
                    this.map.addMarkers(lat, lng, {
			            draggable: true,
                        icon: icon
                    });
                    
                    // Affichage des coordonnées dans le formulaire
                    document.querySelector("#lat").value = lat;
                    document.querySelector("#lng").value = lng;

                    this.map.setView(lat, lng, 16);
                }
            }
        }

        // Ouverture de la requête
        xmlhttp.open("get", `https://nominatim.openstreetmap.org/search?q=${address}&format=json&addressdetails=1&limit=1&polygon_svg=1`);

        xmlhttp.send();
    }
}