
"use strict";
// Class definition

var KTDatatableHtmlTableDemo = function() {
    // Private functions

    // demo initializer
    var demo = function() {

		var datatable = $('#kt_datatable_companies').KTDatatable({

			
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
					field: 'Status',
					title: 'Status',
					sortable: 'asc',
					width: 80,
					textAlign: 'left',
					type: "number",
				},
                {
					field: 'Company',
					title: 'Company',
					sortable: 'asc',
					width: 200,
					textAlign: 'left',
					type: "number",
				},
                {
					field: 'Note',
					title: 'Note',
					width: 700,
					textAlign: 'left',
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

        $('#kt_datatable_search_company_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Company');
        });

		$('#kt_datatable_search_industry').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Industry');
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
