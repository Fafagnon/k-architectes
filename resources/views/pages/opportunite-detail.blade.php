@extends('layouts.app')

@section('title', $opportunity->title . ' | Recrutement K-ARCHITECTES')
@section('meta_description', $opportunity->excerpt)

@section('og_tags')
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="K-ARCHITECTES">
<meta property="og:title" content="{{ $opportunity->title }} | Recrutement K-ARCHITECTES">
<meta property="og:description" content="{{ $opportunity->excerpt }}">
<meta property="og:url" content="{{ $opportunity->share_url }}">
<meta property="og:image" content="{{ asset('assets/img/og-image.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Opportunités", "item": "{{ route('opportunites.index') }}"},
    {"@type": "ListItem", "position": 3, "name": "{{ addslashes($opportunity->title) }}", "item": "{{ $opportunity->share_url }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur fil">
  <nav aria-label="Fil d'Ariane">
    <ol>
      <li><a href="{{ route('home') }}">Accueil</a></li>
      <li><a href="{{ route('opportunites.index') }}">Opportunités</a></li>
      <li aria-current="page">{{ Str::limit($opportunity->title, 40) }}</li>
    </ol>
  </nav>
</div>

<article class="conteneur opportunite-detail" style="max-width: 900px; margin-inline: auto; padding-bottom: clamp(64px, 10vw, 120px);">
  <header style="margin-block: clamp(32px, 5vw, 64px) 32px;">
    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; font-size: .875rem; color: var(--graphite); margin-bottom: 16px;">
      <span style="font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--noir);">{{ $opportunity->contract_type }}</span>
      <span>·</span>
      <span>{{ $opportunity->location }}</span>
      @if($opportunity->application_deadline)
        <span>·</span>
        <span>Date limite : <strong>{{ $opportunity->formatted_deadline }}</strong></span>
      @endif
    </div>

    <h1 class="titre-page" style="margin-top: 0; margin-bottom: 24px; font-size: clamp(2rem, 1.3rem + 2.5vw, 3.5rem);">
      {{ $opportunity->title }}
    </h1>

    <p class="chapeau" style="margin-bottom: 32px;">
      {{ $opportunity->excerpt }}
    </p>

    @if($opportunity->is_open)
      <div>
        <a class="bouton" href="{{ route('postuler.create', ['poste' => $opportunity->slug]) }}">
          Postuler à cette offre <span class="fleche-droite" aria-hidden="true">→</span>
        </a>
      </div>
    @else
      <div style="padding: 16px 20px; background: var(--beton); border-left: 4px solid var(--noir); font-weight: 700;">
        Cette offre est désormais clôturée et n'accepte plus de nouvelles candidatures.
      </div>
    @endif
  </header>

  <div class="article-contenu" style="font-size: 1.0625rem; line-height: 1.7; color: #222; margin-top: 40px; padding-top: 32px; border-top: var(--trait);">
    {!! $opportunity->body !!}
  </div>

  @if($opportunity->is_open)
    <div style="margin-top: 48px; padding: 32px; background: var(--calque); border: var(--trait); text-align: center;">
      <h2 class="titre-section" style="font-size: 1.5rem; margin-bottom: 12px;">Intéressé(e) par cette mission ?</h2>
      <p style="margin-bottom: 24px; color: var(--graphite);">Transmettez-nous votre CV et vos motivations via notre formulaire de recrutement.</p>
      <a class="bouton" href="{{ route('postuler.create', ['poste' => $opportunity->slug]) }}">
        Postuler à cette offre
      </a>
    </div>
  @endif

  <!-- Section 9 : Partage sur les réseaux sociaux -->
  <footer style="margin-top: 56px; padding-top: 32px; border-top: var(--trait);">
    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 20px;">
      <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px;">
        <span style="font-size: .875rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;">Partager l'offre :</span>
        
        <!-- WhatsApp -->
        <a class="bouton" style="min-height: 40px; padding: 0 16px; font-size: .8125rem;" 
           href="https://wa.me/?text={{ rawurlencode($opportunity->title . ' ' . $opportunity->share_url) }}" 
           target="_blank" rel="noopener noreferrer" aria-label="Partager sur WhatsApp">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;" aria-hidden="true">
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
          </svg>
          WhatsApp
        </a>

        <!-- LinkedIn -->
        <a class="bouton" style="min-height: 40px; padding: 0 16px; font-size: .8125rem;" 
           href="https://www.linkedin.com/sharing/share-offsite/?url={{ rawurlencode($opportunity->share_url) }}" 
           target="_blank" rel="noopener noreferrer" aria-label="Partager sur LinkedIn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;" aria-hidden="true">
            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
            <rect x="2" y="9" width="4" height="12"/>
            <circle cx="4" cy="4" r="2"/>
          </svg>
          LinkedIn
        </a>

        <!-- X -->
        <a class="bouton" style="min-height: 40px; padding: 0 16px; font-size: .8125rem;" 
           href="https://twitter.com/intent/tweet?text={{ rawurlencode($opportunity->title) }}&url={{ rawurlencode($opportunity->share_url) }}" 
           target="_blank" rel="noopener noreferrer" aria-label="Partager sur X">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;" aria-hidden="true">
            <path d="M4 4l11.733 16h4.267l-11.733 -16z"/>
            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/>
          </svg>
          X
        </a>

        <!-- Facebook -->
        <a class="bouton" style="min-height: 40px; padding: 0 16px; font-size: .8125rem;" 
           href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($opportunity->share_url) }}" 
           target="_blank" rel="noopener noreferrer" aria-label="Partager sur Facebook">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;" aria-hidden="true">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
          </svg>
          Facebook
        </a>

        <!-- Copier le lien -->
        <button type="button" class="bouton" id="btn-copier-opp" style="min-height: 40px; padding: 0 16px; font-size: .8125rem;" data-url="{{ $opportunity->share_url }}">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;" aria-hidden="true">
            <rect x="9" y="9" width="13" height="13" rx="0" ry="0"/>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
          </svg>
          <span id="label-copier-opp">Copier le lien</span>
        </button>
      </div>

      <div>
        <a class="lien" href="{{ route('opportunites.index') }}">← Retour aux opportunités</a>
      </div>
    </div>
  </footer>
</article>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btn-copier-opp');
  const label = document.getElementById('label-copier-opp');
  if (btn && label) {
    btn.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(btn.dataset.url);
        label.textContent = 'Lien copié !';
        setTimeout(() => { label.textContent = 'Copier le lien'; }, 2500);
      } catch (e) {
        label.textContent = 'Erreur de copie';
      }
    });
  }
});
</script>
@endpush
@endsection
