class Map
{

	constructor(mapId, latLng, zoom)
	{
		this.mapId = mapId; // Identifiant de la carte
		this.latLng = latLng; // Coordonnées de la carte
		this.zoom = zoom; // Niveau de zoom de la carte

		this.addMap();
		this.markerCluster();
	}

	// Ajout de la carte
	addMap()
	{
		// Initialisation de la carte
		this.map = L.map(this.mapId).setView(this.latLng, this.zoom);
		// Chargement des "tuiles"
		L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
			minZoom: 1,
			maxZoom: 20,
			attribution: '&copy; Openstreetmap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(this.map);
	}

	// Ajout de marqueurs à la carte
	addMarkers(lat, lng, icon)
	{
		this.marker = L.marker([lat, lng], icon);
		this.markerCluster.addLayer(this.marker);
		return this.marker;
	}

	// Regroupement des marqueurs
	markerCluster()
	{
		this.markerCluster = L.markerClusterGroup();
		this.map.addLayer(this.markerCluster);
	}

	// Ajout de popups aux marqueurs
	addPopups(content)
	{
		this.marker.bindPopup(content);
	}

	// Suppression des marqueurs
	removeMarkers()
	{
		this.markerCluster.removeLayer(this.marker);
		this.marker = null;
	}

	// Création d'un événement personnalisé
	addCustomEvent(object, type, callback)
	{
		object.on(type, callback);
	}

	// Redéfinition de la vue
	setView(lat, lng, zoom)
	{
		this.map.setView([lat, lng], zoom);
	}
}