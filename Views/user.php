<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main>
        <h4>Liste des utilisateurs</h4>
        <?php foreach($data['users'] as $user){
            echo $user."<br>";
        }
         ?>
    </main>

    <?php require_once 'layout/footer.php'; ?>
</body>
</html>
