<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="nofollow" />
    <link rel="stylesheet" type="text/css" href="static/style.css" media="all">
    <style>
        body { margin-top: 50px }
        body {
            margin: 30px;
            font-family: "arial";
            text-align: center;
            line-height: 150%;
            font-size: 11pt;
        }

        .p {
            margin: 20px 0;
        }

        h1 {
            /*     border-bottom: 1px dotted #666; */
            line-height: 150%;
            font-size: 28pt;
            font-weight: normal;
        }

        th {
            text-align: right;
            padding-right: 15px;
        }

        table {
            margin-top: 15px;
            border-collapse: collapse;
        }

        td {
            padding: 3px 5px;
            text-align: left;
        }

        tfoot {
            font-weight: bold;
        }

        .order-items {
            margin: 20px auto;
            min-width: 600px;
        }

        .order-items td, .order-items th {
            border: 1px solid #AAA;
            border-color: #AAA;
        }

        .order-items .total {
            text-align: right;
            padding-right: 10px;
        }

        form input[type=text] {
            font-size: 16px;
            line-height: 20px;
            height: 22px;
        }

        form input[type=submit] {
            font-size: 16px;
            height: 40px;
            display: block;
            width: 300px;
            margin: 10px auto;
        }
    </style>
</head>

<body>

<h1>Ошибка! <?= $error_message ?></h1>
<script>
    console.log('error: ', '<?php echo $error_info; ?>');
</script>
</body>
</html>
