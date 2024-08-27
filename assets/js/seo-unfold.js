( function( $ ) {
	function seoUnfoldInit(){
		// Vérifie s'il y a des éléments avec la classe 'seo-unfold'
		if ($('.seo-unfold').length > 0) {
		
		    // Parcours chaque élément avec la classe 'seo-unfold'
		    $('.seo-unfold').each(function (i, e) {
		        // Incrémente l'index pour créer une classe unique pour chaque accordéon
		        i = (i + 1);
			
		        // Si l'accordéon a déjà été initialisé, passe au suivant
		        if ($(e).hasClass('seo-unfold-init')) {
		            return;
		        }
			
		        // Ajoute une classe unique à l'accordéon
		        $(e).addClass(`seo-unfold-${i}`);
			
		        // Sélectionne les éléments à l'intérieur de l'accordéon
		        var unfold = $(`.seo-unfold-${i}`);
		        var unfoldWrapper = unfold.find('.seo-unfold-content-wrapper');
		        var unfoldContent = unfoldWrapper.find('.seo-unfold-content');
		        var unfoldButtons = unfold.find('.seo-unfold-buttons');
			
		        // Obtient la hauteur par défaut de l'accordéon
		        var defaultSize = unfoldWrapper.data('height');
			
		        // Si la hauteur par défaut est vide, supprime les boutons et passe au suivant
		        if (defaultSize == '') {
		            unfoldButtons.remove();
		            return false;
		        }
			
		        // Initialise la hauteur de l'accordéon
		        unfoldWrapper.css('height', `${defaultSize}px`);
			
		        // Calcul des hauteurs et marges pour les éléments de l'accordéon
		        window[`divHeight${i}`] = unfoldWrapper.outerHeight();
		        window[`divMargin${i}`] = (parseInt(unfoldWrapper.css("marginTop").replace('px', '')) + parseInt(unfoldWrapper.css("marginBottom").replace('px', '')));
		        window[`divPadding${i}`] = (parseInt(unfoldWrapper.css("paddingTop").replace('px', '')) + parseInt(unfoldWrapper.css("paddingBottom").replace('px', '')));
		        window[`divTotalHeight${i}`] = (window[`divHeight${i}`] + window[`divMargin${i}`] + window[`divPadding${i}`]);
			
		        window[`textHeight${i}`] = unfoldContent.outerHeight();
		        window[`textMargin${i}`] = (parseInt(unfoldContent.css("marginTop").replace('px', '')) + parseInt(unfoldContent.css("marginBottom").replace('px', '')));
		        window[`textPadding${i}`] = (parseInt(unfoldContent.css("paddingTop").replace('px', '')) + parseInt(unfoldContent.css("paddingBottom").replace('px', '')));
		        window[`textTotalHeight${i}`] = (window[`textHeight${i}`] + window[`textMargin${i}`] + window[`textPadding${i}`]);
			
		        // Vérifie si le contenu dépasse la hauteur par défaut de l'accordéon
		        if (window[`textTotalHeight${i}`] > window[`divTotalHeight${i}`]) {
		            // Initialise l'accordéon et ajoute la classe 'seo-unfold-closed'
		            unfold.addClass('seo-unfold-init seo-unfold-closed');
				
		            // Ajoute un gestionnaire de clic pour les boutons de l'accordéon
		            unfoldButtons.on('click', function (event) {
		                var readMore = $(event.target);
		                var currentUnfold = readMore.closest(`.seo-unfold-${i}`);
		                var contentWrapper = currentUnfold.find('.seo-unfold-content-wrapper');
					
		                // Vérifie si l'accordéon est ouvert ou fermé
		                if (!currentUnfold.hasClass('seo-unfold-opened')) {
		                    // Ouvre l'accordéon
		                    currentUnfold.addClass('seo-unfold-opened').removeClass('seo-unfold-closed');
		                    contentWrapper.css('height', `${(window[`textTotalHeight${i}`] + 10)}px`);
		                } else {
		                    // Ferme l'accordéon
		                    currentUnfold.addClass('seo-unfold-closed').removeClass('seo-unfold-opened');
		                    contentWrapper.css('height', `${defaultSize}px`);
		                }
		            });
		        } else {
		            // Si le contenu ne dépasse pas, supprime les boutons et réinitialise la hauteur
		            unfoldButtons.remove();
		            unfoldWrapper.css('height', '');
		        }
		    });
		}
	}

	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetSeoUnfoldHandler = function( $scope, $ ) {
	  seoUnfoldInit();
	};
	 
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
	  elementorFrontend.hooks.addAction( 'frontend/element_ready/seo-unfold.default', WidgetSeoUnfoldHandler );
	} );
  } )( jQuery );