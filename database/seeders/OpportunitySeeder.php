<?php

namespace Database\Seeders;

use App\Models\Opportunity;
use Illuminate\Database\Seeder;

class OpportunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opportunities = [
            [
                'title' => 'Architecte junior / Chargé de projet',
                'slug' => 'architecte-junior-charge-de-projet',
                'contract_type' => 'CDI',
                'location' => 'Lomé, Togo',
                'excerpt' => 'Participation active aux phases de conception (esquisse, APS, APD) et suivi de chantiers résidentiels et tertiaires à Lomé.',
                'body' => <<<'HTML'
<h3>Missions principales</h3>
<p>Au sein de l'équipe de conception de K-ARCHITECTES, vous intervenez sous la supervision directe des architectes associés sur des projets variés (habitat individuel, ensembles immobiliers, équipements tertiaires) :</p>
<ul class="liste-points">
  <li>Élaboration des dossiers graphiques aux différentes étapes (esquisses, avant-projets sommaires et définitifs).</li>
  <li>Production des pièces graphiques pour les dossiers de permis de construire et dossiers de consultation des entreprises (DCE).</li>
  <li>Recherches de références bioclimatiques et propositions d'intégration contextuelle.</li>
  <li>Participation aux réunions de coordination et visites de chantier hebdomadaires.</li>
</ul>

<h3>Profil recherché</h3>
<ul class="liste-points">
  <li>Diplôme d'architecte (DEA, Master ou équivalent reconnu par l'Ordre).</li>
  <li>1 à 3 ans d'expérience en agence ou cabinet d'architecture.</li>
  <li>Maîtrise d'Archicad ou Revit, AutoCAD, suite Adobe (Photoshop, InDesign) et outils de rendu 3D.</li>
  <li>Sensibilité affirmée pour l'architecture tropicale et les matériaux locaux (terre, bois, béton brut).</li>
  <li>Rigueur, curiosité technique et excellent esprit d'équipe.</li>
</ul>

<h3>Conditions</h3>
<p>Poste basé à Lomé (Agoè-Vakpossito). Rémunération selon profil et expérience. Prise de poste souhaitée dès que possible.</p>
HTML
                ,
                'application_deadline' => now()->addMonths(2)->toDateString(),
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Dessinateur-projeteur / Modeleur BIM',
                'slug' => 'dessinateur-projeteur-modeleur-bim',
                'contract_type' => 'CDI',
                'location' => 'Lomé, Togo',
                'excerpt' => 'Modélisation 3D, plans d’exécution détaillés et coordination technique sur maquette numérique pour projets d’envergure.',
                'body' => <<<'HTML'
<h3>Missions principales</h3>
<p>En relation constante avec les architectes concepteurs et les ingénieurs d'études :</p>
<ul class="liste-points">
  <li>Modélisation numérique des maquettes de bâtiments sous Archicad / Revit.</li>
  <li>Production des carnets de détails d'exécution (menuiseries, étanchéité, claustras, serrurerie).</li>
  <li>Vérification de la cohérence spatiale et détection des conflits techniques (structure / fluides).</li>
  <li>Préparation des métrés et quantitatifs estimatifs.</li>
</ul>

<h3>Profil recherché</h3>
<ul class="liste-points">
  <li>Formation Bac+2 à Bac+3 en dessin de bâtiment, génie civil ou équivalent.</li>
  <li>Minimum 2 ans d'expérience en bureau d'études ou agence d'architecture.</li>
  <li>Parfaite maîtrise des conventions graphiques et des normes constructives en vigueur au Togo.</li>
  <li>Rigueur absolue dans le calepinage et le respect des chartes graphiques de l'agence.</li>
</ul>
HTML
                ,
                'application_deadline' => now()->addMonth()->toDateString(),
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Stage — Fin d’études en architecture',
                'slug' => 'stage-fin-detudes-architecture',
                'contract_type' => 'Stage',
                'location' => 'Lomé, Togo',
                'excerpt' => 'Immersion de 6 mois au cœur d’une agence dynamique pour développer vos compétences de conception et de suivi de chantier.',
                'body' => <<<'HTML'
<h3>Objectifs du stage</h3>
<p>K-ARCHITECTES accueille chaque année de jeunes talents pour leur permettre de confronter leur formation académique à la réalité exigeante de la pratique professionnelle en Afrique de l'Ouest :</p>
<ul class="liste-points">
  <li>Immersion dans toutes les étapes d'un projet architectural, de l'esquisse au chantier.</li>
  <li>Développement de maquettes d'études et de rendus 3D de concours.</li>
  <li>Accompagnement de l'équipe sur le terrain pour appréhender le contrôle d'exécution et les relations avec les maîtres d'ouvrage.</li>
</ul>

<h3>Profil recherché</h3>
<p>Étudiant(e) en dernière année d'école d'architecture (EAMAU ou équivalent). Maîtrise des outils de DAO/CAO, autonomie et motivation.</p>
HTML
                ,
                'application_deadline' => now()->addMonths(3)->toDateString(),
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($opportunities as $data) {
            Opportunity::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
