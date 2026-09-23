@extends('layouts.app')

@section('title', 'Contact | K-ARCHITECTES, Lomé Togo')
@section('meta_description', 'Contactez le cabinet d\'architecture K-ARCHITECTES à Lomé : adresse, téléphones, plan d\'accès et formulaire de contact.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type": "ListItem", "position": 1, "name": "Accueil", "item": "{{ route('home') }}"},
    {"@type": "ListItem", "position": 2, "name": "Contact", "item": "{{ route('contact.create') }}"}
  ]
}
</script>
@endpush

@section('content')
<div class="conteneur">
  <h1 class="titre-page">Contact.</h1>
</div>
<div class="conteneur">
  <p class="chapeau contact-page__intro">Un projet d'architecture, une étude de faisabilité ou un besoin d'expertise ? Transmettez votre demande au cabinet.</p>
</div>

<div class="conteneur contact-page">
  <form class="formulaire" data-formulaire action="{{ route('contact.submit') }}" method="post"
        enctype="multipart/form-data" accept-charset="utf-8"
        data-ajax="{{ route('contact.submit') }}">
    @csrf

    <p class="piege" aria-hidden="true" style="display:none;">
      <label>Ne pas remplir <input type="text" name="_honey" tabindex="-1" autocomplete="off"></label>
    </p>

    <div class="champ @error('Nom') champ--erreur @enderror">
      <label for="f-nom">Nom</label>
      <input id="f-nom" name="Nom" type="text" autocomplete="family-name" required value="{{ old('Nom') }}" data-erreur="Indiquez votre nom.">
      @error('Nom') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('Prenom') champ--erreur @enderror">
      <label for="f-prenom">Prénom</label>
      <input id="f-prenom" name="Prenom" type="text" autocomplete="given-name" required value="{{ old('Prenom') }}" data-erreur="Indiquez votre prénom.">
      @error('Prenom') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('email') champ--erreur @enderror">
      <label for="f-mail">E-mail</label>
      <input id="f-mail" name="email" type="email" autocomplete="email" value="{{ old('email') }}" data-erreur-format="Cette adresse e-mail semble incomplète.">
      @error('email') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ @error('Telephone') champ--erreur @enderror">
      <label for="f-tel">Téléphone</label>
      <input id="f-tel" name="Telephone" type="tel" inputmode="tel" autocomplete="tel" value="{{ old('Telephone') }}" data-erreur="Indiquez au moins un moyen de contact.">
      @error('Telephone') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ champ--large @error('Message') champ--erreur @enderror">
      <label for="f-message">Votre message</label>
      <textarea id="f-message" name="Message" rows="6" required data-erreur="Décrivez brièvement votre projet."
                placeholder="Présentez brièvement votre projet d'architecture (nature des travaux, localisation, superficie, besoins, calendrier souhaité)...">{{ old('Message') }}</textarea>
      @error('Message') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <div class="champ champ--large champ--fichier @error('attachment') champ--erreur @enderror">
      <label for="f-fichier">Joindre un fichier (optionnel)</label>
      <div class="zone-fichier" id="zone-fichier">
        <input id="f-fichier" name="attachment" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp,.dwg" class="fichier-input">
        <div class="fichier-label">
          <svg class="fichier-icone" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
               stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
          </svg>
          <div class="fichier-consigne">
            <span class="fichier-action">Cliquez pour choisir un fichier</span>
            <span class="fichier-formats">Formats acceptés : PDF, JPG, PNG, DOCX, DWG (max. 20 Mo)</span>
          </div>
        </div>
        <div class="fichier-apercu" id="fichier-apercu" hidden>
          <span class="fichier-nom" id="fichier-nom"></span>
          <button type="button" class="fichier-supprimer" id="fichier-supprimer" aria-label="Retirer ce fichier">✕</button>
        </div>
      </div>
      @error('attachment') <p class="erreur">{{ $message }}</p> @enderror
    </div>

    <button class="bouton" type="submit">Envoyer ma demande</button>

    <div class="retour" id="retour-ok" role="status" tabindex="-1" hidden>
      <p><strong>Message envoyé avec succès.</strong></p>
      <p>Le cabinet K-ARCHITECTES a bien reçu votre demande et vous répondra par téléphone ou par e-mail dans les plus brefs délais.</p>
    </div>
    <div class="retour" id="retour-echec" role="alert" tabindex="-1" hidden>
      <p><strong>L'envoi n'a pas abouti.</strong></p>
      <p>Écrivez directement à <a class="lien" href="mailto:archkortete@gmail.com">archkortete@gmail.com</a> ou <a class="lien" href="https://wa.me/22891751515?text=Bonjour%2C%20je%20vous%20contacte%20depuis%20le%20site%20K-ARCHITECTES.">sur WhatsApp</a>.</p>
    </div>
  </form>

  <aside class="coordonnees" aria-labelledby="t-coord">
    <h2 id="t-coord"><span class="nb">K-ARCHITECTES</span>.</h2>
    <address>Agoè-Vakpossito, Rue NDE<br>(Notre-Dame de l'Église)<br>28 BP 305 Télessou<br>Lomé, Togo</address>
    <dl>
      <div>
        <dt>Standard</dt>
        <dd><a href="tel:+22822558638">(+228) 22 55 86 38</a></dd>
        <dd><a href="tel:+22896500007">(+228) 96 50 00 07</a></dd>
      </div>
      <div>
        <dt>Secrétariat de direction</dt>
        <dd><a href="tel:+22891751515">(+228) 91 75 15 15</a></dd>
      </div>
      <div>
        <dt>E-mail</dt>
        <dd><a href="mailto:archkortete@gmail.com">archkortete@gmail.com</a></dd>
      </div>
      <div>
        <dt>Ordre professionnel</dt>
        <dd>Inscrit au tableau de l'<abbr title="Ordre national des architectes du Togo">ONAT</abbr></dd>
      </div>
    </dl>

    <div class="coordonnees__actions">
      <a class="bouton" href="https://wa.me/22891751515?text=Bonjour%2C%20je%20vous%20contacte%20depuis%20le%20site%20K-ARCHITECTES.">Écrire sur WhatsApp</a>
      <a class="lien" href="https://www.google.com/maps/search/?api=1&query=K-ARCHITECTES%20Ago%C3%A8-Vakpossito%20Lom%C3%A9%20Togo" target="_blank" rel="noopener noreferrer">Plan d'accès Google Maps →</a>
    </div>
  </aside>
</div>
@endsection
