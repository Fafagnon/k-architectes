/* K-ARCHITECTES — améliorations progressives. Le site reste lisible sans JavaScript. */
(() => {
  'use strict';
  const racine = document.documentElement;

  /* 1. Logo : déposer assets/logo.svg suffit, il remplace le nom en texte sur toutes les pages. */
  const marques = document.querySelectorAll('.marque');
  if (marques.length) {
    const sonde = new Image();
    sonde.onload = () => marques.forEach((marque) => {
      const logo = new Image();
      logo.className = 'marque__logo';
      logo.alt = '';
      logo.src = sonde.src;
      marque.prepend(logo);
      marque.classList.add('a-logo');
    });
    sonde.src = 'assets/logo.svg';
  }

  /* 2. Menu mobile : bouton texte, panneau plein écran, Échap, contenu rendu inerte pendant l'ouverture. */
  const bouton = document.querySelector('.menu-bouton');
  const nav = document.getElementById('nav');
  if (bouton && nav) {
    const zones = document.querySelectorAll('#contenu, .pied');
    const ouvert = () => racine.classList.contains('menu-ouvert');
    const definir = (etat, rendreFocus) => {
      racine.classList.toggle('menu-ouvert', etat);
      bouton.setAttribute('aria-expanded', String(etat));
      bouton.textContent = etat ? 'Fermer' : 'Menu';
      zones.forEach((z) => { z.inert = etat; });
      if (etat) nav.querySelector('a').focus();
      else if (rendreFocus) bouton.focus();
    };
    bouton.addEventListener('click', () => definir(!ouvert(), true));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && ouvert()) definir(false, true); });
    nav.addEventListener('click', (e) => { if (e.target.closest('a')) definir(false, false); });
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => { if (e.matches && ouvert()) definir(false, false); });
  }

  /* 3. Photos absentes : l'emplacement reste visible avec le nom du fichier attendu. */
  const marquerAbsente = (img) => { const cadre = img.closest('.cadre'); if (cadre) cadre.classList.add('est-absent'); };
  document.querySelectorAll('.cadre img').forEach((img) => {
    if (img.complete && img.naturalWidth === 0) marquerAbsente(img);
    img.addEventListener('error', () => marquerAbsente(img));
  });

  /* 4. Mode relecture : ?relecture surligne les contenus provisoires (?relecture=0 le retire). */
  try {
    const params = new URLSearchParams(window.location.search);
    if (params.has('relecture')) {
      if (params.get('relecture') === '0') sessionStorage.removeItem('relecture');
      else sessionStorage.setItem('relecture', '1');
    }
    if (sessionStorage.getItem('relecture')) racine.classList.add('relecture');
  } catch (e) { /* stockage indisponible : sans effet */ }

  /* 5. Formulaire de contact : envoi sans rechargement, avec repli sur l'envoi classique. */
  const form = document.querySelector('[data-formulaire]');
  if (form) {
    form.noValidate = true;
    const ok = document.getElementById('retour-ok');
    const echec = document.getElementById('retour-echec');
    const champs = [...form.querySelectorAll('input:not([type="hidden"]):not([name="_honey"]), select, textarea')];
    const envoyer = form.querySelector('[type="submit"]');
    const libelle = envoyer.textContent;

    const effacer = (champ) => {
      const bloc = champ.closest('.champ');
      bloc.classList.remove('champ--erreur');
      champ.removeAttribute('aria-invalid');
      champ.removeAttribute('aria-describedby');
      const msg = bloc.querySelector('.erreur');
      if (msg) msg.remove();
    };
    const signaler = (champ, texte) => {
      const bloc = champ.closest('.champ');
      bloc.classList.add('champ--erreur');
      champ.setAttribute('aria-invalid', 'true');
      const msg = document.createElement('p');
      msg.className = 'erreur';
      msg.id = champ.id + '-erreur';
      msg.textContent = texte;
      bloc.appendChild(msg);
      champ.setAttribute('aria-describedby', msg.id);
    };
    const valider = () => {
      let premier = null;
      champs.forEach((champ) => {
        effacer(champ);
        if (!champ.checkValidity()) {
          const texte = champ.validity.valueMissing ? champ.dataset.erreur : (champ.dataset.erreurFormat || champ.dataset.erreur);
          signaler(champ, texte || 'Vérifiez ce champ.');
          if (!premier) premier = champ;
        }
      });

      /* Validation au choix : Au moins un moyen de contact (E-mail ou Téléphone) */
      const champEmail = form.querySelector('[name="email"]');
      const champTel = form.querySelector('[name="Telephone"]');
      if (champEmail && champTel) {
        const mailVal = champEmail.value.trim();
        const telVal = champTel.value.trim();
        if (!mailVal && !telVal) {
          signaler(champTel, 'Indiquez au moins une adresse e-mail ou un numéro de téléphone.');
          if (!premier) premier = champTel;
        }
      }

      return premier;
    };
    const montrer = (bloc) => {
      [ok, echec].forEach((b) => { if (b) b.hidden = true; });
      if (bloc) { bloc.hidden = false; bloc.focus(); }
    };

    champs.forEach((champ) => champ.addEventListener('input', () => {
      if (champ.getAttribute('aria-invalid')) effacer(champ);
      const autreContact = champ.name === 'email' ? form.querySelector('[name="Telephone"]') : (champ.name === 'Telephone' ? form.querySelector('[name="email"]') : null);
      if (autreContact && autreContact.getAttribute('aria-invalid')) effacer(autreContact);
    }));

    /* Gestion de la pièce jointe (document ou photo) */
    const inputFichier = form.querySelector('.fichier-input');
    const zoneFichier = form.querySelector('.zone-fichier');
    const labelFichier = form.querySelector('.fichier-label');
    const apercuFichier = document.getElementById('fichier-apercu');
    const nomFichier = document.getElementById('fichier-nom');
    const btnSupprimerFichier = document.getElementById('fichier-supprimer');

    if (inputFichier && apercuFichier && nomFichier) {
      const formaterTaille = (octets) => {
        if (octets < 1024) return octets + ' o';
        if (octets < 1048576) return (octets / 1024).toFixed(1) + ' Ko';
        return (octets / 1048576).toFixed(1) + ' Mo';
      };

      inputFichier.addEventListener('change', () => {
        effacer(inputFichier);
        if (inputFichier.files && inputFichier.files[0]) {
          const f = inputFichier.files[0];
          nomFichier.textContent = `${f.name} (${formaterTaille(f.size)})`;
          apercuFichier.hidden = false;
          if (labelFichier) labelFichier.hidden = true;
          if (zoneFichier) zoneFichier.classList.add('zone-fichier--rempli');
        } else {
          apercuFichier.hidden = true;
          if (labelFichier) labelFichier.hidden = false;
          if (zoneFichier) zoneFichier.classList.remove('zone-fichier--rempli');
        }
      });

      if (btnSupprimerFichier) {
        btnSupprimerFichier.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();
          inputFichier.value = '';
          apercuFichier.hidden = true;
          if (labelFichier) labelFichier.hidden = false;
          if (zoneFichier) zoneFichier.classList.remove('zone-fichier--rempli');
          effacer(inputFichier);
        });
      }
    }

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const premier = valider();
      if (premier) { premier.focus(); return; }
      envoyer.disabled = true;
      envoyer.textContent = 'Envoi en cours';
      try {
        const reponse = await fetch(form.dataset.ajax, { method: 'POST', headers: { Accept: 'application/json' }, body: new FormData(form) });
        if (!reponse.ok) throw new Error('http ' + reponse.status);
        const donnees = await reponse.json().catch(() => ({}));
        if (donnees && String(donnees.success) === 'false') throw new Error('refus');
        form.querySelectorAll('.champ, .bouton, .formulaire__note').forEach((el) => { el.hidden = true; });
        montrer(ok);
      } catch (err) {
        montrer(echec);
        envoyer.disabled = false;
        envoyer.textContent = libelle;
      }
    });

    if (/[?&]envoye=1\b/.test(window.location.search)) {
      form.querySelectorAll('.champ, .bouton, .formulaire__note').forEach((el) => { el.hidden = true; });
      montrer(ok);
    }
  }

  /* 6. Carrousel Projets en Center Mode avec Défilement Automatique Continu */
  function initSwiperProjets() {
    const elCarrousel = document.querySelector('.swiper-projets');
    if (!elCarrousel) return;
    if (typeof Swiper === 'undefined') {
      setTimeout(initSwiperProjets, 60);
      return;
    }
    if (elCarrousel.swiper) return;

    new Swiper(elCarrousel, {
      slidesPerView: 'auto',
      centeredSlides: true,
      spaceBetween: 32,
      loop: true,
      loopedSlides: 6,
      loopAdditionalSlides: 6,
      speed: 4500,
      grabCursor: true,
      watchSlidesProgress: true,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.carrousel-btn--next',
        prevEl: '.carrousel-btn--prev',
      },
      keyboard: {
        enabled: true,
      },
      breakpoints: {
        768: {
          spaceBetween: 36,
        },
        1200: {
          spaceBetween: 48,
        },
      },
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSwiperProjets);
  } else {
    initSwiperProjets();
  }

  /* 7. Diaporama des projets : une seule photo à la fois, flèches précédent/suivant et décompte (ex: 1/4) */
  const diaporamas = document.querySelectorAll('[data-diaporama]');
  diaporamas.forEach((diapo) => {
    const slides = diapo.querySelectorAll('.diaporama__diapo');
    const btnPrec = diapo.querySelector('.diaporama__fleche--prec');
    const btnSuiv = diapo.querySelector('.diaporama__fleche--suiv');
    const decompte = diapo.querySelector('.diaporama__decompte');
    let index = 0;
    const total = slides.length;
    if (total <= 1) {
      if (btnPrec) btnPrec.style.display = 'none';
      if (btnSuiv) btnSuiv.style.display = 'none';
      if (decompte) decompte.textContent = '1/1';
      return;
    }
    const actualiser = (n) => {
      index = (n + total) % total;
      slides.forEach((s, i) => {
        s.classList.toggle('est-active', i === index);
      });
      if (decompte) decompte.textContent = `${index + 1}/${total}`;
    };
    if (btnPrec) btnPrec.addEventListener('click', () => actualiser(index - 1));
    if (btnSuiv) btnSuiv.addEventListener('click', () => actualiser(index + 1));

    // Support clavier
    diapo.setAttribute('tabindex', '0');
    diapo.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        actualiser(index - 1);
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        actualiser(index + 1);
      }
    });

    actualiser(0);
  });
})();
