$(document).ready(function() {

  // platform, touch device & standalone detection
  $ios = ( navigator.userAgent.toLowerCase().match(/(iPad|iPhone|iPod)/i) ? true : false );
  $android = ( navigator.userAgent.toLowerCase().match(/(android)/i) ? true : false );
  $standalone = (window.navigator.standalone) ? true : false;
  $touch = ( navigator.userAgent.match(/(Android|webOS|iPad|iPhone|iPod|BlackBerry)/i) ? true : false );
  var touchEvent = $touch ? 'touchstart' : 'click';

  // console.log('cookies on pageload: ' + document.cookie);

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

  // mobile menu init
  if($('#menu-drawer').length > 0 && $('#panel').length > 0) {
    slideout = new Slideout({
      'panel': document.getElementById('panel'),
      'menu': document.getElementById('menu-drawer'),
      'padding': 260,
      'tolerance': 70
    });
    $('#panel').append('<a id="panel-mask"></a>');
  }

  // display 'add to homescreen' message
  if(!$standalone && getCookie('add_home_message') != "false") {

    if($ios) {
      $('#add_home_message').removeClass('u-hidden');
    } else if($android) {
      $('#add_home_message').removeClass('u-hidden');
      $('#add_home_message .text-ios').addClass('u-hidden');
      $('#add_home_message .text-android').removeClass('u-hidden');
    }

  }

  // display intro message
  if(typeof $('#intro_message') != 'undefined' && getCookie('intro_message') != "false" ) {
    $('#intro_message').removeClass('u-hidden');
  }








  // start listeners

  // dropdown toggle
  $('.hasDropdown > a, .dropdown a').bind('click', (function(e) {
    $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
    $(this).closest('.hasDropdown').find('.ion-chevron-down, .ion-chevron-up').toggleClass('ion-chevron-down').toggleClass('ion-chevron-up');
  }));

  if(window.slideout) {
    // mobile menu toggle button
    $('#navbutton').bind(touchEvent, (function(e) {
      slideout.toggle();
      e.preventDefault();
    }));
    // mobile menu toggle button
    $('#panel-mask').bind(touchEvent, (function(e) {
      slideout.close();
      e.preventDefault();
    }));

    // mobile menu translation functions – WARNING: disabled because of poor performance
    // slideout.on('translate', function(translated) {
    //   slideratio = translated/260;
    //   $('#menu-drawer .menu').css('opacity', slideratio);
    //   $('#panel #panel-mask').css('opacity', slideratio);
    // });
    // slideout.on('open', function() {
    //   $('#menu-drawer .menu').attr('style', '');
    //   $('#panel #panel-mask').attr('style', '');
    //   $('#navbutton .ion-navicon').hide();
    //   $('#navbutton .ion-android-close').css( "display", "block");
    // });
    // slideout.on('close', function() {
    //   $('#menu-drawer .menu').attr('style', '');
    //   $('#panel #panel-mask').attr('style', '');
    //   $('#navbutton .ion-navicon').show();
    //   $('#navbutton .ion-android-close').hide();
    // });
  }

  // dialog open
  $('a[data-dialog]').bind(touchEvent, (function(e) {
    $dest = $(this).attr('data-dialog');
    openDialog($dest);
  }));

  // dialog close
  $('#dialog_mask').bind(touchEvent, (function(e) {
    closeDialog();
  }));

  // (un)support button interactions
  $('#action_support, #action_unsupport').bind(touchEvent, (function(e) {
    $(this).addClass('isBusy');
    $('#loader_mask').removeClass('isVisible');
    $('main,nav').removeClass('dialogIsOpen');
    // if ($(this).attr('id') == 'action_support') {
    //   $this = $('#action_support');
    //   $other = $('#action_unsupport');
    // } else {
    //   $this = $('#action_unsupport');
    //   $other = $('#action_support');
    // }

    // e.preventDefault();

    // 'fake' delay for mockups
    // setTimeout(function() {
      
    //   $('#support_counter').removeClass('isGrowing isSlinking');
    //   previous = parseInt($('#support_counter .value').html());

    //   // add support to counter
    //   if ($this.attr('id') == 'action_support') {
    //     $('#support_counter').addClass('isGrowing');
    //     $('#support_counter .value').html(previous+1);
    //   } else {
    //     $('#support_counter').addClass('isSlinking');
    //     $('#support_counter .value').html(previous-1);
    //   }

    //   $this.removeClass('isBusy').addClass('u-hidden');
    //   $other.removeClass('u-hidden');

    // }, 500);
  }));

  // login button interaction
  $('.login, #dialog_report, #dialog_new_announcement').find('button[type="submit"]').bind(touchEvent, (function(e) {
    $(this).addClass('isBusy');
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

  // closes flash message
  $('.flash #flash_close').click(function() {
    $(this).closest('.flash').fadeOut();
  });
  // closes message
  $('.message #message_close').click(function(e) {
    $messageObj = $(this).closest('.message');
    $messageID = $messageObj.attr('id');
    $messageObj.fadeOut();

    // set cookies for remembering closing message (if it has an id)
    if($messageID) {
      document.cookie=$messageID+"=false";
      // setMessageCookie( $messageID );
    }

  });
  // expand message
  $('.message #message_expand').bind('click', function(e) {
    $(this).toggleClass('c-white').toggleClass('c-light');
    $(this).closest('.message').find('.message-expanded').toggleClass('u-hidden');
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

  $('.card .share').click(function(e) {
    e.preventDefault();
    $url = $(this).attr('href');
    window.open($url, '_blank', 'width=600, height=300, menubar=no, top=300, left=450');
  });

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

  // set maximum number of allowed image uploads
  $maxImages = 3;

  // add listener for input field change
  $('#image_input').change(function() {
    handleFiles(this.files, $maxImages);
    checkImageCount();
  });
  
});


// create issue file upload handler
function handleFiles(files, maxImages) {

  // set fallback for max images
  if(typeof maxImages == 'undefined') { maxImages = 5; }

  var existingImageCount = $("#issue_images > *").length;

  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /^image\//;
    
    if (!imageType.test(file.type)) {
      continue;
    }

    if((files.length + existingImageCount) > $maxImages) {
      alert('You can only upload a maximum of ' + $maxImages + ' images.');
      break;
    }

    var previewDiv = document.createElement("div");
    previewDiv.classList.add("badge", "badge-image", "u-relative", "u-mr10");
    previewDiv.file = file;
    issue_images.appendChild(previewDiv);
    
    var reader = new FileReader();
    reader.onload = (function(aImg) {
      return function(e) {

        // convert string to form value
        var base64string = '';
        if (e.target.result.split(',')[0].indexOf('base64') >= 0) {
          base64string = e.target.result.split(',')[1];
          var resultInput = document.createElement("input");
          resultInput.type = 'hidden';
          resultInput.name = 'images[]';
          resultInput.value = base64string;
          aImg.appendChild(resultInput);
        } else {
          alert('There was a problem with your image.');
          return false;
        }

        // output preview image
        aImg.style.backgroundImage = 'url(' + e.target.result + ')';

        // add remove button
        var closeButtonIcon = document.createElement("i");
        closeButtonIcon.classList.add("ion", "ion-onbadge", "ion-close");
        var closeButton = document.createElement("a");
        closeButton.href = 'javascript:void(0)';
        closeButton.class = 'remove-image';
        closeButton.appendChild(closeButtonIcon);

        aImg.appendChild(closeButton);

        closeButton.addEventListener('click', function(e) {
          $(this).closest('.badge').remove();
          checkImageCount();
        });
      }; 
    })(previewDiv);
    reader.readAsDataURL(file);
  }
}
// check amount of images and hide 'add' button if needed
function checkImageCount() {
  var newImageCount = document.querySelectorAll("#issue_images > *").length;
  if (newImageCount < $maxImages) {
    $('#image_input').closest('.badge').removeClass('u-hidden');
  } else {
    $('#image_input').closest('.badge').addClass('u-hidden');
  }
}

// adds isBusy class to button
function addIsBusy(obj) {
  if(typeof obj != 'undefined' && obj.hasClass('btn')) {
    obj.addClass('isBusy');
  }
}

// opens dialog
function openDialog(dest) {
  $dest = dest;
  $('#' + $dest).addClass('isVisible');
  $('#dialog_mask').addClass('isVisible');
  $('main,nav').addClass('dialogIsOpen');
}

// closes passed dialog (defaults to all)
function closeDialog(obj) {
  if (typeof obj == 'undefined' || obj == 'all' ) {
    $('dialog').removeClass('isVisible');
    $('#dialog_mask').removeClass('isVisible');
    $('main,nav').removeClass('dialogIsOpen');
    // e.preventDefault();
  }
}

// gets page cookies
// from http://www.w3schools.com/js/js_cookies.asp
function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') { c = c.substring(1) };
    if (c.indexOf(nameEQ) != -1) { return c.substring(nameEQ.length,c.length) };
  }
}

// parallax functionality
function scrollActions() {
  scroll = $(window).scrollTop();
  threshold = 100;

  if ((scroll + $('nav').outerHeight()) > threshold) {
    $('nav').addClass('nav-isFixed');
  } else {
    $('nav').removeClass('nav-isFixed');
  }
  if (window.slideout && $(window).outerWidth() > 768) {
    slideout.close();
  }
}


$(window).scroll(function() { scrollActions(); });
$(window).resize(function() { scrollActions(); });
$(document).bind("scrollstart", function() { scrollActions(); });
$(document).bind("scrollstop", function() { scrollActions(); });