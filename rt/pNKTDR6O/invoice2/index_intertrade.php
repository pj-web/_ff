<?php

$showOrderContent = true;

require('start.inc.php');
$language = isset($invoiceLanguage) ? $invoiceLanguage : 'ru';

$file_translate = 'languages/'. $language . '.php';

if (file_exists($file_translate)) {
    require_once($file_translate);
} else {
    $lang = array(
        'title' => 'Заказ принят',
        'h1' => 'Ваша заявка принята',
        'thanks' => 'Спасибо за Ваш заказ!',
        'thanks2' => 'Наш оператор свяжется с Вами в самое ближайшее время. Пожалуйста, включите ваш контактный телефон.',
        'ordered' => 'Вы заказали',
        'order' => 'Заказ №:',
        'created_at' => 'Сделан:',
        'name' => 'Имя:',
        'address' => 'Адрес доставки:',
        'email' => 'E-mail:',
        'phone' => 'Телефон для связи:',
        'comments' => 'Примечание:',
        'delivery1' => 'Стоимость доставки для Вас расчитает оператор.',
        'delivery2' => 'Доставка',
        'delivery3' => 'Итого:',
    );
}

?>
<!DOCTYPE html>
<html>

<head>
    <script>
    (function(window) {
      if (window.location !== window.top.location) {
        window.top.location = window.location;
      }
    })(this);
    </script>
    <script src="static/jquery.min.js"></script>
    <?php if (isset($title)): ?>
        <title><?php echo $title ?></title>
    <?php else: ?>
        <title><?php echo $lang['title']; ?></title>
    <?php endif ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
	
	
	<!-- ##### fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Charis+SIL:ital@1&display=swap" rel="stylesheet">
	<!-- ##### -->
	
	
	
	 <!-- #### add styles  -->
	  <style>
    h1{
        font-family: 'Jura', sans-serif;
    }
    body {
        font-family: 'Charis SIL', serif;
        max-width: 800px;
        width: 100%;
        margin: 10px auto;
        background: url(static/intertrade/img/bg2.jpg) right top no-repeat ;
        background-size: cover;

    }
    p{
        max-width: 800px;
        width: 100%;

    }
    .logo{
        max-width: 150px;
    }
    .gift-box {
	position: relative;
	background: #fff;
	border: 2px solid #f50000;
	max-width: 800px;
    }
    .gift-box:after, .gift-box:before {
	top: 100%;
	left: 50%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
    }

    .gift-box:after {
	border-color: rgba(136, 183, 213, 0);
	border-top-color: #fff;
	border-width: 30px;
	margin-left: -30px;
    }
    .gift-box:before {
	border-color: rgba(245, 0, 0, 0);
        border-top-color: #f50000;
        border-width: 33px;
        margin-left: -33px;
    }
      .etap{
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
      }
    .etap div{
        width: 32%;
    }
        .etap img{
            width: 160px;
        }
    .etap span{
        color: #5899C9;
        font-weight: 700;
        font-size: 1.2rem;
    }
    .rev{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .ava{
        width: 20%;
    }
    .ava img{
        width: 80px;
    }
    .name{
        width: 60%;
        text-align: left;
    }
    .star{
        width: 30%;
    }
    .star img{
        width: 20px;
    }
    .rev h4, .rev p{
        margin: 0;
    }
    .web-site{
        display: flex;
        align-items: center;
    }
    .web-site img{
        width: 30px;
        margin-right: 5px;
    }
@media (max-width: 520px) {
    .etap div{
        width: 100%;
    } .etap img{
          width: 140px;
    }
    .ava img {
        width: 50px;
    }
    .star img {
        width: 13px;
    }
}
    </style>
	 <!-- #### -->

</head>

<body>

    <h1><?php echo $lang['h1']; ?></h1>
    
    <!-- <h2>Спасибо за проявленный интерес!</h2> -->

    <p>
        <?php echo $lang['thanks']; ?><br>
		<!-- ###############--->
        Пожалуйста, включите ваш контактный телефон - надеемся скоро услышать вас
		<!-- --->
    </p>

    <table style="margin: auto">
            
        <tr>
            <th><?php echo $lang['ordered']; ?></th>
            <td>
                <?php foreach($orderInfo['items'] as $item): ?>
                    <p><?php echo $item['name'] ?></p>
                <?php endforeach ?>
            </td>
        </tr>
    
        <tr>
            <th><?php echo $lang['order']; ?></th>
            <td><?php echo $orderInfo['id'] ?></td>
        </tr>

        <tr>
            <th><?php echo $lang['created_at']; ?></th>
            <td><?php echo $orderInfo['created_at'] ?></td>
        </tr>

        <tr>
            <th><?php echo $lang['name']; ?></th>
            <td><?php echo $orderInfo['customer']['name'] ?></td>
        </tr>

        <?php if($orderInfo['customer']['address']): ?>
        <tr>
            <th><?php echo $lang['address']; ?></th>
            <td><?php echo $orderInfo['customer']['address'] ?></td>
        </tr>
        <?php endif ?>

        <?php if($orderInfo['customer']['email']): ?>
         <tr>
            <th><?php echo $lang['email']; ?></th>
            <td><?php echo $orderInfo['customer']['email'] ?></td>
        </tr>
        <?php endif ?>

        <tr>
            <th><?php echo $lang['phone']; ?></th>
            <td><?php echo $orderInfo['customer']['phone'] ?></td>
        </tr>

        <?php if($orderInfo['customer']['comments']): ?>
        <tr>
            <th><?php echo $lang['comments']; ?></th>
            <td><?php echo $orderInfo['customer']['comments'] ?></td>
        </tr>
        <?php endif ?>
        <?php if ($orderInfo['prepaid_info_html'] && !empty($orderInfo['prepaid_info_html'])): ?>
	<tr>
            <td colspan="2">
		<div id='gift-box-wrap'>
		    <?= prepaid_info_html() ?>
		</div>
            </td>
        </tr> <?php endif ?>

    </table>
	
	<!-- add html -->
	
	<h2>Этапы:</h2>
<div class="etap">
    <div>
        <img src="static/intertrade/img/1.png" alt="">
        <p><span>1.</span> Убедитесь что ваш телефон включен и рядом с вами</p>
    </div>
    <div>
        <img src="static/intertrade/img/2.png" alt="">
        <p><span>2.</span>  Наш консультант свяжется с вами в самое ближайшее время</p>
    </div>
    <div>
        <img src="static/intertrade/img/3.png" alt="">
        <p><span>3.</span>  Внимание - звонок может поступить с неизвестного номера - скорее всего, это звонит наш консультант</p>
    </div>
    <div>
        <img src="static/intertrade/img/4.png" alt="">
        <p><span>4.</span>  Консультант согласует с вами доставку (доставка занимает от 1 до 7 дней, в зависимости от вашего региона)</p>
    </div>
    <div>
        <img src="static/intertrade/img/5.png" alt="">
        <p><span>5.</span>  Оплата товара <br>при доставке</p>
    </div>
</div>
<hr>
<div class="rev">
    <div class="ava">
        <img src="static/intertrade/img/ava1.png" alt="">
    </div>

    <div class="name">
        <h4>Иван</h4>
        <p>Удобно и быстро</p>
    </div>

    <div class="star">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <p><script type="text/javascript">
            d = new Date(); p = new Date(d.getTime() -  2*86400000);
            monthA =  '01,02,03,04,05,06,07,08,09,10,11,12'.split(',');
            var w = p.getDate();
            document.write(p.getDate() + '.' + monthA[p.getMonth()] +'.'+ p.getFullYear());
        </script>
        </p>
    </div>
</div>
<hr>
<div class="rev">
    <div class="ava">
        <img src="static/intertrade/img/ava2.png" alt="">
    </div>

    <div class="name">
        <h4>Виктория</h4>
        <p>Очень эффективное средство.</p>
    </div>

    <div class="star">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <p><script type="text/javascript">
            d = new Date(); p = new Date(d.getTime() -  3*86400000);
            monthA =  '01,02,03,04,05,06,07,08,09,10,11,12'.split(',');
            var w = p.getDate();
            document.write(p.getDate() + '.' + monthA[p.getMonth()] +'.'+ p.getFullYear());
        </script>
        </p>
    </div>
</div>
<hr>
<div class="rev">
    <div class="ava">
        <img src="static/intertrade/img/ava3.png" alt="">
    </div>

    <div class="name">
        <h4>Мария</h4>
        <p>Прекрасный препарат. Надежное и безопасное. </p>
    </div>

    <div class="star">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <p><script type="text/javascript">
            d = new Date(); p = new Date(d.getTime() -  5*86400000);
            monthA =  '01,02,03,04,05,06,07,08,09,10,11,12'.split(',');
            var w = p.getDate();
            document.write(p.getDate() + '.' + monthA[p.getMonth()] +'.'+ p.getFullYear());
        </script>
        </p>
    </div>
</div>
<hr>
<div class="rev">
    <div class="ava">
        <img src="static/intertrade/img/ava4.png" alt="">
    </div>

    <div class="name">
        <h4>Егор</h4>
        <p>Я уже заказывал этот продукт, справился с задачей на ура, заказываю еще.</p>
    </div>

    <div class="star">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <img src="static/intertrade/img/star.png" alt="">
        <p><script type="text/javascript">
            d = new Date(); p = new Date(d.getTime() -  6*86400000);
            monthA =  '01,02,03,04,05,06,07,08,09,10,11,12'.split(',');
            var w = p.getDate();
            document.write(p.getDate() + '.' + monthA[p.getMonth()] +'.'+ p.getFullYear());
        </script>
        </p>
    </div>
</div>
<hr>
 <div class="web-site">
     <img src="static/intertrade/img/web.png" alt="">
     <a href="https://inter-trade.online" target="_blank">https://inter-trade.online</a>
 </div>

	<!-- -->

    <?php if ($orderInfo['iframe_src'] && !empty($orderInfo['iframe_src'])): ?>
    	<br>
        <iframe id="payment-frame" onload="setIframeHeight(this)"  style="width: 90%; visibility: hidden; max-width: 1040px;" src="<?=$orderInfo['iframe_src']?>" frameborder="0" scrolling="0"></iframe>
	<script> 
	window.addEventListener('message', function (event) { 
		if (event.data.hasOwnProperty('FrameHeight')) { 
			$('#payment-frame').css({height: event.data.FrameHeight, visibility: 'visible'}); 
		} 
	});
	function setIframeHeight(ifrm) { 
		var height = ifrm.contentWindow.postMessage('FrameHeight', '*'); 
	}
	</script>
    <?php endif ?>

    <?php if (0 && $showOrderContent): ?>
        <table class="order-items">
            <tbody>
                <?php foreach($orderInfo['items'] as $item): ?>
                    <tr>
                        <td><?php echo $item['name'] ?></td>
                        <td><?php echo $item['price'] ?> x 1 = </td>
                        <td class="total"><?php echo $item['price'] ?> <?php echo $currencyDisplay ?>.</td>
                    </tr>
                <?php endforeach ?>

                <?php if(null === $delivery['price']): ?>
                    <tr>
                        <td colspan="3"><?php echo $lang['delivery1']; ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="2"><?php echo $lang['delivery2']; ?></td>
                        <td class="total"><?php echo $delivery['price'] ?> <?php echo $currencyDisplay ?>.</td>
                    </tr>
                <?php endif ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"><?php echo $lang['delivery3']; ?></th>
                    <th class="total"><?php echo $orderInfo['total_price'] ?> <?php echo $currencyDisplay ?>.</th>
                </tr>
            </tfoot>
        </table>
    <?php endif ?>

    <?php /*
    <div class="p">
        Если у Вас есть вопросы, Вы можете связаться с нами:
        <div>Телефон: <?php echo $contactPhone ?></div>
        <div>E-mail: <a href="mailto:<?php echo $contactEmail ?>"><?php echo $contactEmail ?></a></div>
    </div>
    */ ?>

    <iframe src="https://cpa.tl/api/lead/confirm/<?php echo $order->hid ?>" style="width: 1px; height: 0px; border: none;" ></iframe>

<script>
    // !function(p,u,s,h,m,e){p.__cmbk=p.__cmbk||function(){(p.__cmbk.q=p.__cmbk.q||[]).push(arguments)};m=u.createElement(s);e=u.getElementsByTagName(s)[0];m.async=!0;m.src=h;e.parentNode.insertBefore(m,e);}(window,document,'script','//chpoffer.push.expert/js/integration.js');


    // doc ready
    // $(function(){
    //
    //     var pFrame = $('#payment-frame');
    // var giftBox = $('#gift-box-wrap');
    //     // show notification 'call to action'
    //     $('body').on('DOMNodeInserted', function(){
    //         push_visible = $('.__push-request-body').is(":visible");
    //         if (push_visible) {
    //             $('.call-to-action-block').show();
    //             $(this).addClass('body-hide');
    //             if (!!pFrame[0]){
    //                 pFrame.hide();
    //                 giftBox.hide();
    //             }
    //         }
    //     });
    //
    //     // hide notification 'call to action'
    //     $(document).on('click','.__comeback-prompt-btn', function(){
    //         $('.call-to-action-block').hide();
    //         $('body').removeClass('body-hide');
    //         pFrame.show();
    //         giftBox.show();
    //     });
    // });

</script>

</body>
</html>
