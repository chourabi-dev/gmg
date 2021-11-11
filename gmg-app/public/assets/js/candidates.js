"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable_condidates').KTDatatable({

			
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
					width: 50,
					textAlign: 'left',
					type: "number",
				},
				{
					field: 'FullName',
					
					selector: false,
					width: 220,
					textAlign: 'left',
				},
				{
					field: 'Subskills',
					
					selector: false,
					width: 100,
					textAlign: 'left',
					
				},
				{
					field: 'Contract status',
					autoHide: false,
					selector: false,
					width: 'auto',
					textAlign: 'left',
				},
				{
					field: 'Equivalence status',
					autoHide: false,
					selector: false,
					width: 'auto',
					textAlign: 'left',
				},
				{
					field: 'Payment',
					autoHide: true,
					selector: false,
					width: 150,
					textAlign: 'left',
				},
				{
					field: 'Contract note',
					autoHide: true,
					selector: false,
					width: 'auto',
					textAlign: 'left',
				},
				{
					field: 'Equivalence note',
					autoHide: true,
					selector: false,
					width: 'auto',
					textAlign: 'left',
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

        $('#kt_datatable_search_skill').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'FullName');
        });

		$('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Equivalence status');
        });
		$('#kt_datatable_search_contract_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Contract status');
        });




		
		

       // $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();


		

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
