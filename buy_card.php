<?php
session_start();


// Include your storage class and other necessary files
include_once("storage.php");

// Assuming the storage class can handle updating data
$cardStorage = new Storage(new JsonIO('cards.json'));
$userStorage = new Storage(new JsonIO('users.json'));

if (isset($_SESSION['user_id']) && isset($_POST['card_id'])) {
    $userId = $_SESSION['user_id'];
    $cardId = $_POST['card_id'];

    // Retrieve the card details
    $card = $cardStorage->findById($cardId);
    $user = $userStorage->findById($userId);
    // Check if the user has enough money and hasn't reached the card limit
    //if ($_SESSION['money'] >= $card['price'] && $_SESSION['noOfCards'] < 5) {
    if ($user['amountOfMoneyInWallet'] >= $card['price'] && $user['noOfCards'] < 5) {
        // these changes won't persist beyond the current execution of the script or the user's session. If the user logs out, closes the browser, or the server restarts, the changes will be lost.
        // Update user's data
        
        $user['amountOfMoneyInWallet'] -= $card['price'];
        $user['noOfCards'] += 1;
        $user['cards'][] = $card['name'];

        // Update card's data
        $card['owner'] = $user['username'];

         // Save updated user data
         //$userStorage->update($userId, $user);

        // Remove the bought card from admin's cards array
        $adminUserId = "65a34019f2372"; //fixed admin user ID
        $admin = $userStorage->findById($adminUserId);
        $adminCardIndex = array_search($card['name'], $admin['cards']);
        
        if ($adminCardIndex !== false) {
            unset($admin['cards'][$adminCardIndex]);
            $admin['noOfCards'] -= 1;

            // Save updated admin data
            $userStorage->update($adminUserId, $admin);
        }

        // Remove the card from the available cards
        $cardStorage->delete($cardId);
        // // Save updated data>>These lines are responsible for persisting the changes made to the user and card data back to your storage system.  is to make these changes permanent in your data storage system (e.g., JSON files). It ensures that the modifications persist across different sessions, even after the user logs out and logs back in.  I DON'T THINK I NEED THIS PROPERTY NOW BECAUSE THE PROFESSOR NEEDS TO SEE HOW IT WORKS FROM SCRATCH
         $userStorage->update($userId, $user);
         $cardStorage->update($cardId, $card);

        //header('location: index.php');
        //echo "Card purchased successfully!";
        // If card purchase is successful
header('location: index.php?message=Congratulations!  Card purchased successfully!&success=1');
exit;

    } else {
       // echo "Insufficient funds or reached card limit.";
      
    header('location: index.php?message=Check if you have Insufficient funds or have already reached card limit which is 5 cards.');
exit;

    }
} else {
    //echo "Invalid request.";
    header('location: index.php?message=Invalid request.');
    exit;
}
?>
