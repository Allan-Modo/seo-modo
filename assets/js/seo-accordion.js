( function( $ ) {
	function seoAccordionInit(){
		// Vérifie s'il y a des éléments avec la classe 'seo-accordion'
		if ($('.seo-accordion').length > 0) {
		
		    // Parcours chaque élément avec la classe 'seo-accordion'
		    $('.seo-accordion').each(function (i, e) {
		        // Incrémente l'index pour créer une classe unique pour chaque accordéon
		        i = (i + 1);
			
		        // Si l'accordéon a déjà été initialisé, passe au suivant
		        if ($(e).hasClass('seo-accordion-init')) {
		            return;
		        }
			
		        // Ajoute une classe unique à l'accordéon
		        $(e).addClass(`seo-accordion-${i}`);
			
		        // Sélectionne les éléments à l'intérieur de l'accordéon
		        var accordion = $(`.seo-accordion-${i}`);
		        var accordionWrapper = accordion.find('.seo-accordion-content-wrapper');
		        var accordionContent = accordionWrapper.find('.seo-accordion-content');
		        var accordionButtons = accordion.find('.seo-accordion-buttons');
			
		        // Obtient la hauteur par défaut de l'accordéon
		        var defaultSize = accordionWrapper.data('height');
			
		        // Si la hauteur par défaut est vide, supprime les boutons et passe au suivant
		        if (defaultSize == '') {
		            accordionButtons.remove();
		            return false;
		        }
			
		        // Initialise la hauteur de l'accordéon
		        accordionWrapper.css('height', `${defaultSize}px`);
			
		        // Calcul des hauteurs et marges pour les éléments de l'accordéon
		        window[`divHeight${i}`] = accordionWrapper.outerHeight();
		        window[`divMargin${i}`] = (parseInt(accordionWrapper.css("marginTop").replace('px', '')) + parseInt(accordionWrapper.css("marginBottom").replace('px', '')));
		        window[`divPadding${i}`] = (parseInt(accordionWrapper.css("paddingTop").replace('px', '')) + parseInt(accordionWrapper.css("paddingBottom").replace('px', '')));
		        window[`divTotalHeight${i}`] = (window[`divHeight${i}`] + window[`divMargin${i}`] + window[`divPadding${i}`]);
			
		        window[`textHeight${i}`] = accordionContent.outerHeight();
		        window[`textMargin${i}`] = (parseInt(accordionContent.css("marginTop").replace('px', '')) + parseInt(accordionContent.css("marginBottom").replace('px', '')));
		        window[`textPadding${i}`] = (parseInt(accordionContent.css("paddingTop").replace('px', '')) + parseInt(accordionContent.css("paddingBottom").replace('px', '')));
		        window[`textTotalHeight${i}`] = (window[`textHeight${i}`] + window[`textMargin${i}`] + window[`textPadding${i}`]);
			
		        // Vérifie si le contenu dépasse la hauteur par défaut de l'accordéon
		        if (window[`textTotalHeight${i}`] > window[`divTotalHeight${i}`]) {
		            // Initialise l'accordéon et ajoute la classe 'seo-accordion-closed'
		            accordion.addClass('seo-accordion-init seo-accordion-closed');
				
		            // Ajoute un gestionnaire de clic pour les boutons de l'accordéon
		            accordionButtons.on('click', function (event) {
		                var readMore = $(event.target);
		                var currentAccordion = readMore.closest(`.seo-accordion-${i}`);
		                var contentWrapper = currentAccordion.find('.seo-accordion-content-wrapper');
					
		                // Vérifie si l'accordéon est ouvert ou fermé
		                if (!currentAccordion.hasClass('seo-accordion-opened')) {
		                    // Ouvre l'accordéon
		                    currentAccordion.addClass('seo-accordion-opened').removeClass('seo-accordion-closed');
		                    contentWrapper.css('height', `${(window[`textTotalHeight${i}`] + 10)}px`);
		                } else {
		                    // Ferme l'accordéon
		                    currentAccordion.addClass('seo-accordion-closed').removeClass('seo-accordion-opened');
		                    contentWrapper.css('height', `${defaultSize}px`);
		                }
		            });
		        } else {
		            // Si le contenu ne dépasse pas, supprime les boutons et réinitialise la hauteur
		            accordionButtons.remove();
		            accordionWrapper.css('height', '');
		        }
		    });
		}
	}

	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetSeoAccordionHandler = function( $scope, $ ) {
	  seoAccordionInit();
	};
	 
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
	  elementorFrontend.hooks.addAction( 'frontend/element_ready/seo-accordion.default', WidgetSeoAccordionHandler );
	} );
  } )( jQuery );