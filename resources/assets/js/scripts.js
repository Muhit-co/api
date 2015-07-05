$(document).ready(function() {

  // touch device detection
  $touch = ( navigator.userAgent.match(/(Android|webOS|iPad|iPhone|iPod|BlackBerry)/i) ? true : false );
  var touchEvent = $touch ? 'touchstart' : 'click';

  // initiating smoothscroll
  $('a[href^="#"]').smoothScroll();

  // setting loader mask on non-same page links
  $('a').click(function() {
    $href = $(this).attr('href');
    if (!$href.match("^#") && !$href.match("^javascript")) {
      $('#loader_mask').addClass('isVisible');
      $('main,nav').addClass('dialogIsOpen');
    }
  });

  // dropdown toggle
  $('.hasDropdown > a, .dropdown a').bind(touchEvent, (function(e) {
    $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
    $(this).find('.ion-chevron-down, .ion-chevron-up').toggleClass('ion-chevron-down').toggleClass('ion-chevron-up');
  }));

  // mobile menu toggle
  $('#navbutton').bind(touchEvent, (function(e) {
    $(this).toggleClass('isActive');
    $('body').toggleClass('menu-isActive');
    e.preventDefault();
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
  // $('.list ul a, .closeCard').click(function() {
  //   $('.list').toggleClass('list-expanded').toggleClass('list-collapsed');
  //   $('.card').toggleClass('card-hidden').toggleClass('card-expanded');
  // });

  // closes flash message
  $('.flash #flash_close').click(function() {
    $(this).closest('.flash').fadeOut();
  });

  // create issue file upload handler
  function handleFiles(files) {
    $('#image_preview').html('');
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var imageType = /^image\//;

      if(files.length > 5) {
          alert('You can only upload a maximum of 5 images.');
          break;
      }
      
      if (!imageType.test(file.type)) {
        continue;
      }

      var previewDiv = document.createElement("div");
      previewDiv.classList.add("badge", "badge-image", "u-relative", "u-mr10");
      previewDiv.file = file;
      image_preview.appendChild(previewDiv);
      
      var reader = new FileReader();
      reader.onload = (function(aImg) { return function(e) { aImg.style.backgroundImage = 'url(' + e.target.result + ')'; }; })(previewDiv);
      reader.readAsDataURL(file);
    }
  }
  $('#image_input').change(function() {
      handleFiles(this.files);
  });
  
});
