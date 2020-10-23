class Store {

	constructor(contractName, apiKey, carte, reservation) {
		this.carte = carte; // Objet carte

		this.getStores();
	}

	// Récupération des données des points de vente
	getStores() {
		const self = this;
        $.getJSON('./ajax/getStores', function(stores) {
            
            console.log(stores);



			/* stores.forEach(store => {
				// Personnalisation des icônes des marqueurs
				let iconsColor;
				if (store.type === "farm") {
					iconsColor = "red";
				} else if (store.type === "drive") {
					iconsColor = "orange";
				} else if (store.type === "market") {
					iconsColor = "green";
				}
				let icons = L.icon({
					iconUrl: 'asstes/img/marker__icon_' + iconsColor + '.png'
				});
				// Ajout des marqueurs à la carte
				self.carte.addMarkers(store.position.lat, store.position.lng, {icon: icons});
				// Création d'un événement personnalisé au click sur le marqueur
				self.carte.addCustomEvent(self.carte.marker, 'click', self.storeClick(store).bind(self));
			}) */
        })
	}

	// Affichage les informations du point de vente au click sur le marqueur
	storeClick = store => () => {
		
	}
}