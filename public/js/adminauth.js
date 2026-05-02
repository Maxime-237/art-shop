//hamburger
function toggleSidebar() {
    const btn     = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    btn.classList.toggle('open');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');

    // Bloquer le scroll body quand menu ouvert
    document.body.style.overflow =
        sidebar.classList.contains('open') ? 'hidden' : '';
}

// Fermer sidebar si on tourne l'écran en paysage
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        document.getElementById('hamburgerBtn')?.classList.remove('open');
        document.getElementById('sidebar')?.classList.remove('open');
        document.getElementById('sidebarOverlay')?.classList.remove('show');
        document.body.style.overflow = '';
    }
});

document.getElementById('adminLoginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const adminID = document.getElementById('adminID').value;
    const adminPass = document.getElementById('adminPassword').value;
    const btn = document.querySelector('.btn-login');

    // Simulation d'une vérification de sécurité
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Vérification...';
    btn.style.opacity = '0.7';
    btn.disabled = true;

    // Logique temporaire avant le Backend
    setTimeout(() => {
        if(adminID === "ADM-2026" && adminPass === "CamerArt123") {
            // Animation de succès
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Accès Accordé';
            btn.style.background = "#10b981";

            setTimeout(() => {
                window.location.href = "admindash.html";
            }, 1000);
        } else {
            // Animation d'erreur
            btn.innerHTML = '<i class="fa-solid fa-xmark"></i> Échec - Revoir IDs';
            btn.style.background = "#ef4444";

            setTimeout(() => {
                btn.innerHTML = '<span>Authentification</span> <i class="fa-solid fa-arrow-right"></i>';
                btn.style.background = "#e58e26";
                btn.disabled = false;
                btn.style.opacity = '1';
            }, 2000);
        }
    }, 1500);
});

// Simulation de récupération d'IP
document.getElementById('user-ip').innerText = `197.243.${Math.floor(Math.random() * 255)}.XXX`;
