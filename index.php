<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Card Trading</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="modal-style.css">
</head>
<body>

<?php
session_start();////starting a session. (Put at the very beginning of our document)>>.
// Check if there's a message in the query parameters
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageColor = isset($_GET['success']) ? 'green' : 'red';

    echo '<h2 style="color: ' . $messageColor . '; font-weight: bold;">' . $message . '</h2>';
}

if (!isset($_SESSION['user_id'])) {
echo "<div>
  <nav role='navigation' class='primary-navigation'>
    <ul>
      <li class='toRight signIn'>
        <a href='#' onclick='event.preventDefault(); openModal(\"loginModal\")'>Sign In</a>
      </li>
      <li class='toRight forLineBar signUp'>
        <a href='#' onclick='event.preventDefault(); openModal(\"signupModal\")'>Sign Up</a>
      </li>
    </ul>
  </nav>
</div>";
}

if (isset($_SESSION['user_id'])) {
        echo '<div>
    <nav role="navigation" class="primary-navigation">
        <ul>
        <li class="toLeft"><a href="index.php">Home</a></li>
        <li class="toRight forLineBar signUp"><a href="logout.php">SignOut</a></li>
        </ul>
    </nav>
    </div>';
}
// echo "<h1>Pokémon Card Trading</h1>";
echo '<h1>
    <br>
  <span class="highlight">Pokémon Trade Hub</span><br />
  <span class="highlight">Unleash the NFT Adventure</span>
</h1>';
if (isset($_SESSION['user_id'])) {
    include_once("storage.php");
    $stor = new Storage(new JsonIO('users.json'));
    $allUsers = $stor->findAll();
    echo "<br><h2>
    Hello 
    <a href='user_details.php' style=\"
        display: inline-block;
        background-color: #000;
        color: #fff;
        padding: 5px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    \" onmouseover=\"this.style.backgroundColor='#333'\" onmouseout=\"this.style.backgroundColor='#000'\">
        {$allUsers[$_SESSION['user_id']]['username']}
    </a>! Your current balance in the wallet is {$allUsers[$_SESSION['user_id']]['amountOfMoneyInWallet']} huf
    </h2>";

    

}

//echo "<h3>Not a Member <a href=\"registration.php\">Click Here</a> to Sign Up </h3>";

if (!isset($_SESSION['user_id'])) {
    echo '
<div class="introduction">
  <div class="intoImage col-5">
    <img src="./images/pokemon.jpg" alt="" />
  </div>
  <div class="intro col-7">
    <p>
      Step into the Pokémon Trade Hub, an immersive NFT platform where
      Pokémon cards transcend the digital realm. As the appointed
      developer, your mission is to curate an extraordinary trading
      experience. The main page beckons with a diverse array of Pokémon
      cards, each linked to dynamic details, enticing both buying and
      selling adventures. Explore the User Details page to manage your
      collection and engage in the unique thrill of selling cards to the
      admin merchant.
      <br /><br />
      Authentication seamlessly integrates into the main page, offering
      equal footing for all trainers. Admin privileges bring forth the
      power to create new cards, enriching the Pokémon universe. With a
      minimalist design catering to 1024x768 resolution, the Pokémon Trade
      Hub promises a visually appealing and user-friendly experience.
      <br /><br />
      Join us in shaping the legacy of this NFT adventure—a fusion of art,
      technology, and Pokémon magic that captivates trainers and
      collectors alike!
      <br /><br />
      To be able to buy a card, you need to <a href="#" onclick="event.preventDefault(); openModal(\'loginModal\')">Sign In</a>.
      <br /><br />
      Explore the amazing world of Pokémon cards!
    </p>
  </div>
</div>
';
}

if (isset($_SESSION['user_id']) &&  ($_SESSION['user_id']==="65a34019f2372")){
    echo '<h2>
            <a href="new_card.php" style="
                display: inline-block;
                background-color: #000;
                color: #fff;
                padding: 10px 20px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s ease;
            " onmouseover="this.style.backgroundColor=\'#333\'" onmouseout="this.style.backgroundColor=\'#000\'">
                Create New Card
            </a>
          </h2>';
}
if (!isset($_SESSION['user_id'])): 
  echo '<div class="cardContainer" id="guestCardContainer"></div>';
else: 
  echo '<div class="cardContainer" id="cardContainer"></div>';
endif; 


if (isset($_SESSION['user_id'])): 
  echo '<div class="cardContainer" id="cardContainer"></div>';
 endif; 

?>

<script>
function hideAllModals() {
  document.querySelectorAll('.modal-overlay').forEach(o => o.style.display = 'none');
}

function openModal(id) {
  hideAllModals(); // ensures all others are hidden first
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'flex';
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'none';
}

function switchModal(from, to) {
  hideAllModals();
  const next = document.getElementById(to);
  if (next) next.style.display = 'flex';
}

// close when clicking outside
document.addEventListener('click', e => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.style.display = 'none';
  }
});
</script>


<script src="script.js"></script>
<script>
  console.log("JS file loaded!");
</script>
</body>


<?php if (!isset($_SESSION['user_id'])): ?>
  <!-- Sign In Modal -->
  <div class="modal-overlay" id="loginModal" style="display:none;">
    <div class="modal">
      <i class="close fa-solid fa-xmark" onclick="closeModal('loginModal')"></i>
      <form class="form" method="POST" action="login.php">
        <h2 class="title">Sign In</h2>

        <div class="flex-column">
          <label>Username</label>
          <input type="text" class="input" name="username" placeholder="Enter your username" required>
        </div>

        <div class="flex-column">
          <label>Password</label>
          <input type="password" class="input" name="password" placeholder="Enter your password" required>
        </div>

        <button class="button-submit" type="submit">Sign In</button>
        <p class="p">Don't have an account? 
          <span class="span" onclick="switchModal('loginModal','signupModal')">Sign Up</span>
        </p>
      </form>
    </div>
  </div>

  <!-- Sign Up Modal -->
  <div class="modal-overlay" id="signupModal" style="display:none;">
    <div class="modal">
      <i class="close fa-solid fa-xmark" onclick="closeModal('signupModal')"></i>
      <form class="form" method="POST" action="registration.php">
        <h2 class="title">Register</h2>

        <div class="flex-column"><label>Username</label></div>
        <input class="input" type="text" name="username" placeholder="Username" required>

        <div class="flex-column"><label>Email</label></div>
        <input class="input" type="email" name="email" placeholder="Email" required>

        <div class="flex-column"><label>Password</label></div>
        <input class="input" type="password" name="password" placeholder="Password" required>

        <div class="flex-column"><label>Confirm Password</label></div>
        <input class="input" type="password" name="confirm_password" placeholder="Confirm Password" required>

        <button class="button-submit" type="submit">Register</button>
        <p class="p">Already have an account? 
          <span class="span" onclick="switchModal('signupModal','loginModal')">Sign In</span>
        </p>
      </form>
    </div>
  </div>
<?php endif; ?>


</html>
