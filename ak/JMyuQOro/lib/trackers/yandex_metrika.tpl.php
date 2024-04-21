<!-- Yandex.Metrika counter -->
<script type="text/javascript">

<?php if (!$lead): ?>

$(document).on('click', 'form', function(e) {
    if ( ! $(this).find('input[name=phone]').length) {
        return;
    }
    
    if (window['yaCounter<?= $counterId ?>'] && e.validator === window.orderValidator) {
        window['yaCounter<?= $counterId ?>'].reachGoal('FORMCLICK');
    }
});

<?php else: ?>

function yandex_metrika_postinit(ym) {
    ym.reachGoal('ORDER');
}

<?php endif ?>

(function(m, e, t, r, i, k, a) {
    m[i] = m[i] || function() {(m[i].a = m[i].a || []).push(arguments)};
    m[i].l = 1 * new Date();
    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
})(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(<?= $counterId ?>, "init", {
    clickmap:true,
    trackLinks:true,
    accurateTrackBounce:true,
    webvisor:<?= $webvisor ? 'true' : 'false' ?>
});

if (typeof yandex_metrika_postinit !== 'undefined') {
    yandex_metrika_postinit(ym);
}

</script>

<noscript>
    <div><img src="//mc.yandex.ru/watch/<?= $counterId ?>" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter --> 
