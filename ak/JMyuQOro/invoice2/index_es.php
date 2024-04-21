<?php

$showOrderContent = false;

require('start.inc.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php if (isset($title)): ?>
        <title><?php echo $title ?></title>
    <?php else: ?>
        <title>Pedido hecho con éxito</title>
    <?php endif ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
</head>

<body>

<h1>Pedido hecho con éxito.</h1>

<p>
    Gracias por su pedido! Nuestro operador se pondrá en contacto con Usted dentro de un día hábil.
    <br>
    Por favor, incluya su número de teléfono.
</p>

<table style="margin: auto">

    <tr>
        <th>Pedido №:</th>
        <td><?php echo $orderInfo['id'] ?></td>
    </tr>

    <tr>
        <th>Hecho:</th>
        <td><?php echo $orderInfo['created_at'] ?></td>
    </tr>

    <tr>
        <th>Nombre:</th>
        <td><?php echo $orderInfo['customer']['name'] ?></td>
    </tr>

    <?php if($orderInfo['customer']['address']): ?>
        <tr>
            <th>La dirección de envío:</th>
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
        <th>Teléfono de contacto:</th>
        <td><?php echo $orderInfo['customer']['phone'] ?></td>
    </tr>

    <?php if($orderInfo['customer']['comments']): ?>
        <tr>
            <th>Nota:</th>
            <td><?php echo $orderInfo['customer']['comments'] ?></td>
        </tr>
    <?php endif ?>

</table>

<?php if ($showOrderContent): ?>
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
                <td colspan="3">El costo de envío lo calculará el operador.</td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="2">Envío</td>
                <td class="total"><?php echo $delivery['price'] ?> <?php echo $currencyDisplay ?>.</td>
            </tr>
        <?php endif ?>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">Total:</th>
            <th class="total"><?php echo $orderInfo['total_price'] ?> <?php echo $currencyDisplay ?>.</th>
        </tr>
        </tfoot>
    </table>
<?php endif ?>

</body>
</html>


