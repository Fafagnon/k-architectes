@extends('layouts.admin')

@section('title', 'Modifier : ' . $opportunity->title)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
<div style="margin-bottom: 32px;">
  <a class="lien" href="{{ route('admin.opportunites.index') }}">← Retour à la liste des offres</a>
  <h1 class="titre-section" style="margin: 16px 0 8px 0;">Modifier l'offre.</h1>
</div>

<div style="background: var(--blanc); border: var(--trait); padding: clamp(24px, 4vw, 48px); max-width: 960px;">
  <form action="{{ route('admin.opportunites.update', $opportunity) }}" method="post" id="opportunity-form" class="formulaire">
    @csrf
    @method('PUT')

    <div class="champ @error('title') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="title">Intitulé du poste *</label>
      <input id="title" name="title" type="text" required value="{{ old('title', $opportunity->title) }}">
      @error('title') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('contract_type') champ--erreur @enderror">
        <label for="contract_type">Type de contrat *</label>
        <input id="contract_type" name="contract_type" type="text" required list="contrats-suggestions" value="{{ old('contract_type', $opportunity->contract_type) }}">
        <datalist id="contrats-suggestions">
          <option value="CDI">
          <option value="CDD">
          <option value="Stage">
          <option value="Freelance">
          <option value="Alternance">
        </datalist>
        @error('contract_type') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('location') champ--erreur @enderror">
        <label for="location">Lieu de travail *</label>
        <input id="location" name="location" type="text" required value="{{ old('location', $opportunity->location) }}">
        @error('location') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
      <div class="champ @error('slug') champ--erreur @enderror">
        <label for="slug">Slug URL</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $opportunity->slug) }}">
        @error('slug') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('status') champ--erreur @enderror">
        <label for="status">Statut de l'offre *</label>
        <select id="status" name="status" required>
          <option value="draft" {{ old('status', $opportunity->status) === 'draft' ? 'selected' : '' }}>Brouillon (non visible)</option>
          <option value="published" {{ old('status', $opportunity->status) === 'published' ? 'selected' : '' }}>Publiée (ouverte)</option>
          <option value="closed" {{ old('status', $opportunity->status) === 'closed' ? 'selected' : '' }}>Clôturée (visible mais non postulable)</option>
        </select>
        @error('status') <p class="erreur">{{ $message }}</p> @enderror
      </div>

      <div class="champ @error('application_deadline') champ--erreur @enderror">
        <label for="application_deadline">Date limite de candidature (optionnelle)</label>
        <input id="application_deadline" name="application_deadline" type="date" value="{{ old('application_deadline', $opportunity->application_deadline?->format('Y-m-d')) }}">
        @error('application_deadline') <p class="erreur">{{ $message }}</p> @enderror
      </div>
    </div>

    <div class="champ @error('excerpt') champ--erreur @enderror" style="margin-bottom: 24px;">
      <label for="excerpt">Résumé de l'offre * (max. 500 caractères)</label>
      <textarea id="excerpt" name="excerpt" rows="3" required maxlength="500">{{ old('excerpt', $opportunity->excerpt) }}</textarea>
      @error('excerpt') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('body') champ--erreur @enderror" style="margin-bottom: 32px;">
      <label for="editor">Description détaillée du poste *</label>
      <div id="editor">{!! old('body', $opportunity->body) !!}</div>
      <input type="hidden" name="body" id="body-input" value="{{ old('body', $opportunity->body) }}">
      @error('body') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div style="display: flex; gap: 16px; align-items: center;">
      <button type="submit" class="bouton">Mettre à jour l'offre</button>
      <a href="{{ route('admin.opportunites.index') }}" class="lien">Annuler</a>
      <a href="{{ route('opportunites.show', $opportunity) }}" target="_blank" class="lien" style="margin-left: auto;">Voir l'offre publique ↗</a>
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
    placeholder: 'Décrivez les missions, le profil et les modalités de recrutement...',
    modules: {
      toolbar: [
        [{ 'header': [3, false] }],
        ['bold', 'italic', 'underline'],
        [{ 'list': 'bullet' }],
        ['link'],
        ['clean']
      ]
    }
  });

  const form = document.getElementById('opportunity-form');
  const bodyInput = document.getElementById('body-input');

  form.addEventListener('submit', () => {
    let html = quill.getSemanticHTML();
    html = html.replace(/<ul>/g, '<ul class="liste-points">');
    bodyInput.value = html;
  });
});
</script>
@endpush
