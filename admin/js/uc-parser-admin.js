(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    $(function() {

        $('#check_dealers').click(function(){
        	let spinner = $(this).next('.fa-sync');
            let dealers = $('#dealers');
            let save = $('#save_dealers');
            let label = $('#label');
        	let button = $(this);

            spinner.show();
            button.hide();
            save.hide();
            label.hide();
            dealers.empty();
            dealers.hide();
            dealers.selectpicker('destroy');

            let data = {
                action: 'sending',
                check: 'dealers'
            };

            $.post(ajaxurl, data, function(response) {
            	let answer = jQuery.parseJSON(response);
				$('#error').html(answer.status);
                if(answer.message) {
                	label.show();
                    dealers.show();
                    save.show();

                    let count = Object.keys(answer.message).length;
                    $.each(answer.message, function (key, entry) {
                        dealers.append($('<option></option>').attr('value', entry.url).text(entry.name));
                        if (!--count) dealers.selectpicker('refresh');
                    });
				}
                spinner.hide();
                button.show();
            });
        });

        $('#save_dealers').click(function(){
            let spinner = $(this).next('.fa-sync');
            let dealers = $('#dealers');
            let label = $('#label');
            let save = $('#save_dealers');
            let dealers_list = $.map($('#dealers option:selected'),function(option){return{'name': option.text, 'url': option.value}});
            let button = $(this);

            spinner.show();
            button.hide();
            save.hide();

            let data = {
                action: 'sending',
                check: 'save_dealers',
				dealer_list: dealers_list
            };
            $.post(ajaxurl, data, function(response) {
                let answer = jQuery.parseJSON(response);
                $('#error').html(answer.status);
                spinner.hide();
                label.hide();
                dealers.empty();
                dealers.hide();
                dealers.selectpicker('destroy');
                load();
            });
        });

        function load(){
            let dealer = $('#dealer');
            let dealer_m = $('#dealer_m');
            let label = $('#label2');
            let label3 = $('#label3');
            let spinner = label.prev('.fa-sync');
            let spinner3 = label3.prev('.fa-sync');
            let button = $('#sync_cars'); let button2 = $('#save_list'); let button3 = $('#sync_cars_m');

            dealer.empty(); dealer_m.empty();
            dealer.hide(); dealer_m.hide();
            dealer.selectpicker('destroy'); dealer_m.selectpicker('destroy');
            spinner.show(); spinner3.show();

            let data = {
                action: 'sending',
                check: 'get_dealers'
            };
            $.post(ajaxurl, data, function(response) {
                label.show(); label3.show();
                let answer = jQuery.parseJSON(response);
                if(answer){
                    dealer.show(); dealer_m.show();
                    let count = Object.keys(answer.message).length;
                    if(count>0) {
                        button.show(); button2.show(); button3.show();
                    }

                    $.each(answer.message, function (key, entry) {
                        dealer.append($('<option></option>').attr('value', key).text(entry));
                        if(answer.selected.includes(key)===true) {
                            dealer_m.append($('<option selected></option>').attr('value', key).text(entry));
                        } else {
                            dealer_m.append($('<option></option>').attr('value', key).text(entry));
                        }
                        if (!--count) {
                            dealer.selectpicker('refresh');
                            dealer_m.selectpicker('refresh');
                        }
                    });
                }
                spinner.hide();spinner3.hide();

            });
        }

        $('#save_list').click(function(){
            let spinner = $(this).next('.fa-sync');
            let button = $(this);
            let dealers_list = $('#dealer_m').val();

            spinner.show();
            button.hide();

            let data = {
                action: 'sending',
                check: 'save_list',
                dealer_list: dealers_list
            };
            $.post(ajaxurl, data, function(response) {
                let answer = jQuery.parseJSON(response);
                $('#error').html(answer.status);
                spinner.hide();
                button.show();
            });
        });

        $('#sync_cars').click(function(){
            let spinner = $(this).next('.fa-sync');
            let dealer = $('#dealer').val();
            let button = $(this);
            let button2 = $('#sync_cars_m');

            spinner.show();
            button.hide();
            button2.hide();

            let data = {
                action: 'sending',
                check: 'sync_cars',
                dealer: dealer
            };
            $.post(ajaxurl, data, function(response) {
                let answer = jQuery.parseJSON(response);
                $('#error').html(answer.status);
                spinner.hide();
                button.show();
                button2.show();
            });
        });

        $('#sync_cars_m').click(function(){
            let spinner = $(this).next('.fa-sync');
            let dealer = $('#dealer_m').val();
            let button = $(this);
            let button2 = $('#sync_cars');

            spinner.show();
            button.hide();
            button2.hide();

            let data = {
                action: 'sending',
                check: 'sync_cars_m',
                dealers: dealer
            };
            $.post(ajaxurl, data, function(response) {
                let answer = jQuery.parseJSON(response);
                $('#error').html(answer.status);
                spinner.hide();
                button.show();
                button2.show();
            });
        });

        $('[data-toggle="tooltip"]').tooltip();

        load();

    });

})( jQuery );
