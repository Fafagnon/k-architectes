@extends('layouts.app')

@section('title', 'K-ARCHITECTES | Cabinet d\'architecture à Lomé, Togo')
@section('meta_description', 'K-ARCHITECTES, cabinet d\'architecture à Lomé : conception, suivi de chantier et contrôle de vos projets, de l\'esquisse à la livraison.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "K-ARCHITECTES",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/img/logo-k.png') }}",
  "image": "{{ asset('assets/img/og-image.jpg') }}",
  "email": "archkortete@gmail.com",
  "telephone": ["+228 22 55 86 38", "+228 96 50 00 07"],
  "foundingDate": "2016-06",
  "description": "Cabinet d'architecture à Lomé : conception, contrôle et réalisation de projets.",
  "areaServed": {"@type": "Country", "name": "Togo"},
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Agoè-Vakpossito, Rue NDE (Notre-Dame de l'Église)",
    "postOfficeBoxNumber": "28 BP 305 Télessou",
    "addressLocality": "Lomé",
    "addressCountry": "TG"
  }
}
</script>
@endpush

@section('content')
<section class="ouverture" aria-labelledby="titre-accueil">
  <div class="ouverture__media">
    <div class="cadre cadre--plein" data-fichier="accueil-ouverture.jpg">
      <img src="{{ asset('assets/img/accueil-ouverture.jpg') }}" alt="Cabinet d'architecture K-Architectes Lomé" loading="eager" fetchpriority="high" decoding="async">
    </div>
  </div>
  <div class="conteneur ouverture__conteneur">
    <div class="ouverture__bloc">
      <h1 class="ouverture__titre" id="titre-accueil">
        Concevoir avec justesse.<br>
        Construire avec maîtrise.
      </h1>
      <p class="ouverture__chapeau">
        Architecture, ingénierie et conseil pour accompagner les projets résidentiels, professionnels, institutionnels et d’aménagement, de la conception à la réalisation.
      </p>
      <div class="ouverture__actions">
        <a href="{{ route('cabinet') }}" class="hero-bouton hero-bouton--primaire">Découvrir nos expertises</a>
        <a href="{{ route('realisations.index') }}" class="hero-bouton hero-bouton--secondaire">Voir nos réalisations</a>
      </div>
    </div>
  </div>
</section>

<section class="bande bande--beton bande--carrousel" aria-labelledby="t-projets">
  <div class="conteneur">
    <div class="tete-section">
      <h2 class="titre-section" id="t-projets">Réalisations à la une.</h2>
      <a class="lien" href="{{ route('realisations.index') }}">Toutes les réalisations</a>
    </div>
  </div>
  <div class="carrousel-wrapper">
    <div class="swiper swiper-projets" aria-label="Galerie des projets à la une">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a class="projet-card" href="{{ route('realisations.show', 'villa-agoe') }}" aria-label="Voir la Villa Agoè">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-01-couverture.jpg') }}" alt="Villa Agoè" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>
        <div class="swiper-slide">
          <a class="projet-card" href="{{ route('realisations.show', 'immeuble-tokoin') }}" aria-label="Voir l'Immeuble de bureaux Tokoin">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-02-couverture.jpg') }}" alt="Immeuble de bureaux Tokoin" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>
        <div class="swiper-slide">
          <a class="projet-card" href="{{ route('realisations.show', 'residence-adidogome') }}" aria-label="Voir la Résidence Adidogomé">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-03-couverture.jpg') }}" alt="Résidence Adidogomé" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>
        <div class="swiper-slide">
          <a class="projet-card" href="{{ route('realisations.show', 'ecole-kpalime') }}" aria-label="Voir l'École de Kpalimé">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-04-couverture.jpg') }}" alt="École de Kpalimé" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>

        <!-- Duplication pour une boucle infinie continue et fluide -->
        <div class="swiper-slide" aria-hidden="true">
          <a class="projet-card" href="{{ route('realisations.show', 'villa-agoe') }}" tabindex="-1">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-01-couverture.jpg') }}" alt="" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>
        <div class="swiper-slide" aria-hidden="true">
          <a class="projet-card" href="{{ route('realisations.show', 'immeuble-tokoin') }}" tabindex="-1">
            <div class="cadre projet-card__photo">
              <img src="{{ asset('assets/img/projet-02-couverture.jpg') }}" alt="" loading="lazy" decoding="async">
              <div class="projet-card__survol" aria-hidden="true">
                <span class="projet-card__badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="carrousel-navigation">
      <button class="carrousel-btn carrousel-btn--prev" type="button" aria-label="Projet précédent">
        <span class="carrousel-fleche carrousel-fleche--gauche" aria-hidden="true"></span>
      </button>
      <div class="swiper-pagination"></div>
      <button class="carrousel-btn carrousel-btn--next" type="button" aria-label="Projet suivant">
        <span class="carrousel-fleche carrousel-fleche--droite" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</section>

<section class="bande bande--calque" aria-labelledby="t-expertises">
  <div class="conteneur">
    <div class="tete-section"><h2 class="titre-section" id="t-expertises">Expertises.</h2></div>
    <ul class="expertises">
      <li data-provisoire><h3>Conception architecturale</h3><p>De l'esquisse au dossier d'exécution, pour l'habitat comme pour les bâtiments tertiaires.</p></li>
      <li data-provisoire><h3>Maîtrise d'œuvre et suivi de chantier</h3><p>Direction des travaux, coordination des entreprises et réception des ouvrages.</p></li>
      <li data-provisoire><h3>Contrôle et expertise technique</h3><p>Vérification de la conformité des plans et des ouvrages, en cours de chantier ou après livraison.</p></li>
      <li data-provisoire><h3>Aménagement intérieur</h3><p>Agencement des espaces et choix des matériaux, du plan aux finitions.</p></li>
    </ul>
  </div>
</section>

<section class="bande bande--beton" aria-labelledby="t-avis">
  <div class="conteneur">
    <div class="tete-section">
      <div>
        <h2 class="titre-section" id="t-avis">Avis clients.</h2>
        <div class="avis-note-globale">
          <svg class="avis-google-icon" width="20" height="20" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17Z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.16 0 9.97 0 12s.45 3.84 1.25 5.42l4.03-3.15Z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/></svg>
          <span class="avis-note-valeur">5,0 / 5</span>
          <span class="avis-etoiles" aria-label="5 étoiles sur 5">★★★★★</span>
          <span class="avis-source">sur Google</span>
        </div>
      </div>
      <a class="lien" href="https://www.google.com/maps/search/?api=1&query=K-ARCHITECTES%20Ago%C3%A8-Vakpossito%20Lom%C3%A9%20Togo" target="_blank" rel="noopener noreferrer">Voir sur Google Maps</a>
    </div>

    <div class="avis-grille">
      <article class="avis-card">
        <div class="avis-card__entete">
          <div class="avis-card__auteur">
            <h3 class="avis-card__nom">Modeste Tsata</h3>
            <span class="avis-card__badge">Local Guide · 64 avis</span>
          </div>
          <svg class="avis-google-mini" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17Z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.16 0 9.97 0 12s.45 3.84 1.25 5.42l4.03-3.15Z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/></svg>
        </div>
        <div class="avis-card__note" aria-label="5 étoiles sur 5">★★★★★</div>
        <blockquote class="avis-card__texte">
          « Propose des services à haut niveau en architecture. Cadre très propre. Accueil très superbe. »
        </blockquote>
        <time class="avis-card__date" datetime="2023">Il y a 3 ans</time>
      </article>

      <article class="avis-card">
        <div class="avis-card__entete">
          <div class="avis-card__auteur">
            <h3 class="avis-card__nom">Francine Sokpa</h3>
            <span class="avis-card__badge">Avis Google vérifié</span>
          </div>
          <svg class="avis-google-mini" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17Z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.16 0 9.97 0 12s.45 3.84 1.25 5.42l4.03-3.15Z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/></svg>
        </div>
        <div class="avis-card__note" aria-label="5 étoiles sur 5">★★★★★</div>
        <blockquote class="avis-card__texte">
          « Le meilleur cabinet d'architecture. »
        </blockquote>
        <time class="avis-card__date" datetime="2022">Il y a 4 ans</time>
      </article>

      <article class="avis-card">
        <div class="avis-card__entete">
          <div class="avis-card__auteur">
            <h3 class="avis-card__nom">Kokou Djikounou</h3>
            <span class="avis-card__badge">Local Guide · 128 photos</span>
          </div>
          <svg class="avis-google-mini" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17Z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.16 0 9.97 0 12s.45 3.84 1.25 5.42l4.03-3.15Z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/></svg>
        </div>
        <div class="avis-card__note" aria-label="5 étoiles sur 5">★★★★★</div>
        <blockquote class="avis-card__texte">
          « J'ai aimé son travail, très professionnel et à l'écoute. »
        </blockquote>
        <time class="avis-card__date" datetime="2022">Il y a 4 ans</time>
      </article>

      <article class="avis-card">
        <div class="avis-card__entete">
          <div class="avis-card__auteur">
            <h3 class="avis-card__nom">Ako Madjé Wilson-Bahun</h3>
            <span class="avis-card__badge">Local Guide · 85 avis</span>
          </div>
          <svg class="avis-google-mini" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17Z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24Z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.16 0 9.97 0 12s.45 3.84 1.25 5.42l4.03-3.15Z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98Z"/></svg>
        </div>
        <div class="avis-card__note" aria-label="5 étoiles sur 5">★★★★★</div>
        <blockquote class="avis-card__texte">
          « Cabinet d'architecte de référence à Lomé. Équipe compétente. »
        </blockquote>
        <time class="avis-card__date" datetime="2025">Il y a 11 mois</time>
      </article>
    </div>
  </div>
</section>

<!-- Section Actualités Dynamique -->
<section class="bande bande--calque" aria-labelledby="t-actualites">
  <div class="conteneur">
    <div class="tete-section">
      <div>
        <h2 class="titre-section" id="t-actualites">Actualités.</h2>
      </div>
      <a class="lien" href="{{ route('actualites.index') }}">Voir toutes les actualités<span class="fleche-droite" aria-hidden="true"> →</span></a>
    </div>

    @if($articles->isNotEmpty())
      <div class="actualites-accueil-grille">
        @foreach($articles as $article)
          <article class="actualite-card">
            <div class="cadre actualite-card__media" style="--ratio:16/10">
              @if($article->cover_image_url)
                <img src="{{ $article->cover_image_url }}" alt="{{ $article->title }}" loading="lazy" decoding="async">
              @else
                <div style="width:100%; height:100%; background:var(--beton); display:flex; align-items:center; justify-content:center; color:var(--graphite); font-size:.875rem;">Photographie en attente</div>
              @endif
            </div>
            <div class="actualite-card__corps">
              <div class="actualite-card__meta">
                <span class="actualite-card__tag">{{ $article->tag }}</span>
                <time class="actualite-card__date" datetime="{{ $article->published_at?->format('Y-m-d') }}">{{ $article->formatted_date }}</time>
              </div>
              <h3 class="actualite-card__titre">
                <a class="actualite-card__titre-lien" href="{{ route('actualites.show', $article) }}">{{ $article->title }}</a>
              </h3>
              <p class="actualite-card__chapeau">{{ $article->excerpt }}</p>
              <div class="actualite-card__pied">
                <span class="actualite-card__duree">{{ $article->reading_minutes ?? 4 }} min de lecture</span>
                <a class="actualite-card__action" href="{{ route('actualites.show', $article) }}">Lire l'article <span class="fleche-droite" aria-hidden="true">→</span></a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="actualites-accueil-bas">
        <a class="bouton" href="{{ route('actualites.index') }}">Consulter toutes nos actualités</a>
      </div>
    @else
      <p class="opportunites-message">Aucune actualité publiée pour le moment.</p>
    @endif
  </div>
</section>

<section class="bande bande--beton" aria-labelledby="t-contact">
  <div class="conteneur">
    <div class="tete-section"><h2 class="titre-section" id="t-contact">Nous contacter.</h2></div>
    <div class="scene">
      <div class="cadre" data-fichier="accueil-contact.jpg" style="--ratio:16/9">
        <img src="{{ asset('assets/img/accueil-ouverture.jpg') }}" alt="Siège K-ARCHITECTES Lomé" loading="lazy" decoding="async">
      </div>
      <div class="carte">
        <h3 class="carte__nom"><span class="nb">K-ARCHITECTES</span>.</h3>
        <address>Agoè-Vakpossito, Rue NDE<br>(Notre-Dame de l'Église)<br>28 BP 305 Télessou<br>Lomé, Togo</address>
        <dl>
          <div><dt>Standard</dt><dd><a href="tel:+22822558638">(+228) 22 55 86 38</a></dd><dd><a href="tel:+22896500007">(+228) 96 50 00 07</a></dd></div>
          <div><dt>Secrétariat de direction</dt><dd><a href="tel:+22891751515">(+228) 91 75 15 15</a></dd></div>
          <div><dt>E-mail</dt><dd><a href="mailto:archkortete@gmail.com">archkortete@gmail.com</a></dd></div>
        </dl>

        <div class="carte__actions">
          <a class="bouton" href="{{ route('contact.create') }}">Prendre rendez-vous</a>
          <a class="lien" href="https://wa.me/22891751515?text=Bonjour%2C%20je%20vous%20contacte%20depuis%20le%20site%20K-ARCHITECTES.">Écrire sur WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
