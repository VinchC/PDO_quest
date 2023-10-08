<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

?>

<form action="" method="post">
    <div>
        <label for="firstname">Prénom : </label>
        <input type="text" id="firstname" name="firstname">
    </div>

    <div>
        <label for="lastname">Nom de famille : </label>
        <input type="text" id="lastname" name="lastname">
    </div>

    <div class="buttonsLine">
        <button type="submit">Envoyer</button>
    </div>
</form>

<?php


function saveRecipe($firstname, $lastname)
{
    $pdo = new \PDO(DSN, USER, PASS);

    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $statement->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!isset($firstname) || empty($firstname)) {
        $errors[] = 'Le prénom est obligatoire.';
    }

    if (!isset($lastname) || empty($lastname)) {
        $errors[] = 'Le nom de famille est obligatoire.';
    }
    foreach ($errors as $error) : ?>
        <li><?= $error ?></li>
<?php endforeach;

    if (empty($errors)) {
        saveRecipe($firstname, $lastname);
        header('index.php');
        exit;
    }
}
