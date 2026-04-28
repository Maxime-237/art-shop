// Données simulées d'activités
const logs = [
    { user: "Jean Bekolo", role: "Artiste", action: "Upload: Masque Sawa", date: "03/04/2026", status: "Pending" },
    { user: "Marie L.", role: "Client", action: "Achat: Peinture Awa", date: "03/04/2026", status: "Active" },
    { user: "Paul N.", role: "Artiste", action: "Connexion", date: "02/04/2026", status: "Active" }
];

document.addEventListener('DOMContentLoaded', () => {
    loadActivity();
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