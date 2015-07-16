$(document).ready(function() {

  // touch device detection
  $touch = ( navigator.userAgent.match(/(Android|webOS|iPad|iPhone|iPod|BlackBerry)/i) ? true : false );
  var touchEvent = $touch ? 'touchstart' : 'click';

  // initiating smoothscroll
  $('a[href^="#"]').smoothScroll();

  // setting loader mask on non-same page links
  $('a').click(function() {
    $href = $(this).attr('href');
    if ($href && !$href.match("^#") && !$href.match("^javascript")) {
      $('#loader_mask').addClass('isVisible');
      $('main,nav').addClass('dialogIsOpen');

      // automatically removing loader blurring
      setTimeout(function() {
        $('#loader_mask').removeClass('isVisible');
        $('main,nav').removeClass('dialogIsOpen');
      }, 5000);
    }
  });

  // removing loader mask & page loader on init
  $('#loader_mask').removeClass('isVisible');
  $('main,nav').removeClass('dialogIsOpen');




  // start listeners

  // dropdown toggle
  $('.hasDropdown > a, .dropdown a').bind('click', (function(e) {
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

  // (un)support button interactions
  $('#action_support, #action_unsupport').bind(touchEvent, (function(e) {
    if ($(this).attr('id') == 'action_support') {
      $this = $('#action_support');
      $other = $('#action_unsupport');
    } else {
      $this = $('#action_unsupport');
      $other = $('#action_support');
    }

    e.preventDefault();
    $this.addClass('isBusy');

    // 'fake' delay for mockups
    setTimeout(function() {
      
      $('#support_counter').removeClass('isGrowing isSlinking');
      previous = parseInt($('#support_counter .value').html());

      // add support to counter
      if ($this.attr('id') == 'action_support') {
        $('#support_counter').addClass('isGrowing');
        $('#support_counter .value').html(previous+1);
      } else {
        $('#support_counter').addClass('isSlinking');
        $('#support_counter .value').html(previous-1);
      }

      $this.removeClass('isBusy').addClass('u-hidden');
      $other.removeClass('u-hidden');

    }, 500);
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
  // closes form message
  $('.form-message #message_close').click(function(e) {
    $(this).closest('.form-message').fadeOut();
  });

  // tabs active switch
  $(document).on('click', '.tabs a', function(e){
    // target behaviour
    $target = $(this).attr('data-target');
    if($target.length > 0) {
      $('.tabsection').addClass('u-opacity0');
      $('#' + $target).removeClass('u-opacity0');
      window.location.hash = "mode_" + $target;
    }
    if ($target == 'map') {
      mapInitialize();
    }
    // tab bar behaviour
    $(this).closest('.tabs').find('a').removeClass('active');
    $(this).addClass('active');
    $(this).blur();
  });



  // switches to selected tab in location hash
  if(window.location.hash) {
    hash = window.location.hash.replace('#', '').replace('mode_', '');
    $intented_target = $('.tabs a[data-target="' + hash + '"]');
    if($intented_target.length > 0) {
      $intented_target.click();
    }
  }



  // filter field interactions
  // when user starts typing, field should be in 'busy' state
  $(document).on('keyup', '#location_string', function(e){
      if($(this).val().length > 1) {
          $("#location_string").closest('.form-group').attr('data-form-state','is-busy');
      }
  });
  // when user clicks home button
  $(document).on('click', '#home_location', function(e){
    e.preventDefault();
    $("#location_string").closest('.form-group').attr('data-form-state','is-home');
    $("#location_string").val( $(this).attr('data-val') );
    loc = $(this).attr('data-val').split(', ');
    $("#hood").val( loc[0] );
    console.log( loc[0] );
    $("#district").find('.text').html( loc[1] + ', ' + loc[2] );
    console.log( loc[1] + ', ' + loc[2] );
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

// parallax functionality
function scrollActions() {
  scroll = $(window).scrollTop();
  threshold = 100;

  if ((scroll + $('nav').outerHeight()) > threshold) {
    $('nav').addClass('nav-isFixed');
  } else {
    $('nav').removeClass('nav-isFixed');
  }
}

$(window).scroll(function() { scrollActions(); });
$(window).resize(function() { scrollActions(); });
$(document).bind("scrollstart", function() { scrollActions(); });
$(document).bind("scrollstop", function() { scrollActions(); });