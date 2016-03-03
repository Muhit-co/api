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
    if ($href && !$href.match("^#") && !$href.match("^javascript") && $(this).attr('target') != '_blank') {
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
  $('.hasDropdown > a, .hasDropdown > button, .dropdown a').bind('click', (function(e) {
    $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
    $(this).closest('.hasDropdown').find('.ion-chevron-down, .ion-chevron-up').toggleClass('ion-chevron-down').toggleClass('ion-chevron-up');
  }));
  $(window).click(function(e) {
    if(!e.target.matches('.hasDropdown.dropdownIsOpen > a, .hasDropdown.dropdownIsOpen > button, .dropdownIsOpen .dropdown, .dropdownIsOpen .dropdown *')) {
      $('.hasDropdown').removeClass('dropdownIsOpen');
      $('.hasDropdown').find('.ion-chevron-up').addClass('ion-chevron-down').removeClass('ion-chevron-up');
    }
  });

  // mobile menu toggle button
  $('#navbutton, #panel-mask').bind(touchEvent, (function(e) {
    $('body').toggleClass('menu-isOpen');
    e.preventDefault();
  }));

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
    addIsBusy($(this));
    $('#loader_mask').removeClass('isVisible');
    $('main,nav').removeClass('dialogIsOpen');
  }));

  // login button interaction
  $('button[type="submit"], .btn-busyOnClick').bind(touchEvent, (function(e) {
    addIsBusy($(this));
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

  $('textarea[required], input[required]').bind('keyup change', function() {
    $(this).removeClass('form-input-hasError');
    console.log('error being corrected');
  });

  // toggles autocomplete dropdown
  $('.form-autosuggest input').bind('focus blur', function() {
    $(this).closest('.hasDropdown').toggleClass('dropdownIsOpen');
  });

  // closes flash message
  $('.flash #flash_close').click(function() {
    $(this).closest('.flash').animate({ opacity: 0 }, 'normal').slideUp();
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
    $(this).closest('.message').find('.message-expanded').toggleClass('u-hidden');
  });

  // share buttons on show page
  $('.card .btn-twitter[href*=share]').click(function(e) {
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
  if(typeof obj != 'undefined') {
    $validated = true;
    // check all required inputs in form
    obj.closest('form').find('input[required], textarea[required]').each(function() {
      if($(this).attr('type') == 'checkbox') { 
        if(!$(this).is(':checked')) { $validated = false }
      } else if($(this).val().length < 1) { 
        $validated = false;
        $(this).addClass('form-input-hasError');
      }
    });
    // only apply isBusy class if inputs are validated
    if(obj.hasClass('btn') && $validated == true) {
      obj.addClass('isBusy');
    }
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

// passes comment edit data to dialog
function dialogCommentEditData(obj) {
  $dest = obj.attr('data-dialog');
  $comment_id = obj.attr('data-comment-id');
  if (obj.length > 0 && $('#' + $dest).length > 0) {
    $msg = $.trim( obj.closest('.comment').find('.comment-message').html() );
    if ($msg.length > 0) {
      $('#' + $dest).find('textarea[name="comment"]').val($msg);
      $form = $('#' + $dest).find('form');
      $deletebtn = $('#' + $dest).find('#comment_delete');
      $form.attr('action', $form.attr('action') + $comment_id );
      $deletebtn.attr('href', $deletebtn.attr('href') + $comment_id );
    }
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