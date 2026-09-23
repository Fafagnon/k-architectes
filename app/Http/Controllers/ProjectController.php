<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    protected array $projects = [
        'villa-agoe' => [
            'slug' => 'villa-agoe',
            'titre' => 'Villa Agoè',
            'lieu' => 'Lomé, Agoè',
            'annee' => '2023',
            'programme' => 'Habitat individuel',
            'mission' => 'Conception et suivi de chantier',
            'dimension' => '420 m²',
            'chapeau' => "Villa de plain-pied organisée autour d'une cour intérieure qui ventile les pièces de vie.",
            'description' => "<p>Sur une parcelle rectangulaire de taille moyenne, les chambres et le séjour s'ouvrent sur une cour centrale. Les circulations restent couvertes et la ventilation traversante limite le recours à la climatisation.</p><p>Le cabinet a assuré la conception, le dossier d'exécution et le suivi du chantier jusqu'à la réception des travaux.</p>",
            'couverture' => 'assets/img/projet-01-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-01-couverture.jpg', 'alt' => "Villa Agoè — Vue d'ensemble et cour intérieure"],
                ['src' => 'assets/img/projet-01-2.jpg', 'alt' => "Villa Agoè — Séjour contemporain ouvert sur jardin"],
                ['src' => 'assets/img/projet-01-3.jpg', 'alt' => "Villa Agoè — Paroi claustras et jeux d'ombres"],
                ['src' => 'assets/img/projet-01-4.jpg', 'alt' => "Villa Agoè — Vue de la piscine et façades"],
            ],
        ],
        'immeuble-tokoin' => [
            'slug' => 'immeuble-tokoin',
            'titre' => 'Immeuble de bureaux Tokoin',
            'lieu' => 'Lomé, Tokoin',
            'annee' => '2024',
            'programme' => 'Bureaux et tertiaire',
            'mission' => "Maîtrise d'œuvre complète",
            'dimension' => '1 850 m²',
            'chapeau' => "Immeuble tertiaire R+4 à structure béton et double peau assurant une protection solaire continue.",
            'description' => "<p>Le bâtiment accueille plusieurs plateaux de bureaux modulables, des salles de réunion partagées et un parking en sous-sol. Les façades vitrées sont protégées par une résille extérieure en béton ajouré qui tamise le rayonnement solaire direct tout au long de la journée.</p><p>K-ARCHITECTES a conçu le projet architectural et supervisé l'ensemble des études techniques de structure et de fluides.</p>",
            'couverture' => 'assets/img/projet-02-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-02-couverture.jpg', 'alt' => "Immeuble Tokoin — Façade principale et résille protectrice"],
                ['src' => 'assets/img/projet-02-2.jpg', 'alt' => "Immeuble Tokoin — Hall d'accueil et distribution des étages"],
                ['src' => 'assets/img/projet-02-3.jpg', 'alt' => "Immeuble Tokoin — Plateau de bureaux modulable en étage"],
            ],
        ],
        'residence-adidogome' => [
            'slug' => 'residence-adidogome',
            'titre' => 'Résidence Adidogomé',
            'lieu' => 'Lomé, Adidogomé',
            'annee' => '2022',
            'programme' => 'Ensemble résidentiel',
            'mission' => 'Conception architecturale',
            'dimension' => '1 200 m²',
            'chapeau' => "Ensemble de six logements groupés alliant intimité familiale et espaces partagés paysagers.",
            'description' => "<p>Chaque maison bénéficie d'une double orientation et d'un patio végétalisé privatif. Les toitures ventilées et les claustras maçonnés garantissent un confort thermique naturel tout en préservant l'intimité de chaque foyer.</p><p>Le projet propose un modèle d'habitat groupé sobre, dense et respectueux du voisinage.</p>",
            'couverture' => 'assets/img/projet-03-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-03-couverture.jpg', 'alt' => "Résidence Adidogomé — Perspective sur l'allée centrale"],
                ['src' => 'assets/img/projet-03-2.jpg', 'alt' => "Résidence Adidogomé — Patio privatif et coursives"],
                ['src' => 'assets/img/projet-03-3.jpg', 'alt' => "Résidence Adidogomé — Détail des claustras en terre cuite"],
            ],
        ],
        'ecole-kpalime' => [
            'slug' => 'ecole-kpalime',
            'titre' => 'École de Kpalimé',
            'lieu' => 'Kpalimé, Région des Plateaux',
            'annee' => '2023',
            'programme' => 'Équipement scolaire',
            'mission' => 'Conception et suivi de chantier',
            'dimension' => '850 m²',
            'chapeau' => "Établissement primaire de six classes construit en matériaux locaux et ventilation passive.",
            'description' => "<p>Situé sur un terrain en pente douce, le bâtiment tire parti de la déclivité pour capter les brises fraîches de montagne. Les murs porteurs sont réalisés en blocs de terre compressée (BTC) et la charpente en bois local soutient une toiture débordante protectrice.</p><p>Une architecture publique pérenne, économe en ressources et parfaitement adaptée au milieu scolaire.</p>",
            'couverture' => 'assets/img/projet-04-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-04-couverture.jpg', 'alt' => "École de Kpalimé — Façade des salles de classe"],
                ['src' => 'assets/img/projet-04-2.jpg', 'alt' => "École de Kpalimé — Préau ouvert et cours de récréation"],
                ['src' => 'assets/img/projet-04-3.jpg', 'alt' => "École de Kpalimé — Détail de mise en œuvre des briques BTC"],
            ],
        ],
        'agence-bancaire-centre' => [
            'slug' => 'agence-bancaire-centre',
            'titre' => 'Agence bancaire du centre',
            'lieu' => 'Lomé, Centre des affaires',
            'annee' => '2024',
            'programme' => 'Équipement financier',
            'mission' => 'Aménagement et mise aux normes',
            'dimension' => '320 m²',
            'chapeau' => "Réaménagement d'une agence bancaire alliant exigences de haute sécurité et accueil contemporain.",
            'description' => "<p>Reconfiguration intégrale des flux de clientèle et des zones sécurisées. L'aménagement intérieur privilégie la transparence des cloisons acoustiques, l'épure des comptoirs d'accueil et des matériaux nobles et durables.</p><p>Un équilibre maîtrisé entre confidentialité, sécurité bancaire et convivialité de l'espace d'accueil.</p>",
            'couverture' => 'assets/img/projet-05-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-05-couverture.jpg', 'alt' => "Agence bancaire — Espace d'accueil clientèle"],
                ['src' => 'assets/img/projet-05-2.jpg', 'alt' => "Agence bancaire — Salons de conseil confidentiels"],
                ['src' => 'assets/img/projet-05-3.jpg', 'alt' => "Agence bancaire — Détail du mobilier et des éclairages"],
            ],
        ],
        'hotel-aneho' => [
            'slug' => 'hotel-aneho',
            'titre' => 'Hôtel de plage Aného',
            'lieu' => 'Aného, Région Maritime',
            'annee' => '2025',
            'programme' => 'Hôtellerie et tourisme',
            'mission' => 'Conception architecturale',
            'dimension' => '2 400 m²',
            'chapeau' => "Complexe hôtelier balnéaire de vingt-quatre chambres tourné vers l'océan et la lagune.",
            'description' => "<p>Implanté entre mer et lagune à Aného, le projet s'inspire du patrimoine architectural côtier tout en proposant des pavillons modernes surélevés sur pilotis pour respecter les sols dunaires. Chaque chambre dispose d'une terrasse privative ombragée face à l'océan.</p><p>K-ARCHITECTES a conçu le schéma directeur d'aménagement et le projet architectural détaillé.</p>",
            'couverture' => 'assets/img/projet-06-couverture.jpg',
            'photos' => [
                ['src' => 'assets/img/projet-06-couverture.jpg', 'alt' => "Hôtel Aného — Vue aérienne des pavillons face à la mer"],
                ['src' => 'assets/img/projet-06-2.jpg', 'alt' => "Hôtel Aného — Suite ouverte sur terrasse océane"],
                ['src' => 'assets/img/projet-06-3.jpg', 'alt' => "Hôtel Aného — Espace restaurant sous charpente bois"],
            ],
        ],
    ];

    public function getProjects(): array
    {
        return $this->projects;
    }

    public function index(): View
    {
        $projects = $this->projects;
        return view('pages.realisations', compact('projects'));
    }

    public function show(string $slug): View
    {
        if (!isset($this->projects[$slug])) {
            abort(404);
        }

        $project = $this->projects[$slug];
        return view('pages.projet', compact('project'));
    }

    public function legacyRedirect(string $file): RedirectResponse
    {
        $slug = str_replace(['projet-', '.html'], '', $file);
        if (isset($this->projects[$slug])) {
            return redirect()->route('realisations.show', $slug, 301);
        }
        return redirect()->route('realisations.index', [], 301);
    }
}
