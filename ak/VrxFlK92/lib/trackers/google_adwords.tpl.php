<!-- Global site tag (gtag.js) - Google Ads: CONVERSION_ID -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-<?= $counterId ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-<?= $counterId ?>');
</script>

<?php if ($lead): ?>
    <script>
        gtag('event', 'conversion', {'send_to': 'AW-<?= $counterId ?>/<?= $convLabel ?>',
            'transaction_id': ''
        });
    </script>
<?php endif ?>