$(document).ready(function(){

    var path = window.location.pathname; // because the 'href' property of the DOM element is the absolute path
    if (path.trim() === "/") {
        $(".side-navigation-item").first().addClass("menu-item-active");
    }else{
        $(".side-navigation-item").each(function() {

            var linkA = $(this).children("a").attr('href');
            
            console.log(linkA, path);
    
            if ((path.trim().indexOf(linkA.trim()) != -1) && ( linkA.trim() !== "/" ) ) {
                $(this).addClass("menu-item-active");
            }
        });
    }




    $("#addNewAllowses").off().on("click", function(event) {
        event.stopPropagation();
        });
    // add staff js
    var nbrAllowanses = 1;



    $("#addNewAllowses").click(function(e){
        nbrAllowanses++;

        var blocAllowance ='<div><div class="form-group row">';
        blocAllowance+='<label class="col-xl-3 col-lg-3 col-form-label">Allowance type</label>';
        blocAllowance+='<div class="col-lg-9 col-xl-9">';
        blocAllowance+='<input class="form-control form-control-lg form-control-solid" name="allowanceTypeCompany'+nbrAllowanses+'" type="text" value="" />';
        blocAllowance+='</div></div><div class="form-group row"><label class="col-xl-3 col-lg-3 col-form-label">Amount</label><div class="col-lg-9 col-xl-9">';
        blocAllowance+='<inputclass="form-control form-control-lg form-control-solid" name="amountCompany'+nbrAllowanses+'" type="text" value="" />';
        blocAllowance+='</div></div><div class="form-group row"><label class="col-xl-3 col-lg-3 col-form-label">Duedate</label><div class="col-lg-9 col-xl-9">';
        blocAllowance+=' <input class="form-control form-control-lg form-control-solid" name="duedateCompany'+nbrAllowanses+'" type="date" value="" />';
    
        blocAllowance+='</div></div><div class="form-group row"><label class="col-xl-3 col-lg-3 col-form-label">Periodicity</label><div class="col-lg-9 col-xl-9">';
        blocAllowance+='<input class="form-control form-control-lg form-control-solid"  name="periodicityCompany" type="date" value="" />';
        blocAllowance+='</div></div><div class="form-group row"><label class="col-xl-3 col-lg-3 col-form-label">Note </label><div class="col-lg-9 col-xl-9">';
        blocAllowance+='<input class="form-control form-control-lg form-control-solid" name="noteCompany'+nbrAllowanses+'" type="text" value="" />';
        blocAllowance+='</div></div></div>';



        $("#nbrAllowancesCount").val(nbrAllowanses);
        $("#allowancesSection").append(blocAllowance);
        e.preventDefault();
        e.stopPropagation();
    })

    //end staff js




    $(".phone-toogler").click(function(){
        $(".phone-form-update").slideToggle();
    })

    $(".day-toogler").click(function(){
        $(".day-form-update").slideToggle();
    })

    


    // init phones input plugin
    var inputTel1 = $("#phoneOne").intlTelInput({
        preferredCountries: ["tn" ],
        separateDialCode:true,
        nationalMode:false,
        formatOnDisplay:true,

    })
    $("#phoneOne").on("countrychange",function(v) {
        console.log(v);
        var code = $("#phoneOne").parent().children('.iti__flag-container').children('.iti__selected-flag').children('.iti__selected-dial-code').html();

        console.log(code);
        $("#tel1Code").val(code)
    });
        
    
    $("#phoneTwo").intlTelInput({
        preferredCountries: ["tn" ],
        separateDialCode:true,
        nationalMode:false,
        formatOnDisplay:true,
    });

    $("#phoneTwo").on("countrychange",function(v) {

        var code = $("#phoneTwo").parent().children('.iti__flag-container').children('.iti__selected-flag').children('.iti__selected-dial-code').html();

        $("#tel2Code").val(code)
    });
        
    

    $("#nationalityAdd").countrySelect({
        defaultCountry:"tn"
    });

    $("#country_selector").countrySelect({
        defaultCountry:"tn"
    });

    $(".edit-number").each(function(){
        var old = $(this).attr("old-number");
        var comp = old.split(" ");
        $(this).val(comp[comp.length - 1]);
    })

    $("[to-update-type-input]").attr('type','date')
        

    $(".open-note-edit").click(function(e){
        e.preventDefault();
        var target = $(this).attr('target-note-edit');
        
        $("."+target+"-core").hide();
        $("."+target+"").slideDown();
        
        
    });







    var contractsTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#contractsTable').KTDatatable({
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
                        field: 'Type',
                        title: '#',
                        width: 60,
                    },
                    {
                        field: 'Status',
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
    


    var allowoncesTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#allowoncesTable').KTDatatable({
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
                        field: 'Type',
                        title: '#',
                        width: 90,
                    },
                    {
                        field: 'Actions',
                        title: '#',
                        width: 90,
                    },
                    {
                        field: 'Note',
                        width: 200,
                        autoHide: true,
                        
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



    
    var skillsTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#skillsTable').KTDatatable({
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
                        field: 'Order',
                        title: 'Order',
                        width: 60,
                    },
                    {
                        field: 'Actions',
                        title: '#',
                        width: 90,
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
    

    var paymentsTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#paymentsTable').KTDatatable({
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
                        field: 'Note',
                        title: '#',
                        selector: false,
                        autoHide: true,
                        width: 90,
                    },
                    {
                        field: 'Actions',
                        width: 90,
                        selector: false,
                        autoHide: false,
                        textAlign: 'center',
                        overflow: 'visible',
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


    var documentsTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#documentsTable').KTDatatable({
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
                        width: 90,
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
    
    
    
    
    
    var contractsTablesInitilized = false;
    var skillsTableInitilized = false;
    
    $("#tab_2_contracts").click(function(){
        
        
        if (contractsTablesInitilized == false) {
            contractsTable.init();
            contractsTablesInitilized = ! contractsTablesInitilized;
        }

        if (skillsTableInitilized == false) {
            skillsTable.init();
            skillsTableInitilized = ! skillsTableInitilized;
        }
        
    })


    var allowancesTablesInitilized = false;
    var paymentsTableInitilized = false;




    $("#tab_3_allowonces").click(function(){
        
        
        if (allowancesTablesInitilized == false) {
            allowoncesTable.init();
            allowancesTablesInitilized = ! allowancesTablesInitilized;
        }

        if (paymentsTableInitilized == false) {
            paymentsTable.init();
            paymentsTableInitilized = ! paymentsTableInitilized;
        }
        
    })

    // Class definition


    var kt_reperter_inited = false
    var documentsTableInited = false;


    $("#tab_4_documents").click(function(){

        if (documentsTableInited == false) {
            documentsTable.init();
            documentsTableInited = ! documentsTableInited;
        }


        console.log("wiouw");
        // init repeater
        if (kt_reperter_inited == false) {
            $('#kt_repeater_documents').repeater({
                initEmpty: false,
               
                defaultValues: {
                    'text-input': 'foo'
                },
                 
                show: function () {
                    $(this).slideDown();
                },
    
                hide: function (deleteElement) {                
                    $(this).slideUp(deleteElement);                 
                }   
            });

            kt_reperter_inited = !kt_reperter_inited;
        }

    })


    var locationsTable = function() {
        // Private functions
    
        // demo initializer
        var demo = function() {
    
            var datatable = $('#locationsTable').KTDatatable({
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
                        width: 120,
                        selector: false,
                        autoHide: false,
                        textAlign: 'center',
                        overflow: 'visible',
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
    
    
    
    

    
    var locationsTableInited = false;


    $("#tab_2_locations").click(function(){
        

        

        if (locationsTableInited == false) {
            locationsTable.init();
            locationsTableInited = ! locationsTableInited;
        }

    })



    var doneNameFormat = false
    $("#docForm").on('submit',function(e){
        e.preventDefault();


            doneNameFormat == true;
            $(".document-to-upload").each(function(){
                var oldName = $(this).attr('name');
                var newName =oldName.substr(4,(oldName.length-5))+'['+oldName.substr(1,(oldName.indexOf(']')-1))+']';

                $(this).attr('name',newName);

            
            });
            

            $(this).unbind('submit').submit();


    })

    $("#submit-btn-add-documents").click(function(e){
            //e.preventDefault();

			
			//console.log( $("#docForm").serializeArray() );

            var expiryDate = $("#docExpiryDate").val();
            var issueDate = $("#docIssueDate").val();
            

            
            if (expiryDate != '' ) {
                var iDate = new Date(issueDate);
                var eDate = new Date(expiryDate);

                if (eDate.getTime() <= iDate.getTime()) {
                    e.preventDefault();
                    $("#errDateDocAdd").fadeIn();
                }
                
                
            }else{
                $("#errDateDocAdd").fadeOut();
            }
			
		
	});


    ///********************************* */
    













    $("#photoUpdate").on('change',function(){
        $(this).parent().submit();
    });

    /*var stringPeriodicitys = $("#per_data").val();
    

    var periodicitysArray = stringPeriodicitys.split(",");
    periodicitysArray.pop();



    periodicitysArray.map((p)=>{
        $("#allowances_periodicity").append('<option value="'+p+'">'+p+'</option>');
    })*/


    $("#refByDrop").select2();


    $("#condidates_dob").attr('type','date')






    $("#skill-details-page").change(function(e){
		
		var skillID = $(this).val();
		var url = '/EN/condidates/get-subskill/'+skillID;
		
		$.ajax({
			url: url,
		  }).done(function(data) {
			console.log(data);
			
			var bloc = '<option value="">Please choose a value</option>';
			data.forEach(s => {
				bloc+='<option value="'+s.id+'">'+s.sub_skill+'</option>';
			});
			
			
			$("#subskill-details-page").html(bloc)
			$("#subskill-details-page").slideDown();
		  });
	});



    $(".country_selector_many").countrySelect({
        defaultCountry:"tn"
    });

    $(".country-selector-x").countrySelect({
        defaultCountry:"tn"
    });

    



    




    
    $(".edit-phone-btn").click(function(){
        var phone = $(".phone-init-plugin").attr('to-update-phone');
       
        var code = phone.substr(1, (phone.indexOf(')')-1) );
        $("#phoneEditCode").val(code);
        $(".phone-init-plugin").val(code+' '+phone.split(' ')[1]);
        $(".phone-init-plugin").change();
        
        $(".phone-init-plugin").intlTelInput({});
    })

    $("#submit-btn-add-condidate").click(function(){
        $(this).attr('disabled','disabled');
        $(this).text("please wait...");
        console.log("closed ");
        
    });






    $("#tab_1_notes").click(function(){
        localStorage.setItem('last-selected-tab','tab_1_notes');
        
    });

    $("#tab_2_contracts").click(function(){
        localStorage.setItem('last-selected-tab','tab_2_contracts');
    });

    $("#tab_3_allowonces").click(function(){
        localStorage.setItem('last-selected-tab','tab_3_allowonces');
    });
    $("#tab_2_locations").click(function(){
        localStorage.setItem('last-selected-tab','tab_2_locations');
    });

    $("#open-locations-tab").click(function(e){
        e.preventDefault();
        $("#tab_2_locations").children('.nav-link').trigger('click');

    })
    

    $("#tab_4_documents").click(function(){
        localStorage.setItem('last-selected-tab','tab_4_documents');

    });

    

    // init last selected tab
    const idLastSelectedTab = localStorage.getItem('last-selected-tab');
    $("#"+idLastSelectedTab+"").children('.nav-link').trigger('click');


    $("#candidate-change-status").change(function(){
        const newState = this.checked;
        const idCondidate = $(this).attr('id-condidate')
        var url = '/EN/condidates/update_state/'+idCondidate;

        $.ajax({
			url: url,
		  }).done(function(data) {
			console.log(data);
		  });
    });


    $("#company-change-status").change(function(){
        const newState = this.checked;
        const idCompany = $(this).attr('id-company')
        var url = '/EN/Companies/update_state/'+idCompany;

        $.ajax({
			url: url,
		  }).done(function(data) {
			console.log(data);
		  });
    });

    




    var avatar = document.getElementById('avatar');
    var image = $("#image");
    var input = $("#cropper_image");
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var $alert = $('.alert');
    var $modal = $('#modal');
    var cropper;

    $('[data-toggle="tooltip"]').tooltip();

    input.on('change', function (e) {
      var files = e.target.files;
      var done = function (url) {
          console.log(url);
        input.value = '';
        image.attr('src',url);
        $alert.hide();
        $modal.modal('show');
      };
      var reader;
      var file;
      var url;

      if (files && files.length > 0) {
        file = files[0];

        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) {
          reader = new FileReader();
          reader.onload = function (e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    $modal.on('shown.bs.modal', function () {
        console.log();
      cropper = new Cropper(document.getElementById("image"), {
        aspectRatio: 1,
        viewMode: 3,
      });
    }).on('hidden.bs.modal', function () {
      cropper.destroy();
      cropper = null;
    });

    document.getElementById('crop').addEventListener('click', function () {
      var initialAvatarURL;
      var canvas;

      $modal.modal('hide');

      if (cropper) {
        canvas = cropper.getCroppedCanvas({
          width: 160,
          height: 160,
        });
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        $progress.show();
        $alert.removeClass('alert-success alert-warning');
        canvas.toBlob(function (blob) {


            let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
            let container = new DataTransfer();

            container.items.add(file);

            document.getElementById('cropper_image').files = container.files ;

            if ($("#cropper_image").attr('preview-real') == 'true') {
                $("#cropper_image").parent().submit();
            }

            
          /*var formData = new FormData();

          formData.append('avatar', blob, 'avatar.jpg');
          $.ajax('https://jsonplaceholder.typicode.com/posts', {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            xhr: function () {
              var xhr = new XMLHttpRequest();

              xhr.upload.onprogress = function (e) {
                var percent = '0';
                var percentage = '0%';

                if (e.lengthComputable) {
                  percent = Math.round((e.loaded / e.total) * 100);
                  percentage = percent + '%';
                  $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                }
              };

              return xhr;
            },

            success: function () {
              $alert.show().addClass('alert-success').text('Upload success');
            },

            error: function () {
              avatar.src = initialAvatarURL;
              $alert.show().addClass('alert-warning').text('Upload error');
            },

            complete: function () {
              $progress.hide();
            },
          });*/



        });
      }
    });




    $(".edit-form-location").submit(function(e){
        e.preventDefault();
        var values = $(this).serialize();

        console.log(values);

        const input = $(this).parent(".modal-content").children(".modal-body");
    })




});

