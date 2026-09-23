@extends('layouts.admin')

@section('title', 'Modifier : ' . $article->title)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div style="margin-bottom: 32px;">
  <a class="lien" href="{{ route('admin.articles.index') }}">← Retour à la liste des articles</a>
  <h1 class="titre-section" style="margin: 16px 0 8px 0;">Modifier l'article.</h1>
</div>

<div style="background: var(--blanc); border: var(--trait); padding: clamp(24px, 4vw, 48px); max-width: 960px;">
  <form action="{{ route('admin.articles.update', $article) }}" method="post" enctype="multipart/form-data" id="article-form" class="formulaire">
    @csrf
    @method('PUT')

    <div class="champ @error('title') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="title">Titre de l'article *</label>
      <input id="title" name="title" type="text" required value="{{ old('title', $article->title) }}">
      @error('title') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('tag') champ--erreur @enderror">
        <label for="tag">Tag / Catégorie *</label>
        <input id="tag" name="tag" type="text" required value="{{ old('tag', $article->tag) }}">
        @error('tag') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('slug') champ--erreur @enderror">
        <label for="slug">Slug URL</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $article->slug) }}">
        @error('slug') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('reading_minutes') champ--erreur @enderror">
        <label for="reading_minutes">Temps de lecture estimé (minutes)</label>
        <input id="reading_minutes" name="reading_minutes" type="number" min="1" max="120" value="{{ old('reading_minutes', $article->reading_minutes) }}">
        @error('reading_minutes') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('status') champ--erreur @enderror">
        <label for="status">Statut de publication *</label>
        <select id="status" name="status" required>
          <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Brouillon</option>
          <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Publié</option>
        </select>
        @error('status') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('published_at') champ--erreur @enderror">
        <label for="published_at">Date de publication</label>
        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}">
        @error('published_at') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="champ @error('cover_image') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="cover_image">Photographie de couverture</label>
      
      @if($article->cover_image_url)
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 16px; padding: 12px; background: var(--calque); border: var(--trait);">
          <img src="{{ $article->cover_image_url }}" alt="" style="width: 120px; height: 75px; object-fit: cover;">
          <div>
            <p style="margin: 0 0 8px 0; font-size: .875rem; font-weight: 700;">Image actuelle</p>
            <label style="font-size: .8125rem; display: flex; align-items: center; gap: 6px; cursor: pointer; color: #d60000;">
              <input type="checkbox" name="supprimer_image" value="1">
              <span>Supprimer cette image</span>
            </label>
          </div>
        </div>
      @endif

      <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp">
      <p style="font-size: .8125rem; color: var(--graphite); margin-top: 6px;">Téléversez un nouveau fichier pour remplacer l'image existante (Max 20 Mo, JPG, PNG, WebP).</p>
      @error('cover_image') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('excerpt') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="excerpt">Résumé / Chapeau introductif * (max. 500 caractères)</label>
      <textarea id="excerpt" name="excerpt" rows="3" required maxlength="500">{{ old('excerpt', $article->excerpt) }}</textarea>
      @error('excerpt') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('body') champ--erreur @enderror" style="margin-bottom: 32px;">
      <label for="editor">Corps de l'article *</label>
      <div id="editor">{!! old('body', $article->body) !!}</div>
      <input type="hidden" name="body" id="body-input" value="{{ old('body', $article->body) }}">
      @error('body') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: flex; gap: 16px; align-items: center;">
      <button type="submit" class="bouton">Mettre à jour l'article</button>
      <a href="{{ route('admin.articles.index') }}" class="lien">Annuler</a>
      <a href="{{ route('actualites.show', $article) }}" target="_blank" class="lien" style="margin-left: auto;">Prévisualiser l'article public ↗</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Rédigez le contenu complet de votre article...',
    modules: {
      toolbar: [
        [{ 'header': [3, false] }],
        ['bold', 'italic', 'underline'],
        ['blockquote'],
        [{ 'list': 'bullet' }],
        ['link'],
        ['clean']
      ]
    }
  });

  const form = document.getElementById('article-form');
  const bodyInput = document.getElementById('body-input');

  form.addEventListener('submit', () => {
    let html = quill.getSemanticHTML();
    html = html.replace(/<blockquote>/g, '<blockquote class="citation-architecte">');
    html = html.replace(/<ul>/g, '<ul class="liste-points">');
    bodyInput.value = html;
  });
});
</script>
@endpush
