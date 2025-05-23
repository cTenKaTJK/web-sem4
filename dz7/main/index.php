<!DOCTYPE html>
<head>
    <title>PblHOK</title>
</head>

<body>
    <div>
        <h2>Объявления:</h2>
        <table>
            <tr>
                <td><b>email</b></td>
                <td><b>Название</b></td>
                <td><b>Описание</b></td>
                <td><b>Категория</b></td>
            </tr>
            <?php foreach (require 'get.php' as $ad): ?>
                <tr>
                    <td><?=$ad['email']?></td>
                    <td><?=$ad['title']?></td>
                    <td><?=$ad['description']?></td>
                    <td><?=$ad['category']?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div>
        <h4>Добавить свое объявление:</h4>
        <form method="post", action="post.php">
            email: <input type="email" name="email"><br>
            Название: <input type="text" name="title"><br>
            Категория:
            <select name="category">
                <option>Игры</option>
                <option>Фильмы</option>
                <option>Сериалы</option>
            </select><br>
            Описание: <label><textarea name="description"></textarea></label><br>
            <button>Отправить</button>
        </form>
    </div>
</body>
