<?php

$showOrderContent = true;

require('start.inc.php');
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <?php if (isset($title)): ?>
        <title><?php echo $title ?></title>
    <?php else: ?>
        <title>Заказ принят</title>
    <?php endif ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
    <style>
        body { margin-top: 50px }
    </style>
</head>

<body>

<h1>Ваша заявка принята.</h1>

<!-- <h2>Спасибо за проявленный интерес!</h2> -->

<p>
    Спасибо за Ваш заказ! <br>
    Наш оператор свяжется с Вами в самое ближайшее время. Пожалуйста, включите ваш контактный телефон.
</p>

<table style="margin: auto">

    <tr>
        <th>Вы заказали</th>
        <td>
            <?php foreach($orderInfo['items'] as $item): ?>
                <p><?php echo $item['name'] ?></p>
            <?php endforeach ?>
        </td>
    </tr>

    <tr>
        <th>Заказ №:</th>
        <td><?php echo $orderInfo['id'] ?></td>
    </tr>

    <tr>
        <th>Сделан:</th>
        <td><?php echo $orderInfo['created_at'] ?></td>
    </tr>

    <tr>
        <th>Имя:</th>
        <td><?php echo $orderInfo['customer']['name'] ?></td>
    </tr>

    <?php if($orderInfo['customer']['address']): ?>
        <tr>
            <th>Адрес доставки:</th>
            <td><?php echo $orderInfo['customer']['address'] ?></td>
        </tr>
    <?php endif ?>

    <?php if($orderInfo['customer']['email']): ?>
        <tr>
            <th>E-mail:</th>
            <td><?php echo $orderInfo['customer']['email'] ?></td>
        </tr>
    <?php endif ?>

    <tr>
        <th>Телефон для связи:</th>
        <td><?php echo $orderInfo['customer']['phone'] ?></td>
    </tr>

    <?php if($orderInfo['customer']['comments']): ?>
        <tr>
            <th>Примечание:</th>
            <td><?php echo $orderInfo['customer']['comments'] ?></td>
        </tr>
    <?php endif ?>

</table>
<div class="call-to-action-block" style="display:none">
    <p>Нажмите <b>"Разрешить"</b> для подтверждения заказа!</p>
</div>

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
                <td colspan="3">Стоимость доставки для Вас расчитает оператор.</td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="2">Доставка</td>
                <td class="total"><?php echo $delivery['price'] ?> <?php echo $currencyDisplay ?>.</td>
            </tr>
        <?php endif ?>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">Итого:</th>
            <th class="total"><?php echo $orderInfo['total_price'] ?> <?php echo $currencyDisplay ?>.</th>
        </tr>
        </tfoot>
    </table>
<?php endif ?>

<?= prepaid_info_html() ?>
</body>
</html>

