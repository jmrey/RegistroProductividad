/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*
	Name: jquery.textCounter.js
	Author: Andy Matthews
	Website: http://www.andyMatthews.net
	Packed With: http://jsutility.pjoneil.net/
*/
(function($){

	$.fn.textCounter = function(o){
		
		o = $.extend( {}, $.fn.textCounter.defaults, o );
		
		return this.each(function(i, el){

			var $e = $(el);

			$e.html(o.count);
			$(o.target).keyup(function(){
				var cnt = this.value.length;

				if (cnt <= (o.count-o.alertAt)) {
					// clear skies
					$e.removeClass('tcAlert tcWarn');
				} else if ( (cnt > (o.count-o.alertAt)) && (cnt <= (o.count-o.warnAt)) ) {
					// getting close
					$e.removeClass('tcAlert tcWarn').addClass('tcAlert');
				} else {
					// over limit
					$e.removeClass('tcAlert tcWarn').addClass('tcWarn');
					if (o.stopAtLimit) this.value = this.value.substring(0, o.count);
				}
				$e.html('(' + (o.count-this.value.length + '') + ')');
			}).trigger('keyup');

		});
		
	}

	$.fn.textCounter.defaults = {
		count: 140,
		alertAt: 20,
		warnAt: 0,
		target: '',
		stopAtLimit: false
	};

})(jQuery);

$(document).on('ready', function(){
    $('.numeric').keypress(function (event) {
        var controlKeys = [8, 9, 13, 35, 36, 37, 39];
        var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
        if (!event.which || // Control keys in most browsers. e.g. Firefox tab is 0
            (49 <= event.which && event.which <= 57) || // Always 1 through 9
            (48 == event.which && $(this).attr("value")) || // No 0 first digit
            isControlKey) { // Opera assigns values for control keys.
            return;
        } else {
            event.preventDefault();
        }
    });
    $('#resumeCounter').textCounter({
        target: '#resumeTextarea',
        count: 500,
        alertAt:100,
        warnAt:25,
        stopAtLimit:true
    });
    $('.float-messages .error-message').prepend('<div class="arrow"></div><a class="close" href="#" data-dismiss="alert">×</a>');
    $('.input .form-error').focus(function () {
        $(this).siblings('.error-message').children('.close').click();
    });
});

