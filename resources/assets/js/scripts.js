$(document).ready(function() {

  (function () {
    $(document).ready(function() {
      // touch device detection
      $touch = ( navigator.userAgent.match(/(Android|webOS|iPad|iPhone|iPod|BlackBerry)/i) ? true : false );
      var touchEvent = $touch ? 'touchstart' : 'click';

      // dropdown toggle
      $('.hasDropdown > a').bind(touchEvent, (function(e) {
      $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
      $(this).find('.ion-chevron-down, .ion-chevron-up').toggleClass('ion-chevron-down').toggleClass('ion-chevron-up');
      }));

      // dialog open
      $('a[data-dialog]').bind(touchEvent, (function(e) {
      $dest = $(this).attr('data-dialog');
      $('#' + $dest).addClass('isVisible');
      $('#dialog_mask').addClass('isVisible');
      $('main,nav').addClass('dialogIsOpen');
      }));

      // dialog close
      $('#dialog_mask, #closeDialog').bind(touchEvent, (function(e) {
      $('dialog').removeClass('isVisible');
      $('#dialog_mask').removeClass('isVisible');
      $('main,nav').removeClass('dialogIsOpen');
      e.preventDefault();
      }));

      // toggles dialog close on Esc key
      $('body').bind('keyup', (function(e) {
      if(e.keyCode == 27) {
        $('dialog').removeClass('isVisible');
        $('#dialog_mask').removeClass('isVisible');
        $('main,nav').removeClass('dialogIsOpen');
      }
      e.preventDefault();
      }));

      // toggles autocomplete dropdown
      $('.form-autosuggest input').bind('focus blur', function() {
        $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
      });

      // toggles card/list in listdetail view
      $('.list ul a, .closeCard').click(function() {
        $('.list').toggleClass('list-expanded').toggleClass('list-collapsed');
        $('.card').toggleClass('card-hidden').toggleClass('card-expanded');
      });

    });
    })();

});
