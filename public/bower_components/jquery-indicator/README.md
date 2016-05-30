jquery-indicator
===========

The library is a javascript loading indicator.

### Contribute ###

I'm waiting your pull requests :)

### Usage ###

First include script/css
```html
<link rel="stylesheet" type="text/css" href="indicator.css" />
<script src="indicator.js"></script>
```

HTML
```html
<div id="data">
...
</div>
```

Your javascript
```javascript
// Show indicator
indicator.show('#data');

// AJAX Request
$.ajax({
	url: "/uri/",
	type: "POST",
	data: "key=value",
	success: function(result) {

	  // Hide indicator
	  indicator.hide('#data');

	  // Result
	  $('#data').html(result);
	}
});
```

This content is released under the (http://opensource.org/licenses/MIT) MIT License.
