//************** this is for update supplier ********************************//
var id;
var handleChanged = false;
var formData2 = new FormData();

//let the change event for the inputs of the show modal
AttachChange();

$("#show-image").click(function () {
  // Get the source of the preview image
  var src = $("#show-previewImage").attr("src");

  // Set the source of the image in the modal
  $("#imageModalLabel").attr("src", src);

  // Show the modal
  $("#imageModal").modal("show");
});

$("#suppliersTable").on("click", "tbody tr", function () {
  // Get the clicked row data
  const rowData = table.row(this).data();

  // Get the value of the 'id' property
  id = rowData.id;

  $.ajax({
    url: "../controller/getSupplier.php",
    method: "GET",
    dataType: "json",
    data: { id },
    success: function (response) {
      var data = response[0];
      fillModalFields(
        data.business_name,
        data.nom,
        data.prenom,
        data.email,
        data.phone,
        data.code_postale,
        data.Ville,
        data.Pays,
        data.address,
        data.adress2,
        "../static/images/" + data.image,
        data.gender
      );
    },
    errors: (err) => {
      console.log("errors: " + err);
    },
  });

  // Display the id in an alert
  $("#showSupplier").modal("show");
});

$("#showSupplier .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

function fillModalFields(
  businessName,
  lastName,
  firstName,
  email,
  phone,
  codePostal,
  city,
  country,
  address1,
  address2,
  imageSrc,
  gender
) {
  // Fill input fields
  $("#show-businessName").val(businessName);
  $("#show-lastName").val(lastName);
  $("#show-firstName").val(firstName);
  $("#show-email").val(email);
  $("#show-phone").val(phone);
  $("#show-codePostal").val(codePostal);
  $("#show-city").val(city);
  $("#show-country").val(country);
  $("#show-adress1").val(address1);
  $("#show-adress2").val(address2);

  // Set image source
  $("#show-previewImage").attr("src", imageSrc);
  $("#show-previewImage").css("display", "block");
  $(".delete-icon.show").css("display", "flex");

  // Set selected option in select element
  $("#show-gender").val(gender);
}

$("#showSupplier").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  // You can place your logic here
  handleChange();
  AttachChange();
  handleChanged = false;
  $("#update-supplier-button").addClass("disabled");
});

$("#update-supplier-button").click(function () {
  if (!validateInputs2()) return;
  $(this).html('<i class="fas fa-spinner fa-spin"></i>');
  $("#update-supplier-button").toggleClass("disabled");

  // Get the form element
  const form = $(".tab-content.show");

  // Append all form fields to the FormData object
  form.find(":input:not([type='file'])").each(function () {
    const field = $(this);

    // Append other inputs, selects, and textareas to the FormData object
    formData2.append(field.attr("name"), field.val());
  });

  formData2.append("id", id);

  //Make the AJAX POST request
  $.ajax({
    url: "../controller/updateSupplier.php",
    method: "POST",
    data: formData2,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Supplier updated successfully.") {
        table.ajax.reload();
        $("#showSupplier").modal("hide");
        $("#update-supplier-button").removeClass("disabled");
        $("#update-supplier-button").html("Update");
      } else {
        formMessage(response, "danger", $("#showSupplier .modal-body"));
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});

//show the image event
$("#show-image").click(function () {
  // Get the source of the preview image
  var src = $("#show-previewImage").attr("src");

  // Set the source of the image in the modal
  $("#imageModalLabel").attr("src", src);

  // Show the modal
  $("#imageModal").modal("show");
});

//trigger the image selector
$(".box.show-box").click(function (e) {
  $("#showFileInput").click();
});

/*functions*/
function AttachChange() {
  // Attach change event listeners to each input element
  $("#showSupplier input").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSupplier textarea").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSupplier select").on("change", handleChange);
}

// Function to handle the change event
function handleChange() {
  $("#update-supplier-button").toggleClass("disabled");

  // Attach change event listeners to each input element
  $("#showSupplier input").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSupplier textarea").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showSupplier select").off("change", handleChange);

  handleChanged = true;
}

function drop2(event) {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  handleFile2(file);
}

function handleFileSelect2(event) {
  const file = event.target.files[0];
  handleFile2(file);
}

function handleFile2(file) {
  const reader = new FileReader();
  reader.onload = function (event) {
    const previewImage = document.getElementById("show-previewImage");
    previewImage.src = event.target.result;
    previewImage.style.display = "block";
    $(".delete-icon.show").css("display", "flex");
  };

  formData2.append("image", file);

  if (file) {
    $(".show-drop-text").css("display", "none");
    reader.readAsDataURL(file);
  } else {
    $(".show-drop-text").css("display", "block");
    $("#show-previewImage").attr("src", "").hide();
    $(".delete-icon.show").css("display", "none");
  }

  if (handleChanged == false) {
    handleChange();
    handleChanged = true;
  }
}

function validateInputs2() {
  // Get the values of the required inputs
  const businessName = $("#show-businessName").val().trim();
  const lastName = $("#show-lastName").val().trim();
  const firstName = $("#show-firstName").val().trim();
  const gender = $("#show-gender").val();

  // Check if any of the required inputs are empty or the gender is "none"
  if (
    businessName === "" ||
    lastName === "" ||
    firstName === "" ||
    gender === "none"
  ) {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#showSupplier .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

function deleteImage2(event) {
  event.stopPropagation();
  const previewImage = document.getElementById("show-previewImage");
  previewImage.src = "#";
  previewImage.style.display = "none";
  $(".delete-icon.show").css("display", "none");
  $(".show-drop-text").css("display", "block");
  if (handleChanged == false) {
    handleChange();
    handleChanged = true;
  }
  formData2.append("imageRemoved", "true");
}
