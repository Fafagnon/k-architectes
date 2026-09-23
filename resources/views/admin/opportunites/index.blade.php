@extends('layouts.admin')

@section('title', 'Gestion des Opportunités')

@section('content')
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 16px; margin-bottom: 32px;">
  <div>
    <h1 class="titre-section" style="margin: 0 0 8px 0;">Offres et opportunités.</h1>
    <p style="margin: 0; color: var(--graphite);">Gérez les recrutements d'architectes, dessinateurs, ingénieurs et stagiaires.</p>
  </div>
  <a href="{{ route('admin.opportunites.create') }}" class="bouton">+ Nouvelle offre</a>
</div>

@if($opportunities->isNotEmpty())
  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Poste visé</th>
          <th>Type</th>
          <th>Lieu</th>
          <th>Statut</th>
          <th>Date limite</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($opportunities as $opp)
          <tr>
            <td>
              <strong>{{ $opp->title }}</strong>
              <div style="font-size: .8125rem; color: var(--graphite);">{{ Str::limit($opp->excerpt, 80) }}</div>
            </td>
            <td><span style="font-weight: 700; font-size: .8125rem;">{{ $opp->contract_type }}</span></td>
            <td>{{ $opp->location }}</td>
            <td>
              <span class="statut-badge statut-badge--{{ $opp->status }}">
                {{ $opp->status === 'published' ? 'Ouverte' : ($opp->status === 'closed' ? 'Clôturée' : 'Brouillon') }}
              </span>
            </td>
            <td style="font-size: .8125rem; color: var(--graphite);">
              {{ $opp->application_deadline ? $opp->formatted_deadline : 'Non définie' }}
            </td>
            <td style="text-align: right; white-space: nowrap;">
              <a href="{{ route('opportunites.show', $opp) }}" target="_blank" class="lien" style="margin-right: 12px;">Voir</a>
              <a href="{{ route('admin.opportunites.edit', $opp) }}" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem; margin-right: 8px;">Modifier</a>
              
              <form action="{{ route('admin.opportunites.destroy', $opp) }}" method="post" style="display: inline;" onsubmit="return confirm('Supprimer définitivement cette offre ?');">
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
    {{ $opportunities->links() }}
  </div>
@else
  <div style="background: var(--blanc); border: var(--trait); padding: 48px; text-align: center;">
    <p class="opportunites-message" style="margin-bottom: 24px;">Aucune offre créée pour le moment.</p>
    <a href="{{ route('admin.opportunites.create') }}" class="bouton">Créer la première offre</a>
  </div>
@endif
@endsection
