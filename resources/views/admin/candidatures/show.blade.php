@extends('layouts.admin')

@section('title', 'Candidature de ' . $application->nom_complet)

@section('content')
<div style="margin-bottom: 32px;">
  <a class="lien" href="{{ route('admin.candidatures.index') }}">← Retour à la liste des candidatures</a>
  <h1 class="titre-section" style="margin: 16px 0 8px 0;">Candidature de {{ $application->nom_complet }}.</h1>
</div>

<div style="background: var(--blanc); border: var(--trait); padding: clamp(24px, 4vw, 48px); max-width: 800px;">
  <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: var(--trait);">
    <div>
      <span class="statut-badge statut-badge--{{ $application->status }}">
        {{ $application->status }}
      </span>
      <span style="font-size: .875rem; color: var(--graphite); margin-left: 12px;">
        Transmise le {{ $application->created_at->format('d/m/Y à H:i') }}
      </span>
    </div>

    <!-- Modification du statut -->
    <form action="{{ route('admin.candidatures.updateStatus', $application) }}" method="post" style="display: flex; align-items: center; gap: 8px;">
      @csrf
      @method('PATCH')
      <select name="status" style="font-size: .8125rem; padding: 6px 10px; border: var(--trait); font-weight: 700;">
        <option value="unread" {{ $application->status === 'unread' ? 'selected' : '' }}>Non lu</option>
        <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>Examiné</option>
        <option value="contacted" {{ $application->status === 'contacted' ? 'selected' : '' }}>Contacté</option>
        <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejeté</option>
      </select>
      <button type="submit" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem;">Actualiser</button>
    </form>
  </div>

  <dl class="donnees" style="margin-bottom: 32px;">
    <div><dt>Candidat</dt><dd><strong>{{ $application->nom_complet }}</strong></dd></div>
    <div><dt>Poste visé</dt><dd><strong>{{ $application->poste_vise }}</strong></dd></div>
    @if($application->opportunity)
      <div><dt>Offre associée</dt><dd><a href="{{ route('opportunites.show', $application->opportunity) }}" target="_blank" class="lien">{{ $application->opportunity->title }} ↗</a></dd></div>
    @endif
    <div><dt>E-mail</dt><dd><a href="mailto:{{ $application->email }}" class="lien">{{ $application->email }}</a></dd></div>
    <div><dt>Téléphone</dt><dd><a href="tel">{{ $application->telephone }}</a></dd></div>
  </dl>

  <!-- Bloc CV -->
  <div style="margin-bottom: 32px; padding: 24px; background: var(--beton); border: var(--trait); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
    <div>
      <h3 style="font-size: 1.125rem; margin: 0 0 4px 0;">Curriculum Vitae (CV)</h3>
      <div style="font-size: .8125rem; color: var(--graphite);">Document joint par le candidat</div>
    </div>
    <a href="{{ $application->cv_url }}" target="_blank" download class="bouton" style="min-height: 42px; padding: 0 20px;">
      Télécharger le CV ⤓
    </a>
  </div>

  <div style="margin-bottom: 32px;">
    <h2 style="font-size: 1.125rem; margin-bottom: 12px; text-transform: uppercase; letter-spacing: .05em;">Message & Motivations :</h2>
    <div style="background: var(--calque); border: var(--trait); padding: 24px; font-size: 1rem; line-height: 1.7; white-space: pre-wrap;">{{ $application->message }}</div>
  </div>

  <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--beton); padding-top: 24px;">
    <div style="display: flex; gap: 12px;">
      <a href="mailto:{{ $application->email }}?subject=Candidature%20K-ARCHITECTES%20—%20{{ rawurlencode($application->poste_vise) }}" class="bouton">Contacter par e-mail</a>
      <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $application->telephone) }}" target="_blank" class="bouton bouton--secondaire">Écrire sur WhatsApp</a>
    </div>

    <form action="{{ route('admin.candidatures.destroy', $application) }}" method="post" onsubmit="return confirm('Supprimer définitivement cette candidature ?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="bouton" style="background: #d60000; border-color: #d60000; color: #fff; min-height: 38px; padding: 0 16px; font-size: .8125rem;">Supprimer</button>
    </form>
  </div>
</div>
@endsection
