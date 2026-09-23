@extends('layouts.admin')

@section('title', 'Gestion des Actualités')

@section('content')
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 16px; margin-bottom: 32px;">
  <div>
    <h1 class="titre-section" style="margin: 0 0 8px 0;">Actualités du cabinet.</h1>
    <p style="margin: 0; color: var(--graphite);">Rédigez et publiez les articles, retours de chantiers et réflexions architecturales.</p>
  </div>
  <a href="{{ route('admin.articles.create') }}" class="bouton">+ Rédiger un article</a>
</div>

@if($articles->isNotEmpty())
  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr>
          <th style="width: 70px;">Visuel</th>
          <th>Titre</th>
          <th>Tag / Catégorie</th>
          <th>Statut</th>
          <th>Publication</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($articles as $article)
          <tr>
            <td>
              <div class="cadre" style="--ratio: 1; width: 50px; height: 50px;">
                @if($article->cover_image_url)
                  <img src="{{ $article->cover_image_url }}" alt="" style="object-fit: cover;">
                @else
                  <div style="width:100%; height:100%; background:var(--beton);"></div>
                @endif
              </div>
            </td>
            <td>
              <strong>{{ $article->title }}</strong>
              <div style="font-size: .8125rem; color: var(--graphite);">{{ Str::limit($article->excerpt, 80) }}</div>
            </td>
            <td><span style="font-size: .8125rem; font-weight: 700;">{{ $article->tag }}</span></td>
            <td>
              <span class="statut-badge statut-badge--{{ $article->status }}">
                {{ $article->status === 'published' ? 'Publié' : 'Brouillon' }}
              </span>
            </td>
            <td style="font-size: .8125rem; color: var(--graphite);">
              {{ $article->published_at ? $article->formatted_date : 'Non planifié' }}
            </td>
            <td style="text-align: right; white-space: nowrap;">
              <a href="{{ route('actualites.show', $article) }}" target="_blank" class="lien" style="margin-right: 12px;">Voir</a>
              <a href="{{ route('admin.articles.edit', $article) }}" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem; margin-right: 8px;">Modifier</a>
              
              <form action="{{ route('admin.articles.destroy', $article) }}" method="post" style="display: inline;" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer cet article ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem; background: #d60000; border-color: #d60000; color: #fff;">Supprimer</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div style="margin-top: 32px;">
    {{ $articles->links() }}
  </div>
@else
  <div style="background: var(--blanc); border: var(--trait); padding: 48px; text-align: center;">
    <p class="opportunites-message" style="margin-bottom: 24px;">Aucun article pour le moment.</p>
    <a href="{{ route('admin.articles.create') }}" class="bouton">Créer le premier article</a>
  </div>
@endif
@endsection
