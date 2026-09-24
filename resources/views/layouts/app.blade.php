<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'K-ARCHITECTES | Cabinet d\'architecture à Lomé, Togo')</title>
<meta name="description" content="@yield('meta_description', 'K-ARCHITECTES, cabinet d\'architecture à Lomé : conception, suivi de chantier et contrôle de vos projets, de l\'esquisse à la livraison.')">
<link rel="canonical" href="@yield('canonical', url()->current())">
<meta name="theme-color" content="#f5f5f5">
<link rel="icon" href="{{ asset('assets/favicon.svg') }}" type="image/svg+xml">

@section('og_tags')
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="K-ARCHITECTES">
<meta property="og:title" content="@yield('title', 'K-ARCHITECTES | Cabinet d\'architecture à Lomé, Togo')">
<meta property="og:description" content="@yield('meta_description', 'K-ARCHITECTES, cabinet d\'architecture à Lomé : conception, suivi de chantier et contrôle de vos projets, de l\'esquisse à la livraison.')">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('assets/img/og-image.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@show

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

<script>document.documentElement.classList.add('js')</script>
<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}">
@stack('styles')
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}" defer></script>
<script src="{{ asset('assets/js/main.js') }}" defer></script>
@stack('scripts')
</head>
<body id="haut">
<a class="evitement" href="#contenu">Aller au contenu</a>
<header class="entete">
  <div class="conteneur entete__interieur">
    <a class="marque" href="{{ route('home') }}" aria-label="K-ARCHITECTES, accueil">
      <img src="{{ asset('assets/img/logo-k-embleme.png') }}" alt="" class="marque__logo" style="height:34px; width:auto; margin-right:12px; display:inline-block; vertical-align:middle;">
      <span class="marque__texte"><span class="nb">K-ARCHITECTES</span>.</span>
    </a>
    <button class="menu-bouton" type="button" aria-expanded="false" aria-controls="nav">Menu</button>
    <nav class="nav" id="nav" aria-label="Navigation principale">
      <ul class="nav__liste">
        <li><a class="nav__lien" href="{{ route('home') }}" {!! request()->routeIs('home') ? 'aria-current="page"' : '' !!}>Accueil</a></li>
        <li><a class="nav__lien" href="{{ route('cabinet') }}" {!! request()->routeIs('cabinet') ? 'aria-current="page"' : '' !!}>Le cabinet</a></li>
        <li><a class="nav__lien" href="{{ route('realisations.index') }}" {!! request()->routeIs('realisations.*') ? 'aria-current="page"' : '' !!}>Réalisations</a></li>
        <li><a class="nav__lien" href="{{ route('actualites.index') }}" {!! request()->routeIs('actualites.*') ? 'aria-current="page"' : '' !!}>Actualités</a></li>
        <li><a class="nav__lien" href="{{ route('opportunites.index') }}" {!! request()->routeIs('opportunites.*') ? 'aria-current="page"' : '' !!}>Opportunités</a></li>
        <li><a class="nav__lien nav__lien--cta" href="{{ route('contact.create') }}" {!! request()->routeIs('contact.*') ? 'aria-current="page"' : '' !!}>Contact</a></li>
      </ul>
    </nav>
  </div>
</header>

<main id="contenu" tabindex="-1">
  @yield('content')
</main>

<footer class="pied bande--noire">
  <div class="conteneur pied__haut">
    <p class="pied__nom" style="display:inline-flex; align-items:center; gap:12px;"><img src="{{ asset('assets/img/logo-k-embleme-blanc.png') }}" alt="" style="height:32px; width:auto; display:inline-block; vertical-align:middle;"><span><span class="nb">K-ARCHITECTES</span>.</span></p>
    <address>Agoè-Vakpossito, Rue NDE<br>(Notre-Dame de l'Église)<br>28 BP 305 Télessou<br>Lomé, Togo</address>
    <p><a href="mailto:archkortete@gmail.com">archkortete@gmail.com</a><br><a href="tel:+22822558638">(+228) 22 55 86 38</a><br><a href="tel:+22896500007">(+228) 96 50 00 07</a><br>Inscrit à l'<abbr title="Ordre national des architectes du Togo">ONAT</abbr></p>
  </div>
  <div class="conteneur pied__bas">
    <p>© {{ date('Y') }} <span class="nb">K-ARCHITECTES</span>. Tous droits réservés.</p>
    <a class="retour-haut" href="#haut">Retour en haut<span class="fleche fleche--haut" aria-hidden="true"></span></a>
  </div>
</footer>
</body>
</html>
