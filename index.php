<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $category = $_POST["category"];
    $header = $_POST["header"];
    $text = $_POST["text"];
    

    if (!empty($email) && !empty($category) && !empty($header) && !empty($text)) {
        if ($category == "interior") $filename = "interior";
        if ($category == "tableware") $filename = "tableware";
        if ($category == "housetech") $filename = "housetech";
        $filename .= "/" . $header . ".txt";
        file_put_contents($filename, "Email: $email\n\n$text");
    }
}


$cells = [];
$categories = ["interior", "tableware", "housetech"];
foreach ($categories as $cater) {
    $files = glob("$cater/*.txt");
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $cells[] = [
            "category" => $cater,
            "header" => pathinfo($file, PATHINFO_FILENAME),
            "text" => $content
        ];
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
            <title>бурито.ру</title>
			<meta charset="utf-8"/>
            <style>td, th { border: 0.05vw; padding-right: 3vw; padding-top: 1vh; }</style>
    </head>
    <body>
        <br>
        <h2>Добавить объявление</h2>
        <form method="POST">
            <label>адрес email</label>
            <input type="text" name="email">
            <br>
            <label>выберите категорию</label>
            <select name="category" required>
                <option value="interior">интерьер</option>
                <option value="tableware">посуда</option>
                <option value="housetech">бытовая техника</option>
            </select>
            <br>
            <label>заголовок</label>
            <input type="text" name="header">
            <br>
            <label>описание</label>
            <input type="text" name="text">
            <br>
            <button type="submit">добавить объявление</button>
        </form>
        <br>
        <h2>Список объявлений</h2>
        <table>
            <tr>
                <th>Категория</th>
                <th>Заголовок</th>
                <th>Содержание</th>
            </tr>
            <?php foreach ($cells as $cell): ?>
            <tr>
                <td><?php
                    if ($cell["category"] == "interior") echo htmlspecialchars("интерьер");
                    if ($cell["category"] == "tableware") echo htmlspecialchars("посуда");
                    if ($cell["category"] == "housetech") echo htmlspecialchars("бытовая техника");
                    ?>
                </td>
                <td><?= htmlspecialchars($cell["header"]) ?></td>
                <td><pre><?= htmlspecialchars($cell["text"]) ?></pre></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>