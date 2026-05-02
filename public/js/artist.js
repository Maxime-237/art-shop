// Données simulées des œuvres de l'artiste connecté
// const myWorks = [
//     { id: 101, title: "Masque Dan", views: 450, sales: 2, img: "https://images.unsplash.com/photo-1566996694954-90b052c413c4?q=80&w=600" },
//     { id: 102, title: "Abstractions Sawa", views: 1200, sales: 1, img: "https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=600" },
//     { id: 103, title: "Guerrier Bamileke", views: 890, sales: 0, img: "https://images.unsplash.com/photo-1515405299443-f73bb32881d3?q=80&w=600" }
// ];

document.addEventListener('DOMContentLoaded', () => {
    loadPortfolio();
    initNavigation();
});

function toggleSidebar() {
    const btn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(btn && sidebar) {
        btn.classList.toggle('open');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');

        //bloquer le sroll body quand menu ouvert
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    }
}

// Handle resize
window.addEventListener('resize', () => {
    const btn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(btn && sidebar) {
        btn.classList.remove('open');
        sidebar.classList.remove('open');
        if(overlay) overlay.classList.remove('show');
        document.body.style.overflow = '';
    }
});

// Charger le Portfolio
function loadPortfolio() {
    const grid = document.getElementById('artist-works');
    if(!grid) return;

    grid.innerHTML = myWorks.map(work => `
        <div class="work-item">
            <img src="${work.img}" alt="${work.title}">
            <div class="work-overlay">
                <div class="work-actions">
                    <button onclick="editWork(${work.id})"><i class="fa-solid fa-pen"></i></button>
                    <button onclick="deleteWork(${work.id})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div style="padding: 10px; font-size: 0.9rem;">
                <p><strong>${work.title}</strong></p>
                <small>${work.views} vues • ${work.sales} ventes</small>
            </div>
        </div>
    `).join('');
}

// Navigation Dynamique (Sidebar)
function initNavigation() {
    const links = document.querySelectorAll('.sidebar-menu a');
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            const section = link.getAttribute('data-section');
            updateContent(section);
        });
    });
}

function updateContent(section) {
    const area = document.getElementById('dynamic-area');
    if(section === 'branding') {
        area.innerHTML = `
            <div class="content-section">
                <h3>Personnalisation du Branding</h3>
                <div class="stat-card" style="margin-top:20px">
                    <div>
                        <label>Bannière du profil</label>
                        <input type="file" class="btn-upload" style="margin-top:10px">
                        <label style="display:block; margin-top:20px">Biographie d'artiste</label>
                        <textarea rows="5">Artiste contemporain basé à Douala, explorant les racines du Noun...</textarea>
                        <button class="btn-upload">Mettre à jour le profil</button>
                    </div>
                </div>
            </div>
        `;
    } else if(section === 'overview') {
        location.reload(); // Recharger pour voir les stats
    }
    // Ajoute d'autres sections selon tes besoins
}

// Modal Upload
const modal = document.getElementById('uploadModal');
function openUploadModal() { modal.style.display = 'block'; }
function closeUploadModal() { modal.style.display = 'none'; }

window.onclick = function(e) { if(e.target == modal) closeUploadModal(); }

// plus

// Empêcher le débordement des éléments larges
function makeElementsResponsive() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.style.overflowX = 'auto';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
}
