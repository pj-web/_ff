<?php

global $offer, $offers, $leadToken, $invoiceLanguage, $language, $lang, $shared_path, $showcase_url, $disablePhoneMask;

$_offers = [];
$_allowedCountries = [];

foreach($offers as $offerData) {
    $_offers[$offerData['id']] = $offerData;
    $_allowedCountries[] = $offerData['country']['code'];
}

if (isset($language)) {
    echo "
    <script>
    function set_validator_errors(){
        orderValidator.errorTitle = '" . $lang['error_title'] . "'; 

        orderValidator.errorNameField = '" . $lang['name'] . "'; 
        orderValidator.errorNameMess = '" . $lang['error_name'] . "'; 
        
        orderValidator.errorPhoneField = '" . $lang['phone'] . "'; 
        orderValidator.errorPhoneMess = '" . $lang['error_phone'] . "'; 
        
        orderValidator.errorAddress = '" . $lang['error_address'] . "'; 
        orderValidator.errorRequired = '" . $lang['error_required'] . "'; 
        orderValidator.errorMaxLength = '" . $lang['error_max_length'] . "'; 
        orderValidator.errorMinLength = '" . $lang['error_min_length'] . "'; 
        orderValidator.errorEmail = '" . $lang['error_email_mess'] . "';
        }
    </script>
    ";

}

?>

<script>


window.app = {
    timestamp: parseInt((new Date()).getTime() / 1000),
    jq: jQuery,
    formAction: window.location.href,
    leadToken: '<?= $leadToken ?>',
    offers: <?= json_encode($_offers); ?>,
    currentOffer: <?= json_encode($offer); ?>,
    allowedCountries: <?= json_encode($_allowedCountries); ?>,
    sharedPath: '<?= $shared_path ?>',
    _setOfferId: false,
    showcaseUrl: '<?= $showcase_url ?>',
    disablePhoneMask: Boolean(<?= $disablePhoneMask ?>),

    setOffer: function (offerId) {
        if (offerId == this._setOfferId) {
            return ;
        }
        this._setOfferId = offerId;
        if (offerId) {
            var offer = app.offers[offerId];
            var previousOffer = app.currentOffer;
            app.currentOffer = offer;
            var event = this.jq.Event("offerchange");
            event.previousOffer = previousOffer;
            event.currentOffer = app.currentOffer;
            this.jq(document).trigger(event);
            this.updatePage(offer);
        } else {
            $('input[name=country]').val('');
        }
    },
    
    updatePage: function(offer) {
        $('x-newprice').html(offer.price);
        $('x-oldprice').html(offer.price2);
        $('x-currency').html(offer.currency.name);
        $('input[name=offer], select[name=offer]').val(offer.id);
        $('input[name=country]').val(offer.country.code);
    }
    

};

$(document).on('change input', function(e) {
    $('input[type=submit]', $(this)).prop( 'disabled', false ).attr( 'disabled', false );
    $('button', $(this)).prop( 'disabled', false ).attr( 'disabled', false );
});


</script><?php

unset($_offers);
unset($_allowedCountries);
