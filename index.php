<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($friendsArray as $friend) : ?>
    <ul>
        <li><?= $friend['firstname'] . " " . $friend['lastname']; ?></li>
    </ul>
<?php endforeach;

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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if (!isset($firstname) || empty($firstname)) {
        $errors[] = 'Le prénom est obligatoire.';
    }

    if (strlen($firstname) > 45) {
        $errors[] = 'Le prénom est trop long.';
    }

    if (!isset($lastname) || empty($lastname)) {
        $errors[] = 'Le nom de famille est obligatoire.';
    }

    if (strlen($lastname) > 45) {
        $errors[] = 'Le nom de famille  est trop long.';
    }

    foreach ($errors as $error) : ?>
        <li><?= $error ?></li>
<?php endforeach;

    if (empty($errors)) {
        saveRecipe($firstname, $lastname);
        header("result.php");
        exit;
    }
}


function saveRecipe($firstname, $lastname)
{
    $pdo = new \PDO(DSN, USER, PASS);

    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $statement->execute();
}

?>