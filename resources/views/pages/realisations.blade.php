@extends('layouts.app')

@section('title', 'Réalisations | K-ARCHITECTES, architectes à Lomé')
@section('meta_description', 'Les réalisations de K-ARCHITECTES : habitat, bureaux, équipements publics et hôtellerie, conçus et suivis par le cabinet à Lomé et au Togo.')

@section('content')
<h1 class="visuellement-cache">Réalisations</h1>

<section class="bande bande--beton bande--realisations" aria-label="Liste des réalisations">
  <div class="conteneur">
    <ul class="index">
      @foreach($projects as $slug => $projet)
        <li class="index__item">
          <a class="index__lien" href="{{ route('realisations.show', $slug) }}">
            <div class="cadre" style="--ratio:16/10">
              <img src="{{ asset($projet['couverture']) }}" alt="{{ $projet['titre'] }}" loading="lazy" decoding="async">
              <div class="index__survol" aria-hidden="true">
                <span class="index__survol-badge">En savoir plus <span class="index__fleche">&rarr;</span></span>
              </div>
            </div>
            <div class="index__legende">
              <h2 class="index__titre">{{ $projet['titre'] }}</h2>
              <span class="index__mention" aria-hidden="true">En savoir plus <span class="index__fleche">&rarr;</span></span>
            </div>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</section>
@endsection
