@extends('layouts.app')

@section('title', 'Postuler | K-ARCHITECTES, Lomé')
@section('meta_description', 'Déposez votre candidature pour rejoindre K-ARCHITECTES à Lomé : architectes, projeteurs, ingénieurs et stagiaires.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Opportunités", "item": "{{ route('opportunites.index') }}"},
    {"@type": "ListItem", "position": 3, "name": "Postuler", "item": "{{ route('postuler.create') }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur">
  <h1 class="titre-page">Postuler.</h1>
</div>
<div class="conteneur">
  <p class="chapeau contact-page__intro">Rejoignez l'équipe de K-ARCHITECTES. Transmettez votre candidature et votre CV en remplissant le formulaire ci-dessous.</p>
</div>

<div class="conteneur contact-page">
  <form class="formulaire" data-formulaire action="{{ route('postuler.submit') }}" method="post"
        enctype="multipart/form-data" accept-charset="utf-8"
        data-ajax="{{ route('postuler.submit') }}">
    @csrf

    <p class="piege" aria-hidden="true" style="display:none;">
      <label>Ne pas remplir <input type="text" name="_honey" tabindex="-1" autocomplete="off"></label>
    </p>

    <div class="champ @error('Nom') champ--erreur @enderror">
      <label for="c-nom">Nom</label>
      <input id="c-nom" name="Nom" type="text" autocomplete="family-name" required value="{{ old('Nom') }}" data-erreur="Indiquez votre nom.">
      @error('Nom') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('Prenom') champ--erreur @enderror">
      <label for="c-prenom">Prénom</label>
      <input id="c-prenom" name="Prenom" type="text" autocomplete="given-name" required value="{{ old('Prenom') }}" data-erreur="Indiquez votre prénom.">
      @error('Prenom') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('email') champ--erreur @enderror">
      <label for="c-mail">E-mail</label>
      <input id="c-mail" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" data-erreur="Indiquez votre adresse e-mail." data-erreur-format="Cette adresse e-mail semble incomplète.">
      @error('email') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('Telephone') champ--erreur @enderror">
      <label for="c-tel">Téléphone</label>
      <input id="c-tel" name="Telephone" type="tel" inputmode="tel" autocomplete="tel" required value="{{ old('Telephone') }}" data-erreur="Indiquez votre numéro de téléphone.">
      @error('Telephone') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ champ--large @error('Poste_vise') champ--erreur @enderror">
      <label for="c-poste">Poste visé</label>
      <select id="c-poste" name="Poste_vise" required data-erreur="Sélectionnez le poste visé.">
        <option value="">Choisir un poste</option>
        
        @if(isset($openOpportunities) && $openOpportunities->isNotEmpty())
          <optgroup label="Offres actuellement ouvertes">
            @foreach($openOpportunities as $opp)
              <option value="{{ $opp->title }}" {{ (old('Poste_vise') == $opp->title || $selectedSlug == $opp->slug) ? 'selected' : '' }}>
                {{ $opp->title }} ({{ $opp->contract_type }})
              </option>
            @endforeach
          </optgroup>
        @endif

        <optgroup label="Candidature spontanée & autres">
          <option value="Candidature spontanée" {{ old('Poste_vise') == 'Candidature spontanée' ? 'selected' : '' }}>Candidature spontanée</option>
          <option value="Architecte" {{ old('Poste_vise') == 'Architecte' ? 'selected' : '' }}>Architecte</option>
          <option value="Dessinateur-projeteur / BIM" {{ old('Poste_vise') == 'Dessinateur-projeteur / BIM' ? 'selected' : '' }}>Dessinateur-projeteur / BIM</option>
          <option value="Ingénieur génie civil / Structure" {{ old('Poste_vise') == 'Ingénieur génie civil / Structure' ? 'selected' : '' }}>Ingénieur génie civil / Structure</option>
          <option value="Conducteur de travaux" {{ old('Poste_vise') == 'Conducteur de travaux' ? 'selected' : '' }}>Conducteur de travaux</option>
          <option value="Stage" {{ old('Poste_vise') == 'Stage' ? 'selected' : '' }}>Stage</option>
          <option value="Autre profil" {{ old('Poste_vise') == 'Autre profil' ? 'selected' : '' }}>Autre profil</option>
        </optgroup>
      </select>
      @error('Poste_vise') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ champ--large champ--fichier @error('attachment') champ--erreur @enderror">
      <label for="c-cv">Curriculum Vitae (CV)</label>
      <div class="zone-fichier" id="zone-fichier">
        <input id="c-cv" name="attachment" type="file" accept=".pdf,.doc,.docx" required class="fichier-input"
               data-erreur="Veuillez joindre votre CV (PDF, DOC ou DOCX).">
        <div class="fichier-label">
          <svg class="fichier-icone" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
          </svg>
          <div class="fichier-consigne">
            <span class="fichier-action">Cliquez pour choisir votre CV</span>
            <span class="fichier-formats">Formats acceptés : PDF, DOC, DOCX (max. 20 Mo)</span>
          </div>
        </div>
        <div class="fichier-apercu" id="fichier-apercu" hidden>
          <span class="fichier-nom" id="fichier-nom"></span>
          <button type="button" class="fichier-supprimer" id="fichier-supprimer" aria-label="Retirer ce fichier">✕</button>
        </div>
      </div>
      @error('attachment') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ champ--large @error('Message') champ--erreur @enderror">
      <label for="c-message">Votre message</label>
      <textarea id="c-message" name="Message" rows="6" required data-erreur="Rédigez votre message ou lettre de motivation."
                placeholder="Présentez brièvement votre parcours, vos motivations et vos compétences...">{{ old('Message') }}</textarea>
      @error('Message') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <button class="bouton" type="submit">Envoyer ma candidature</button>
    <p class="formulaire__note">Ces informations servent uniquement au traitement de votre candidature.</p>

    <div class="retour" id="retour-ok" role="status" tabindex="-1" hidden>
      <p><strong>Candidature envoyée avec succès.</strong></p>
      <p>Le cabinet K-ARCHITECTES a bien reçu votre CV et votre message. Nous reviendrons vers vous si votre profil correspond à nos besoins.</p>
    </div>
    <div class="retour" id="retour-echec" role="alert" tabindex="-1" hidden>
      <p><strong>L'envoi n'a pas abouti.</strong></p>
      <p>Écrivez directement à <a class="lien" href="mailto:archkortete@gmail.com">archkortete@gmail.com</a> en joignant votre CV.</p>
    </div>
  </form>

  <aside class="coordonnees" aria-labelledby="t-coord">
    <h2 id="t-coord">Recrutement.</h2>
    <address>K-ARCHITECTES<br>Agoè-Vakpossito, Rue NDE<br>(Notre-Dame de l'Église)<br>28 BP 305 Télessou<br>Lomé, Togo</address>
    <dl>
      <div>
        <dt>Standard</dt>
        <dd><a href="tel:+22822558638">(+228) 22 55 86 38</a></dd>
        <dd><a href="tel:+22896500007">(+228) 96 50 00 07</a></dd>
      </div>
      <div>
        <dt>E-mail recrutement</dt>
        <dd><a href="mailto:archkortete@gmail.com">archkortete@gmail.com</a></dd>
      </div>
    </dl>

    <div class="coordonnees__actions">
      <a class="lien" href="{{ route('opportunites.index') }}">← Revenir aux opportunités</a>
      <a class="lien" href="{{ route('contact.create') }}">Vous avez un projet ? Contactez le cabinet →</a>
    </div>
  </aside>
</div>
@endsection
