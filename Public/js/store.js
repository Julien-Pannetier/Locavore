class Store
{

	constructor(map) 
	{
		this.map = map; // Objet carte
		this.marker; // Marqueur

		this.getStores();
	}

	// Récupération des données des points de vente
	getStores() 
	{
		const self = this;
        $.getJSON('./ajax/getStores', function(stores) {
			console.log("1");
			console.log(stores);
			self.displayStores(stores);
			
			
			const radios = document.querySelectorAll('input[name="storeType"]')
			
			radios.forEach(radio => {
				radio.addEventListener('change', () => {
					console.log("2");
					let filter = radio.value;
					console.log(filter);
					self.filterStores(stores, filter);
				});
			})
        })
	}

	filterStores(stores, filter = "All")
	{
		//const self = this;
		//const radios = document.querySelectorAll('input[name="storeType"]')
		//console.log("2");
		//radios.forEach(radio => {
			//radio.addEventListener('change', () => {
				let filteredStores = "";

				if(filter === "All") {
					filteredStores = stores;
				} else {
					filteredStores = stores.filter(store => store.type === filter);
					console.log(filter);
					console.log(filteredStores);
				}
				//self.displayStores(filteredStores);
				this.displayStores(filteredStores);
			//});
		//})
	}

	displayStores(stores)
	{
		const self = this;
		console.log("3");
		console.log("markerCluster", this.map.marker);
		


		// Suppression des marqueurs
 		if(this.map.marker != undefined){
			console.log("4");
			this.map.removeMarkers();
			self.marker = null;
		}


		console.log("marker", self.marker);
		console.log("markerCluster2", this.map.marker);

		stores.forEach(store => {

			// Personnalisation des marqueurs
			let icons = L.icon({
				iconUrl: '/public/assets/img/mapMarkerDarken.png',
				iconSize: [60, 60],
				iconAnchor: [30, 60],
				popupAnchor: [0, -60]
			});

			// Ajout des marqueurs à la carte
			const [lng, lat] = store.wkt.substr(6).substr(0, store.wkt.substr(6).length - 1).split(" ");
			self.marker = self.map.addMarkers(lat, lng, {icon: icons});
			console.log("marker", self.marker);

			// Ajout de popups aux marqueurs
			self.map.addPopups('<p>'+ store.name +'</p><br><a href="store/findOne/'+ store.id +'">Accéder à la fiche complète</a>');
		})
	}
}