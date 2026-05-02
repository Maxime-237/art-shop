# TODO - Mobile Responsive Login/Register CSS Updates

## Task

Modifier le CSS lié aux vues login et register dans style.css afin ces vues soient bien adaptées au format mobile phone.

## Plan

### Changes appliquées dans style.css

1. **auth-container:**
    - Changé height de 90vh à min-height pour permettre le scroll sur mobile
    - Container prend maintenant 100% de la largeur sur mobile

2. **Media Queries ajoutées:**
    - @media (max-width: 850px): container full-width, pas de border-radius
    - @media (max-width: 600px): padding réduits, inputs et boutons tactiles (min-height 48px)
    - @media (max-width: 480px): ajustements fins pour petits écrans

3. **Éléments de formulaire:**
    - Inputs avec min-height: 48px pour le tactile
    - Labels avec taille de police plusisible
    - Plus d'espacement entre les éléments

4. **Rôle selector:**
    - Changé en colonne sur mobile pour meilleur affichage
    - Labels plus grands pour le tactile

5. **Améliorations mobile:**
    - overflow-y: auto avec -webkit-overflow-scrolling: touch
    - Visual overlay caché sur mobile (comme auth-visual)

## Status

- [x] Analyser les fichiers existants
- [x] Appliquer les modifications CSS
- [x] Tester les différences

## Fichiers modifiés

- public/css/style.css
