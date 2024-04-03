<?php

class DB
{
  const DSN = "mysql:host=localhost;dbname=dev_candidate_15;port=3306;";
  const USERNAME = 'dev_candidate_15';
  const PASSWORD = 'DHznK2m6bv';

  public static function getBbconnection()
  {

    try {
      $pdo = new PDO(self::DSN, self::USERNAME, self::PASSWORD);
      return $pdo;
    } catch (PDOException $exception) {
      echo 'Error: ' . $exception->getMessage();
      return null;
    }
  }
}


// функція яка додає користувачів в БД
function addUser(array $user_info)
{
  $pdo = DB::getBbconnection();

  // записуємо ID користувача
  $userId = $user_info['telegram_id'];

  // перевіряємо, чи є користувач з таким ID в БД
  $sqlReq = "SELECT * FROM test_chat_bot WHERE telegram_id = ?";
  $stmtReq = $pdo->prepare($sqlReq);
  $stmtReq->execute([$userId]);

  // отримуємо відповідь (true'1'-якщо є, false'0'-якщо немає)
  $response = $stmtReq->fetch(PDO::FETCH_ASSOC);

  //якщо такого користувача немає, то додаємо його до БД 
  if (!$response) {
    $sql = "INSERT INTO test_chat_bot (name, telegram_id) VALUES (:name, :telegram_id)";
    $stmt = $pdo->prepare($sql);

    // Зв'язуємо параметри з масивом користувача
    $stmt->bindParam(':name', $user_info['name']);
    $stmt->bindParam(':telegram_id', $user_info['telegram_id']);

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo "Error: {$e->getMessage()}";
    }
  }
}
