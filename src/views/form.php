<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <?php if(!empty($errors)) { 
        echo $errors;
     } ?>
    <form method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?= $recipe ? $recipe['title'] : "" ?>">
        <label for="description">Description</label>
        <textarea name="description" id="description">
        <?= $recipe ? $recipe['description'] : "" ?>
        </textarea>
        <input type="text" name="id" id="id" value="<?= $recipe ? $recipe['id'] : "" ?>" style="display:none">
        <button type="submit">Send</button>
    </form>
</body>
</html>