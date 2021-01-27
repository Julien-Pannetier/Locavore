class Flash
{

	constructor() 
	{
		this.getFlash();
	}

	// Récupération du message flash
	getFlash() 
	{
		$.getJSON('/ajax/getFlash', function(flash) {

		if(!flash){
			return;
		}
		
		// Personnalisation du message flash
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": false,
			"positionClass": "toast-top-full-width",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}

		// Affichage du message flash
		toastr[flash.type]( flash.message);
		})
	}
}