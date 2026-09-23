@extends('layouts.app')

@section('title', 'Actualités | K-ARCHITECTES, cabinet d\'architecture à Lomé')
@section('meta_description', 'Suivez les actualités, réalisations, réflexions bioclimatiques et chantiers du cabinet d\'architecture K-ARCHITECTES à Lomé et au Togo.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Actualités", "item": "{{ route('actualites.index') }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur">
  <h1 class="titre-page">Actualités.</h1>
</div>

<section class="bande bande--calque actualites-section" aria-label="Liste des articles">
  <div class="conteneur">
    @if($articles->isNotEmpty())
      <div class="actualites-grille">
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
              <h2 class="actualite-card__titre">
                <a class="actualite-card__titre-lien" href="{{ route('actualites.show', $article) }}">{{ $article->title }}</a>
              </h2>
              <p class="actualite-card__chapeau">{{ $article->excerpt }}</p>
              <div class="actualite-card__pied">
                <span class="actualite-card__duree">{{ $article->reading_minutes ?? 4 }} min de lecture</span>
                <a class="actualite-card__action" href="{{ route('actualites.show', $article) }}">
                  Lire l'article <span class="fleche-droite" aria-hidden="true">→</span>
                </a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      @if($articles->hasPages())
        <div style="margin-top: 48px; display: flex; justify-content: center; gap: 16px;">
          @if(!$articles->onFirstPage())
            <a href="{{ $articles->previousPageUrl() }}" class="bouton">← Précédent</a>
          @endif
          @if($articles->hasMorePages())
            <a href="{{ $articles->nextPageUrl() }}" class="bouton">Suivant →</a>
          @endif
        </div>
      @endif
    @else
      <div class="opportunites-page">
        <p class="opportunites-message">Aucun article publié pour le moment.</p>
      </div>
    @endif
  </div>
</section>
@endsection
