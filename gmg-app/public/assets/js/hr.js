"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable_hr').KTDatatable({

			
			afterTemplate: function (row, data, index) {
				console.log("after render");
				$( "th[data-field='More']" ).hide();
			},

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
					width: 40,
					textAlign: 'center',
					type: "number",
				},
				{
					field: 'Full Name',
					
					selector: false,
					width: 200,
					textAlign: 'left',
				},
				{
					field: 'Agency',
					width: 'auto',
					selector: false,
					textAlign: 'center',
				},
				
				{
					field: 'Department',
					width: 'auto',
					selector: false,
					textAlign: 'center',
				},
				{
					field: 'Mobile',
					width: 'auto',
					selector: false,
					textAlign: 'center',
				},

				{
					field: 'Status',
					width: 80,
					textAlign: 'center',
				},
				{
					field: 'Note',
					width: 300,
					autoHide: true,
					
				},
				{
					field: 'Salary',
					width: 'auto',
					autoHide: true,
					
				},
				{
					field: 'DaysOff',
					width: 'auto',
					autoHide: true,
					
				},
				{
					field: 'Actions',
					width: 120,
					selector: false,
					autoHide: false,
					textAlign: 'center',
					overflow: 'visible',
				},
				
			],
		});


        $('#kt_datatable_search_query').on('keyup', function() {
			console.log("now search in table");
            datatable.search($(this).val().toLowerCase(),'generalSearch');
        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });
		$('#kt_datatable_search_Agency').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Agency');
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

jQuery(document).ready(function() {
	KTDatatableHtmlTableDemo.init();
	
});
