@extends('layouts.app')

@section('title', $project['titre'] . ' | Projets K-ARCHITECTES')
@section('meta_description', $project['titre'] . ' (' . $project['lieu'] . ', ' . $project['annee'] . '), projet du cabinet K-ARCHITECTES. ' . $project['chapeau'])

@section('og_tags')
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="K-ARCHITECTES">
<meta property="og:title" content="{{ $project['titre'] }} | Projets K-ARCHITECTES">
<meta property="og:description" content="{{ $project['chapeau'] }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset($project['couverture']) }}">
<meta name="twitter:card" content="summary_large_image">
@endsection

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Réalisations", "item": "{{ route('realisations.index') }}"},
    {"@type": "ListItem", "position": 3, "name": "{{ $project['titre'] }}", "item": "{{ url()->current() }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur fil">
  <nav aria-label="Fil d'Ariane">
    <ol>
      <li><a href="{{ route('realisations.index') }}">Réalisations</a></li>
      <li aria-current="page">{{ $project['titre'] }}</li>
    </ol>
  </nav>
</div>

<div class="conteneur">
  <h1 class="titre-page">{{ $project['titre'] }}.</h1>
</div>

<section class="conteneur fiche-corps" data-provisoire aria-label="Présentation du projet">
  <dl class="donnees">
    <div><dt>Lieu</dt><dd>{{ $project['lieu'] }}</dd></div>
    <div><dt>Année</dt><dd>{{ $project['annee'] }}</dd></div>
    <div><dt>Programme</dt><dd>{{ $project['programme'] }}</dd></div>
    <div><dt>Mission</dt><dd>{{ $project['mission'] }}</dd></div>
    <div><dt>Dimension</dt><dd>{{ $project['dimension'] }}</dd></div>
  </dl>
  <div class="fiche-corps__texte">
    <p class="chapeau">{{ $project['chapeau'] }}</p>
    {!! $project['description'] !!}
  </div>
</section>

<section class="conteneur section-diaporama" aria-label="Photographies du projet">
  <div class="diaporama" data-diaporama>
    <div class="diaporama__vue">
      <div class="diaporama__piste">
        @foreach($project['photos'] as $index => $photo)
          <div class="diaporama__diapo {{ $index === 0 ? 'est-active' : '' }}">
            <div class="cadre" style="--ratio:16/9">
              <img src="{{ asset($photo['src']) }}" alt="{{ $photo['alt'] }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" decoding="async">
            </div>
          </div>
        @endforeach
      </div>

      <button type="button" class="diaporama__fleche diaporama__fleche--prec" aria-label="Photo précédente">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button type="button" class="diaporama__fleche diaporama__fleche--suiv" aria-label="Photo suivante">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="square"><path d="M9 18l6-6-6-6"/></svg>
      </button>
    </div>

    <div class="diaporama__bas">
      <span class="diaporama__decompte" aria-live="polite">1/{{ count($project['photos']) }}</span>
    </div>
  </div>
</section>
@endsection
