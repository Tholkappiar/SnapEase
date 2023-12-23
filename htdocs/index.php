<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?
        include_once "_libs/load.php"
    ?>
</head>
<body>
    <?
        load_template("header");
    ?>
    <?
        load_template("heroes");
    ?>
    <?
        load_template("album");
    ?>
    <?
        load_template("footer");
    ?>
    
</body>
</html>