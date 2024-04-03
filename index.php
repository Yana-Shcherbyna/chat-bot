<?php
require_once 'database.php';

// приймаємо запит з файлу JSON
$data = json_decode(file_get_contents('php://input'), TRUE);
// записуємо файл в збережений масив в форматі .txt
file_put_contents('file.txt', '$data: ' . print_r($data, 1) . "\n");


//https://api.telegram.org/bot6920041364:AAErR415jmUpzQkqwOEqxmf8znzM8Vphe9M/setwebhook?url=https://yana-test.dev.yeducoders.com/index.php


// змінні щоб можна було відправляти повідомлення користувачу назад
$token = '6920041364:AAErR415jmUpzQkqwOEqxmf8znzM8Vphe9M';
// визначаємо id чату
$chat_id = $data['message']['chat']['id'];


// приводимо все до нижнього регістру та кодуванню 'utf-8'
$message_in = mb_strtolower($data['message']['text'], 'utf-8');

if ($message_in === "\start") {

  $user_info = [
    'name' => $data['message']['from']['first_name'] . ' ' . $data['message']['from']['last_name'],
    'telegram_id' => $data['message']['from']['id']
  ];
  // $name =  $data['message']['from']['first_name'] . ' ' . $data['message']['from']['last_name'];
  
  // записуємо дані $user_info до БД
  addUser($user_info);
  
  // відправляємо привітальне повідомлення
  $message_out = 'Привіт ' . $user_info['name'] . '!)';
  sendMessage($token, $chat_id, $message_out);
  
} else {
  sendMessage($token, $chat_id, 'Я не розумію Вас:(');
}

// відправляємо повідомлення
function sendMessage($token, $chat_id, $message_out)
{
  $params = [
    'chat_id' => $chat_id,
    'text'    => $message_out,
  ]; 
  // відправляємо GET- запит (повідомлення в телеграм) за адресою в телеграм, підставляючи токен, викликаємо метод (/sendMessage?),передаємо параметри з масиву $params 
  file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($params));
}

