// --- 1. DONNÉES (PRODUITS & ARTISTES) ---
// const artworks = [
//     { id: 1, title: "Masque Bamoun Bronze", artist: "Moussa F.", price: 75000, category: "Sculpture", img: '../assets/artworks/art_1.png', stars: 5, stock: 3, desc: "Véritable bronze issu des fonderies traditionnelles de Foumban." },
//     { id: 2, title: "Rêve Tropical", artist: "Sali H.", price: 120000, category: "Peinture", img: '../assets/artworks/art_2.png', stars: 4, stock: 1, desc: "Une peinture vibrante capturant l'essence des forêts du Sud." },
//     { id: 3, title: "Dynastie Grassfields", artist: "Paul N.", price: 250000, category: "Sculpture", img: '../assets/artworks/art_3.png', stars: 5, stock: 2, desc: "Sculpture sur bois précieux représentant la lignée royale." },
//     { id: 4, title: "Afro-Futurisme 237", artist: "Awa N.", price: 45000, category: "Digital Art", img: '../assets/artworks/art_4.png', stars: 4, stock: 10, desc: "Oeuvre numérique haute résolution livrée avec certificat NFT." },
//     { id: 5, title: "La joconde", artist: "Leonard de v.", price: 5000000, category: "Peinture", img: '../assets/artworks/art_5.png', stars: 5, stock: 1, desc: "Oeuvre numérique haute résolution livrée avec certificat NFT." },
//     { id: 6, title: "Illusion du Temp", artist: "Sali H.", price: 120000, category: "Peinture", img: '../assets/artworks/art_6.png', stars: 4, stock: 10, desc: "Une peinture vibrante capturant l'essence des forêts du Sud." }
// ];


// MENU MOBILE
function toggleMenu() {
    document.getElementById('hamburger').classList.toggle('open');
    document.getElementById('mobileMenu').classList.toggle('open');
}
const artistsData = [
    { name: "Awa Ndongo", bio: "Spécialiste Digital Art", region: "Littoral", img: '../assets/artist/ava_1.png', news: "Vernissage ce week-end !" },
    { name: "Moussa F.", bio: "Maître sculpteur Bronze", region: "Ouest", img: '../assets/artist/ava_2.png', news: "3 nouvelles pièces dispo." }
];

let cart = [];

// --- 2. INITIALISATION AU CHARGEMENT ---
document.addEventListener('DOMContentLoaded', () => {
    displayProducts(artworks);
    displayArtists();
    initFilters();
});

// --- 3. FONCTIONS D'AFFICHAGE ---
function displayProducts(data) {
    const container = document.getElementById('product-display');
    if (!container) return;

    container.innerHTML = data.map(item => `
        <div class="product-card">
            <div class="product-img-container">
                <img src="${item.img}" class="product-img" alt="${item.title}">
                <div class="card-actions">
                    <button class="btn-card btn-detail-view" onclick="openProduct(${item.id})">
                        <i class="fa-solid fa-eye"></i> Détails
                    </button>
                    <button class="btn-card btn-quick-add" onclick="quickAdd(${item.id})">
                        <i class="fa-solid fa-cart-plus"></i> + Panier
                    </button>
                </div>
            </div>
            <div class="product-info" style="padding:15px">
                <div class="stars" style="color: #f1c40f;">
                    ${'★'.repeat(item.stars)}${'☆'.repeat(5 - item.stars)}
                </div>
                <h3>${item.title}</h3>
                <p>Par ${item.artist}</p>
                <div class="price">${item.price.toLocaleString()} FCFA</div>
            </div>
        </div>
    `).join('');
}

function displayArtists() {
    const container = document.getElementById('artists-list');
    if (!container) return;
    container.innerHTML = artistsData.map(art => `
        <div class="artist-card">
            <img src="${art.img}" alt="${art.name}">
            <h3>${art.name}</h3>
            <p><i class="fa-solid fa-location-dot"></i> ${art.region}</p>
            <small>${art.bio}</small>
            <div class="artist-news">"${art.news}"</div>
        </div>
    `).join('');
}

// --- 4. FILTRES ---
function initFilters() {
    const btns = document.querySelectorAll('.filter-btn');
    btns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            btns.forEach(b => b.classList.remove('active'));
            e.target.classList.add('active');
            const filter = e.target.getAttribute('data-filter');
            const filteredData = filter === 'all' ? artworks : artworks.filter(a => a.category === filter);
            displayProducts(filteredData);
        });
    });
}

// --- 5. MODALE DÉTAILS ---
function openProduct(id) {
    const p = artworks.find(x => x.id === id);
    const modal = document.getElementById('productModal');

    if (p && modal) {
        document.getElementById('modal-img').src = p.img;
        document.getElementById('modal-title').innerText = p.title;
        document.getElementById('modal-artist').innerText = p.artist;
        document.getElementById('modal-price').innerText = p.price.toLocaleString();
        document.getElementById('modal-cat').innerText = p.category;
        document.getElementById('modal-desc').innerText = p.desc;

        const stockEl = document.getElementById('modal-stock');
        if(stockEl) stockEl.innerHTML = `<i class="fa-solid fa-boxes-stacked"></i> <span>${p.stock} pièces restantes</span>`;

        const starsEl = document.getElementById('modal-stars');
        if(starsEl) starsEl.innerHTML = '<i class="fa-solid fa-star"></i>'.repeat(p.stars);

        modal.style.display = "block";
        modal.setAttribute('data-current-id', id);
    }
}

function closeProductModal() {
    document.getElementById('productModal').style.display = "none";
}

// --- 6. GESTION DU PANIER ---
function toggleCart() {
    const cartModal = document.getElementById('cartModal');
    if(cartModal) {
        cartModal.style.display = (cartModal.style.display === "block") ? "none" : "block";
        renderCart();
    }
}

function quickAdd(id) {
    const product = artworks.find(p => p.id === id);
    if(product) addToCart(product, 1);
}

function addToCartFromModal() {
    const id = parseInt(document.getElementById('productModal').getAttribute('data-current-id'));
    const qty = parseInt(document.getElementById('modal-qty').value) || 1;
    const product = artworks.find(p => p.id === id);
    if(product) {
        addToCart(product, qty);
        closeProductModal();
    }
}

function addToCart(product, qty) {
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ ...product, qty: qty });
    }
    updateCartUI();
}

function updateCartUI() {
    const count = cart.reduce((acc, item) => acc + item.qty, 0);
    document.getElementById('cart-count').innerText = count;
}

function renderCart() {
    const container = document.getElementById('cart-items-container');
    const totalEl = document.getElementById('cart-total-price');
    const subtotalEl = document.getElementById('subtotal');

    if (!container) return;

    let total = 0;
    container.innerHTML = cart.map((item, index) => {
        total += item.price * item.qty;
        return `
            <div class="cart-item" style="display:flex; align-items:center; gap:10px; margin-bottom:10px; border-bottom:1px solid #eee; padding-bottom:5px;">
                <img src="${item.img}" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                <div style="flex:1">
                    <h4 style="margin:0; font-size:0.9rem;">${item.title}</h4>
                    <small>${item.price.toLocaleString()} FCFA x ${item.qty}</small>
                </div>
                <button onclick="removeFromCart(${index})" style="color:red; border:none; background:none; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
    }).join('');

    if(totalEl) totalEl.innerText = total.toLocaleString() + " FCFA";
    if(subtotalEl) subtotalEl.innerText = total.toLocaleString() + " FCFA";
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
    updateCartUI();
}

// --- 7. DASHBOARD & MISC ---
function toggleUserDashboard() {
    document.getElementById('userDropdown').classList.toggle('show');
}

// Fermeture modals clic extérieur
window.onclick = function(event) {
    const pModal = document.getElementById('productModal');
    const cModal = document.getElementById('cartModal');
    const sModal = document.getElementById('settingsModal');
    if (event.target == pModal) pModal.style.display = "none";
    if (event.target == cModal) cModal.style.display = "none";
    if (event.target == sModal) sModal.style.display = "none";
}

// --- AUTH SWITCH (Pour auth.html) ---

const loginBtn = document.getElementById('login-btn');

const registerBtn = document.getElementById('register-btn');

const loginForm = document.getElementById('login-form');

const registerForm = document.getElementById('register-form');



if (loginBtn && registerBtn) {

    registerBtn.addEventListener('click', () => {

        registerBtn.classList.add('active');

        loginBtn.classList.remove('active');

        loginForm.classList.remove('active-form');

        registerForm.classList.add('active-form');

    });



    loginBtn.addEventListener('click', () => {

        loginBtn.classList.add('active');

        registerBtn.classList.remove('active');

        registerForm.classList.remove('active-form');

        loginForm.classList.add('active-form');

    });

}
