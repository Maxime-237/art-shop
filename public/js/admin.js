// Données simulées d'activités
const logs = [
    { user: "Jean Bekolo", role: "Artiste", action: "Upload: Masque Sawa", date: "03/04/2026", status: "Pending" },
    { user: "Marie L.", role: "Client", action: "Achat: Peinture Awa", date: "03/04/2026", status: "Active" },
    { user: "Paul N.", role: "Artiste", action: "Connexion", date: "02/04/2026", status: "Active" }
];

document.addEventListener('DOMContentLoaded', () => {
    loadActivity();
});

// Toggle Sidebar pour Hamburger Menu
function toggleSidebar() {
    const btn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(btn && sidebar) {
        btn.classList.toggle('open');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');

        // Bloquer le scroll body quand menu ouvert
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    }
}

// Fermer sidebar si on tourne l'écran en paysage
window.addEventListener('resize', () => {
    const btn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if(btn && sidebar) {
        btn.classList.remove('open');
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }
});


function loadActivity() {
    const tbody = document.getElementById('activity-log');
    if(!tbody) return;

    tbody.innerHTML = logs.map(log => `
        <tr>
            <td><strong>${log.user}</strong></td>
            <td>${log.role}</td>
            <td>${log.action}</td>
            <td>${log.date}</td>
            <td><span class="status-tag ${log.status.toLowerCase()}">${log.status}</span></td>
        </tr>
    `).join('');
}

function showSection(section) {
    const view = document.getElementById('main-view');
    // Logique simple pour changer de vue (tu pourras l'étendre pour chaque section)
    if(section === 'approvals') {
        view.innerHTML = `
            <div class="table-container">
                <div class="table-header"><h3>Approbations en attente</h3></div>
                <div style="padding: 20px;">
                    <p>3 nouvelles œuvres attendent votre validation avant publication.</p>
                    <button class="btn-export" style="background:var(--admin-accent); color:white; margin-top:10px" onclick="alert('Œuvres Validées !')">Valider tout</button>
                </div>
            </div>
        `;
    } else {
        location.reload(); // Revient à la vue Overview
    }
}

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
