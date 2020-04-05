$(document).ready(function () {
  $("#four-wheeler-entry-form").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "fade",
    autoFocus: true,
    transitionEffectSpeed: 500,
    titleTemplate: '<div class="title">#title#</div>',
    labels: {
      previous: '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">navigate_before</i></button>',
      next: '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">navigate_next</i></button>',
      finish: '<button type="button" class="btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">check</i></button>',
      current: ""
    }
  });
});
