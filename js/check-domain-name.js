currentCurrency = 'BYR';

function formPrice ( price, currency, period ) {
	var priceString = '';
	
	if( price > 0 && period > 0) {
		switch ( currency ) {
			case 'BYR':
				price *= period;
				priceString = price.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
			break;
		}
	}
	
	return priceString;
}

function onPeriodChanged ( selectElem ) {
	jQuery( '.eld_domain_price' ).each( function (index , priceElem ) {
		var domainIndex = priceElem.id.replace('eld_price_amount_elem_', '');
		var newPriceString = formPrice( domainsData[ domainIndex ].price, currentCurrency, selectElem.value );
		
		priceElem.textContent = newPriceString + ' ';
	} )
		

}

function displayResult( jsonData ){
	var tableContent;
	var firstAvailableChecked = false;
	
	jsonData.forEach( function ( item, i, arr ) {
		var radioBtnId = 'eld_domain_choose_radio_button_' + i;
		var availabilityColumnId = 'eld_domain_availability_elem' + i;
		var availabilityText = item.available ? 'свободен' : 'занят';
		var availabilityClass = item.available ? 'eld_domain_available true' : 'eld_domain_available false'
		var priceColumnId = 'eld_domain_price_elem_' + i;
		var priceAmountElemId = 'eld_price_amount_elem_' + i;
		var currencyElemId = 'eld_currency_elem' + i;
		
// 		tableContent += '<tr id="eld_domains_table_row_' + i + '" class="eld_domains_table_row' + ( item.available && ! firstAvailableChecked ? ' row_checked' : ( item.available ? ' row_hover onclick="checkLine(\'eld_domain_choose_radio_button\',this)' : ' ') ) + '">' +
// 		
		tableContent += '<tr id="eld_domains_table_row_' + i + '" class="eld_domains_table_row' + ( item.available ?  ( firstAvailableChecked ? ' row_hover" ' : ' row_checked" ') +  'onclick="checkLine(\'^choosen_domain$\',this)' : '' ) + '">' +
		'<td class="eld_domain_name_radio"><span><input id="' + radioBtnId + '" type="radio" name="choosen_domain" value="' + item.domain + '"" ';
		if( item.available && ! firstAvailableChecked ) {
			tableContent += 'checked="checked" ';
			firstAvailableChecked = true;
		} else if( ! item.available ){
			tableContent += 'disabled="disabled" ';
		}
		
		tableContent += '">';
		
		tableContent += '<label for="' +  '">' + item.domain + '</label></span></td>' +
		'<td id="' + availabilityColumnId + '" class="' + availabilityClass + '"><span">' + availabilityText + '</span></td>';
		
		if ( item.available ) {
			tableContent += '<td id="'+ priceColumnId + '" class="eld_domain_price_row"><span class="eld_price_box">' +
                           ' <span id="' + priceAmountElemId + '" class="eld_domain_price">' + formPrice( item.price, item.currency, jQuery('#eld_period_select').val() ) + ' </span>' +
                            '<span id="' + currencyElemId + '">руб.</span></span></td>' ;
		} else { 
			tableContent += '<td></td>'
		}
		
		tableContent += '</tr>';
		
	} );
	
	var table = jQuery( '#eld_domains_table' );
	var rowsCount = table[0].rows.length;
	
	for( i = rowsCount - 1; i >= 0; i-- ) {
		table[0].deleteRow( i );
	}
	
	table.append( tableContent );
	
	jQuery("#eld_result_holder").css('display', 'block');
}

function checkLine(nameregex, current) {
    if (jQuery("#" + current.id + " input:disabled").length == 0) {
        re = new RegExp(nameregex);
		var form = jQuery('#choose_domain_name_form');
        for (i = 0; i < form[0].elements.length; i++) {
            elm = form[0].elements[i];
            if (elm.type == 'radio') {
                if (re.test(elm.name)) {
                    elm.checked = false;
                }
            }
        }
        
		jQuery("#" + current.id + " input").attr('checked', true);
        jQuery("#eld_domains_table .row_checked").addClass('row_hover');
        jQuery("#eld_domains_table .row_checked").removeClass('row_checked');
		jQuery("#" + current.id).removeClass('row_hover');
        jQuery("#" + current.id).addClass('row_checked');
    }
}

jQuery(document).ready(function() {
	var frm = jQuery('#check_domain_name_form');
	var spinner = jQuery('#eld_spinner');
	
	frm.submit(function (ev) {
		spinner.css('visibility', 'visible');
		ev.preventDefault();
		
		jQuery.ajax({
			type: frm.attr('method'),
			url: frm.attr('action'),
			data: frm.serialize(),
			success: function (data) {
				spinner.css('visibility', 'hidden');
				domainsData = JSON.parse( data.substring( 0, data.length - 1 ) );
				
				jQuery('#eld_check_domain_submit_button').blur();
				displayResult( domainsData );
				
				var destination = jQuery('#eld_result_holder').offset().top;
				jQuery("html,body").animate({scrollTop: destination}, 1000);
				
			},
			error: function (err) {
				spinner.css('visibility', 'hidden')
				//TODO добавить сообщение об ошибке
			}
		});
		
		
	});
});