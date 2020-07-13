$(document).ready(function () {
  fetch_data();
  function fetch_data() {
    var table = $("#tbl-contact").DataTable({
      scrollX: true,
      pagingType: "numbers",
      processing: true,
      serverSide: true,
      ajax: {
        url: "php-scripts/viewVehicleDetails.php",
        type: "POST"
      }
    });
  }
  function destroyTable() {
    $("#tbl-contact").DataTable().destroy();
  }
  $(document).on("click", ".deleteData", function () {
    var id = $(this).attr("id");
    var vehicleType = $(this).attr("data-vehicleType");
    if (confirm("Are you sure you want to remove entry?")) {
      $.ajax({
        url: "php-scripts/deleteDataFromTables.php",
        method: "POST",
        data: { id: id, vehicleType: vehicleType },
        success: function (data) {
          $("#alert-message").html(
            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
              data +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
          );
          destroyTable();
          fetch_data();
        }
      });
    }
  });
  $(document).on("click", ".viewReport", function () {
    var id = $(this).attr("id");
    var vehicleType = $(this).attr("data-vehicleType");
    window.open(`view-report.php?repId=${id}&vehicleType=${vehicleType}`, '_blank');
  });
});
