document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
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