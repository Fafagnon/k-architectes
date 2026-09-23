#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Génère les pages HTML de K-ARCHITECTES à la racine du site.

Le site est du HTML statique : vous pouvez aussi éditer les pages à la main.
Ce script est facultatif. Il évite de répéter un changement (en-tête, pied de page,
coordonnées, projets) dans onze fichiers. Attention : le relancer écrase les pages.

Usage :  python3 tools/generer-site.py
"""
import json
import re
from html import escape
from pathlib import Path

RACINE = Path(__file__).resolve().parent.parent
DOMAINE = "https://k-architectes.com"
ANNEE = 2026
DATE_MAJ = "2026-09-21"
NBSP = "\u00a0"

# ---------------------------------------------------------------------------
# DONNÉES
# ---------------------------------------------------------------------------

def tel_affiche(t):
    return t.replace(" ", NBSP)

SITE = {
    "nom": "K-ARCHITECTES",
    "email": "archkortete@gmail.com",
    "standard": [("(+228) 22 55 86 38", "+22822558638"), ("(+228) 96 50 00 07", "+22896500007")],
    "secretariat": ("(+228) 91 75 15 15", "+22891751515"),
    "whatsapp": "https://wa.me/22891751515?text=Bonjour%2C%20je%20vous%20contacte%20depuis%20le%20site%20K-ARCHITECTES.",
    "adresse": ["Agoè-Vakpossito, Rue NDE", "(Notre-Dame de l'Église)", "28 BP 305 Télessou", "Lomé, Togo"],
    "itineraire": "https://www.google.com/maps/search/?api=1&query=K-ARCHITECTES%20Ago%C3%A8-Vakpossito%20Lom%C3%A9%20Togo",
    "form_action": "https://formsubmit.co/archkortete@gmail.com",
    "form_ajax": "https://formsubmit.co/ajax/archkortete@gmail.com",
}

NAV = [
    ("index.html", "Accueil", "accueil"),
    ("le-cabinet.html", "Le cabinet", "cabinet"),
    ("realisations.html", "Réalisations", "realisations"),
    ("actualites.html", "Actualités", "actualites"),
    ("opportunites.html", "Opportunités", "opportunites"),
    ("contact.html", "Contact", "contact"),
]

# Contenus PROVISOIRES : projets fictifs, à remplacer (voir CONTENU-PROVISOIRE.md)
PROJETS = [
    {
        "n": "01", "slug": "villa-agoe", "titre": "Villa Agoè", "lieu": "Lomé, Agoè", "annee": "2023",
        "programme": "Habitat individuel", "mission": "Conception et suivi de chantier", "dimension": "420 m²",
        "resume": "Villa de plain-pied organisée autour d'une cour intérieure qui ventile les pièces de vie.",
        "texte": [
            "Sur une parcelle rectangulaire de taille moyenne, les chambres et le séjour s'ouvrent sur une cour centrale. Les circulations restent couvertes et la ventilation traversante limite le recours à la climatisation.",
            "Le cabinet a assuré la conception, le dossier d'exécution et le suivi du chantier jusqu'à la réception des travaux.",
        ],
    },
    {
        "n": "02", "slug": "immeuble-tokoin", "titre": "Immeuble de bureaux Tokoin", "lieu": "Lomé, Tokoin", "annee": "2022",
        "programme": "Bâtiment tertiaire", "mission": "Conception", "dimension": "1 800 m², R+4",
        "resume": "Immeuble à plateaux libres, protégé du soleil par un brise-soleil en béton.",
        "texte": [
            "Quatre niveaux de plateaux libres, distribués par un noyau central, permettent d'aménager les bureaux selon les besoins de chaque occupant. La façade la plus exposée est doublée d'un brise-soleil en béton qui filtre la lumière sans fermer les vues.",
            "Le cabinet a conçu le bâtiment et coordonné les études techniques.",
        ],
    },
    {
        "n": "03", "slug": "residence-adidogome", "titre": "Résidence Adidogomé", "lieu": "Lomé, Adidogomé", "annee": "2024",
        "programme": "Habitat collectif", "mission": "Maîtrise d'œuvre complète", "dimension": "12 logements",
        "resume": "Douze logements répartis sur trois niveaux, desservis par une coursive ouverte.",
        "texte": [
            "Les logements s'organisent de part et d'autre d'une coursive extérieure qui dessert chaque palier. Les pièces d'eau sont regroupées côté coursive, les pièces de vie s'ouvrent sur les balcons.",
            "Le cabinet a assuré la maîtrise d'œuvre complète, de l'esquisse à la livraison.",
        ],
    },
    {
        "n": "04", "slug": "ecole-kpalime", "titre": "École de Kpalimé", "lieu": "Kpalimé", "annee": "2021",
        "programme": "Équipement public", "mission": "Contrôle et suivi de chantier", "dimension": "2 600 m²",
        "resume": "Groupe scolaire de douze classes en bandes parallèles séparées par des cours plantées.",
        "texte": [
            "Trois bâtiments allongés, orientés pour éviter le soleil direct dans les salles, encadrent deux cours plantées. Des préaux couverts relient les bandes et offrent un espace de jeu à l'ombre.",
            "Le cabinet est intervenu pour le contrôle et le suivi du chantier.",
        ],
    },
    {
        "n": "05", "slug": "agence-bancaire-centre", "titre": "Agence bancaire du centre", "lieu": "Lomé, centre-ville", "annee": "2023",
        "programme": "Aménagement intérieur", "mission": "Aménagement intérieur", "dimension": "350 m²",
        "resume": "Réaménagement d'un rez-de-chaussée commercial en agence bancaire.",
        "texte": [
            "L'accueil, les bureaux fermés et l'espace de conseil se répartissent sur un plateau unique. Le mobilier et les cloisons ont été dessinés pour dégager une circulation claire depuis l'entrée.",
            "Le cabinet a assuré l'aménagement intérieur, du plan des espaces au suivi des travaux.",
        ],
    },
    {
        "n": "06", "slug": "hotel-aneho", "titre": "Hôtel d'Aného", "lieu": "Aného", "annee": "2022",
        "programme": "Hôtellerie", "mission": "Conception et réalisation", "dimension": "30 chambres",
        "resume": "Hôtel de trente chambres disposées en peigne vers la lagune.",
        "texte": [
            "Les chambres s'alignent en trois ailes perpendiculaires à la lagune, séparées par des jardins. Le rez-de-chaussée, ouvert à la brise, réunit l'accueil, le restaurant et les espaces communs.",
            "Le cabinet a assuré la conception et la réalisation du projet.",
        ],
    },
]
for _p in PROJETS:
    _p["fichier"] = "projet-" + _p["slug"] + ".html"

# Prestations PROVISOIRES
EXPERTISES = [
    ("Conception architecturale", "De l'esquisse au dossier d'exécution, pour l'habitat comme pour les bâtiments tertiaires."),
    ("Maîtrise d'œuvre et suivi de chantier", "Direction des travaux, coordination des entreprises et réception des ouvrages."),
    ("Contrôle et expertise technique", "Vérification de la conformité des plans et des ouvrages, en cours de chantier ou après livraison."),
    ("Aménagement intérieur", "Agencement des espaces et choix des matériaux, du plan aux finitions."),
]

TYPES_PROJET = ["Construction neuve", "Rénovation ou extension", "Aménagement intérieur", "Contrôle ou expertise", "Autre"]

# ---------------------------------------------------------------------------
# OUTILS
# ---------------------------------------------------------------------------

LARGEURS = [640, 1024, 1600, 2400]
PHOTOS = {}      # registre des emplacements photo -> PHOTOS-A-FOURNIR.md
CTX = {"page": ""}


def fr(t):
    """Typographie française : espace insécable avant : ; ! ? » et après «."""
    t = re.sub(r" ([:;!?»])", NBSP + r"\1", t)
    t = re.sub(r"(«) ", r"\1" + NBSP, t)
    return t


def texte_fr(t):
    """fr() + le nom du cabinet ne se coupe pas au trait d'union en fin de ligne."""
    return fr(t).replace("K-ARCHITECTES", '<span class="nb">K-ARCHITECTES</span>')


def typographie(doc):
    """Applique la typographie aux seuls nœuds de texte (ni balises, ni scripts, styles, titre ou SVG)."""
    sortie, pos = [], 0
    for m in re.finditer(r"(<script.*?</script>|<style.*?</style>|<title.*?</title>|<svg.*?</svg>|<[^>]+>)", doc, re.S):
        sortie.append(texte_fr(doc[pos:m.start()]))
        sortie.append(fr(m.group(0)) if m.group(0).startswith("<title") else m.group(0))
        pos = m.end()
    sortie.append(texte_fr(doc[pos:]))
    return "".join(sortie)


def cadre(nom, alt, ratio, sizes, eager=False, plein=False, classe="", point=None, note=""):
    """Emplacement photo : <picture> AVIF/WebP/JPEG + repli si le fichier manque."""
    PHOTOS.setdefault(nom, []).append((CTX["page"], note or (ratio or "").replace("/", ":")))

    def ss(ext):
        return ", ".join("assets/img/%s-%d.%s %dw" % (nom, w, ext, w) for w in LARGEURS)

    style = []
    if ratio:
        style.append("--ratio:" + ratio)
    if point:
        style.append("--point:" + point)
    classes = "cadre" + (" cadre--plein" if plein else "") + ((" " + classe) if classe else "")
    charge = 'loading="eager" fetchpriority="high"' if eager else 'loading="lazy"'
    attr_style = (' style="%s"' % ";".join(style)) if style else ""
    return (
        '<div class="%s" data-fichier="%s.jpg"%s><picture>'
        '<source type="image/avif" srcset="%s" sizes="%s">'
        '<source type="image/webp" srcset="%s" sizes="%s">'
        '<img src="assets/img/%s-1024.jpg" srcset="%s" sizes="%s" alt="%s" %s decoding="async">'
        '</picture></div>'
    ) % (classes, nom, attr_style, ss("avif"), sizes, ss("webp"), sizes, nom, ss("jpg"), sizes,
         escape(alt, quote=True), charge)


def coordonnees_html():
    std = "".join('<dd><a href="tel:%s">%s</a></dd>' % (t, tel_affiche(d)) for d, t in SITE["standard"])
    sec_d, sec_t = SITE["secretariat"]
    return """<address>%s</address>
<dl>
  <div><dt>Standard</dt>%s</div>
  <div><dt>Secrétariat de direction</dt><dd><a href="tel:%s">%s</a></dd></div>
  <div><dt>E-mail</dt><dd><a href="mailto:%s">%s</a></dd></div>
</dl>
""" % ("<br>".join(SITE["adresse"]), std, sec_t, tel_affiche(sec_d), SITE["email"], SITE["email"])


ABBR_ONAT = '<abbr title="Ordre national des architectes du Togo">ONAT</abbr>'

# ---------------------------------------------------------------------------
# STRUCTURE COMMUNE
# ---------------------------------------------------------------------------

def entete(courant):
    liens = []
    for href, libelle, cle in NAV:
        cta = " nav__lien--cta" if cle == "contact" else ""
        cur = ' aria-current="page"' if cle == courant else ""
        liens.append('<li><a class="nav__lien%s" href="%s"%s>%s</a></li>' % (cta, href, cur, libelle))
    return """<a class="evitement" href="#contenu">Aller au contenu</a>
<header class="entete">
  <div class="conteneur entete__interieur">
    <a class="marque" href="index.html" aria-label="K-ARCHITECTES, accueil"><span class="marque__texte">K-ARCHITECTES.</span></a>
    <button class="menu-bouton" type="button" aria-expanded="false" aria-controls="nav">Menu</button>
    <nav class="nav" id="nav" aria-label="Navigation principale">
      <ul class="nav__liste">
        %s
      </ul>
    </nav>
  </div>
</header>
""" % "\n        ".join(liens)


def pied():
    return """<footer class="pied bande--noire">
  <div class="conteneur pied__haut">
    <p class="pied__nom">K-ARCHITECTES.</p>
    <address>%s</address>
    <p><a href="mailto:%s">%s</a><br><a href="tel:%s">%s</a><br>Inscrit à l'%s</p>
  </div>
  <div class="conteneur pied__bas">
    <p>© %d K-ARCHITECTES. Tous droits réservés.</p>
    <a class="retour-haut" href="#haut">Retour en haut<span class="fleche fleche--haut" aria-hidden="true"></span></a>
  </div>
</footer>
""" % ("<br>".join(SITE["adresse"]), SITE["email"], SITE["email"], SITE["standard"][0][1],
       tel_affiche(SITE["standard"][0][0]), ABBR_ONAT, ANNEE)


def jsonld_entreprise():
    return {
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "name": "K-ARCHITECTES",
        "url": DOMAINE + "/",
        "logo": DOMAINE + "/assets/logo.svg",
        "image": DOMAINE + "/assets/img/og-image.jpg",
        "email": SITE["email"],
        "telephone": ["+228 22 55 86 38", "+228 96 50 00 07"],
        "foundingDate": "2016-06",
        "description": "Cabinet d'architecture à Lomé : conception, contrôle et réalisation de projets.",
        "areaServed": {"@type": "Country", "name": "Togo"},
        "address": {
            "@type": "PostalAddress",
            "streetAddress": SITE["adresse"][0] + " " + SITE["adresse"][1],
            "postOfficeBoxNumber": SITE["adresse"][2],
            "addressLocality": "Lomé",
            "addressCountry": "TG",
        },
    }


def page(fichier, titre, description, corps, courant, jsonld=None, base=False, noindex=False):
    assert len(titre) <= 62, "titre trop long (%d) : %s" % (len(titre), titre)
    assert len(description) <= 160, "description trop longue (%d) : %s" % (len(description), description)
    url = DOMAINE + "/" + ("" if fichier == "index.html" else fichier)
    ld = ""
    for bloc in (jsonld or []):
        ld += '<script type="application/ld+json">%s</script>\n' % json.dumps(bloc, ensure_ascii=False)
    doc = """<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
%(base)s<title>%(titre)s</title>
<meta name="description" content="%(desc)s">
<link rel="canonical" href="%(url)s">
%(robots)s<meta name="theme-color" content="#f5f5f5">
<link rel="icon" href="favicon.svg" type="image/svg+xml">
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="K-ARCHITECTES">
<meta property="og:title" content="%(titre)s">
<meta property="og:description" content="%(desc)s">
<meta property="og:url" content="%(url)s">
<meta property="og:image" content="%(dom)s/assets/img/og-image.jpg">
<meta name="twitter:card" content="summary_large_image">
<script>document.documentElement.classList.add('js')</script>
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/main.js" defer></script>
%(ld)s</head>
<body id="haut">
%(entete)s<main id="contenu" tabindex="-1">
%(corps)s</main>
%(pied)s</body>
</html>
""" % {
        "base": '<base href="/">\n' if base else "",
        "titre": escape(fr(titre)), "desc": escape(fr(description), quote=True), "url": url, "dom": DOMAINE,
        "robots": '<meta name="robots" content="noindex">\n' if noindex else "",
        "ld": ld, "entete": entete(courant), "corps": corps, "pied": pied(),
    }
    (RACINE / fichier).write_text(typographie(doc), encoding="utf-8")
    print("  écrit :", fichier)


# ---------------------------------------------------------------------------
# PAGES
# ---------------------------------------------------------------------------

def page_accueil():
    CTX["page"] = "Accueil"
    P = PROJETS

    def projet(pr, variante, ratio, sizes):
        return """<article class="projet projet--%s">
  %s
  <div class="projet__panneau" data-provisoire>
    <h3 class="projet__titre"><a class="etendu" href="%s">%s</a></h3>
    <p class="projet__lieu">%s</p>
    <p class="projet__type">%s, %s</p>
    <p class="projet__texte">%s</p>
    <span class="fleche" aria-hidden="true"></span>
  </div>
</article>
""" % (variante, cadre("projet-%s-couverture" % pr["n"], pr["titre"], ratio, sizes, classe="projet__photo"),
       pr["fichier"], pr["titre"], pr["lieu"], pr["programme"], pr["annee"], pr["resume"])

    expertises = "\n".join('<li data-provisoire><h3>%s</h3><p>%s</p></li>' % e for e in EXPERTISES)
    sec_d, sec_t = SITE["secretariat"]

    corps = """<section class="ouverture" aria-labelledby="titre-accueil">
  <div class="ouverture__media">%s</div>
  <div class="ouverture__marque" aria-hidden="true">
    <svg class="ouverture__nom" viewBox="0 0 1200 118" focusable="false"><text x="0" y="112" textLength="1200" lengthAdjust="spacingAndGlyphs">K-ARCHITECTES</text></svg>
  </div>
  <div class="conteneur ouverture__texte">
    <h1 class="ouverture__titre" id="titre-accueil"><span class="sr-only">K-ARCHITECTES, </span>Cabinet d'architecture à Lomé.</h1>
    <div class="ouverture__corps">
      <p class="chapeau">Faire de votre rêve le nôtre et vous assister techniquement dans toutes les étapes de sa concrétisation.</p>
      <a class="lien" href="contact.html">Prendre rendez-vous</a>
    </div>
  </div>
</section>

<section class="bande bande--beton" aria-labelledby="t-projets">
  <div class="conteneur">
    <div class="tete-section"><h2 class="titre-section" id="t-projets">Projets à la une.</h2><a class="lien" href="projets.html">Tous les projets</a></div>
    <div class="une">
      %s
      %s
      %s
    </div>
  </div>
</section>

<section class="bande bande--calque" aria-labelledby="t-expertises">
  <div class="conteneur">
    <div class="tete-section"><h2 class="titre-section" id="t-expertises">Expertises.</h2></div>
    <ul class="expertises">
      %s
    </ul>
  </div>
</section>

<section class="bande bande--beton" aria-labelledby="t-contact">
  <div class="conteneur">
    <div class="tete-section"><h2 class="titre-section" id="t-contact">Nous contacter.</h2></div>
    <div class="scene">
      %s
      <div class="carte">
        <h3 class="carte__nom">K-ARCHITECTES.</h3>
        %s
        <div class="carte__actions">
          <a class="bouton" href="contact.html">Prendre rendez-vous</a>
          <a class="lien" href="%s">Écrire sur WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</section>
""" % (
        cadre("accueil-ouverture", "", None, "100vw", eager=True, plein=True, note="bandeau pleine largeur, environ 21:9"),
        projet(P[0], "a", "3/2", "(min-width:1024px) 66vw, 100vw"),
        projet(P[1], "b", "4/5", "(min-width:1024px) 42vw, 100vw"),
        projet(P[2], "c", "16/9", "(min-width:1200px) 1200px, 100vw"),
        expertises,
        cadre("accueil-contact", "", "16/9", "(min-width:1200px) 1200px, 100vw"),
        coordonnees_html(), SITE["whatsapp"])

    page("index.html",
         "K-ARCHITECTES | Cabinet d'architecture à Lomé, Togo",
         "K-ARCHITECTES, cabinet d'architecture à Lomé : conception, suivi de chantier et contrôle de vos projets, de l'esquisse à la livraison.",
         corps, "accueil", jsonld=[jsonld_entreprise()])


def page_cabinet():
    CTX["page"] = "Le cabinet"
    corps = """<div class="bandeau">%s</div>
<div class="conteneur"><h1 class="titre-page">Le cabinet.</h1></div>

<section class="conteneur presentation" aria-label="Présentation">
  <div class="presentation__texte">
    <p class="chapeau">« Faire de votre rêve le nôtre et vous assister techniquement dans toutes les étapes de sa concrétisation », tel est le leitmotiv de la Société à Responsabilité Limitée K-ARCHITECTES, créée en juin 2016.</p>
    <p>Quoiqu'elle soit une jeune entreprise, l'agence emploie une équipe pluridisciplinaire présentant des capacités et une expérience considérables en termes de conception, de contrôle ou de réalisation de projets.</p>
  </div>
  <dl class="cartouche">
    <div><dt>Création</dt><dd>Juin 2016</dd></div>
    <div data-provisoire><dt>Équipe</dt><dd>12 collaborateurs</dd></div>
    <div data-provisoire><dt>Projets</dt><dd>60 conçus, contrôlés ou réalisés</dd></div>
    <div><dt>Ordre</dt><dd>Inscrit à l'%s</dd></div>
  </dl>
</section>

<section class="bande bande--beton" aria-labelledby="t-direction">
  <div class="conteneur direction">
    %s
    <div class="direction__panneau">
      <h2 class="titre-section" id="t-direction">Irénée KORTETE</h2>
      <p class="direction__role">Directeur général de K-ARCHITECTES.</p>
      <p class="direction__texte" data-provisoire>À la tête du cabinet, Irénée KORTETE veille à ce que chaque client soit accompagné de l'esquisse à la livraison, selon le principe qui guide l'agence.</p>
      <a class="lien" href="contact.html">Prendre rendez-vous avec la direction</a>
    </div>
  </div>
</section>

<section class="bande bande--calque" aria-labelledby="t-appel">
  <div class="conteneur appel">
    <h2 class="titre-section" id="t-appel">Parlons de votre projet.</h2>
    <div>
      <p>Décrivez-le en quelques lignes. Le cabinet vous répond pour convenir d'un rendez-vous.</p>
      <a class="bouton" href="contact.html">Prendre rendez-vous</a>
    </div>
  </div>
</section>
""" % (
        cadre("cabinet-ouverture", "", None, "100vw", eager=True, plein=True, note="bandeau pleine largeur, environ 21:9"),
        ABBR_ONAT,
        cadre("direction-irenee-kortete", "Irénée KORTETE, directeur général de K-ARCHITECTES", "4/5",
              "(min-width:1024px) 33vw, 100vw", classe="direction__photo"))

    page("le-cabinet.html",
         "Le cabinet | K-ARCHITECTES, architectes à Lomé",
         "Créé en juin 2016 à Lomé, le cabinet K-ARCHITECTES réunit une équipe pluridisciplinaire en conception, contrôle et réalisation de projets.",
         corps, "cabinet", jsonld=[jsonld_entreprise()])


def page_projets():
    CTX["page"] = "Projets"
    items = []
    for i, pr in enumerate(PROJETS):
        portrait = (i % 2 == 0)
        items.append("""<li class="index__item" data-provisoire>
        <a class="index__lien" href="%s">
          %s
          <div class="index__legende">
            <h2 class="index__titre">%s</h2>
            <p class="index__meta">%s</p>
            <p class="index__meta">%s, %s</p>
          </div>
        </a>
      </li>""" % (pr["fichier"],
                  cadre("projet-%s-couverture" % pr["n"], pr["titre"], "4/5" if portrait else "3/2",
                        "(min-width:768px) 41vw, 100vw"),
                  pr["titre"], pr["lieu"], pr["programme"], pr["annee"]))
    corps = """<div class="bandeau">%s</div>
<div class="conteneur"><h1 class="titre-page">Projets.</h1></div>

<section class="bande bande--beton" aria-label="Liste des projets">
  <div class="conteneur">
    <ul class="index">
      %s
    </ul>
  </div>
</section>
""" % (cadre("projets-ouverture", "", None, "100vw", eager=True, plein=True, note="bandeau pleine largeur, environ 21:9"),
       "\n      ".join(items))

    page("projets.html",
         "Projets | K-ARCHITECTES, architectes à Lomé",
         "Les réalisations de K-ARCHITECTES : habitat, bureaux, équipements publics et hôtellerie, conçus et suivis par le cabinet à Lomé et au Togo.",
         corps, "projets")


def page_fiche(i):
    pr = PROJETS[i]
    CTX["page"] = "Projet : " + pr["titre"]
    prec, suiv = PROJETS[(i - 1) % len(PROJETS)], PROJETS[(i + 1) % len(PROJETS)]
    n = pr["n"]
    paragraphes = "".join("<p>%s</p>" % t for t in pr["texte"])
    corps = """<div class="conteneur fil">
  <nav aria-label="Fil d'Ariane"><ol><li><a href="projets.html">Projets</a></li><li aria-current="page">%(titre)s</li></ol></nav>
</div>
<div class="conteneur"><h1 class="titre-page">%(titre)s.</h1></div>

<section class="conteneur fiche-corps" data-provisoire aria-label="Présentation du projet">
  <dl class="donnees">
    <div><dt>Lieu</dt><dd>%(lieu)s</dd></div>
    <div><dt>Année</dt><dd>%(annee)s</dd></div>
    <div><dt>Programme</dt><dd>%(programme)s</dd></div>
    <div><dt>Mission</dt><dd>%(mission)s</dd></div>
    <div><dt>Dimension</dt><dd>%(dimension)s</dd></div>
  </dl>
  <div class="fiche-corps__texte">
    <p class="chapeau">%(resume)s</p>
    %(paragraphes)s
  </div>
</section>

<section class="conteneur galerie" aria-label="Photographies du projet">
  %(p1)s
  <div class="galerie__paire">
    %(p2)s
    %(p3)s
  </div>
</section>

<div class="conteneur">
  <nav class="autres" aria-label="Autres projets">
    <a class="autres__lien autres__lien--prec" href="%(prec_f)s"><span class="autres__sens">Projet précédent</span><span class="autres__titre">%(prec_t)s</span></a>
    <a class="autres__lien autres__lien--suiv" href="%(suiv_f)s"><span class="autres__sens">Projet suivant</span><span class="autres__titre">%(suiv_t)s</span></a>
  </nav>
</div>
""" % {
        "titre": pr["titre"], "lieu": pr["lieu"], "annee": pr["annee"], "programme": pr["programme"],
        "mission": pr["mission"], "dimension": pr["dimension"], "resume": pr["resume"], "paragraphes": paragraphes,
        "p1": cadre("projet-%s-1" % n, pr["titre"] + ", vue 1", "16/9", "(min-width:1200px) 1200px, 100vw"),
        "p2": cadre("projet-%s-2" % n, pr["titre"] + ", vue 2", "3/2", "(min-width:768px) 50vw, 100vw"),
        "p3": cadre("projet-%s-3" % n, pr["titre"] + ", vue 3", "3/2", "(min-width:768px) 50vw, 100vw"),
        "prec_f": prec["fichier"], "prec_t": prec["titre"], "suiv_f": suiv["fichier"], "suiv_t": suiv["titre"],
    }
    fil = {
        "@context": "https://schema.org", "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type": "ListItem", "position": 1, "name": "Accueil", "item": DOMAINE + "/"},
            {"@type": "ListItem", "position": 2, "name": "Projets", "item": DOMAINE + "/projets.html"},
            {"@type": "ListItem", "position": 3, "name": pr["titre"], "item": DOMAINE + "/" + pr["fichier"]},
        ],
    }
    description = "%s (%s, %s), projet du cabinet K-ARCHITECTES. %s" % (pr["titre"], pr["lieu"], pr["annee"], pr["resume"])
    page(pr["fichier"], "%s | Projets K-ARCHITECTES" % pr["titre"], description, corps, "projets", jsonld=[fil])


def page_contact():
    CTX["page"] = "Contact"
    options = "".join("<option>%s</option>" % t for t in TYPES_PROJET)
    sec_d, sec_t = SITE["secretariat"]
    corps = """<div class="conteneur"><h1 class="titre-page">Contact.</h1></div>
<div class="conteneur">
  <p class="chapeau contact-page__intro">Décrivez votre projet en quelques lignes. Le cabinet vous répond par téléphone ou par e-mail pour convenir d'un rendez-vous.</p>
</div>

<div class="conteneur contact-page">
  <form class="formulaire" data-formulaire action="%(action)s" method="post" accept-charset="utf-8" data-ajax="%(ajax)s">
    <input type="hidden" name="_subject" value="Nouvelle demande de rendez-vous, k-architectes.com">
    <input type="hidden" name="_captcha" value="false">
    <input type="hidden" name="_template" value="table">
    <input type="hidden" name="_next" value="%(dom)s/contact.html?envoye=1">
    <p class="piege" aria-hidden="true"><label>Ne pas remplir <input type="text" name="_honey" tabindex="-1" autocomplete="off"></label></p>
    <div class="champ"><label for="f-nom">Nom et prénom</label><input id="f-nom" name="Nom" type="text" autocomplete="name" required data-erreur="Indiquez votre nom."></div>
    <div class="champ"><label for="f-tel">Téléphone</label><input id="f-tel" name="Telephone" type="tel" inputmode="tel" autocomplete="tel" required data-erreur="Indiquez un numéro de téléphone."></div>
    <div class="champ"><label for="f-mail">E-mail <span class="facultatif">(facultatif)</span></label><input id="f-mail" name="email" type="email" autocomplete="email" data-erreur-format="Cette adresse e-mail semble incomplète."></div>
    <div class="champ"><label for="f-type">Type de projet</label><select id="f-type" name="Type de projet"><option value="">Choisir</option>%(options)s</select></div>
    <div class="champ champ--large"><label for="f-lieu">Lieu du projet</label><input id="f-lieu" name="Lieu du projet" type="text"></div>
    <div class="champ champ--large"><label for="f-message">Votre message</label><textarea id="f-message" name="Message" rows="6" required data-erreur="Décrivez brièvement votre projet."></textarea></div>
    <button class="bouton" type="submit">Envoyer ma demande</button>
    <p class="formulaire__note">Ces informations servent uniquement à vous répondre.</p>
    <div class="retour" id="retour-ok" role="status" tabindex="-1" hidden><p><strong>Message envoyé.</strong></p><p>Le cabinet vous répondra par téléphone ou par e-mail.</p></div>
    <div class="retour" id="retour-echec" role="alert" tabindex="-1" hidden><p><strong>L'envoi n'a pas abouti.</strong></p><p>Écrivez directement à <a class="lien" href="mailto:%(mail)s">%(mail)s</a> ou <a class="lien" href="%(wa)s">sur WhatsApp</a>.</p></div>
  </form>

  <aside class="coordonnees" aria-labelledby="t-coord">
    <h2 id="t-coord">K-ARCHITECTES.</h2>
    %(coord)s
    <a class="lien" href="%(wa)s">Écrire sur WhatsApp</a><br>
    <a class="lien" href="%(iti)s" rel="noopener">Itinéraire</a>
  </aside>
</div>
""" % {"action": SITE["form_action"], "ajax": SITE["form_ajax"], "dom": DOMAINE, "options": options,
       "mail": SITE["email"], "wa": SITE["whatsapp"], "coord": coordonnees_html(), "iti": SITE["itineraire"]}

    page("contact.html",
         "Contact et rendez-vous | K-ARCHITECTES, Lomé",
         "Contactez K-ARCHITECTES à Lomé : formulaire, téléphone, WhatsApp et adresse du cabinet pour convenir d'un rendez-vous.",
         corps, "contact", jsonld=[jsonld_entreprise()])


def page_404():
    CTX["page"] = "404"
    corps = """<div class="conteneur"><h1 class="titre-page">Page introuvable.</h1></div>
<div class="conteneur introuvable">
  <p class="chapeau">L'adresse demandée n'existe pas ou a été déplacée.</p>
  <a class="bouton" href="index.html">Retour à l'accueil</a>
</div>
"""
    page("404.html", "Page introuvable | K-ARCHITECTES",
         "Cette page n'existe pas. Retournez à l'accueil du cabinet d'architecture K-ARCHITECTES, à Lomé.",
         corps, "", base=True, noindex=True)


# ---------------------------------------------------------------------------
# FICHIERS ANNEXES
# ---------------------------------------------------------------------------

def annexes():
    urls = ["", "le-cabinet.html", "projets.html", "contact.html"] + [p["fichier"] for p in PROJETS]
    lignes = ['<?xml version="1.0" encoding="UTF-8"?>',
              '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']
    for u in urls:
        lignes.append("  <url><loc>%s/%s</loc><lastmod>%s</lastmod></url>" % (DOMAINE, u, DATE_MAJ))
    lignes.append("</urlset>")
    (RACINE / "sitemap.xml").write_text("\n".join(lignes) + "\n", encoding="utf-8")
    (RACINE / "robots.txt").write_text("User-agent: *\nAllow: /\n\nSitemap: %s/sitemap.xml\n" % DOMAINE, encoding="utf-8")
    (RACINE / "favicon.svg").write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" fill="#000"/>'
        '<text x="32" y="47" text-anchor="middle" font-family="Helvetica, Arial, sans-serif" font-size="44" font-weight="700" fill="#fff">K</text></svg>\n',
        encoding="utf-8")

    # Liste des photos attendues, construite à partir des emplacements réellement présents dans les pages
    lignes = ["# Photos à fournir", "",
              "Déposez vos originaux (JPEG ou PNG, le plus grand possible) dans `assets/img/originaux/`, **avec exactement ces noms**, puis lancez `python3 tools/optimiser-images.py`.", "",
              "Les cadrages sont faits par le site (recadrage centré). Choisissez des images dont le sujet reste lisible quand on les recadre.", "",
              "| Fichier | Format(s) affiché(s) | Page(s) |", "|---|---|---|"]
    for nom in sorted(PHOTOS):
        formats = sorted({f for _, f in PHOTOS[nom] if f})
        pages = sorted({p for p, _ in PHOTOS[nom]})
        lignes.append("| `%s.jpg` | %s | %s |" % (nom, ", ".join(formats), ", ".join(pages)))
    lignes += ["| `og-image.jpg` | 1200 x 630 | Aperçu lors d'un partage (réseaux sociaux, messageries) |", ""]
    (RACINE / "PHOTOS-A-FOURNIR.md").write_text("\n".join(lignes) + "\n", encoding="utf-8")


def main():
    print("Génération dans", RACINE)
    page_accueil()
    page_cabinet()
    page_projets()
    for i in range(len(PROJETS)):
        page_fiche(i)
    page_contact()
    page_404()
    annexes()
    print("Terminé : %d emplacements photo." % len(PHOTOS))


if __name__ == "__main__":
    main()
