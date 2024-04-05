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
<html lang="<?php echo $language; ?>">

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
        <title><?php echo $lang['title']; ?></title>
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

<h1><?php echo $lang['h1']; ?></h1>

<p>
    <?php echo $lang['thanks']; ?><br>
    <?php echo $lang['thanks2']; ?>
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

</table>

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

<?= prepaid_info_html() ?>
</body>
</html>

