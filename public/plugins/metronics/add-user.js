"use strict";

// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _avatar;
    var _top_submit;
    var _block_1;
    var _block_2;
    var _block_3;
	var _validations = [];

	// Private Functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						wizard.goTo(wizard.getNewStep());
						if(wizard.isLastStep()) {
                            _top_submit.disabled = false;
                            var formData = new FormData(_formEl);
                            _block_1.innerHTML = formData.get('first_name') + ' ' + formData.get('last_name') + '<br />Phone: ' + formData.get('phone') + '<br />Email: ' + formData.get('email');
                            _block_2.innerHTML = 'Language: ' + formData.get('language') + '<br />Time Zone: ' + formData.get('time_zone') + '<br />Communication Via Email: ' + formData.get('comm_email') + '<br />Communication Via Phone: ' + formData.get('comm_phone') + '<br />Role: ' + formData.get('role_id');
                            _block_3.innerHTML = formData.get('address_line1') + '<br />' + formData.get('address_line2') + '<br />' + formData.get('city') + '<br />' + formData.get('state') + '<br />' + formData.get('country');
                        } else {
                            _top_submit.disabled = true;
                        }
						KTUtil.scrollTop();
					} else {
						// rola changes from swal.fire to swal
						// Swal.fire({
						// 	text: "Sorry, looks like there are some errors detected, please try again.",
						// 	icon: "error",
						// 	buttonsStyling: false,
						// 	confirmButtonText: "Ok, got it!",
						// 	customClass: {
						// 		confirmButton: "btn font-weight-bold btn-light"
						// 	}
						// }).then(function () {
						// 	KTUtil.scrollTop();
						// });

						// rola check 
						swal({
							
                            // آسف يبدو أن هناك بعض الأخطاء المكتشفة يرجى المحاولة مرة أخر
	                        text: "Sorry, looks like there are some errors detected, please try again.",
	                        icon: 'error',
	                        buttonsStyling: false,  //swal alert doesnt have buttonStyling
	                        confirmButtonText:  "Ok, got it!",
	                        customClass: {
	                      	confirmButton: "btn font-weight-bold btn-light"
	                       }
	                       }).then(function () {
			             	KTUtil.scrollTop();
			            });
						
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
            _top_submit.disabled = false;
			// Swal.fire({
			// 	text: "All is good! Please confirm the form submission.",
			// 	icon: "success",
			// 	showCancelButton: true,
			// 	buttonsStyling: false,
			// 	confirmButtonText: "Yes, submit!",
			// 	cancelButtonText: "No, cancel",
			// 	customClass: {
			// 		confirmButton: "btn font-weight-bold btn-primary",
			// 		cancelButton: "btn font-weight-bold btn-default"
			// 	}
			// }).then(function (result) {
			// 	if (result.value) {
            //         _formEl.submit(); // Submit form
			// 	} else if (result.dismiss === 'cancel') {
			// 		Swal.fire({
			// 			text: "Your form has not been submitted!.",
			// 			icon: "error",
			// 			buttonsStyling: false,
			// 			confirmButtonText: "Ok, got it!",
			// 			customClass: {
			// 				confirmButton: "btn font-weight-bold btn-primary",
			// 			}
			// 		});
			// 	}
			// });

			//rola  changed from Swal.    fire to swal & added transaltion
			swal({
				//كل شيء جيد يرجى تأكيد تقديم النموذج 
				text: "All is good! Please confirm the form submission.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Yes, submit!",
				cancelButtonText: "No, cancel",
				customClass: {
					confirmButton: "btn font-weight-bold btn-primary",
					cancelButton: "btn font-weight-bold btn-default"
				}
			}).then(function (result) {
				if (result.value) {
                    _formEl.submit(); // Submit form
				} else if (result.dismiss === 'cancel') {
					swal({
						///لم يتم إرسال النموذج الخاص بك
						text: "Your form has not been submitted!.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-primary",
						}
					});
				}
			});
		});
	}

	var _initValidations = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Validation Rules For Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					first_name: {
						validators: {
							notEmpty: {
								message: 'First Name is required'
							}
						}
					},
					last_name: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					company: {
						validators: {
							notEmpty: {
								message: 'Company Name is required'
							}
						}
					},
					phone: {
						validators: {
							notEmpty: {
								message: 'Phone is required'
							},
							phone: {
								country: 'US',
								message: 'The value is not a valid phone number. (e.g 5554443333)'
							}
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
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            },
                            password: {
                                message: 'The value is not a valid password'
                            }
                        }
                    },
					website: {
						validators: {
							notEmpty: {
								message: 'Website URL is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
					comm_method: {
						validators: {
							choice: {
								min: 1,
								message: 'Please select at least 1 option'
							}
						}
					},
					language: {
						validators: {
							notEmpty: {
								message: 'Please select a language'
							}
						}
					},
					timezone: {
						validators: {
							notEmpty: {
								message: 'Please select a timezone'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
                    address_line1: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
					post_code: {
						validators: {
							notEmpty: {
								message: 'Postcode is required'
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
								message: 'state is required'
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
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
	}

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_user_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');
            _top_submit = KTUtil.getById('top_submit');

            _block_1 = KTUtil.getById('block_1');
            _block_2 = KTUtil.getById('block_2');
            _block_3 = KTUtil.getById('block_3');

			_initWizard();
			_initValidations();
			_initAvatar();
            _top_submit.disabled = true;
		}
	};
}();

jQuery(document).ready(function () {
	KTAddUser.init();
});
