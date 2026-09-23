@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: 16px; margin-bottom: 32px;">
  <div>
    <h1 class="titre-section" style="margin: 0 0 8px 0;">Tableau de bord.</h1>
    <p style="margin: 0; color: var(--graphite);">Gestion des publications et des interactions du cabinet.</p>
  </div>
  <div style="display: flex; gap: 12px;">
    <a href="{{ route('admin.articles.create') }}" class="bouton">+ Nouvel article</a>
    <a href="{{ route('admin.opportunites.create') }}" class="bouton bouton--secondaire">+ Nouvelle opportunité</a>
  </div>
</div>

<!-- Statistiques synthétiques -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 48px;">
  <div class="admin-stat-card">
    <div class="admin-stat-card__val">{{ $stats['published_articles'] }} <span style="font-size: 1rem; color: var(--graphite);">/ {{ $stats['total_articles'] }}</span></div>
    <div class="admin-stat-card__label">Articles publiés</div>
  </div>

  <div class="admin-stat-card">
    <div class="admin-stat-card__val">{{ $stats['open_opportunities'] }} <span style="font-size: 1rem; color: var(--graphite);">/ {{ $stats['total_opportunities'] }}</span></div>
    <div class="admin-stat-card__label">Offres en cours</div>
  </div>

  <div class="admin-stat-card" style="{{ $stats['unread_messages'] > 0 ? 'background: #fff8e6;' : '' }}">
    <div class="admin-stat-card__val">{{ $stats['unread_messages'] }}</div>
    <div class="admin-stat-card__label">Messages non lus (Total: {{ $stats['total_messages'] }})</div>
  </div>

  <div class="admin-stat-card" style="{{ $stats['unread_applications'] > 0 ? 'background: #fff8e6;' : '' }}">
    <div class="admin-stat-card__val">{{ $stats['unread_applications'] }}</div>
    <div class="admin-stat-card__label">Candidatures à traiter (Total: {{ $stats['total_applications'] }})</div>
  </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 36px;">
  <!-- Derniers Articles -->
  <div style="background: var(--blanc); border: var(--trait); padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
      <h2 style="font-size: 1.25rem; margin: 0;">Dernières actualités</h2>
      <a class="lien" href="{{ route('admin.articles.index') }}">Toutes les actualités →</a>
    </div>

    @if($recentArticles->isNotEmpty())
      <table class="admin-table" style="margin-top: 0;">
        <thead>
          <tr>
            <th>Titre</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentArticles as $art)
            <tr>
              <td>
                <strong>{{ Str::limit($art->title, 40) }}</strong>
                <div style="font-size: .75rem; color: var(--graphite);">{{ $art->tag }} · {{ $art->formatted_date }}</div>
              </td>
              <td>
                <span class="statut-badge statut-badge--{{ $art->status }}">
                  {{ $art->status === 'published' ? 'Publié' : 'Brouillon' }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.articles.edit', $art) }}" class="lien">Éditer</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p style="color: var(--graphite); margin: 16px 0;">Aucun article créé.</p>
    @endif
  </div>

  <!-- Dernières Opportunités -->
  <div style="background: var(--blanc); border: var(--trait); padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
      <h2 style="font-size: 1.25rem; margin: 0;">Dernières opportunités</h2>
      <a class="lien" href="{{ route('admin.opportunites.index') }}">Toutes les offres →</a>
    </div>

    @if($recentOpportunities->isNotEmpty())
      <table class="admin-table" style="margin-top: 0;">
        <thead>
          <tr>
            <th>Intitulé</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentOpportunities as $opp)
            <tr>
              <td>
                <strong>{{ Str::limit($opp->title, 35) }}</strong>
                <div style="font-size: .75rem; color: var(--graphite);">{{ $opp->location }}</div>
              </td>
              <td>{{ $opp->contract_type }}</td>
              <td>
                <span class="statut-badge statut-badge--{{ $opp->status }}">
                  {{ $opp->status === 'published' ? 'Ouverte' : ($opp->status === 'closed' ? 'Clôturée' : 'Brouillon') }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.opportunites.edit', $opp) }}" class="lien">Éditer</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p style="color: var(--graphite); margin: 16px 0;">Aucune opportunité créée.</p>
    @endif
  </div>

  <!-- Derniers Messages de Contact -->
  <div style="background: var(--blanc); border: var(--trait); padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
      <h2 style="font-size: 1.25rem; margin: 0;">Derniers messages reçus</h2>
      <a class="lien" href="{{ route('admin.messages.index') }}">Boîte de réception →</a>
    </div>

    @if($recentMessages->isNotEmpty())
      <table class="admin-table" style="margin-top: 0;">
        <thead>
          <tr>
            <th>Expéditeur</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentMessages as $msg)
            <tr style="{{ $msg->isUnread() ? 'font-weight: 700;' : '' }}">
              <td>
                {{ $msg->nom_complet }}
                <div style="font-size: .75rem; color: var(--graphite); font-weight: normal;">{{ $msg->email ?? $msg->telephone }}</div>
              </td>
              <td style="font-size: .8125rem;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
              <td>
                <span class="statut-badge statut-badge--{{ $msg->status }}">
                  {{ $msg->isUnread() ? 'Non lu' : 'Lu' }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.messages.show', $msg) }}" class="lien">Consulter</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p style="color: var(--graphite); margin: 16px 0;">Aucun message reçu pour l'instant.</p>
    @endif
  </div>

  <!-- Dernières Candidatures -->
  <div style="background: var(--blanc); border: var(--trait); padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
      <h2 style="font-size: 1.25rem; margin: 0;">Dernières candidatures</h2>
      <a class="lien" href="{{ route('admin.candidatures.index') }}">Toutes les candidatures →</a>
    </div>

    @if($recentApplications->isNotEmpty())
      <table class="admin-table" style="margin-top: 0;">
        <thead>
          <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Statut</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentApplications as $app)
            <tr style="{{ $app->isUnread() ? 'font-weight: 700;' : '' }}">
              <td>
                {{ $app->nom_complet }}
                <div style="font-size: .75rem; color: var(--graphite); font-weight: normal;">{{ $app->email }}</div>
              </td>
              <td style="font-size: .8125rem;">{{ $app->poste_vise }}</td>
              <td>
                <span class="statut-badge statut-badge--{{ $app->status }}">
                  {{ $app->status }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.candidatures.show', $app) }}" class="lien">Voir CV</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p style="color: var(--graphite); margin: 16px 0;">Aucune candidature reçue pour l'instant.</p>
    @endif
  </div>
</div>
@endsection
