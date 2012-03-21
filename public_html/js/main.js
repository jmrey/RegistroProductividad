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
    $('[data-property]').bind('click', function () {
        var dataProperty = $(this).attr('data-property');
        var value = !$(this).hasClass('active');
        $.post('/admin/contenidos/set/' + dataProperty + '/' + value, function (data) {
            //alert(data);
            if (data === 'error') return false;
        });
    });
    
    var autocomplete = $('.autocomplete').typeahead()
        .on('keyup', function(ev){
            ev.stopPropagation();
            ev.preventDefault();
            //filter out up/down, tab, enter, and escape keys
            if( $.inArray(ev.keyCode,[40,38,9,13,27]) === -1 ){
                var self = $(this);
                //set typeahead source to empty
                self.data('typeahead').source = [];
                //active used so we aren't triggering duplicate keyup events
                if( !self.data('active') && self.val().length > 0){
                    self.data('active', true);
                    //Do data request. Insert your own API logic here.
                    $.getJSON("/json/" + $(this).attr('data-source') + "/index/" + $(this).attr('data-field') + "/" + $(this).val(),
                        function(data) {
                            //set this to true when your callback executes
                            self.data('active',true);
                            //Filter out your own parameters. Populate them into an array, since this is what typeahead's source requires
                            /*var arr = [],
                                i = data.results.length;
                            while(i--){
                                arr[i] = data.results[i].text
                            }*/
                            //set your results into the typehead's source 
                            self.data('typeahead').source = data;
                            //trigger keyup on the typeahead to make it search
                            self.trigger('keyup');
                            //All done, set to false to prepare for the next remote query.
                            self.data('active', false);

                        });

                }
            }
        });
});

