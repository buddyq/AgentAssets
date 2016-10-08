// @codekit-prepend "conditional-fields-legacy.js";
// @codekit-prepend "conditions.js";
/**
* Handles showing and hiding fields conditionally
*/
jQuery( document ).ready( function( $ ) {

	// Show/hide elements as necessary when a conditional field is changed
	$( '#envira-gallery-settings input:not([type=hidden]), #envira-gallery-settings select' ).conditions( 
		[

			{	// Main Theme Elements
				conditions: {
					element: '[name="_envira_gallery[lightbox_theme]"]',
					type: 'value',
					operator: 'array',
					condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
				},
				actions: {
					if: [
						{
							element: '#envira-config-lightbox-title-display-box, #envira-config-lightbox-arrows-box, #envira-config-lightbox-arrows-position-box, #envira-config-lightbox-toolbar-box, #envira-config-lightbox-toolbar-title-box, #envira-config-lightbox-toolbar-position-box, #envira-config-thumbnails-width-box, #envira-config-thumbnails-height-box, #envira-config-thumbnails-position-box, #envira-config-mobile-arrows-box, #envira-config-mobile-toolbar-box, #envira-config-mobile-thumbnails-box, #envira-config-social-lightbox-orientation-box, #envira-config-social-lightbox-outside-box, #envira-config-social-lightbox-position-box, #envira-config-print-lightbox-position-box, #envira-config-downloads-lightbox-position-box',
							action: 'show'
						}
					]
				}
			},
			{
				conditions: {
					element: '[name="_envira_gallery[lightbox_theme]"]',
					type: 'value',
					operator: 'array',
					condition: [ 'base_dark' ]
				},
				actions: {
					if: [
						{
							element: '#envira-config-lightbox-title-display-box, #envira-config-lightbox-arrows-box, #envira-config-lightbox-arrows-position-box, #envira-config-lightbox-toolbar-box, #envira-config-lightbox-toolbar-title-box, #envira-config-lightbox-toolbar-position-box, #envira-config-thumbnails-width-box, #envira-config-thumbnails-height-box, #envira-config-thumbnails-position-box, #envira-config-mobile-arrows-box, #envira-config-mobile-toolbar-box, #envira-config-mobile-thumbnails-box, #envira-config-social-lightbox-orientation-box, #envira-config-social-lightbox-outside-box, #envira-config-social-lightbox-position-box, #envira-config-print-lightbox-position-box, #envira-config-downloads-lightbox-position-box',
							action: 'hide'
						}
					]
				}
			},
			{	// Mobile Elements Dependant on Theme
				conditions: [
					{
						element: '[name="_envira_gallery[lightbox_theme]"]',
						type: 'value',
						operator: 'array',
						condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
					},
					{
						element: '[name="_envira_gallery[mobile_lightbox]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-mobile-arrows-box, #envira-config-mobile-toolbar-box, #envira-config-mobile-thumbnails-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-mobile-arrows-box, #envira-config-mobile-toolbar-box, #envira-config-mobile-thumbnails-box',
						action: 'hide'
					}
				}
			},
			{	// Mobile Elements Independant of Theme
				conditions: {
					element: '[name="_envira_gallery[mobile_lightbox]"]',
					type: 'checked',
					operator: 'is'
				},
				actions: {
					if: {
						element: '#envira-config-mobile-touchwipe-box, #envira-config-mobile-touchwipe-close-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-mobile-touchwipe-box, #envira-config-mobile-touchwipe-close-box',
						action: 'hide'
					}
				}
			},
			{	// Download Button Elements Dependant on Theme
				conditions: [
					{
						element: '[name="_envira_gallery[lightbox_theme]"]',
						type: 'value',
						operator: 'array',
						condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
					},
					{
						element: '[name="_envira_gallery[download_lightbox]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-downloads-lightbox-position-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-downloads-lightbox-position-box',
						action: 'hide'
					}
				}
			},
			{	// Download Button Elements Independant of Theme
				conditions: {
					element: '[name="_envira_gallery[download_lightbox]"]',
					type: 'checked',
					operator: 'is'
				},
				actions: {
					if: {
						element: '#envira-config-downloads-lightbox-force-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-downloads-lightbox-force-box',
						action: 'hide'
					}
				}
			},
			{	// Printing Button Elements Dependant on Theme
				conditions: [
					{
						element: '[name="_envira_gallery[lightbox_theme]"]',
						type: 'value',
						operator: 'array',
						condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
					},
					{
						element: '[name="_envira_gallery[print_lightbox]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-print-lightbox-position-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-print-lightbox-position-box',
						action: 'hide'
					}
				}
			},
			{	// Social Elements Dependant on Theme
				conditions: [
					{
						element: '[name="_envira_gallery[lightbox_theme]"]',
						type: 'value',
						operator: 'array',
						condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
					},
					{
						element: '[name="_envira_gallery[social_lightbox]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-social-lightbox-position-box, #envira-config-social-lightbox-outside-box, #envira-config-social-lightbox-orientation-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-social-lightbox-position-box, #envira-config-social-lightbox-outside-box, #envira-config-social-lightbox-orientation-box',
						action: 'hide'
					}
				}
			},
			{	// Social Elements Independant of Theme, Dependant on Social Icons
				conditions: [
					{
						element: '[name="_envira_gallery[social_lightbox]"]',
						type: 'checked',
						operator: 'is'
					},
					{
						element: '[name="_envira_gallery[social_lightbox_facebook]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-social-lightbox-networks-facebook-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-social-lightbox-networks-facebook-box',
						action: 'hide'
					}
				}
			},
			{	// Social Elements Independant of Theme, Dependant on Social Icons
				conditions: [
					{
						element: '[name="_envira_gallery[social_lightbox]"]',
						type: 'checked',
						operator: 'is'
					},
					{
						element: '[name="_envira_gallery[social_lightbox_twitter]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-social-lightbox-networks-twitter-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-social-lightbox-networks-twitter-box',
						action: 'hide'
					}
				}
			},
			{	// Social Elements Independant of Theme
				conditions: [
					{
						element: '[name="_envira_gallery[social_lightbox]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-social-lightbox-networks-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-social-lightbox-networks-box',
						action: 'hide'
					}
				}
			},
			{	// Thumbnail Elements Dependant on Theme
				conditions: [
					{
						element: '[name="_envira_gallery[lightbox_theme]"]',
						type: 'value',
						operator: 'array',
						condition: [ 'base', 'caption', 'polaroid', 'showcase', 'sleek', 'subtle' ]
					},
					{
						element: '[name="_envira_gallery[thumbnails]"]',
						type: 'checked',
						operator: 'is'
					}
				],
				actions: {
					if: {
						element: '#envira-config-thumbnails-position-box, #envira-config-thumbnails-height-box, #envira-config-thumbnails-width-box',
						action: 'show'
					},
					else: {
						element: '#envira-config-thumbnails-position-box, #envira-config-thumbnails-height-box, #envira-config-thumbnails-width-box',
						action: 'hide'
					}
				}
			}

		]
	);

} );