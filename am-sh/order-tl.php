<?php 
  $apiKey = 'oaj38NPGzSy2VgGN7csFnbgLENhaZtddbkhSaWs1O'; // Примичание от Ильи: указан api пользователя который предоставил доступ
  $offer_id = 6887; // для каждого оффера свой айди, надо уточнять его в админке или у суппортов "Примечание от Ильи: указан id оффера 'Видеорегистратор Neoline X-COP 9100S за 1990 руб (Без МО и МСК)' но лучше уточнить правильный ли id у саппорта"
  $stream_hid = 'wV6UojGb'; // не обязательное, если указано, заявка будет привязана к потоку "Примечание от Ильи: Указан уникальный код потока, дляоффера 'Видеорегистратор Neoline X-COP 9100S за 1990 руб (Без МО и МСК)' работоспособность не проверенна!"
  $apiUrl = 'http://api.cpa.tl/api/lead/send'; // Это поле не менять!!!!

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
              'ip_address' => $_SERVER['REMOTE_ADDR'],
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
              $str = "Invalid JSON";
              $fp = fopen('formData.txt', 'a');
              fwrite($fp, $str . PHP_EOL);
              fclose($fp);              
          } else if (!empty($obj->errmsg)) {
              // Ошибка в отправленном запросе
              $str = "Ошибка: " . $obj->errmsg;
              $fp = fopen('formData.txt', 'a');
              fwrite($fp, $str . PHP_EOL);
              fclose($fp);
          } else {
              // Успешная отправка
              $str = "Country: {$data['country']}; Fio: {$data['name']}; Phone: {$data['phone']}; UserIp: {$data['ip_address']}; UserAgent: {$data['user_agent']}; OrderTime: {$data['tz']};";
              $fp = fopen('formData.txt', 'a');
              fwrite($fp, $str . PHP_EOL);
              fclose($fp);
      }

  header('Location: https://amulet-schit.ru/success.php'); // Вместо site_url указать свой домен

  }
?>
