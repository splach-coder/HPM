var formData2 = new FormData();
var id;
var handleChanged = false;

//let the change event for the inputs of the show modal
AttachChange();

/********************* the show data states */
$("#productsTable").on("click", "tbody tr", function () {
  // Get the clicked row data
  const rowData = table.row(this).data();

  // Get the value of the 'id' property
  id = rowData.id;

  $.ajax({
    url: "../controller/getProduct.php",
    method: "GET",
    dataType: "json",
    data: { id },
    success: function (response) {
      var data = response[0];
      fillModalFields(
        data.name,
        data.family_id,
        data.unit,
        data.activity,
        data.purchase_price,
        data.gross_margin,
        data.gorss_margin_100,
        data.selling_price,
        data.stock,
        data.supplier,
        data.description,
        data.Note,
        data.images
      );
    },
    errors: (err) => {
      console.log("errors: " + err);
    },
  });

  // Display the id in an alert
  $("#showProduct").modal("show");
});

$("#showProduct .nav .nav-link").click(function (e) {
  e.preventDefault();
  $(this).tab("show");
});

$("#showProduct").on("hidden.bs.modal", function () {
  // Code to execute when the modal has finished being hidden
  resetShowForm();
  handleChange();
  AttachChange();
  handleChanged = false;
  $("#update-product-button").addClass("disabled");
});

function fillModalFields(
  nom,
  family,
  unit,
  activity,
  prix,
  margeHT,
  marge100,
  prixVente,
  stock,
  supplier,
  desc,
  note,
  images
) {
  // Fill input fields
  $("#Show-produitNom").val(nom);
  $("#Show-category").val(family);
  $("#Show-unit").val(unit);
  $("#Show-activite").val(activity);
  $("#Show-prix").val(prix);
  $("#Show-margeht").val(margeHT);
  $("#Show-margeht100").val(marge100);
  $("#Show-prixvente").val(prixVente);
  $("#Show-stock").val(stock);
  $("#Show-suppliers").val(supplier);
  $("#Show-desc").val(desc);
  $("#Show-note").val(note);

  // Set image source
  images.forEach((image) => {
    const previewImage = $(".Show-product-images");
    previewImage.prepend(
      `
        <div class="product-image">
          <img src="../static/images/products/${image.image_url}" data-image-id="${image.id}" data-image-name="${image.image_url}" alt="product image">
        </div>
      `
    );
  });

  $(".swiper-wrapper").empty();

  images.forEach((image) => {
    $(".swiper-wrapper").append(`<div class="swiper-slide">
    <img src="../static/images/products/${image.image_url}" alt="Image *">
</div>`);
  });
}

/*********************** the suppliers search **************/
$("input#Show-suppliers").on("input", function () {
  let input = $(this).val();

  //populate the suppliers modal
  $.ajax({
    url: "../controller/searchSuppliersJSON.php",
    method: "GET",
    data: { query: input },
    // dataType: "json",
    success: function (response) {
      $("#Show-suppliers_list option:not([value='none'])").remove();

      $.each(response, function (item) {
        var res = response[item];
        var option = $("<option>")
          .val(res.id)
          .text(res.nom + " " + res.prenom + "     |   " + res.business_name);
        $("select[id='Show-suppliers_list']").append(option);
      });
    },
    error: function (xhr, status, error) {
      console.log("AJAX request error:", error);
    },
  });
});

/******************** functions that i neeeeeed *****************/
function resetShowForm() {
  // Empty all inputs
  $("input[type='text']").val("");
  $("input[type='number']").val("0.00");

  $("textarea").val("");

  $(".Show-product-images").find(".product-image").remove();

  // Select the first option in the select element
  $("select").prop("selectedIndex", 0);

  $("#update-product-button").html("Update Product");
  $("#update-product-button").removeClass("disabled");

  $("select[id='suppliers_list'").empty();

  clearShowFormData();
}

function clearShowFormData() {
  formData2 = new FormData();
}

/*functions*/
function AttachChange() {
  // Attach change event listeners to each input element
  $("#showProduct input").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showProduct textarea").on("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showProduct select").on("change", handleChange);
}

// Function to handle the change event
function handleChange() {
  $("#update-product-button").toggleClass("disabled");

  // Attach change event listeners to each input element
  $("#showProduct input").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showProduct textarea").off("change", handleChange);

  // Attach change event listeners to each textarea element
  $("#showProduct select").off("change", handleChange);

  handleChanged = true;
}

function ShowvalidateInputs() {
  // Get the values of the required inputs
  const produitNom = $("#Show-produitNom").val().trim();
  const prix = $("#Show-prix").val().trim();
  const margeht = $("#Show-margeht").val().trim();
  const margeht100 = $("#Show-margeht100").val().trim();
  const prixvente = $("#Show-prixvente").val().trim();
  const category = $("#Show-category").val().trim();
  const unit = $("#Show-unit").val().trim();
  const activite = $("#Show-activite").val();
  const suppliers = $("select[id='Show-suppliers_list'").val();
  const supplier = $("#Show-suppliers").val();

  // Check if any of the required inputs are empty or the gender is "none"
  if (
    produitNom === "" ||
    prix === "" ||
    margeht === "" ||
    margeht100 === "" ||
    prixvente === "" ||
    category === "none" ||
    unit === "none" ||
    activite === "none" ||
    (suppliers === "none" && supplier === "")
  ) {
    // Display an error message or perform appropriate action
    message = "Please fill in all the required fields.";
    formMessage(message, "danger", $("#showProduct .modal-body"));
    return false; // Return false to indicate validation failure
  }

  // Validation successful
  return true;
}

/******************* images handling **************/
$(".box.show").click(function (e) {
  $("#Show-fileInput").click();
});

function Showdrop(event) {
  event.preventDefault();
  const files = event.dataTransfer.files;
  ShowhandleFile(files);
}

function ShowhandleFileSelect(event) {
  const files = event.target.files;
  ShowhandleFile(files);
}

function ShowhandleFile(files) {
  Array.from(files).forEach((file) => {
    const reader = new FileReader(); // Create a new FileReader for each file

    reader.onload = function (event) {
      const previewImage = $(".Show-product-images");
      previewImage.prepend(
        `
          <div class="product-image">
            <img src="${event.target.result}" data-image-name="${file.name}" alt="product image">
            <span class="delete-icon" onclick="ShowdeleteImage(event)">&#x2715;</span>
          </div>
          `
      );
    };

    if (file) {
      reader.readAsDataURL(file);
      formData2.append("images[]", file); // Append file to the 'images' array in the formData
    }

    if (handleChanged == false) {
      handleChange();
      handleChanged = true;
    }
  });

  $(".Show-product-images").animate(
    { scrollTop: $(".Show-product-images")[0].scrollHeight },
    "slow"
  );
}

function ShowdeleteImage(event) {
  const imageContainer = $(event.target).parent(".product-image");
  imageContainer.remove();

  const imageSrc = imageContainer.find("img").attr("data-image-name");

  // Retrieve the files from the FormData object
  let files = formData2.getAll("images[]");

  // Find the index of the file to remove
  let index = -1;
  for (let i = 0; i < files.length; i++) {
    if (files[i].name === imageSrc) {
      index = i;
      break;
    }
  }

  // If the file was found, remove it from the array and FormData
  if (index > -1) {
    files.splice(index, 1);
    formData2.delete("images[]");
    for (let i = 0; i < files.length; i++) {
      formData2.append("images[]", files[i]);
    }
  }

  if (handleChanged == false) {
    handleChange();
    handleChanged = true;
  }
}

/********************the price calculations******************************************/
$("#Show-prix").on("input", calculateMargins);
$("#Show-margeht100").on("input", calculateMargins);
$("#Show-prixvente").on("input", calculateMarginsFromPrixVente);

function calculateMargins() {
  const prix = parseFloat($("#Show-prix").val());
  const margeHTPercent = parseFloat($("#Show-margeht100").val());

  if (!isNaN(prix) && !isNaN(margeHTPercent)) {
    const margeHT = prix * (margeHTPercent / 100);
    const prixVenteTTC = prix + margeHT;

    $("#Show-margeht").val(margeHT.toFixed(2));
    $("#Show-prixvente").val(prixVenteTTC.toFixed(2));
  }
}

function calculateMarginsFromPrixVente() {
  const prixVente = parseFloat($("#Show-prixvente").val());
  const prix = parseFloat($("#Show-prix").val());

  if (!isNaN(prixVente) && !isNaN(prix) && prix !== 0) {
    const margeHT = prixVente - prix;
    const margeHTPercent = (margeHT / prix) * 100;

    $("#Show-margeht").val(margeHT.toFixed(2));
    $("#Show-margeht100").val(margeHTPercent.toFixed(2));
  }
}

/*********** update product event **********************/
$("#update-product-button").click(function () {
  if (!ShowvalidateInputs()) return;
  $(this).html('<i class="fas fa-spinner fa-spin"></i>');
  $(this).addClass("disabled");

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
    url: "../controller/updateProduct.php",
    method: "POST",
    data: formData2,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the success response
      console.log(response);
      if (response == "Success: Product updated successfully.") {
        resetForm();
        $("#showProduct").modal("hide");
        table.ajax.reload();
      }
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });
});
