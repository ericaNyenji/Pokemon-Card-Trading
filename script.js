"use strict";

document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("cardContainer");
  if (!container) return;

  // Fetch cards from JSON
  fetch("cards.json")
    .then(res => res.json())
    .then(cards => {
      // Filter only cards owned by admin
      const adminCards = Object.entries(cards)
        .filter(([id, card]) => card.owner === "admin");

      adminCards.forEach(([id, card], index) => {
        const cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "fade-in");
        cardDiv.style.animationDelay = `${index * 0.1}s`;

        cardDiv.innerHTML = `
          <div class="cardRow pokemonCardImage ${card.type}">
            <img src="${card.image}" alt="no image found" />
          </div>
          <div class="cardRow pokemoneCardData">
            <div class="pokemoneName"><h3>${card.name}</h3></div>          
            <div class="pokemoneType">
              <div class="discription hidden">
                <p>${card.description}</p>
              </div><p>Type
              <img src="./images/${card.type}.png" alt="no image found" />: ${card.type}
            </p></div>
            <div class="pokemoneStatus">
              <div><p>Health<img src="./images/health.png" alt="no image found" />: ${card.hp}<p></div>
              <div><p>Defence<img src="./images/defance.png" alt="no image found" />: ${card.defense}</p></div>
              <div><p>Attack<img src="./images/attack.png" alt="no image found" />: ${card.attack}</p></div>
            </div>
          </div>
          <div class="cardRow pokemoneCardPrice">
            <p>Price<img src="./images/moneyBag.png" alt="no image found"/>: ${card.price} HUF</p>
          </div>
          <form action="buy_card.php" method="post">
            <input type="hidden" name="card_id" value="${id}">
            <button type="submit">Buy</button>
          </form>
        `;

        container.appendChild(cardDiv);
      });

      addCardEffects();
    })
    .catch(err => console.error("Error loading cards:", err));
});

// === Animation & Effects ===
function addCardEffects() {
  const cards = document.querySelectorAll(".card");

  cards.forEach(card => {
    const desc = card.querySelector(".discription");

    // Hover to show description
    card.addEventListener("mouseenter", () => {
      if (desc) desc.classList.remove("hidden");
    });

    card.addEventListener("mouseleave", () => {
      if (desc) desc.classList.add("hidden");
    });

    // Click animation
    card.addEventListener("click", () => {
      card.classList.add("selected");
      setTimeout(() => card.classList.remove("selected"), 300);
    });
  });

  console.log("Card effects active!");
}

// ================== GUEST VIEW: SHOW DISTINCT CARDS ONLY ==================
document.addEventListener("DOMContentLoaded", () => {
  const guestContainer = document.getElementById("guestCardContainer");
  if (!guestContainer) return;

  fetch("cards.json")
    .then(res => res.json())
    .then(cards => {
      const seenNames = new Set(); // Track distinct Pokémon by name

      Object.entries(cards).forEach(([id, card]) => {
        // Skip duplicate Pokémon names
        if (seenNames.has(card.name)) return;
        seenNames.add(card.name);

        const cardDiv = document.createElement("div");
        cardDiv.classList.add("card", "fade-in");

        cardDiv.innerHTML = `
          <div class="cardRow pokemonCardImage ${card.type}">
            <img src="${card.image}" alt="no image found" />
          </div>
          <div class="cardRow pokemoneCardData">
            <div class="pokemoneName"><h3>${card.name}</h3></div>
            <div class="pokemoneType">
              <div class="discription hidden">
                <p>${card.description}</p>
              </div>
              <p>Type:<img src="./images/${card.type}.png" alt="no image found" /> ${card.type}</p>
            </div>
            <div class="pokemoneStatus">
              <div><p>Health<img src="./images/health.png" alt="no image found" />: ${card.hp}<p></div>
              <div><p>Defence<img src="./images/defance.png" alt="no image found" />: ${card.defense}</p></div>
              <div><p>Attack<img src="./images/attack.png" alt="no image found" />: ${card.attack}</p></div>
            </div>
          </div>
          <div class="cardRow pokemoneCardPrice">
            <p>Price<img src="./images/moneyBag.png" alt="no image found"/>: ${card.price} HUF</p>
          </div>
          <button class="disabledBuy" title="Sign in to buy this card">Buy</button>
        `;

        guestContainer.appendChild(cardDiv);
      });

      addCardEffects();
    })
    .catch(err => console.error("Error loading guest cards:", err));
});
