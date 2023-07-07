var table = $("#suppliersTable").DataTable({
  ajax: {
    url: "../controller/getSuppliersJSON.php",
    dataSrc: "",
  },
  columns: [
    { data: "id" },
    { data: "business_name" },
    { data: "prenom" },
    { data: "nom" },
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
  $(".table-data-rows").html(" | " + dataLength + " suppliers right now");
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
