<?php
header('Content-Type: text/html; charset=UTF-8');

$db_user = 'u82591';
$db_pass = '2762718';
$db_name = 'u82591';

$error_message = '';
$success_message = '';

$allowed_languages = ['Pascal', 'C', 'C++', 'JavaScript', 'PHP', 'Python',
                      'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala', 'Go'];


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        $success_message = 'Данные успешно сохранены!';
    }
    include('form.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    // 1. ФИО
    $fio = trim($_POST['fio'] ?? '');
    if (empty($fio)) {
        $errors[] = 'Заполните ФИО';
    } elseif (strlen($fio) > 150) {
        $errors[] = 'ФИО не должно превышать 150 символов';
    } elseif (!preg_match('/^[\p{L}\s\-]+$/u', $fio)) {
        $errors[] = 'ФИО должно содержать только буквы, пробелы и дефисы';
    }

    // 2. Телефон
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        $errors[] = 'Заполните телефон';
    }
    // 3. Email
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $errors[] = 'Заполните email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Введите корректный email';
    }
    // 4. Дата рождения
    $birth_date = $_POST['birth_date'] ?? '';
    if (empty($birth_date)) {
        $errors[] = 'Заполните дату рождения';
    }

    // 5. Пол
    $gender = $_POST['gender'] ?? '';
    if (!in_array($gender, ['male', 'female'])) {
        $errors[] = 'Выберите пол';
    }
    // 6. Языки
    $languages = $_POST['languages'] ?? [];
    if (empty($languages)) {
        $errors[] = 'Выберите хотя бы один язык программирования';
    } else {
        foreach ($languages as $lang) {
            if (!in_array($lang, $allowed_languages)) {
                $errors[] = 'Некорректный язык: ' . htmlspecialchars($lang);
                break;
            }
        }
    }
    // 7. Биография
    $biography = trim($_POST['biography'] ?? '');
    if (strlen($biography) > 5000) {
        $errors[] = 'Биография не должна превышать 5000 символов';
    }
    // 8. Чекбокс
    $contract_accepted = isset($_POST['contract_accepted']) ? 1 : 0;
    if (!$contract_accepted) {
        $errors[] = 'Необходимо подтвердить ознакомление с контрактом';
    }
    // Если есть ошибки
    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        include('form.php');
        exit();
    }
    // Сохранение в БД
    try {
        $db = new PDO("mysql:host=localhost;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        // Вставка основной записи
        $stmt = $db->prepare("INSERT INTO application (fio, phone, email, birth_date, gender, biography, contract_accepted) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fio, $phone, $email, $birth_date, $gender, $biography, $contract_accepted]);
        $app_id = $db->lastInsertId();
        // Получаем ID языков
        $placeholders = implode(',', array_fill(0, count($languages), '?'));
        $stmt_lang = $db->prepare("SELECT id, name FROM programming_languages WHERE name IN ($placeholders)");
        $stmt_lang->execute($languages);
        $lang_map = [];
        while ($row = $stmt_lang->fetch(PDO::FETCH_ASSOC)) {
            $lang_map[$row['name']] = $row['id'];
        }
        // Вставляем связи
        $stmt_link = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
        foreach ($languages as $lang) {
            if (isset($lang_map[$lang])) {
                $stmt_link->execute([$app_id, $lang_map[$lang]]);
            }
        }
        $db->commit();
        header('Location: ?save=1');
        exit();
    } catch (PDOException $e) {
        $db->rollBack();
        $error_message = 'Ошибка БД: ' . $e->getMessage();
        include('form.php');
        exit();
    }
}
?>
