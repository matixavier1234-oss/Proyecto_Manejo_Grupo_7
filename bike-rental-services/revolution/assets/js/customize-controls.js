( function( api ) {

	// Extends our custom "bike-rental-services" section.
	api.sectionConstructor['bike-rental-services'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );