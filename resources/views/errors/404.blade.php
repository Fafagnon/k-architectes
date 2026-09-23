@extends('layouts.app')

@section('title', 'Page non trouvée | K-ARCHITECTES Lomé')
@section('meta_description', 'La page demandée est introuvable sur le site de K-ARCHITECTES.')

@section('content')
<div class="conteneur">
  <div class="introuvable" style="padding-block: clamp(64px, 12vw, 160px); display: grid; gap: 28px; justify-items: start;">
    <h1 class="titre-page" style="margin-block: 0 16px;">404. Page introuvable.</h1>
    <p class="chapeau">L'adresse demandée n'existe pas ou le document a été déplacé.</p>
    <div style="display: flex; flex-wrap: wrap; gap: 16px; margin-top: 16px;">
      <a class="bouton" href="{{ route('home') }}">Retour à l'accueil</a>
      <a class="bouton bouton--secondaire" href="{{ route('realisations.index') }}">Voir les réalisations</a>
    </div>
  </div>
</div>
@endsection
