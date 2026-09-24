@extends('layouts.admin')

@section('title', 'Message de ' . $message->nom_complet)

@section('content')
<div style="margin-bottom: 32px;">
  <a class="lien" href="{{ route('admin.messages.index') }}">← Retour à la liste des messages</a>
  <h1 class="titre-section" style="margin: 16px 0 8px 0;">Message de {{ $message->nom_complet }}.</h1>
</div>

<div style="background: var(--blanc); border: var(--trait); padding: clamp(24px, 4vw, 48px); max-width: 800px;">
  <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: var(--trait);">
    <div>
      <span class="statut-badge statut-badge--{{ $message->status }}">
        {{ $message->status === 'unread' ? 'Nouveau' : 'Lu' }}
      </span>
      <span style="font-size: .875rem; color: var(--graphite); margin-left: 12px;">
        Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}
      </span>
    </div>

    <form action="{{ route('admin.messages.toggle', $message) }}" method="post" style="display: inline;">
      @csrf
      <button type="submit" class="bouton bouton--secondaire" style="min-height: 32px; padding: 0 12px; font-size: .75rem;">
        Marquer comme {{ $message->status === 'unread' ? 'lu' : 'non lu' }}
      </button>
    </form>
  </div>

  <dl class="donnees" style="margin-bottom: 32px;">
    <div><dt>Nom complet</dt><dd><strong>{{ $message->nom_complet }}</strong></dd></div>
    @if($message->email)<div><dt>E-mail</dt><dd><a href="mailto:{{ $message->email }}" class="lien">{{ $message->email }}</a></dd></div>@endif
    @if($message->telephone)<div><dt>Téléphone</dt><dd><a href="tel:{{ $message->telephone }}">{{ $message->telephone }}</a></dd></div>@endif
    @if($message->ip_address)<div><dt>Adresse IP</dt><dd style="font-size: .8125rem; color: var(--graphite);">{{ $message->ip_address }}</dd></div>@endif
  </dl>

  <div style="margin-bottom: 32px;">
    <h2 style="font-size: 1.125rem; margin-bottom: 12px; text-transform: uppercase; letter-spacing: .05em;">Message :</h2>
    <div style="background: var(--calque); border: var(--trait); padding: 24px; font-size: 1rem; line-height: 1.7; white-space: pre-wrap;">{{ $message->message }}</div>
  </div>

  @if($message->attachment_path)
    <div style="margin-bottom: 36px; padding: 20px; background: var(--beton); border: var(--trait); display: flex; justify-content: space-between; align-items: center; gap: 16px;">
      <div>
        <strong style="font-size: .9375rem;">Pièce jointe fournie</strong>
        <div style="font-size: .8125rem; color: var(--graphite);">Fichier joint lors de la demande</div>
      </div>
      <a href="{{ route('admin.messages.download', $message) }}" class="bouton" style="min-height: 38px; padding: 0 18px; font-size: .8125rem;">
        Télécharger la pièce jointe ⤓
      </a>
    </div>
  @endif

  <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--beton); padding-top: 24px;">
    <div style="display: flex; gap: 12px;">
      @if($message->email)
        <a href="mailto:{{ $message->email }}" class="bouton">Répondre par e-mail</a>
      @endif
      @if($message->telephone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->telephone) }}" target="_blank" class="bouton bouton--secondaire">Écrire sur WhatsApp</a>
      @endif
    </div>

    <form action="{{ route('admin.messages.destroy', $message) }}" method="post" onsubmit="return confirm('Supprimer ce message définitivement ?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="bouton" style="background: #d60000; border-color: #d60000; color: #fff; min-height: 38px; padding: 0 16px; font-size: .8125rem;">Supprimer</button>
    </form>
  </div>
</div>
@endsection
