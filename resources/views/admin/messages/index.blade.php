@extends('layouts.admin')

@section('title', 'Boîte de réception des messages')

@section('content')
<div style="margin-bottom: 32px;">
  <h1 class="titre-section" style="margin: 0 0 8px 0;">Messages de contact.</h1>
  <p style="margin: 0; color: var(--graphite);">Demandes de rendez-vous et prises de contact reçues depuis le site.</p>
</div>

@if($messages->isNotEmpty())
  <div style="overflow-x: auto;">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Statut</th>
          <th>Expéditeur</th>
          <th>Contact</th>
          <th>Message</th>
          <th>Pièce jointe</th>
          <th>Date</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($messages as $msg)
          <tr style="{{ $msg->isUnread() ? 'background: #fffdf5; font-weight: 700;' : '' }}">
            <td>
              <span class="statut-badge statut-badge--{{ $msg->status }}">
                {{ $msg->isUnread() ? 'Nouveau' : 'Lu' }}
              </span>
            </td>
            <td>{{ $msg->nom_complet }}</td>
            <td style="font-weight: normal; font-size: .8125rem;">
              @if($msg->email)<div><a href="mailto:{{ $msg->email }}" class="lien">{{ $msg->email }}</a></div>@endif
              @if($msg->telephone)<div><a href="tel:{{ $msg->telephone }}">{{ $msg->telephone }}</a></div>@endif
            </td>
            <td style="font-weight: normal;">
              {{ Str::limit($msg->message, 80) }}
            </td>
            <td>
              @if($msg->attachment_path)
                <a href="{{ $msg->attachment_url }}" target="_blank" class="lien" style="font-size: .8125rem;">Télécharger</a>
              @else
                <span style="color: var(--graphite); font-size: .8125rem;">Aucune</span>
              @endif
            </td>
            <td style="font-size: .8125rem; font-weight: normal; color: var(--graphite);">
              {{ $msg->created_at->format('d/m/Y H:i') }}
            </td>
            <td style="text-align: right; white-space: nowrap;">
              <a href="{{ route('admin.messages.show', $msg) }}" class="bouton" style="min-height: 32px; padding: 0 12px; font-size: .75rem; margin-right: 6px;">Consulter</a>
              
              <form action="{{ route('admin.messages.destroy', $msg) }}" method="post" style="display: inline;" onsubmit="return confirm('Supprimer ce message ?');">
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
    {{ $messages->links() }}
  </div>
@else
  <div style="background: var(--blanc); border: var(--trait); padding: 48px; text-align: center;">
    <p class="opportunites-message">Aucun message de contact dans la boîte de réception.</p>
  </div>
@endif
@endsection
