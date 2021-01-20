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

			let radios = $('#storesFilter input');
    		radios.change(function() {
				let checked = radios.filter(':checked');
				console.log(checked.val());
				
				if(checked.val() == ""){
					return stores;
				} else {
					let filteredStores = stores.filter(store => store.type === checked.val());
					console.log(filteredStores);
				}
			})

            stores.forEach(store => {
				// Personnalisation des icônes des marqueurs
				let icons = L.icon({
					iconUrl: '/public/assets/img/mapMarkerDarken.png',
					iconSize: [60, 60],
					iconAnchor: [30, 60],
					popupAnchor: [0, -60]
				});

				// Ajout des marqueurs à la carte
				const [lng, lat] = store.wkt.substr(6).substr(0, store.wkt.substr(6).length - 1).split(" ");
				self.map.addMarkers(lat, lng, {icon: icons});

				// Ajout de popups aux marqueurs
				self.map.addPopups('<p>'+ store.name +'</p><br><a href="store/findOne/'+ store.id +'">Accéder à la fiche complète</a>');
			})
        })
	}
}