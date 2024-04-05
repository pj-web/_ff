<?php

        $apiKey = 'oaj38NPGzSy2VgGN7csFnbgLENhaZtddbkhSaWs1O';
        $offer_id = 6981; // для каждого оффера свой айди, надо уточнять его в админке или у суппортов
        $stream_hid = 'vZ6Fdwzn'; // не обязательное, если указано, заявка будет привязана к потоку
        $apiUrl = 'http://api.cpa.tl/api/lead/send';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data_post = $_POST;

            $data = array(
                    'key' => $apiKey,
                    'id' => microtime(true), // тут лучше вставить значение, по которому вы сможете идентифицировать свой лид; можно оставить microtime если у вас нет своей crm
                    'offer_id' => $offer_id,
                    'stream_hid' => $stream_hid,
                    'name' => $data_post['name'],
                    'phone' => $data_post['phone'],
                    'comments' => $data_post['comments'],
                    'country' => $data_post['country'], // формат ISO 3166-1 Alpha-2 - https://ru.wikipedia.org/wiki/ISO_3166-1
                    'address' => $data_post['address'],
                    'tz' => $data_post['timezone_int'], // очень желательно получать его с ленда, но если никак лучше оставить пустым или 3 (таймзона мск)
                    'web_id' => '',
                    'ip_address' => isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            );

            $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data),
                        'ignore_errors' => true,
                    )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($apiUrl, false, $context);

            $obj = json_decode($result);

            if (null === $obj) {
                    // Ошибка в полученном ответе
                    print("Invalid JSON");
                } else if (!empty($obj->errmsg)) {
                    // Ошибка в отправленном запросе
                    print("Ошибка: " . $оbj->errmsg);
                } else {
                    print('ID заявки: ' . $obj->id);
            }

        }