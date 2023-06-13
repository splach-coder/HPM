$(document).ready(function () {
  var table = $("#clientsTable").DataTable({
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
    $(".table-data-rows").html(" | " + dataLength + " clients right now");
  });

  table.draw();
});
