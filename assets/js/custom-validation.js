$(document).ready(function () {
	$.validator.addMethod(
		"pwcheck",
		function (value, element) {
			if (!/[a-z]/.test(value)) {
				$(element).data(
					"error",
					"Password must contains atleast 1 small letter"
				);
				return false;
			}
			if (!/[A-Z]/.test(value)) {
				$(element).data(
					"error",
					"Password must contains atleast 1 capital letter"
				);
				return false;
			}
			if (!/\d/.test(value)) {
				$(element).data("error", "Password must contains atleast 1 number");
				return false;
			}
			if (!/([!,%,&,@,#,$,^,*,?,_,~])/.test(value)) {
				$(element).data(
					"error",
					"Password must contains atleast 1 special character"
				);
				return false;
			}
			$(element).data("error", "");
			return true;
		},
		function (params, element) {
			return $(element).data("error");
		}
	);

	$.validator.addMethod(
		"noSpace",
		function (value, element) {
			return value.indexOf(" ") < 0 && value != "";
		},
		"No space please and don't leave it empty"
	);

	$.validator.addMethod(
		"lettersonly",
		function (value, element) {
			return this.optional(element) || /^[a-zA-Z]+$/i.test(value);
		},
		"Letters and spaces only please"
	);

	$.validator.addMethod(
		"atlease_one",
		function (value, elem, param) {
			return $(".atlst_one:checkbox:checked").length > 0;
		},
		"You must select at least one."
	);

	$.validator.addClassRules({
		arrFld: {
			required: true,
			number: true,
			minlength: 1,
			maxlength: 1,
			min: 0,
			max: 9,
		},
	});
	$.validator.addClassRules({
		strArrFld: {
			required: true,
		},
	});
	$.validator.addClassRules({
		atlst_one: {
			atlease_one: true,
		},
	});
	$.validator.addMethod(
		"multiemail",
		function (value, element) {
			if (this.optional(element)) return true;
			var emails = value.split(",");
			// var emails = value.split(/[;,]+/);
			valid = true;
			for (var i in emails) {
				value = emails[i];
				valid =
					valid && $.validator.methods.email.call(this, $.trim(value), element);
			}
			return valid;
		},
		"Please enter all emails in valid format"
	);

	$("#frmSearch").validate({
		rules: {
			q: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});
	$("#frmChangePass").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			pswd: {
				required: true,
			},
			npswd: {
				required: true,
				pwcheck: true,
				minlength: 8,
			},
			cpswd: {
				required: true,
				pwcheck: true,
				minlength: 8,
				equalTo: "#npswd",
			},
		},
		messages: {
			npswd: {
				required: "This field is required.",
				minlength: "New password must be at least 8 characters.",
			},
			cpswd: {
				required: "This field is required.",
				equalTo: "Confirm password must be the as the password.",
			},
		},
	});

	$("#frmSignup").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			mem_fname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_lname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_email: {
				required: true,
				email: true,
			},
			mem_phone: {
				required: true,
			},
			password: {
				required: true,
				minlength: 8,
				pwcheck: true,
			},
			cpassword: {
				required: true,
				equalTo: "#password",
			},
			confirm: "required",
		},
		messages: {
			mem_fname: {
				required: "First name is required.",
				minlength: "First Name should contains atleast 2 letters.",
				maxlength: "First Name should not be greater than 20 letters.",
				noSpace: "First Name should contains only letters and avoid space.",
				lettersonly: "First Name should contains only letters.",
			},
			mem_lname: {
				required: "Last name is required.",
				minlength: "Last Name should contains atleast 2 letters.",
				maxlength: "Last Name should not be greater than 20 letters.",
				noSpace: "Last Name should contains only letters and avoid space.",
				lettersonly: "Last Name should contains only letters.",
			},
			email: {
				required: "Email is required.",
				email: "Please enter a valid email.",
			},
			mem_phone: {
				required: "Phone number is required.",
			},
			password: {
				required: "Password is required.",
				minlength: "Password must be at least 8 characters.",
			},
			cpassword: {
				required: "Confirm Password is required.",
				equalTo: "Confirm password must be the as the password.",
			},
			confirm: {
				required: "Please accept our terms and conditions.",
			},
		},
		errorPlacement: (error, element) => {
			if (element.attr("name") == "confirm") {
				error.appendTo($("#confirm-error"));
			} else {
				error.insertAfter(element);
			}
		},
	});

	$("#newsletterFrm").validate({
		errorElement: "div",
		rules: {
			email: {
				required: true,
				email: true,
			},
		},
		messages: {},
		errorPlacement: function (error, element) {},
	});

	$("#vendorProfileSettings").validate({
		errorElement: "div",
		rules: {
			mem_fname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_lname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_company_name: {
				required: true,
				minlength: 2,
			},
			mem_company_email: {
				required: true,
				email: true,
			},
			mem_company_phone: {
				required: true,
			},
			mem_company_order_email: {
				required: true,
				email: true,
			},
			mem_company_website: {
				required: true,
			},
			mem_company_trustpilot: {
				required: true,
			},
			mem_company_pickdrop: {
				required: true,
			},
			mem_company_walkin_facility: {
				required: true,
			},
			mem_business_country: {
				required: {
					depends: function (element) {
						return (
							$("select#mem_company_walkin_facility option")
								.filter(":selected")
								.val() == "yes"
						);
					},
				},
			},
			mem_business_state: {
				required: {
					depends: function (element) {
						return (
							$("select#mem_company_walkin_facility option")
								.filter(":selected")
								.val() == "yes"
						);
					},
				},
			},
			mem_business_city: {
				required: {
					depends: function (element) {
						return (
							$("select#mem_company_walkin_facility option")
								.filter(":selected")
								.val() == "yes"
						);
					},
				},
			},
			mem_business_zip: {
				required: {
					depends: function (element) {
						return (
							$("select#mem_company_walkin_facility option")
								.filter(":selected")
								.val() == "yes"
						);
					},
				},
			},
			mem_business_address: {
				required: {
					depends: function (element) {
						return (
							$("select#mem_company_walkin_facility option")
								.filter(":selected")
								.val() == "yes"
						);
					},
				},
			},
			pickup_zip: {
				required: true,
			},
			mon_opening: {
				required: {
					depends: function (element) {
						element = $(element);
						let mon_closing = $("select#mon_closing option")
							.filter(":selected")
							.val();
						if (mon_closing != "") {
							return true;
						}
					},
				},
			},
			mon_closing: {
				required: {
					depends: function (element) {
						element = $(element);
						let mon_opening = $("select#mon_opening option")
							.filter(":selected")
							.val();
						if (mon_opening != "") {
							return true;
						}
					},
				},
			},
			tue_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#tue_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			tue_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#tue_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			wed_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#wed_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			wed_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#wed_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			thu_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#thu_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			thu_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#thu_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			fri_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#fri_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			fri_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#fri_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			sat_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#sat_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			sat_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#sat_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			sun_opening: {
				required: {
					depends: function (element) {
						return (
							$("select#sun_closing option").filter(":selected").val() != ""
						);
					},
				},
			},
			sun_closing: {
				required: {
					depends: function (element) {
						return (
							$("select#sun_opening option").filter(":selected").val() != ""
						);
					},
				},
			},
			mem_charges_per_miles: {
				required: true,
			},
			mem_charges_free_over: {
				required: true,
			},
			mem_charges_min_order: {
				required: true,
			},
		},
		messages: {
			mem_fname: {
				minlength: "First Name should contains atleast 2 letters.",
				maxlength: "First Name should not be greater than 20 letters.",
				noSpace: "First Name should contains only letters and avoid space.",
				lettersonly: "First Name should contains only letters.",
			},
			mem_lname: {
				minlength: "Last Name should contains atleast 2 letters.",
				maxlength: "Last Name should not be greater than 20 letters.",
				noSpace: "Last Name should contains only letters and avoid space.",
				lettersonly: "Last Name should contains only letters.",
			},
		},
		errorPlacement: function (error, element) {
			if (
				$.inArray(element.attr("id"), ["mem_fname", "mem_lname"]) !== -1 &&
				error.text() != "This field is required."
			) {
				error.addClass("alert alert-danger alert-sm");
				error.appendTo(
					element.parents("form").find("div.alertMsg:first").show()
				);
				$("html, body").animate(
					{
						scrollTop:
							element.parents("form").find("div.alertMsg:first").offset().top -
							300,
					},
					"slow"
				);
			}
			return false;
		},
	});

	$("#buyerProfileSettings").validate({
		errorElement: "div",
		rules: {
			mem_fname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_lname: {
				required: true,
				minlength: 2,
				maxlength: 20,
				noSpace: true,
				lettersonly: true,
			},
			mem_phone: {
				required: true,
			},
			mem_dob: {
				required: true,
			},
			mem_sex: {
				required: true,
			},
			mem_country: {
				required: true,
			},
			mem_state: {
				required: true,
			},
			mem_city: {
				required: true,
			},
			mem_zip: {
				required: true,
			},
			mem_address: {
				required: true,
			},
		},
		messages: {
			mem_fname: {
				minlength: "First Name should contains atleast 2 letters.",
				maxlength: "First Name should not be greater than 20 letters.",
				noSpace: "First Name should contains only letters and avoid space.",
				lettersonly: "First Name should contains only letters.",
			},
			mem_lname: {
				minlength: "Last Name should contains atleast 2 letters.",
				maxlength: "Last Name should not be greater than 20 letters.",
				noSpace: "Last Name should contains only letters and avoid space.",
				lettersonly: "Last Name should contains only letters.",
			},
		},
		errorPlacement: function (error, element) {
			if (
				$.inArray(element.attr("id"), ["mem_fname", "mem_lname"]) !== -1 &&
				error.text() != "This field is required."
			) {
				error.addClass("alert alert-danger alert-sm");
				error.appendTo(
					element.parents("form").find("div.alertMsg:first").show()
				);
				$("html, body").animate(
					{
						scrollTop:
							element.parents("form").find("div.alertMsg:first").offset().top -
							300,
					},
					"slow"
				);
			}
			return false;
		},
	});

	$("#changePassword").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			pswd: {
				required: true,
			},
			npswd: {
				required: true,
				minlength: 8,
				pwcheck: true,
			},
			cpswd: {
				required: true,
				minlength: 8,
				pwcheck: true,
				equalTo: "#npswd",
			},
		},
		messages: {
			pswd: {
				required: "Current password is required.",
			},
			npswd: {
				required: "New password is required.",
				minlength: "Password must be at least 8 characters.",
			},
			cpswd: {
				required: "New confirm password is required.",
				equalTo: "Confirm password must be the same as the password!",
			},
		},
	});

	$("#vendorBankAccount").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			bank_name: {
				required: true,
			},
			account_number: {
				required: true,
			},
			short_code: {
				required: true,
			},
			beneficiary_name: {
				required: true,
			},
		},
		messages: {},
	});

	$("#frmAmendInvoice").validate({
		errorElement: "div",
		rules: {
			sub_service_name: {
				required: true,
			},
			quantity: {
				required: true,
			},
			sub_service_price: {
				required: true,
			},
		},
		messages: {},
		errorPlacement: function (error, element) {
			if (
				$.inArray(element.attr("id"), [
					"sub_service_name",
					"quantity",
					"sub_service_price",
				]) !== -1 &&
				error.text() != "This field is required."
			) {
				error.addClass("alert alert-danger alert-sm");
				error.appendTo(
					element.parents("form").find("div.alertMsg:first").show()
				);
				$("html, body").animate(
					{
						scrollTop:
							element.parents("form").find("div.alertMsg:first").offset().top -
							300,
					},
					"slow"
				);
			}
			return false;
		},
	});

	$("#acceptDeliveryAndRating").validate({
		errorElement: "div",
		rules: {
			review_comment: {
				required: true,
			},
		},
		messages: {},
		errorPlacement: function (error, element) {
			if (
				$.inArray(element.attr("id"), ["review_comment"]) !== -1 &&
				error.text() != "This field is required."
			) {
				error.addClass("alert alert-danger alert-sm");
				error.appendTo(
					element.parents("form").find("div.alertMsg:first").show()
				);
				$("html, body").animate(
					{
						scrollTop:
							element.parents("form").find("div.alertMsg:first").offset().top -
							300,
					},
					"slow"
				);
			}
			return false;
		},
	});

	$("#frmSignin").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			email: {
				required: true,
				email: true,
			},
			password: {
				required: true,
			},
		},
		messages: {
			email: {
				required: "Email is required.",
				email: "Please enter a valid email address.",
			},
			password: {
				required: "Password is required.",
			},
		},
	});

	$("#frmForgot").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmZipSearch").validate({
		rules: {
			zip: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmReset").validate({
		errorElement: "span",
		errorClass: "validation-error",
		rules: {
			pswd: {
				required: true,
				minlength: 8,
				pwcheck: true,
			},
			cpswd: {
				required: true,
				minlength: 8,
				pwcheck: true,
				equalTo: "#password",
			},
		},
		messages: {
			pswd: {
				required: "Password is required.",
				minlength: "Password must be at least 8 characters.",
			},
			cpswd: {
				required: "Confirm passowrd is required.",
				equalTo: "Confirm password must be the same as the password.",
			},
		},
	});
	$("#frmSetting").validate({
		rules: {
			profile_bio: {
				required: true,
			},
			fname: {
				required: true,
			},
			lname: {
				required: true,
			},
			phone: {
				required: true,
				valid_phone: true,
				/*phoneUS: true,
                digits: true,
                maxlength: 10*/
			},
			email: {
				required: true,
				email: true,
			},
			country: {
				required: true,
				// number: true
			},
			city: {
				required: true,
			},
			zip: {
				required: true,
			},
			address: {
				required: true,
			},
			profile_heading: {
				required: true,
			},
			fb_link: {
				url: true,
			},
			instagram_link: {
				url: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmAdditionalSubjects").validate({
		rules: {
			subject: {
				required: true,
				number: true,
			},
			"subjects[]": {
				atlease_one: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmAdditionalInfo").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			hourly_rate: {
				required: true,
				number: true,
				min: 20,
				max: 150,
			},
			school_name: {
				required: true,
			},
			major_subject: {
				required: true,
			},
			graduation_year: {
				required: true,
				number: true,
				min: 1900,
			},
			travel_radius: {
				required: true,
				number: true,
				min: 0,
			},
			zip: {
				required: true,
			},
			address: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmContact").validate({
		rules: {
			name: {
				required: true,
				minlength: 2,
				maxlength: 30,
			},
			phone: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			subject: {
				required: true,
			},
			msg: {
				required: true,
			},
		},
		messages: {
			name: {
				minlength: "Name should contains atleast 2 letters.",
				maxlength: "Name should not be greater than 30 letters.",
			},
		},
		errorPlacement: function (error, element) {
			if (
				$.inArray(element.attr("id"), [
					"msg",
					"name",
					"phone",
					"email",
					"subject",
				]) !== -1 &&
				error.text() != "This field is required."
			) {
				error.addClass("alert alert-danger alert-sm");
				error.appendTo(
					element.parents("form").find("div.alertMsg:first").show()
				);
				$("html, body").animate(
					{
						scrollTop:
							element.parents("form").find("div.alertMsg:first").offset().top -
							300,
					},
					"slow"
				);
			}
			return false;
		},
	});

	$("#frmNewsletter").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});
	/*$('#frmRpt').validate({
            rules: {
                reason: {
                    required: true,
                }
            },
            errorPlacement: function(){
                return false;  // suppresses error message text
            }
        })*/
	$("#frmNt").validate({
		rules: {
			title: {
				required: true,
			},
			detail: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmPhone").validate({
		rules: {
			phone: {
				required: true,
				valid_phone: true,
				// phoneUS: true,
				// digits: true,
				// maxlength: 10
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmPhonevld").validate({
		errorPlacement: function () {
			return false;
		},
	});
	/*$("#frmPhonevld").validate({
        ignore: [],
        rules: {
            'code[]': {
                required: true,
                number: true,
                minlength: 1,
                maxlength: 1,
                min: 0,
                max: 9
            }
        },
        errorPlacement: function(){
            return false;  // suppresses error message text
        }
    });*/

	$("#frmChangeEmail").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
		},
		errorPlacement: function () {
			return false; // suppresses error message text
		},
	});

	$("#frmCreditCard").validate({
		rules: {
			card_holder_name: {
				required: true,
			},
			cardnumber: {
				required: true,
				// number: true,
				maxlength: 19,
			},
			exp_month: {
				required: true,
			},
			exp_year: {
				required: true,
			},
			cvc: {
				required: true,
				maxlength: 4,
			},
		},
		errorPlacement: function () {
			return false;
		},
	});

	$("#frmBnkAct").validate({
		rules: {
			swift_code: {
				required: true,
				number: true,
			},
			routing_number: {
				required: true,
				number: true,
			},
			bank_name: {
				required: true,
			},
			account_title: {
				required: true,
			},
			account_number: {
				required: true,
				number: true,
			},
			city: {
				required: true,
			},
			state: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false;
		},
	});

	/*--------------Contact Page -------------- */
});
