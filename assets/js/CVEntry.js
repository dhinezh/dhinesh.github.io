$(document).ready(function () {
  var form = $("#CV-entry-form").show();
  form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "fade",
    autoFocus: true,
    transitionEffectSpeed: 500,
    titleTemplate: '<div class="title">#title#</div>',
    labels: {
      previous:
        '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">navigate_before</i></button>',
      next:
        '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">navigate_next</i></button>',
      finish: '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">check</i></button>',
      current: ""
    },
    onStepChanging: function (event, currentIndex, newIndex) {
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinishing: function (event, currentIndex) {
      form.validate().settings.ignore = ":disabled";
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      form.submit();
    }
  });
  form.validate({
    errorPlacement: function errorPlacement(error, element) {
      element.after(error);
    }
  });
});
