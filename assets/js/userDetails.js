$(document).ready(function () {
  fetch_data();

  function fetch_data() {
    var table = $("#tbl-contact").DataTable({
      scrollX: true,
      pagingType: "numbers",
      processing: true,
      serverSide: true,
      ajax: {
        url: "php-scripts/viewUserDetails.php",
        type: "POST"
      }
    });
  }
  $(document).on("click", ".deleteData", function () {
    var id = $(this).attr("id");
    if (confirm("Are you sure you want to remove user?")) {
      $.ajax({
        url: "php-scripts/deleteUser.php",
        method: "POST",
        data: { id: Number(id) },
        success: function (data) {
          $("#alert-message").html(
            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
              data +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
          );
          $("#tbl-contact").DataTable().destroy();
          fetch_data();
        }
      });
      setInterval(function () {
        $("#alert-message").html("");
      }, 5000);
    }
  });
});
