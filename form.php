<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Анкета разработчика - Задание 3</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .form-content {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        .required::after {
            content: " *";
            color: #e74c3c;
        }
        
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }
        
        .radio-group label {
            display: inline-flex;
            align-items: center;
            font-weight: normal;
            margin-bottom: 0;
            cursor: pointer;
        }
        
        .radio-group input {
            width: auto;
            margin-right: 8px;
        }
        
        select[multiple] {
            height: 150px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
        }
        
        .checkbox-group input {
            width: auto;
            margin-right: 10px;
        }
        
        .checkbox-group label {
            margin-bottom: 0;
            font-weight: normal;
        }
        
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        
        .success-message {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
        }
        
        small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Анкета разработчика</h1>
            <p>Заполните форму, чтобы стать частью нашего сообщества</p>
        </div>
        <div class="form-content">
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
                <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label class="required">ФИО</label>
                    <input type="text" name="fio" value="<?= htmlspecialchars($_POST['fio'] ?? '') ?>" 
                           maxlength="150" placeholder="Иванов Иван Иванович">
                </div>
                
                <div class="form-group">
                    <label class="required">Телефон</label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" 
                           placeholder="+7 (123) 456-78-90">
                </div>
                
                <div class="form-group">
                    <label class="required">E-mail</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                           placeholder="ivanov@example.com">
                </div>
                
                <div class="form-group">
                    <label class="required">Дата рождения</label>
                    <input type="date" name="birth_date" value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <label class="required">Пол</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="male" 
                                   <?= (($_POST['gender'] ?? '') == 'male') ? 'checked' : '' ?>> Мужской
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" 
                                   <?= (($_POST['gender'] ?? '') == 'female') ? 'checked' : '' ?>> Женский
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="required">Любимый язык программирования</label>
                    <select name="languages[]" multiple="multiple">
                        <option value="Pascal">Pascal</option>
                        <option value="C">C</option>
                        <option value="C++">C++</option>
                        <option value="JavaScript">JavaScript</option>
                        <option value="PHP">PHP</option>
                        <option value="Python">Python</option>
                        <option value="Java">Java</option>
                        <option value="Haskell">Haskell</option>
                        <option value="Clojure">Clojure</option>
                        <option value="Prolog">Prolog</option>
                        <option value="Scala">Scala</option>
                        <option value="Go">Go</option>
                    </select>
                    <small>Удерживайте Ctrl (Cmd) для выбора нескольких языков</small>
                </div>
                
                <div class="form-group">
                    <label>Биография</label>
                    <textarea name="biography" rows="5" placeholder="Расскажите немного о себе..."><?= htmlspecialchars($_POST['biography'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="contract_accepted" value="1" 
                               <?= (($_POST['contract_accepted'] ?? '') == '1') ? 'checked' : '' ?>>
                        <label class="required">Я ознакомлен(а) с контрактом и согласен(на)</label>
                    </div>
                </div>
                
                <button type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</body>
</html>
