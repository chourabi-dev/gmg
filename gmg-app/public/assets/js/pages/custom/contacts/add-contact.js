"use strict";

// Class definition
var KTContactsAdd = function () {
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
					tel1: {
						validators: {
							notEmpty: {
								message: 'Telephone is required'
							}
						}
					},
					tel2: {
						validators: {
							
						}
					},
					pemail: {
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
					titleCompany: {
						validators: {
							notEmpty: {
								message: 'Title is required'
							}
						}
					},
					departmentCompany: {
						validators: {
							notEmpty: {
								message: 'Department is required'
							}
						}
					},
					agencyCompany: {
						validators: {
							notEmpty: {
								message: 'Agency is required'
							}
						}
					},
					
					
					banknameCompany: {
						validators: {
							notEmpty: {
								message: 'Bank name  is required'
							}
						}
					},
					bankaddressCompany: {
						validators: {
							notEmpty: {
								message: 'Bank address is required'
							}
						}
					},
					accountnumberCompany: {
						validators: {
							notEmpty: {
								message: 'Account number is required'
							}
						}
					},
					beneficiarynameCompany: {
						validators: {
							notEmpty: {
								message: 'Beneficiary name is required'
							}
						}
					}, 
					swiftcodeCompany: {
						validators: {
							notEmpty: {
								message: 'Swift code is required'
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
					emailSTaff: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
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
					isActiveStaff: {
						
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
		_avatar = new KTImageInput('kt_contact_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_contact_add');
			_formEl = KTUtil.getById('kt_contact_add_form');

			initWizard();
			initValidation();
			initAvatar();
		}
	};
}();

jQuery(document).ready(function () {
	KTContactsAdd.init();


	$("#submit-btn-add-staff").off().on("click", function(event) {
        event.stopPropagation();
        });
	$("#submit-btn-add-staff").click(function(){
		var v = $(this).text().trim();
		if (v === 'Submit') {
			$("#kt_contact_add_form").submit();
		}
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

	
});
