$(document).ready(function () {
  var formData = new FormData();
  var palleteForm = new FormData();
  var id;
  //get all colors
  //Make the AJAX POST request
  $.ajax({
    url: "../controller/getColorsJSON.php",
    method: "GET",
    processData: false,
    contentType: false,
    success: function (response) {
      console.log(response);

      $("#colorsContainer").empty();
      response.forEach(function (color) {
        $("#colorsContainer").append(`
        <div class="color-box">
            <div class="innerBox" data-color="${
              color.color
            }" style="background-color:${color.color};">
            <i class="fas fa-gear editColor" id="${color.id}"></i>
            </div>
            <div class="colorName">
               ${convertDashToSpace(color.name)}
            </div>
        </div>
        `);
      });

      $(".editColor").click(function () {
        id = $(this).attr("id");
        const color = $(this).parent().attr("data-color");
        $("#myModal").modal("show");
        $("#colorPicker").val(color);
      });
    },
    error: function (error) {
      // Handle the error response
      console.log(error);
    },
  });

  //on change color picker
  $("#colorPicker").on("change", function () {
    $("#edit-color-button").removeClass("disabled");
  });

  $("#myModal").on("hide.bs.modal", function (e) {
    $("#edit-color-button").addClass("disabled");
    clearForm();
  });

  $("#edit-color-button").click(function () {
    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
    $(this).addClass("disabled");

    let color = $("#colorPicker").val();
    formData.append("color", color);
    formData.append("id", id);

    $.ajax({
      url: "../controller/updateColor.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response == "success: Color updated successfully") {
          $("#myModal").modal("hide");
        } else {
          formMessage(response, "danger", $("#myModal .modal-body"));
        }
      },
      error: function (error) {
        // Handle the error response
        console.log(error);
      },
    });
  });

  function clearForm() {
    formData = new FormData();
  }

  $("#save-pallete-button").click(function () {
    $(this).html('<i class="fas fa-spinner fa-spin"></i>');
    $(this).addClass("disabled");

    // Get the form element
    const pallete = $(".palleteGenerator");

    let i = 0;

    let arr = ["primaryColor", "Lightprimary", "Darkprimary"];

    // Append all form fields to the FormData object
    pallete.find(".color").each(function () {
      const hexColor = $(this).children(".hex-value").text();

      if (i < 3) {
        // Append other inputs, selects, and textareas to the FormData object
        palleteForm.append(arr[i], hexColor);
        i++;
      }
    });

    //Make the AJAX POST request
    $.ajax({
      url: "../controller/savePallete.php",
      method: "POST",
      data: palleteForm,
      processData: false,
      contentType: false,
      success: function (response) {
        // Handle the success response
        location.reload();
      },
    });
  });
});
