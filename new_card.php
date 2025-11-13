<?php
include_once("storage.php");

$stor = new Storage(new JsonIO('cards.json'));
$userStor = new Storage(new JsonIO('users.json'));

$errors = [];
$selectedName = $_POST['name'] ?? '';

// Predefined allowed Pokémon cards
$allowedCards = ["Pikachu", "Charizard", "Bulbasaur", "Squirtle", "Caterpie", "Weedle", "Pidgey", "Rattata", "Spearow", "Ekans"];

if ($_POST) {
    if (!in_array($selectedName, $allowedCards)) {
        $errors['name'] = 'You cannot create this card because it does not exist in the database!';
    }

    if (count($errors) === 0) {
        $card = createCard($selectedName);

        $stor->add($card);
        $adminUserId = "65a34019f2372";
        $admin = $userStor->findById($adminUserId);
        $admin['cards'][] = $card['name'];
        $admin['noOfCards']++;
        $userStor->update($admin['id'], $admin);

        echo "<h2>You have successfully created the {$selectedName} card!</h2>";
        echo "<img src='{$card['image']}' alt='{$card['name']}' style='max-width: 100%; height: auto;'>";
    }
}
// Function to create a card based on its name
function createCard($name) {
    switch ($name) {
        case 'Pikachu':
            return [
                "name" => "Pikachu",
                "type" => "electric",
                "hp" => 60,
                "attack" => 20,
                "defense" => 20,
                "price" => 160,
                "description" => "Pikachu that can generate powerful electricity have cheek sacs that are extra soft and super stretchy.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/025.png",
                "owner" => "admin"
            ];

        case 'Charizard':
            return [
                "name" => "Charizard",
                "type" => "fire",
                "hp" => 78,
                "attack" => 84,
                "defense" => 78,
                "price" => 534,
                "description" => "It spits fire that is hot enough to melt boulders. It may cause forest fires by blowing flames.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/006.png",
                "owner" => "admin"
            ];

        case 'Bulbasaur':
            return [
                "name" => "Bulbasaur",
                "type" => "grass",
                "hp" => 45,
                "attack" => 49,
                "defense" => 49,
                "price" => 318,
                "description" => "A strange seed was planted on its back at birth. The plant sprouts and grows with this POKéMON.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/001.png",
                "owner" => "admin"
            ];

        case 'Squirtle':
            return [
                "name" => "Squirtle",
                "type" => "water",
                "hp" => 44,
                "attack" => 48,
                "defense" => 65,
                "price" => 314,
                "description" => "After birth, its back swells and hardens into a shell. Powerfully sprays foam from its mouth.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/007.png",
                "owner" => "admin"
            ];

        case 'Caterpie':
            return [
                "name" => "Caterpie",
                "type" => "bug",
                "hp" => 45,
                "attack" => 30,
                "defense" => 35,
                "price" => 195,
                "description" => "Its short feet are tipped with suction pads that enable it to tirelessly climb slopes and walls.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/010.png",
                "owner" => "admin"
            ];

        case 'Weedle':
            return [
                "name" => "Weedle",
                "type" => "bug",
                "hp" => 40,
                "attack" => 35,
                "defense" => 30,
                "price" => 195,
                "description" => "Often found in forests, eating leaves. It has a sharp venomous stinger on its head.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/013.png",
                "owner" => "admin"
            ];

        case 'Pidgey':
            return [
                "name" => "Pidgey",
                "type" => "normal",
                "hp" => 40,
                "attack" => 45,
                "defense" => 40,
                "price" => 251,
                "description" => "A common sight in forests and woods. It flaps its wings at ground level to kick up blinding sand.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/016.png",
                "owner" => "admin"
            ];

        case 'Rattata':
            return [
                "name" => "Rattata",
                "type" => "normal",
                "hp" => 30,
                "attack" => 56,
                "defense" => 35,
                "price" => 253,
                "description" => "Bites anything when it attacks. Small and very quick, it is a common sight in many places.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/019.png",
                "owner" => "admin"
            ];

        case 'Spearow':
            return [
                "name" => "Spearow",
                "type" => "normal",
                "hp" => 40,
                "attack" => 60,
                "defense" => 30,
                "price" => 262,
                "description" => "Eats bugs in grassy areas. It has to flap its short wings at high speed to stay airborne.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/021.png",
                "owner" => "admin"
            ];

        case 'Ekans':
            return [
                "name" => "Ekans",
                "type" => "poison",
                "hp" => 35,
                "attack" => 60,
                "defense" => 44,
                "price" => 288,
                "description" => "Moves silently and stealthily. Eats the eggs of birds, such as PIDGEY and SPEAROW, whole.",
                "image" => "https://assets.pokemon.com/assets/cms2/img/pokedex/full/023.png",
                "owner" => "admin"
            ];

        default:
            return [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Card</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Create New Card</h2>
    <a href="index.php" style="
    display: inline-block;
    background-color: #000;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
" onmouseover="this.style.backgroundColor='#333'" onmouseout="this.style.backgroundColor='#000'">
    &#8592; Back to Main Page
</a>


    <ul style="color: red;">
        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>

    <form action="new_card.php" method="POST" novalidate>
        <label for="name">Select Card:</label>
        <select name="name" id="name" required>
            <option value="" disabled <?= $selectedName === '' ? 'selected' : '' ?>>-- Choose a Pokémon --</option>
            <?php foreach ($allowedCards as $cardName): ?>
                <option value="<?= $cardName ?>" <?= $selectedName === $cardName ? 'selected' : '' ?>>
                    <?= $cardName ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
