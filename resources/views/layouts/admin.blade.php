<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Administration') | K-ARCHITECTES</title>
<link rel="icon" href="{{ asset('assets/favicon.svg') }}" type="image/svg+xml">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<style>
  /* Styles spécifiques au panneau d'administration, rigoureusement fidèles à l'identité K-ARCHITECTES */
  .admin-bar {
    background: var(--noir);
    color: var(--blanc);
    padding: 12px 0;
    border-bottom: 2px solid var(--noir);
  }
  .admin-bar__inner {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }
  .admin-nav {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .admin-nav__link {
    color: var(--blanc);
    text-decoration: none;
    font-size: .8125rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 6px 0;
    position: relative;
  }
  .admin-nav__link:hover, .admin-nav__link.is-active {
    border-bottom: 2px solid var(--blanc);
  }
  .admin-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    background: var(--blanc);
    color: var(--noir);
    font-size: .6875rem;
    font-weight: 700;
    margin-left: 4px;
    vertical-align: middle;
  }
  .admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 24px;
    background: var(--blanc);
    border: var(--trait);
    font-size: .9375rem;
  }
  .admin-table th, .admin-table td {
    padding: 14px 18px;
    text-align: left;
    border-bottom: 1px solid var(--beton);
  }
  .admin-table th {
    background: var(--calque);
    font-size: .8125rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 700;
    border-bottom: var(--trait);
  }
  .admin-table tr:hover {
    background: #fafafa;
  }
  .admin-stat-card {
    background: var(--blanc);
    border: var(--trait);
    padding: 24px;
  }
  .admin-stat-card__val {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -.03em;
  }
  .admin-stat-card__label {
    font-size: .8125rem;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--graphite);
    font-weight: 700;
  }
  .flash-alert {
    padding: 16px 20px;
    margin-bottom: 24px;
    border: var(--trait);
    font-weight: 700;
  }
  .flash-alert--succes {
    background: var(--noir);
    color: var(--blanc);
  }
  .flash-alert--erreur {
    background: #ffebeb;
    border-color: #d60000;
    color: #900000;
  }
  .statut-badge {
    display: inline-block;
    padding: 3px 8px;
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    border: 1px solid currentColor;
  }
  .statut-badge--published { background: var(--noir); color: var(--blanc); }
  .statut-badge--draft { background: var(--beton); color: var(--graphite); border-color: var(--graphite); }
  .statut-badge--closed { background: #e0e0e0; color: #666; border-color: #888; }
  .statut-badge--unread { background: var(--noir); color: var(--blanc); }
  .statut-badge--read { background: var(--beton); color: var(--graphite); }

  /* Éditeur de texte riche minimaliste */
  .ql-toolbar.ql-snow {
    border: var(--trait) !important;
    background: var(--calque);
    border-radius: 0 !important;
  }
  .ql-container.ql-snow {
    border: var(--trait) !important;
    border-top: none !important;
    background: var(--blanc);
    font-family: var(--police) !important;
    font-size: 1rem !important;
    border-radius: 0 !important;
    min-height: 280px;
  }
  .ql-editor {
    min-height: 280px;
    line-height: 1.65;
  }
</style>
@stack('styles')
</head>
<body style="background: var(--calque); min-height: 100vh; display: flex; flex-direction: column;">

<header class="admin-bar">
  <div class="conteneur admin-bar__inner">
    <div style="display: flex; align-items: center; gap: 16px;">
      <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 10px; color: var(--blanc); text-decoration: none;">
        <img src="{{ asset('assets/img/logo-k-embleme-blanc.png') }}" alt="" style="height: 26px; width: auto; display: inline-block; vertical-align: middle;">
        <strong style="font-size: 1rem; letter-spacing: -.02em;">K-ARCHITECTES</strong>
      </a>
      <span style="background: var(--graphite); color: var(--blanc); font-size: .6875rem; font-weight: 700; padding: 2px 6px; letter-spacing: .08em; text-transform: uppercase;">Admin</span>
    </div>

    <nav aria-label="Navigation administration">
      <ul class="admin-nav">
        <li><a class="admin-nav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li><a class="admin-nav__link {{ request()->routeIs('admin.articles.*') ? 'is-active' : '' }}" href="{{ route('admin.articles.index') }}">Actualités</a></li>
        <li><a class="admin-nav__link {{ request()->routeIs('admin.opportunites.*') ? 'is-active' : '' }}" href="{{ route('admin.opportunites.index') }}">Opportunités</a></li>
        <li>
          <a class="admin-nav__link {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}" href="{{ route('admin.messages.index') }}">
            Messages
            @php $countMsg = \App\Models\ContactMessage::where('status', 'unread')->count(); @endphp
            @if($countMsg > 0)<span class="admin-badge">{{ $countMsg }}</span>@endif
          </a>
        </li>
        <li>
          <a class="admin-nav__link {{ request()->routeIs('admin.candidatures.*') ? 'is-active' : '' }}" href="{{ route('admin.candidatures.index') }}">
            Candidatures
            @php $countCand = \App\Models\JobApplication::where('status', 'unread')->count(); @endphp
            @if($countCand > 0)<span class="admin-badge">{{ $countCand }}</span>@endif
          </a>
        </li>
      </ul>
    </nav>

    <div style="display: flex; align-items: center; gap: 16px;">
      <a href="{{ route('home') }}" target="_blank" style="color: var(--blanc); text-decoration: underline; font-size: .8125rem;">Voir le site public ↗</a>
      <form action="{{ route('admin.logout') }}" method="post" style="display: inline;">
        @csrf
        <button type="submit" class="bouton" style="min-height: 34px; padding: 0 16px; font-size: .75rem; background: transparent; border-color: var(--blanc); color: var(--blanc);">Déconnexion</button>
      </form>
    </div>
  </div>
</header>

<main style="flex: 1; padding: clamp(32px, 5vw, 64px) 0;">
  <div class="conteneur">
    @if(session('succes'))
      <div class="flash-alert flash-alert--succes">{{ session('succes') }}</div>
    @endif
    @if(session('info'))
      <div class="flash-alert" style="background: var(--beton);">{{ session('info') }}</div>
    @endif
    @if($errors->any())
      <div class="flash-alert flash-alert--erreur">
        <ul style="margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </div>
</main>

<footer style="background: var(--beton); border-top: var(--trait); padding: 20px 0; font-size: .8125rem; color: var(--graphite);">
  <div class="conteneur" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <span>Panneau d'administration K-ARCHITECTES · Lomé, Togo</span>
    <span>Connecté en tant que <strong>{{ Auth::user()->name ?? 'Administrateur' }}</strong></span>
  </div>
</footer>

@stack('scripts')
</body>
</html>
