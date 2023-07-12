// Create a new FormData object
const formData = new FormData();
const formData2 = new FormData();
var File;
var id;
var handleChanged = false;

var table = $("#clientsTable").DataTable({
  ajax: {
    url: "../controller/getClientsJSON.php",
    dataSrc: "",
  },
  columns: [
    { data: "id" },
    { data: "business_name" },
    { data: "first_name" },
    { data: "last_name" },
    { data: "gender" },
    { data: "email" },
    { data: "phone" },
  ],
  dom: "Bfrtip",
  buttons: ["print", "csv", "colvis"],
});

//get the number of data
var dataLength = 0;

table.on("draw", function () {
  dataLength = table.rows().count();
  $(".table-data-rows").html(" | " + dataLength + " clients right now");
});

table.draw();

//fill the select box with genders data
$.ajax({
  url: "../controller/getGenderJSON.php",
  method: "GET",
  dataType: "json",
  success: function (response) {
    $.each(response, function (item) {
      var res = response[item];
      var option = $("<option>").val(res.id).text(res.name);
      $("select[name='gender']").append(option);
      $("select[id='show-gender']").append(option);
    });
  },
  error: function (xhr, status, error) {
    console.log("AJAX request error:", error);
  },
});

$("#showClient .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

$("#myModal .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

$(".box.add").click(function (e) {
  $("#fileInput").click();
});

$(".box.show-box").click(function (e) {
  $("#showFileInput").click();
});

$("#myModal").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  // You can place your logic here
  resetForm();
});

$("#add-client-button").on("click", function () {
  if (!validateInputs()) return;
  $(this).html('<i class="fas fa-spinner fa-spin"></i>');

  // Get the form element
  const form = $(".tab-content");

  // Append all form fields to the FormData object
  form.find(":input:not([type='file'])").each(function () {
    const field = $(this);

    // Append other inputs, selects, and textareas to the FormData object
    formData.append(field.attr("name"), field.val());
  });

  //Make the AJAX POST request
  $.ajax({
    url: "../controller/addClient.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "success") {
        resetForm();
        $("#myModal").modal("hide");
        table.ajax.reload();
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});

$("#clientsTable").on("click", "tbody tr", function () {
  // Get the clicked row data
  const rowData = table.row(this).data();

  // Get the value of the 'id' property
  id = rowData.id;

  $.ajax({
    url: "../controller/getClient.php",
    method: "GET",
    dataType: "json",
    data: { id },
    success: function (response) {
      var data = response[0];
      fillModalFields(
        data.business_name,
        data.last_name,
        data.first_name,
        data.email,
        data.phone,
        data.code_postale,
        data.Ville,
        data.Pays,
        data.address1,
        data.address2,
        "../static/images/" + data.image,
        data.gender
      );
    },
  });

  // Display the id in an alert
  $("#showClient").modal("show");
});

$("#showClient").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  // You can place your logic here
  handleChange();
  AttachChange();
  handleChanged = false;
  $("#update-client-button").addClass("disabled");
});

AttachChange();

$("#update-client-button").click(function () {
  if (!validateInputs2()) return;
  $(this).html('<i class="fas fa-spinner fa-spin"></i>');
  $("#update-client-button").toggleClass("disabled");

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
    url: "../controller/updateClient.php",
    method: "POST",
    data: formData2,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Client updated successfully.") {
        table.ajax.reload();
        $("#showClient").modal("hide");
        $("#update-client-button").removeClass("disabled");
        $("#update-client-button").html("Update");
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});

$("#show-image").click(function () {
  // Get the source of the preview image
  var src = $("#show-previewImage").attr("src");

  // Set the source of the image in the modal
  $("#imageModalLabel").attr("src", src);

  // Show the modal
  $("#imageModal").modal("show");
});

$("#imageModal").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  $("#showClient").modal("show");
});

/*functions*/
function AttachChange() {
  // Attach change event listeners to each input element
  $("#showClient input").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showClient textarea").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showClient select").on("change", handleChange);
}

// Function to handle the change event
function handleChange() {
  $("#update-client-button").toggleClass("disabled");

  // Attach change event listeners to each input element
  $("#showClient input").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showClient textarea").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showClient select").off("change", handleChange);

  handleChanged = true;
}

function allowDrop(event) {
  event.preventDefault();
}

function drop(event) {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  handleFile(file);
}

function drop2(event) {
  event.preventDefault();
  const file = event.dataTransfer.files[0];
  handleFile2(file);
}

function handleFileSelect(event) {
  const file = event.target.files[0];
  handleFile(file);
}
function handleFileSelect2(event) {
  const file = event.target.files[0];
  handleFile2(file);
}

function handleFile(file) {
  const reader = new FileReader();
  reader.onload = function (event) {
    const previewImage = document.getElementById("previewImage");
    previewImage.src = event.target.result;
    previewImage.style.display = "block";
    $(".delete-icon").css("display", "flex");
  };

  if (file) {
    $(".drop-text").css("display", "none");
    reader.readAsDataURL(file);
  } else {
    $(".drop-text").css("display", "block");
    $("#previewImage").attr("src", "").hide();
    $(".delete-icon").css("display", "none");
  }

  formData.append("image", file);
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

function deleteImage(event) {
  event.stopPropagation();
  const previewImage = document.getElementById("previewImage");
  previewImage.src = "#";
  previewImage.style.display = "none";
  $(".delete-icon").css("display", "none");
  $(".drop-text").css("display", "block");
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

function resetForm() {
  // Empty all inputs
  $("input[type='text']").val("");

  $("input#country").val("Maroc");

  // Remove the image source and hide it
  $("#previewImage").attr("src", "").hide();

  // Set display of .drop-text to "block"
  $(".drop-text").css("display", "block");

  // Select the first option in the select element
  $("select[id='gender']").prop("selectedIndex", 0);

  // Hide the delete icon
  $(".delete-icon").css("display", "none");

  $("#add-client-button").html("Add Client");
}

function validateInputs() {
  // Get the values of the required inputs
  const businessName = $("#businessName").val().trim();
  const lastName = $("#lastName").val().trim();
  const firstName = $("#firstName").val().trim();
  const gender = $("#gender").val();

  // Check if any of the required inputs are empty or the gender is "none"
  if (
    businessName === "" ||
    lastName === "" ||
    firstName === "" ||
    gender === "none"
  ) {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#myModal .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
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
    formMessage(message, "danger", $("#showClient .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

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
