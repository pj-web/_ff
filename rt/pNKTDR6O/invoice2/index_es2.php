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
        <title>Pedido aceptado</title>
    <?php endif ?>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
    <style>
    body { margin-top: 50px }

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
    </style>
</head>

<body>

    <h1>Su solicitud ha sido aceptada.</h1>

    <p>
      Gracias por su pedido! <br>
      Nuestro especialista se pondrá en contacto con usted lo antes posible. Por favor, mantenga su teléfono encendido.
    </p>

    <table style="margin: auto">
            
        <tr>
            <th>Usted pidió</th>
            <td>
                <?php foreach($orderInfo['items'] as $item): ?>
                    <p><?php echo $item['name'] ?></p>
                <?php endforeach ?>
            </td>
        </tr>
    
        <tr>
            <th>Pedido Nº:</th>
            <td><?php echo $orderInfo['id'] ?></td>
        </tr>

        <tr>
            <th>Creado:</th>
            <td><?php echo $orderInfo['created_at'] ?></td>
        </tr>

        <tr>
            <th>Nombre:</th>
            <td><?php echo $orderInfo['customer']['name'] ?></td>
        </tr>

        <?php if($orderInfo['customer']['email']): ?>
         <tr>
            <th>E-mail:</th>
            <td><?php echo $orderInfo['customer']['email'] ?></td>
        </tr>
        <?php endif ?>

        <tr>
            <th>Teléfono:</th>
            <td><?php echo $orderInfo['customer']['phone'] ?></td>
        </tr>

    </table>

</body>
</html>
