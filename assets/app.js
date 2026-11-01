import './stimulus_bootstrap.js';
import './styles/app.css';

function animerCompteur(element) {
    const cible = parseInt(element.dataset.compteur, 10) || 0;
    const duree = 1200;
    const debut = performance.now();

    function etape(maintenant) {
        const progression = Math.min((maintenant - debut) / duree, 1);
        const lissage = 1 - Math.pow(1 - progression, 3);
        element.textContent = Math.round(cible * lissage);
        if (progression < 1) {
            requestAnimationFrame(etape);
        }
    }

    requestAnimationFrame(etape);
}

function initialiserAnimations() {
    const elements = document.querySelectorAll('.reveal:not(.is-visible)');

    if (!('IntersectionObserver' in window)) {
        elements.forEach((el) => el.classList.add('is-visible'));
    } else {
        const observateur = new IntersectionObserver((entrees) => {
            entrees.forEach((entree) => {
                if (entree.isIntersecting) {
                    entree.target.classList.add('is-visible');
                    entree.target.querySelectorAll('[data-compteur]').forEach(animerCompteur);
                    observateur.unobserve(entree.target);
                }
            });
        }, { threshold: 0.15 });

        elements.forEach((el) => observateur.observe(el));
    }

    document.querySelectorAll('.carte-voiture:not([data-lueur])').forEach((carte) => {
        carte.dataset.lueur = '1';
        carte.addEventListener('mousemove', (e) => {
            const zone = carte.getBoundingClientRect();
            carte.style.setProperty('--x', `${e.clientX - zone.left}px`);
            carte.style.setProperty('--y', `${e.clientY - zone.top}px`);
        });
    });
}

document.addEventListener('turbo:load', initialiserAnimations);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initialiserAnimations);
} else {
    initialiserAnimations();
}
