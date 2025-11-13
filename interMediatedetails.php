<?php
include_once("storage.php");

// Create an instance of the Storage class with JsonIO as the data storage mechanism
$stor = new Storage(new JsonIO('cards.json'));

// Get the card ID from the GET parameter
$cardId = $_GET['card_id'] ?? '';//The card ID is then used to fetch the corresponding card details from the storage.

// Fetch the details of the specified card
$card = $stor->findById($cardId);

// Check if the card exists>>>>>IF $card IS ASSIGNED A VALUE
if ($card) {
    
    header("Location: card_details.php?card_id=$cardId");
    exit();

 }
?>
