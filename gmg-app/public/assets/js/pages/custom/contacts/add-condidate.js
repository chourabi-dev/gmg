"use strict";

// Class definition
var KTCondidatesAdd = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			// Don't go to the next step yet
			_wizard.stop();

			// Validate form
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
			validator.validate().then(function (status) {
				if (status == 'Valid') {
					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Change Event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					profile_avatar:{
						validators: {
							notEmpty: {
								message: 'Photo is required'
							}
						}
					},
					Gender:{
						validators: {
							notEmpty: {
								message: 'Gender is required'
							}
						}
					},
					firstname: {
						validators: {
							notEmpty: {
								message: 'First Name is required'
							}
						}
					},
					lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					dob: {
						validators: {
							notEmpty: {
								message: 'Date of birth is required'
							}
						}
					},
					nationality: {
						validators: {
							notEmpty: {
								message: 'Nationality is required'
							}
						}
					},
					FST: {
						validators: {
							notEmpty: {
								message: 'Family status is required'
							}
						}
					},
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
					address1: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					address2: {
						validators: {
							
						}
					},
					tel: {
						validators: {
							notEmpty: {
								message: 'Telephone is required'
							}
						}
					},
					extension: {
						validators: {
							
						}
					},
					
					email: {
						validators: {
							
							notEmpty: {
								message: 'Email is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
					zipcode: {
						validators: {
							notEmpty: {
								message: 'ZipCode is required'
							}
						}
					},
					city: {
						validators: {
							notEmpty: {
								message: 'City is required'
							}
						}
					},
					state: {
						validators: {
							notEmpty: {
								message: 'State is required'
							}
						}
					},
					country: {
						validators: {
							notEmpty: {
								message: 'Country is required'
							}
						}
					},
					phoneType: {
						validators: {
							notEmpty: {
								message: 'Phone type is required'
							}
						}
					},
					emailType: {
						validators: {
							notEmpty: {
								message: 'Email type is required'
							}
						}
					},
					socialMediaType: {
						validators: {
							notEmpty: {
								message: 'Social Media type is required'
							}
						}
					},
					socialurl: {
						validators: {
							notEmpty: {
								message: 'Social Media url is required'
							}
						}
					},
					
					
					
					
					
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));


		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					skill: {
						validators: {
							notEmpty: {
								message: 'Skill is required'
							}
						}
					},
					subskill: {
						validators: {
							notEmpty: {
								message: 'Sub skill is required'
							}
						}
					},
					orderskill: {
						validators: {
							notEmpty: {
								message: 'Order is required'
							}
						}
					},
					language: {
						validators: {
							notEmpty: {
								message: 'Language is required'
							}
						}
					},
					levelLng:{
						validators: {
							notEmpty: {
								message: 'Level is required'
							}
						}
					},
					orderslanguage: {
						validators: {
							notEmpty: {
								message: 'Order is required'
							}
						}
					},
					otherExperience:{
						validators: {
							
						}
					},
					

					
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 6
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					receiptFile: {
						validators: {
							notEmpty: {
								message: 'Receipt is required'
							}
						}
					},
					paymentMode: {
						validators: {
							notEmpty: {
								message: 'Mode is required'
							}
						}
					},
					datePayment: {
						validators: {
							notEmpty: {
								message: 'Date is required'
							}
						}
					},
					packType: {
						validators: {
							notEmpty: {
								message: 'Pack is required'
							}
						}
					}
					
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 6
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					stuffTypeSTaff: {
						validators: {
							notEmpty: {
								message: 'Staff type is required'
							}
						}
					},
					usernameSTaff: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							}
						}
					},
					passwordSTaff: {
						validators: {
							notEmpty: {
								message: 'Password  is required'
							}
						}
					},
					
					noteSTaff: {
						validators: {
							notEmpty: {
								message: 'Note is required'
							}
						}
					},
					reffBy: {
						validators: {
							
						}
					},
					applicationFile: {
						validators: {
							
						}
					},
					agencyCompany: {
						validators: {
							notEmpty: {
								message: 'Agency is required'
							}
						}
					},
					sourceType: {
						validators: {
							notEmpty: {
								message: 'Source type is required'
							}
						}
					},
					
					
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
		
		
	}

	var initAvatar = function () {
		_avatar = new KTImageInput('kt_condidate_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_condidate_add');
			_formEl = KTUtil.getById('kt_condidate_add_form');

			initWizard();
			initValidation();
			initAvatar();
		}
	};
}();



// Class definition
var KTFormRepeater = function() {

    // Private functions
    var demo1 = function() {
        $('.kt_repeater_1').repeater({
            
             
            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {                
                $(this).slideUp(deleteElement);                 
            }   
        });
    }



    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();




jQuery(document).ready(function () {
	KTCondidatesAdd.init();
	KTFormRepeater.init();

	$("#submit-btn-add-condidate").off().on("click", function(event) {
        event.stopPropagation();
        });
	$("#submit-btn-add-condidate").click(function(){
		var v = $(this).text().trim();
		if (v === 'Submit') {
			


			$("[name]").each(function(){
				if ($(this).attr('name').indexOf("[") != -1) {
					var oldName = $(this).attr('name');
					var newName =oldName.substr(4,(oldName.length-5))+'['+oldName.substr(1,(oldName.indexOf(']')-1))+']';

					$(this).attr('name',newName);

				}
			});

			//console.log( $("#kt_condidate_add_form").serializeArray() );
			$("#kt_condidate_add_form").submit();
		}
	});


	$('#add-another-sub-skill').click(function(e) {
		//KTCondidatesAdd.init();
		$(".skill-change").change(function(e){
		
			var skillID = $(this).val();
			var url = '/EN/condidates/get-subskill/'+skillID;
			var target = $(this).parent().parent().parent().children(".sub-skill-child").children(".subskill").children("select");
			$.ajax({
				url: url,
			  }).done(function(data) {
				console.log(data);
				
				var bloc = '<option value="">Please choose a value</option>';
				data.forEach(s => {
					bloc+='<option value="'+s.id+'">'+s.sub_skill+'</option>';
				});
				
				console.log(target);
				target.html(bloc);
				target.slideDown();
			  });
		});
		
	})


	$(".skill-change").change(function(e){
		
		var skillID = $(this).val();
		var url = '/EN/condidates/get-subskill/'+skillID;
		var target = $(this).parent().parent().parent().children(".sub-skill-child").children(".subskill").children("select");
		$.ajax({
			url: url,
		  }).done(function(data) {
			console.log(data);
			
			var bloc = '<option value="">Please choose a value</option>';
			data.forEach(s => {
				bloc+='<option value="'+s.id+'">'+s.sub_skill+'</option>';
			});
			
			console.log(target);
			target.html(bloc)
			target.slideDown();
		  });
	});


	$("#new-phone-bloc-btn").click(function(){
		var inputTel1 = $(".phone-repeater").intlTelInput({
			preferredCountries: ["tn" ],
			separateDialCode:true,
			nationalMode:false,
			formatOnDisplay:true,
	
		})
		$(".phone-repeater").on("countrychange",function(v) {
			console.log(v);
			var code = $(this).parent().children('.iti__flag-container').children('.iti__selected-flag').children('.iti__selected-dial-code').html();
	
			console.log(code);
			$(this).parent().parent().children(".phone-repeater-code").val(code)
		});
	});


	$("#add-another-location-btn").click(function(){
		$(".country-selector").countrySelect({
			defaultCountry:"tn"
		});
	
	});



	// the phone extension hide and show
	$(".the-phone-select-type").change(function(){
		const value = $(this).val();
		if (value == '1') {
			$(this).parent().parent().parent().children(".the-extenstion-select").slideDown();
		}else{
			$(this).parent().parent().parent().children(".the-extenstion-select").slideUp();
		}
	});


	$("#new-phone-bloc-btn").click(function(){
		$(".the-phone-select-type").change(function(){
			const value = $(this).val();
			if (value == '1') {
				$(this).parent().parent().parent().children(".the-extenstion-select").slideDown();
			}else{
				$(this).parent().parent().parent().children(".the-extenstion-select").slideUp();
			}
		});
	})
	
});
