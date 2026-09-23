@extends('layouts.admin')

@section('title', 'Gestion des candidatures')

@section('content')
<div style="margin-bottom: 32px;">
  <h1 class="titre-section" style="margin: 0 0 8px 0;">Candidatures reçues.</h1>
  <p style="margin: 0; color: var(--graphite);">Consultez les CVs et motivations des candidats pour les offres ou candidatures spontanées.</p>
</div>

@if($applications->isNotEmpty())
  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Statut</th>
          <th>Candidat</th>
          <th>Poste visé</th>
          <th>Contact</th>
          <th>CV</th>
          <th>Date</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($applications as $app)
          <tr style="{{ $app->isUnread() ? 'background: #fffdf5; font-weight: 700;' : '' }}">
            <td>
              <span class="statut-badge statut-badge--{{ $app->status }}">
                {{ $app->status === 'unread' ? 'Non lu' : ($app->status === 'reviewed' ? 'Examiné' : ($app->status === 'contacted' ? 'Contacté' : 'Rejeté')) }}
              </span>
            </td>
            <td>{{ $app->nom_complet }}</td>
            <td>
              <span style="font-weight: 700;">{{ $app->poste_vise }}</span>
              @if($app->opportunity)
                <div style="font-size: .75rem; color: var(--graphite); font-weight: normal;">Offre : {{ $app->opportunity->title }}</div>
              @endif
            </td>
            <td style="font-weight: normal; font-size: .8125rem;">
              <div><a href="mailto:{{ $app->email }}" class="lien">{{ $app->email }}</a></div>
              <div><a href="tel:{{ $app->telephone }}">{{ $app->telephone }}</a></div>
            </td>
            <td>
              <a href="{{ $app->cv_url }}" target="_blank" download class="bouton" style="min-height: 28px; padding: 0 10px; font-size: .75rem;">
                Télécharger CV ⤓
              </a>
            </td>
            <td style="font-size: .8125rem; font-weight: normal; color: var(--graphite);">
              {{ $app->created_at->format('d/m/Y H:i') }}
            </td>
            <td style="text-align: right; white-space: nowrap;">
              <a href="{{ route('admin.candidatures.show', $app) }}" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem; margin-right: 6px;">Détails</a>
              
              <form action="{{ route('admin.candidatures.destroy', $app) }}" method="post" style="display: inline;" onsubmit="return confirm('Supprimer définitivement cette candidature ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bouton" style="min-height: 32px; padding: 0 10px; font-size: .75rem; background: #d60000; border-color: #d60000; color: #fff;">✕</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div style="margin-top: 32px;">
    {{ $applications->links() }}
  </div>
@else
  <div style="background: var(--blanc); border: var(--trait); padding: 48px; text-align: center;">
    <p class="opportunites-message">Aucune candidature reçue pour le moment.</p>
  </div>
@endif
@endsection
