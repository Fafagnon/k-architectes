@extends('layouts.admin')

@section('title', 'Rédiger un article')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div style="margin-bottom: 32px;">
  <a class="lien" href="{{ route('admin.articles.index') }}">← Retour à la liste des articles</a>
  <h1 class="titre-section" style="margin: 16px 0 8px 0;">Nouvel article.</h1>
</div>

<div style="background: var(--blanc); border: var(--trait); padding: clamp(24px, 4vw, 48px); max-width: 960px;">
  <form action="{{ route('admin.articles.store') }}" method="post" enctype="multipart/form-data" id="article-form" class="formulaire">
    @csrf

    <div class="champ @error('title') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="title">Titre de l'article *</label>
      <input id="title" name="title" type="text" required value="{{ old('title') }}" placeholder="ex: L'architecture bioclimatique au Togo...">
      @error('title') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('tag') champ--erreur @enderror">
        <label for="tag">Tag / Catégorie *</label>
        <input id="tag" name="tag" type="text" required value="{{ old('tag') }}" placeholder="ex: Recherche & Climat, Suivi de chantier, Matériaux locaux...">
        @error('tag') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('slug') champ--erreur @enderror">
        <label for="slug">Slug URL (optionnel)</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug') }}" placeholder="Laissez vide pour génération automatique">
        @error('slug') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('reading_minutes') champ--erreur @enderror">
        <label for="reading_minutes">Temps de lecture estimé (minutes)</label>
        <input id="reading_minutes" name="reading_minutes" type="number" min="1" max="120" value="{{ old('reading_minutes', 4) }}">
        @error('reading_minutes') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('status') champ--erreur @enderror">
        <label for="status">Statut de publication *</label>
        <select id="status" name="status" required>
          <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
          <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Publié</option>
        </select>
        @error('status') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('published_at') champ--erreur @enderror">
        <label for="published_at">Date de publication</label>
        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
        @error('published_at') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="champ @error('cover_image') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="cover_image">Photographie de couverture (Max. 20 Mo, compression auto 2400px)</label>
      <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp">
      <p style="font-size: .8125rem; color: var(--graphite); margin-top: 6px;">Format JPG, PNG ou WebP. Les photos haute résolution sont optimisées automatiquement avant stockage.</p>
      @error('cover_image') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('excerpt') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="excerpt">Résumé / Chapeau introductif * (max. 500 caractères)</label>
      <textarea id="excerpt" name="excerpt" rows="3" required maxlength="500" placeholder="Court texte d'introduction affiché sur la carte d'aperçu et en chapeau d'article...">{{ old('excerpt') }}</textarea>
      @error('excerpt') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('body') champ--erreur @enderror" style="margin-bottom: 32px;">
      <label for="editor">Corps de l'article *</label>
      <div id="editor">{!! old('body') !!}</div>
      <input type="hidden" name="body" id="body-input" value="{{ old('body') }}">
      @error('body') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: flex; gap: 16px; align-items: center;">
      <button type="submit" class="bouton">Enregistrer l'article</button>
      <a href="{{ route('admin.articles.index') }}" class="lien">Annuler</a>
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
    // Si l'éditeur contient une citation, ajouter la classe citation-architecte
    let html = quill.getSemanticHTML();
    html = html.replace(/<blockquote>/g, '<blockquote class="citation-architecte">');
    html = html.replace(/<ul>/g, '<ul class="liste-points">');
    bodyInput.value = html;
  });
});
</script>
@endpush
