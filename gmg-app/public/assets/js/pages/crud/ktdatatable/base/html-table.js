"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable').KTDatatable({
			data: {
				saveState: {cookie: false},
			},
			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},
			columns: [
				{
					field: '#',
					title: '#',
					sortable: 'asc',
					width: 60,
					textAlign: 'center',
				},
				{
					field: 'Actions',
					title: '#',
					width: 100,
					selector: false,
					textAlign: 'center',
				},
				
			],
		});


        $('#kt_datatable_search_query').on('keyup', function() {
			console.log("now search in table");
            datatable.search($(this).val().toLowerCase(),'generalSearch');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();





var KTDatatableHtmlTableHolidays = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable_holidays').KTDatatable({
			data: {
				saveState: {cookie: false},
			},
			columns: [
				{
					field: '#',
					title: '#',
					sortable: 'asc',
					width: 60,
					textAlign: 'center',
				},
				{
					field: 'Actions',
					title: '#',
					width: 60,
					selector: false,
					textAlign: 'center',
				},
				
			],
		});


    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();



jQuery(document).ready(function() {
	KTDatatableHtmlTableDemo.init();
	KTDatatableHtmlTableHolidays.init();
	
});
