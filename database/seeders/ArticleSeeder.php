<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => "L'architecture bioclimatique au Togo : concevoir avec le climat tropical",
                'slug' => 'architecture-bioclimatique-togo-climat-tropical',
                'tag' => 'Recherche & Climat',
                'reading_minutes' => 4,
                'published_at' => '2026-09-14 10:00:00',
                'status' => 'published',
                'cover_image' => 'assets/img/actualite-01.jpg',
                'excerpt' => "Ventilation naturelle traversante, claustras en terre cuite et brise-soleil orientés : adapter nos conceptions au climat de Lomé pour allier confort et sobriété.",
                'body' => <<<'HTML'
<p class="chapeau">Concevoir un bâtiment sur la côte togolaise exige une compréhension intime des dynamiques atmosphériques : chaleur permanente, humidité relative oscillant entre 75% et 90%, et vents côtiers réguliers soufflant du Sud-Sud-Ouest.</p>

<h3>1. Orienter et protéger avant de climatiser</h3>
<p>L'erreur récurrente des architectures importées consiste à multiplier les surfaces vitrées sans protection solaire, transformant les intérieurs en serres thermiques dépendantes à 100% de la climatisation artificielle. Chez <strong>K-ARCHITECTES</strong>, chaque projet débute par une étude d'ensoleillement millimétrée.</p>
<p>Nous privilégions des façades principales orientées Nord et Sud, limitant l'exposition aux rayons rasants d'Est et d'Ouest, complétées par des casquettes béton généreuses et des auvents protecteurs.</p>

<blockquote class="citation-architecte">
  <p>« En climat tropical humide, la climatisation ne doit jamais être la solution de rattrapage d'une mauvaise conception. Le premier régulateur thermique, c'est l'enveloppe architecturale elle-même. »</p>
  <cite>— Irénée KORTETE, Directeur général de K-ARCHITECTES</cite>
</blockquote>

<h3>2. La ventilation traversante et la réinvention du claustra</h3>
<p>Pour dissiper l'humidité et créer une sensation de fraîcheur corporelle, l'air intérieur doit être constamment renouvelé. Nous mettons en œuvre des dispositifs de <em>tirage thermique passif</em> : courettes intérieures végétalisées, doubles hauteurs sous plafond et parois perforées en moucharabiehs de béton ou briques ajourées.</p>
<p>Ces éléments agissent comme de véritables filtres climatiques : ils tamisent la lumière aveuglante du soleil zénithal, assurent une intimité visuelle et laissent circuler les brises marines bienfaisantes sans consommer le moindre kilowatt-heure.</p>

<h3>3. Une esthétique indissociable de la fonction</h3>
<p>Loin d'être une contrainte technique, le bioclimatisme façonne notre signature formelle : des lignes tendues, des jeux d'ombres et de lumières rythmés, et des volumes sculptés pour faire corps avec la géographie de Lomé.</p>
HTML
            ],
            [
                'title' => "Chantier Immeuble Tokoin : achèvement du gros œuvre et pose des façades",
                'slug' => 'chantier-immeuble-tokoin-gros-oeuvre-facades',
                'tag' => 'Suivi de chantier',
                'reading_minutes' => 3,
                'published_at' => '2026-08-28 09:30:00',
                'status' => 'published',
                'cover_image' => 'assets/img/actualite-02.jpg',
                'excerpt' => "Point d'étape technique sur la coulée des voiles béton et le calepinage des coursives extérieures. Contrôle rigoureux à chaque étape charnière.",
                'body' => <<<'HTML'
<p class="chapeau">Une étape majeure vient d'être franchie sur le chantier de l'immeuble tertiaire de Tokoin : le coulage de la dernière dalle haute a été validé avec succès par notre équipe de maîtrise d'œuvre d'exécution.</p>

<h3>Rigueur des contrôles et cure du béton</h3>
<p>Sous les températures élevées de Lomé, la cure du béton armé requiert un protocole d'humidification rigoureux pour éviter tout phénomène de fissuration par retrait. Nos ingénieurs et architectes effectuent des visites hebdomadaires inopinées pour contrôler la conformité des ferraillages, les résistances d'éprouvettes et la verticalité des voiles porteurs.</p>

<h3>Coordination des corps d'état secondaires</h3>
<p>Le second œuvre démarre immédiatement :</p>
<ul class="liste-points">
  <li>Pose des précadres pour les menuiseries aluminium à rupture de pont thermique.</li>
  <li>Passage des réseaux encastrés (électricité basse tension, fibre et plomberie multicouche).</li>
  <li>Application des complexes d'étanchéité multicouches protégés sur les toitures terrasses inaccessibles.</li>
</ul>

<blockquote class="citation-architecte">
  <p>« Le dessin architectural ne prend tout son sens que s'il est soutenu par une exigence sans compromis sur le chantier. Le respect des délais et des standards de sécurité est notre engagement premier envers le maître d'ouvrage. »</p>
</blockquote>

<p>La livraison de cet édifice contemporain de quatre niveaux reste programmée pour le premier trimestre 2027.</p>
HTML
            ],
            [
                'title' => "Table ronde de l'ONAT : repenser la densification urbaine à Lomé",
                'slug' => 'table-ronde-onat-repenser-densification-urbaine-lome',
                'tag' => 'Profession & ONAT',
                'reading_minutes' => 5,
                'published_at' => '2026-07-15 14:00:00',
                'status' => 'published',
                'cover_image' => 'assets/img/actualite-03.jpg',
                'excerpt' => "À l'invitation de l'Ordre National des Architectes du Togo, débats et propositions sur l'expansion de la métropole et l'habitat intermédiaire durable.",
                'body' => <<<'HTML'
<p class="chapeau">À l'invitation de l'Ordre National des Architectes du Togo (ONAT), les acteurs majeurs de la construction et de l'aménagement urbain se sont réunis à Lomé pour débattre de l'expansion spatiale de la capitale et des solutions de densification raisonnée.</p>

<h3>Les défis d'une métropole en pleine mutation</h3>
<p>Lomé connaît une croissance démographique soutenue, qui s'accompagne d'un étalement périurbain important vers le Nord et l'Est. Ce modèle d'étalement horizontal entraîne des coûts d'infrastructures élevés (voiries, adduction d'eau, réseaux électriques) et aggrave les problématiques d'assainissement et de ruissellement des eaux pluviales.</p>

<h3>La proposition de K-ARCHITECTES : l'habitat intermédiaire</h3>
<p>Au cours des panels, notre agence a défendu le développement de l'habitat collectif intermédiaire à échelle humaine (R+2 à R+4) :</p>
<ul class="liste-points">
  <li>Préserver au maximum les sols perméables et végétalisés sur chaque parcelle.</li>
  <li>Proposer des logements familiaux confortables dotés de véritables terrasses extérieures.</li>
  <li>Démocratiser le recours aux architectes inscrits à l'Ordre pour garantir la sécurité et la pérennité du patrimoine foncier togolais.</li>
</ul>

<blockquote class="citation-architecte">
  <p>« Construire en hauteur à Lomé ne doit pas signifier reproduire des tours anonymes et inadaptées, mais réinventer une communauté de vie aérée, sécurisée et profondément togolaise. »</p>
</blockquote>

<p>Les conclusions de cette table ronde feront l'objet d'un livre blanc remis aux autorités ministérielles de l'urbanisme et de l'habitat.</p>
HTML
            ],
            [
                'title' => "Briques de terre compressée (BTC) et teck togolais : bâtir en circuit court",
                'slug' => 'briques-terre-compressee-btc-teck-togolais-circuit-court',
                'tag' => 'Matériaux locaux',
                'reading_minutes' => 4,
                'published_at' => '2026-06-02 11:15:00',
                'status' => 'published',
                'cover_image' => 'assets/img/actualite-04.jpg',
                'excerpt' => "Retour d'expérience sur l'alliance des briques de terre compressée et du bois togolais : inertie thermique, bilan carbone réduit et savoir-faire local.",
                'body' => <<<'HTML'
<p class="chapeau">Face à la hausse des coûts des matériaux d'importation et à la nécessité de réduire l'empreinte environnementale du secteur du bâtiment, K-ARCHITECTES renforce ses prescriptions en faveur des ressources géosourcées et biosourcées locales.</p>

<h3>Les qualités remarquables de la terre compressée</h3>
<p>Issue de carrières togolaises sélectionnées et stabilisée à faible dosage de liant, la brique de terre compressée (BTC) offre des performances exceptionnelles :</p>
<ul class="liste-points">
  <li><strong>Grande inertie thermique :</strong> elle absorbe la chaleur de la journée et la restitue lentement pendant les heures plus fraîches de la nuit, lissant les écarts de température.</li>
  <li><strong>Régulation hygrométrique :</strong> la terre respire et contribue naturellement à équilibrer l'humidité de l'air ambiant.</li>
  <li><strong>Finition brute et noble :</strong> une texture tactile chaleureuse qui ne nécessite aucun crépi chimique ni peinture périodique.</li>
</ul>

<h3>L'association avec le teck et les essences du Togo</h3>
<p>Associées à des éléments en bois de teck local traité naturellement — pour les brise-soleil, les garde-corps, les pergolas et les revêtements muraux —, les BTC confèrent aux constructions une élégance contemporaine ancrée dans son territoire.</p>

<blockquote class="citation-architecte">
  <p>« Choisir les matériaux locaux, ce n'est pas faire un pas en arrière vers le vernaculaire passéiste. C'est faire un choix technologique d'avant-garde, résilient et économiquement bénéfique pour les artisans de notre pays. »</p>
</blockquote>

<p>Nous intégrons désormais ces solutions dès la phase esquisse pour tous les clients désireux d'allier distinction architecturale et impact écologique positif.</p>
HTML
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
