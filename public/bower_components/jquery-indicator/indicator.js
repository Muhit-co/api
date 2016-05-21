/**
 * JS Loading Indicator
 *
 * @author  Şakir ŞENSOY | sakirsensoy@gmail.com
 * @depend jQuery
 * @return object
 */

var indicator = function() {

	/**
	 * Remove hash and dot, from element name.
	 *
	 * @param  string elementId
	 * @return string
	 */
	var elementNameFixer = function(elementId) {

		return elementId.replace('.', '').replace('#', '');
	};

	var elementExPosition = null;

	return {

		/**
		 * Create temporarily layer for indicator
		 *
		 * @param  string elementId
		 * @return void
		 */
		show: function(elementId) {

			//dom
			el = $(elementId);

			//temporarily parent layer position to relative
			elementExPosition = el.css('position');
			el.css('position', 'relative');

			//temporarily indicator layer
			tempIndicator = $('<div />')
			.attr('id', elementNameFixer(elementId) + '-indicator')
			.css({
				width: el.outerWidth(),
				height: el.outerHeight()
			})
			.addClass('indicator indicator-loader')
			.html('<div class="loading-pane">\
			        <div class="loading-message">\
			            <div class="spinner">\
			                <div class="double-bounce1"></div>\
			                <div class="double-bounce2"></div>\
			            </div>\
			        </div>\
			    </div>\
		    ');

			//indicator append to element
			el.append(tempIndicator);

			// spinner margin-top
			$('#' + elementNameFixer(elementId) + '-indicator').find('.spinner').css('margin-top', (el.outerHeight() - 40) / 2);

			// console.log('#' + $(elementNameFixer(elementId) + '-indicator').find('.spinner'));
		},

		/**
		 * Destroy loading indicator
		 *
		 * @param  string elementId
		 * @return void
		 */
		hide: function(elementId) {

			//dom
			el = $(elementId);

			//parent layer position restore
			el.css('position', elementExPosition);

			elementExPosition = null;

			//find indicator and destroy
			el.find('#' + elementNameFixer(elementId) + '-indicator').remove();
		},

		/**
		 * Create fullscreen indicator layer
		 *
		 * @return void
		 */
		showFS: function() {

			//temporarily indicator layer
			tempIndicator = $('<div />')
			.attr('id', 'fullscreen-indicator')
			.css({
				width: $(window).width(),
				height: $(window).height()
			})
			.addClass('indicator indicator-loader indicator-fullscreen-loader')
			.html('<div class="loading-pane">\
			        <div class="loading-message">\
			            <div class="spinner">\
			                <div class="double-bounce1"></div>\
			                <div class="double-bounce2"></div>\
			            </div>\
			        </div>\
			    </div>\
		    ');

			//indicator append to body
			$('body').append(tempIndicator);

			// spinner margin-top
			$('#fullscreen-indicator').find('.spinner').css('margin-top', ($(window).outerHeight() - 40) / 2);
		},

		/**
		 * Destroy fullscreen loading indicator
		 *
		 * @return void
		 */
		hideFS: function() {

			//find indicator and destroy
			$('#fullscreen-indicator').remove();
		}
	};
}();
