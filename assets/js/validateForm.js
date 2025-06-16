$(document).ready(function () {

  $.validator.addMethod(
    "noSpecialCharsExceptSingleQuote",
    function (value, element) {
      return this.optional(element) || /^[a-zA-Z\s']*$/.test(value)  && !/''/.test(value);
    },
    "Special characters/numbers are not allowed"
  );

  $.validator.addMethod(
    "auPhoneNumber",
    function (value, element) {
      let numberWithoutFormatting = value.replace(/[\s\-\(\)]/g, "");

      return this.optional(element) ||
        /^(0[2-9]\d{8})$/.test(numberWithoutFormatting) || // Mobile and landline 0x xxxx xxxx
        /^(1[8|3]0\d{7})$/.test(numberWithoutFormatting); // FreeCall and local rate (180, 130)
    },
    "Please enter a valid Australian phone number"
  );

  $.validator.addMethod(
    "validEmail",
    function (value, element) {
      return this.optional(element) ||
        /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value);
    },
    "Please enter a valid email address"
  );

  $.validator.addMethod(
    "validCardNumber",
    function (value, element) {
      return this.optional(element) || /^\d+$/.test(value);
    },
    "Credit card number must contain numbers only"
  );

  $.validator.addMethod("cardNotExpired", function (value, element, params) {
    const month = parseInt($("#expiryMonth").val(), 10);
    const year = parseInt($("#expiryYear").val(), 10);

    if (!month || !year) return true;

    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();

    if (year === currentYear && month === currentMonth + 1) {
      return false;
    }

    return (year > currentYear) || (year === currentYear && month > currentMonth + 1);
  }, "Card has expired");


  $("form.needs-validation").each(function () {
    const $form = $(this);

    $form.validate({
      rules: {
        firstName: {
          required: true,
          noSpecialCharsExceptSingleQuote: true,
          minlength: 2
        },
        lastName: {
          required: true,
          noSpecialCharsExceptSingleQuote: true,
          minlength: 2
        },
        contactNumber: {
          auPhoneNumber: true
        },
        emailAddress: {
          required: true,
          validEmail: true,
          email: true
        },
        streetAddress: "required",
        suburb: "required",
        postcode: {
          required: true,
          digits: true,
          minlength: 4,
          maxlength: 4
        },
        state: {
          required: true
        },
        cardName: {
          required: true,
          noSpecialCharsExceptSingleQuote: true,
          minlength: 2
        },
        cardNumber: {
          required: true,
          validCardNumber: true
        },
        expiryMonth: {
          required: true,
          cardNotExpired: true
        },
        expiryYear: {
          required: true,
          cardNotExpired: true
        }
      },
      messages: {
        firstName: {
          required: "Please enter your first name",
          minlength: "First name must be at least 2 characters long"
        },
        lastName: {
          required: "Please enter your last name",
          minlength: "Last name must be at least 2 characters long"
        },
        emailAddress: {
          required: "Please enter your email",
          email: "Please enter a valid email address"
        },
        streetAddress: "Street address is required",
        suburb: "Suburb is required",
        postcode: {
          required: "Postcode is required",
          digits: "Postcode must be digits only",
          minlength: "Postcode must be 4 digits",
          maxlength: "Postcode must be 4 digits"
        },
        state: "Please select a state"
      },
      errorPlacement: function (error, element) {
        error.insertAfter(element);
      },
      submitHandler: function (form, event) {
        form.submit();
      }
    });
  });




});
