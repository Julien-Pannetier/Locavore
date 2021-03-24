class Marker
{

	constructor(map)
	{
        this.map = map; // Objet carte

        this.lat = document.querySelector("#lat");
        this.lng = document.querySelector("#lng");
        this.city = document.querySelector('#city');

        this.eventListener();
	}

    // Ecoute les évènements
    eventListener()
    {
        this.map.addCustomEvent(this.map.map, 'click', this.addMarkerOnMapClick.bind(this));
        this.city.addEventListener("blur", this.addMarkerByAddress.bind(this));
        this.lat.addEventListener("input", this.addMarker(this.lat.value, this.lng.value));
    }

    // Ajout d'un marqueur au clic sur la carte
	addMarkerOnMapClick(e)
	{
        // Récupération des coordonnées du clic
        let position = e.latlng;
        let lat = position.lat;
        let lng = position.lng;

        this.addMarker(lat, lng);
    }

    // Ajout d'un marqueur à l'adresse indiquée
    addMarkerByAddress()
    {
        // Fabrication de l'adresse
        let address = document.querySelector("#address").value + ", " + document.querySelector("#postalCode").value + ", " + document.querySelector("#city").value;
        
        // Initialisation de la requête Ajax
        let xmlhttp = new XMLHttpRequest

        xmlhttp.onreadystatechange = () => {
            if(xmlhttp.readyState == 4){
                if(xmlhttp.status == 200){
                    let response = JSON.parse(xmlhttp.response);
                    
                    let lat = response[0]["lat"];
                    let lng = response[0]["lon"];

                    this.addMarker(lat, lng);

                    this.map.setView(lat, lng, 16);
                }
            }
        }

        // Ouverture de la requête
        xmlhttp.open("get", `https://nominatim.openstreetmap.org/search?q=${address}&format=json&addressdetails=1&limit=1&polygon_svg=1`);

        // Envoi de la requête
        xmlhttp.send();
    }

    // Ajout d'un marker à la carte
    addMarker(lat, lng)
    {
        // Suppression des marqueurs
        if(this.map.marker != undefined){
            this.map.removeMarkers();
        }

        // Personnalisation du marqueur
        let icon = L.icon({
            iconUrl: '/public/assets/img/mapMarkerDarken.png',
            iconSize: [50, 50],
            iconAnchor: [25, 50],
        });

        // Ajout du marqueur à la carte
        this.marker = this.map.addMarkers(lat, lng, {
			draggable: true,
            icon: icon
        });

        this.getCurrentPosition(lat, lng);
        this.marker.on('dragend', this.dragEnd.bind(this));
    }

    // Affichage des coordonnées dans le formulaire
    getCurrentPosition(lat, lng)
    {
        this.lat.value = lat;
        this.lng.value = lng;
    }

    // Correction des coordonnées au déplacement du marqueur
    dragEnd(e)
    {
        let position = e.target.getLatLng();
        this.getCurrentPosition(position.lat, position.lng);
    }
}