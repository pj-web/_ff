<?php
global $shared_path;
?>
<?php if (isset($comebacker) && $comebacker && $comebacker['enabled']): ?>

  <?php
  if (!isset($comebacker['message']) || !$comebacker['message']) {
      $comebacker['message'] = '******************************\n\u041e\u0414\u041d\u0423 \u0421\u0415\u041a\u0423\u041d\u0414\u0423!\n******************************\n\u041f\u0440\u0435\u0436\u0434\u0435 \u0447\u0435\u043c \u0432\u044b \u0443\u0439\u0434\u0435\u0442\u0435, \u043c\u044b \u0445\u043e\u0442\u0438\u043c \u0441\u0434\u0435\u043b\u0430\u0442\u044c \u0432\u0430\u043c \u043d\u0435\u0431\u043e\u043b\u044c\u0448\u043e\u0439 \u041f\u041e\u0414\u0410\u0420\u041e\u041a\n\n\u0427\u0442\u043e\u0431\u044b \u043f\u043e\u043b\u0443\u0447\u0438\u0442\u044c \u0435\u0433\u043e - \u043a\u043b\u0438\u043a\u043d\u0438\u0442\u0435 \u043d\u0430 \u043a\u043d\u043e\u043f\u043a\u0443 [[\u043d\u0430\u0437\u0432\u0430\u043d\u0438\u0435 \u043a\u043d\u043e\u043f\u043a\u0438]]';
  }
  ?>
  <script>
  var config = {
    exit_text: "<?php echo $comebacker['message'] ?>",
    launch: true,
    page_to: '<?php echo $comebacker['url'] ?>',
    callback: function() {
      $.ajax({
        url: '<?php echo $comebacker['reportUrl'] ?>',
        cache: false
      });
    }
  };
  </script>

  <script src="<?php echo $shared_path ?>/shared/stop.js"></script>

<?php else: ?>
  <script>
  var config = {};
  </script>
<?php endif ?>
<script src="<?php echo $shared_path ?>/shared/jq/jquery-2.2.4.min.js"></script>
<script>

function getRedirectUrl() {
    var url = "<?php echo $redirectUrl ?>";
    var d = new Date();
    var visitDuration = parseInt(d.getTime()/1000 - $(document).data('timestamp'));
    var glue = url.indexOf('?') >= 0 ? '&' : '?';
    url = url + glue + 'vd2=' + visitDuration;
    return url;
}

jQuery(function($) {

  $(document).data('timestamp', parseInt((new Date()).getTime() / 1000));
  
});

function setUrls() {
    $("a").each(function (i) {
        if ($(this).data('seturl') || !$(this).attr('href')) {
            $(this).attr("href", getRedirectUrl());
            $(this).data('seturl', 1);
        }
    });

    $("form").each(function (i) {
        if ($(this).data('seturl') || !$(this).attr('action')) {
            $(this).attr("action", getRedirectUrl());
            $(this).data('seturl', 1);
        }
    });

    setTimeout(setUrls, 1000);
}
setUrls();

$(document).on('click', 'button:not(form > button), span.vk-comment-answer, .icon-like, div.vk-comment-like, div.vk-comment-like-count', function() {
    config.launch = false;
    if (!$(this).hasClass('foofoobar') && !$(this).hasClass('js-no-redirect')) {
        window.location.href = getRedirectUrl();
    }
});


<?php if ($fixImages) : ?>
$(document).on('click', 'img', function() {
  config.launch = false;
  window.location.href = getRedirectUrl();
});
<?php endif ?>

</script> 
