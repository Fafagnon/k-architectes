@extends('layouts.app')

@section('title', 'Qui sommes-nous | K-ARCHITECTES, Lomé')
@section('meta_description', 'Découvrez K-ARCHITECTES à Lomé : histoire du cabinet d\'architecture créé en 2016, l\'équipe et son Directeur Général Irénée KORTETE.')

@push('scripts')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ProfessionalService",
  "name": "K-ARCHITECTES",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/img/logo-k.png') }}",
  "image": "{{ asset('assets/img/og-image.jpg') }}",
  "email": "archkortete@gmail.com",
  "telephone": ["+228 22 55 86 38", "+228 96 50 00 07"],
  "foundingDate": "2016-06",
  "description": "Cabinet d'architecture à Lomé : conception, contrôle et réalisation de projets.",
  "areaServed": {"@type": "Country", "name": "Togo"},
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Agoè-Vakpossito, Rue NDE (Notre-Dame de l'Église)",
    "postOfficeBoxNumber": "28 BP 305 Télessou",
    "addressLocality": "Lomé",
    "addressCountry": "TG"
  }
}
</script>
@endpush

@section('content')
<div class="conteneur"><h1 class="titre-page">Qui sommes-nous.</h1></div>

<!-- Section 1 : Photo des bureaux & Histoire du cabinet -->
<section class="conteneur section-histoire" aria-label="Histoire du cabinet">
  <div class="section-histoire__grille">
    <div class="section-histoire__media">
      <div class="cadre" style="--ratio:4/3">
        <img src="{{ asset('assets/img/bureaux-k-architectes.jpg') }}" alt="Les bureaux et l'atelier de conception de K-ARCHITECTES à Lomé" loading="eager" decoding="async">
      </div>
    </div>
    <div class="section-histoire__contenu">
      <p class="chapeau">« Faire de votre rêve le nôtre et vous assister techniquement dans toutes les étapes de sa concrétisation », tel est le leitmotiv de la Société à Responsabilité Limitée <span class="nb">K-ARCHITECTES</span>, créée en juin 2016 à Lomé.</p>
      <p>Quoiqu'elle soit une jeune entreprise, l'agence réunit une équipe pluridisciplinaire d'architectes, d'ingénieurs et de techniciens présentant des capacités et une expérience considérables en matière de conception architecturale, de contrôle d'exécution et de réalisation de projets.</p>
      <p>Inscrit au tableau de l'Ordre National des Architectes du Togo (<abbr title="Ordre national des architectes du Togo">ONAT</abbr>), le cabinet a déjà conçu, piloté et livré plus d'une soixantaine de réalisations d'envergure — villas contemporaines, ensembles résidentiels, immeubles tertiaires et équipements d'intérêt public.</p>
      <dl class="cartouche-histoire">
        <div><dt>Création</dt><dd>Juin 2016</dd></div>
        <div><dt>Ordre</dt><dd>Inscrit à l'<abbr title="Ordre national des architectes du Togo">ONAT</abbr></dd></div>
        <div><dt>Localisation</dt><dd>Lomé, Togo</dd></div>
      </dl>
    </div>
  </div>
</section>

<!-- Section 2 : Focus Direction Générale (Irénée KORTETE) -->
<section class="bande bande--beton section-direction" aria-labelledby="t-direction">
  <div class="conteneur section-direction__grille">
    <div class="section-direction__media">
      <div class="cadre" style="--ratio:3/4">
        <img src="{{ asset('assets/img/direction-irenee-kortete.jpg') }}" alt="Irénée KORTETE, Directeur Général de K-ARCHITECTES" loading="lazy" decoding="async">
      </div>
    </div>
    <div class="section-direction__contenu">
      <span class="sur-titre">Direction générale</span>
      <h2 class="titre-section" id="t-direction">Irénée KORTETE</h2>
      <p class="section-direction__role">Directeur Général &amp; Fondateur de <span class="nb">K-ARCHITECTES</span>.</p>
      <div class="section-direction__texte">
        <p>Architecte diplômé et inscrit à l'Ordre National des Architectes du Togo (<abbr title="Ordre national des architectes du Togo">ONAT</abbr>), Irénée KORTETE dirige le cabinet avec une exigence affirmée de rigueur, de créativité contextuelle et de précision constructive.</p>
        <p>À la tête d'une équipe dynamique, il veille personnellement à ce que chaque client soit accompagné de l'esquisse à la livraison définitive, en garantissant la parfaite adéquation entre ambitions architecturales, respect budgétaire et maîtrise des délais.</p>
      </div>
      <div class="section-direction__action">
        <a class="bouton bouton--secondaire" href="{{ route('contact.create') }}">Prendre rendez-vous avec la direction <span class="fleche fleche--droite" aria-hidden="true"></span></a>
      </div>
    </div>
  </div>
</section>

<!-- Section 3 : Appel à projet (CTA) -->
<section class="bande bande--calque" aria-labelledby="t-appel">
  <div class="conteneur appel">
    <h2 class="titre-section" id="t-appel">Parlons de votre projet.</h2>
    <div>
      <p>Décrivez-le en quelques lignes. Le cabinet vous répond pour convenir d'un rendez-vous.</p>
      <a class="bouton" href="{{ route('contact.create') }}">Prendre rendez-vous</a>
    </div>
  </div>
</section>
@endsection
