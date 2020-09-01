class Carte {

	constructor(idMap, latLng, zoom) {
		this.idMap = idMap; // Identifiant de la carte
		this.latLng = latLng; // Coordonnées de la carte
		this.zoom = zoom; // Niveau de zoom de la carte

		this.addMap();
		this.markerCluster();
	}

	// Ajout de la carte
	addMap() {
		// Initialisation de la carte
		this.map = L.map(this.idMap).setView(this.latLng, this.zoom);
		// Chargement des "tuiles"
		L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
			minZoom: 1,
			maxZoom: 20,
			attribution: '&copy; Openstreetmap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(this.map);
	}

	// Ajout de marqueurs à la carte
	addMarkers(lat, lng, icon) {
		this.marker = L.marker([lat, lng], icon);
		this.markerCluster.addLayer(this.marker);
	}

	// Regroupement des marqueurs
	markerCluster() {
		this.markerCluster = L.markerClusterGroup();
		this.map.addLayer(this.markerCluster);
	}

	// Création d'un événement personnalisé
	addCustomEvent(object, type, callback) {
		object.on(type, callback);
	}
}