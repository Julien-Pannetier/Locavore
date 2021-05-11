class Store
{

	constructor(map) 
	{
		this.map = map; // Objet carte

		this.getStores();
	}

	// Récupération des données des points de vente
	getStores() 
	{
		const self = this;
        $.getJSON('./ajax/getStores', function(stores) {
			self.displayStores(stores);
			
			const radios = document.querySelectorAll('input[name="storeType"]')
			
			radios.forEach(radio => {
				radio.addEventListener('change', () => {
					let filter = radio.value;
					self.filterStores(stores, filter);
				});
			})
        })
	}

	filterStores(stores, filter = "All")
	{
		let filteredStores = "";

		if(filter === "All") {
			filteredStores = stores;
		} else {
			filteredStores = stores.filter(store => store.type === filter);
		}
		this.displayStores(filteredStores);
	}

	displayStores(stores)
	{
		const self = this;

		// Suppression des marqueurs
 		if(this.map.marker != undefined){
			this.map.removeMarkers();
		}

		stores.forEach(store => {

			// Personnalisation des marqueurs
			let icons = L.icon({
				iconUrl: '/public/assets/img/mapMarker.png',
				iconSize: [60, 60],
				iconAnchor: [30, 60],
				popupAnchor: [0, -60]
			});

			// Ajout des marqueurs à la carte
			const [lng, lat] = store.lng_lat.substr(6).substr(0, store.lng_lat.substr(6).length - 1).split(" ");
			self.marker = self.map.addMarkers(lat, lng, {icon: icons});

			// Ajout de popups aux marqueurs
			self.map.addPopups('<p>'+ store.name +'</p><br><a href="store/findOne/'+ store.id +'">Accéder à la fiche complète</a>');
		})
	}
}