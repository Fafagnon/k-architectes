@extends('layouts.app')

@section('title', 'Opportunités | K-ARCHITECTES Lomé Togo')
@section('meta_description', 'Opportunités d\'emploi et de collaboration au sein du cabinet d\'architecture K-ARCHITECTES à Lomé, Togo.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Opportunités", "item": "{{ route('opportunites.index') }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur">
  <h1 class="titre-page">Opportunités.</h1>
</div>

@if($opportunities->isEmpty())
  <div class="conteneur opportunites-page">
    <p class="opportunites-message">aucune opportunité pour l'instant</p>
    <div style="margin-top: 32px;">
      <a class="bouton" href="{{ route('postuler.create') }}">Déposer une candidature spontanée</a>
    </div>
  </div>
@else
  <section class="bande bande--calque" aria-label="Liste des opportunités">
    <div class="conteneur">
      <div style="margin-bottom: 48px; max-width: 800px;">
        <p class="chapeau">Rejoignez une équipe engagée pour une architecture rigoureuse, contextuelle et durable à Lomé et en Afrique de l'Ouest.</p>
      </div>

      <div class="actualites-grille">
        @foreach($opportunities as $opp)
          <article class="actualite-card">
            <div class="actualite-card__corps" style="padding-top: 24px;">
              <div class="actualite-card__meta">
                <span class="actualite-card__tag">{{ $opp->contract_type }}</span>
                <span>{{ $opp->location }}</span>
              </div>
              <h2 class="actualite-card__titre">
                <a class="actualite-card__titre-lien" href="{{ route('opportunites.show', $opp) }}">{{ $opp->title }}</a>
              </h2>
              <p class="actualite-card__chapeau">{{ $opp->excerpt }}</p>

              @if($opp->application_deadline)
                <p style="font-size: .875rem; color: var(--graphite); margin-top: 12px;">
                  Date limite : <strong>{{ $opp->formatted_deadline }}</strong>
                </p>
              @endif

              <div class="actualite-card__pied" style="margin-top: 24px;">
                @if($opp->is_open)
                  <a class="bouton" style="min-height: 44px; padding: 0 20px; font-size: .875rem;" href="{{ route('opportunites.show', $opp) }}">
                    Voir l'offre <span class="fleche-droite" aria-hidden="true">→</span>
                  </a>
                @else
                  <span style="font-size: .875rem; font-weight: 700; color: var(--graphite); text-transform: uppercase;">Offre pourvue</span>
                @endif
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div style="margin-top: 64px; padding: 32px; background: var(--beton); border: var(--trait); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 24px;">
        <div>
          <h2 class="titre-section" style="font-size: 1.5rem; margin-bottom: 8px;">Candidature spontanée</h2>
          <p style="margin: 0; color: var(--graphite);">Votre profil ne correspond à aucune offre ouverte ? Vous pouvez nous soumettre votre dossier.</p>
        </div>
        <a class="bouton" href="{{ route('postuler.create') }}">Postuler spontanément</a>
      </div>
    </div>
  </section>
@endif
@endsection
