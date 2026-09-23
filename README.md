# Site K-ARCHITECTES

Site vitrine statique : HTML, CSS et un peu de JavaScript. Aucune dépendance, aucun service à installer, aucun cookie.

## Voir le site

Ouvrez `index.html` dans un navigateur, ou lancez un petit serveur local depuis ce dossier :

```
python3 -m http.server 8000
```

puis rendez-vous sur http://localhost:8000.

## Ce que vous devez apporter

### 1. Le logo

Déposez votre logo en **SVG** sous le nom `assets/logo.svg` (hauteur d'affichage : 28 px). Il remplace automatiquement le nom en texte dans l'en-tête de toutes les pages. Tant que le fichier n'existe pas, le nom « K-ARCHITECTES. » s'affiche en texte.

Le pied de page garde le nom en texte, car un logo sombre n'est pas lisible sur fond noir. Remplacez aussi `favicon.svg` (icône d'onglet, actuellement un K blanc sur fond noir).

### 2. Les photos

La liste exacte des fichiers attendus, leur format et la page où ils s'affichent se trouvent dans **`PHOTOS-A-FOURNIR.md`**.

1. Déposez vos originaux (JPEG ou PNG, les plus grands possible) dans `assets/img/originaux/`, avec les noms indiqués (exemple : `projet-01-couverture.jpg`).
2. Lancez `python3 tools/optimiser-images.py` (Python 3 et `pip install pillow`).
3. Le script écrit dans `assets/img/` les versions AVIF, WebP et JPEG en 640, 1024, 1600 et 2400 px. Les pages les utilisent seules : chaque visiteur reçoit le format et la taille adaptés à son écran, ce qui compte sur un réseau mobile.

Tant qu'une photo manque, la page affiche un emplacement hachuré avec le nom du fichier attendu. Une photo fournie disparaît de cette liste dès qu'elle est présente.

Les textes alternatifs (`alt`) des photos de projet ne contiennent que le nom du projet. Décrivez ce que montre chaque image quand vous les aurez (par exemple « Villa Agoè, façade sur cour »). Les photos d'ambiance de haut de page sont volontairement décoratives (`alt` vide).

### 3. Les contenus provisoires

Les six projets, les quatre expertises, deux chiffres et le paragraphe du directeur général sont **fictifs**. Pour les repérer à l'écran, ajoutez `?relecture` à l'adresse d'une page (exemple : `index.html?relecture`) : chaque contenu provisoire est entouré d'un cadre pointillé, sur toutes les pages, pendant la session. `?relecture=0` désactive le mode. La liste complète est dans **`CONTENU-PROVISOIRE.md`**. Ne mettez pas le site en ligne avant de l'avoir traitée.

## Formulaire de contact

Le formulaire envoie les demandes à `archkortete@gmail.com` par le service gratuit FormSubmit, sans serveur à maintenir :

- Sans JavaScript, il s'envoie de manière classique et renvoie sur `contact.html?envoye=1`.
- Avec JavaScript, il s'envoie sans recharger la page, vérifie les champs (messages d'erreur sous chaque champ) et, en cas d'échec réseau, propose l'e-mail et WhatsApp.
- Un champ caché piège les robots.

**À faire avant la mise en ligne** : envoyez un message de test. Lors du premier envoi, FormSubmit envoie normalement un e-mail de confirmation à l'adresse du cabinet : il faut cliquer sur le lien qu'il contient, sinon les demandes ne sont pas transmises. Vérifiez aussi le dossier des courriers indésirables.

Les messages transitent par ce service tiers. Pour utiliser un autre prestataire ou un point d'accès sur votre hébergement, modifiez `action` et `data-ajax` du formulaire dans `contact.html` (ou `form_action` et `form_ajax` dans `tools/generer-site.py`).

## Mise en ligne

Tout hébergeur de fichiers statiques convient (Cloudflare Pages, Netlify, hébergement mutualisé). Envoyez le contenu du dossier, sans `tools/` ni `assets/img/originaux/`.

Le site suppose le domaine `https://k-architectes.com` pour les adresses canoniques, le plan du site (`sitemap.xml`), les aperçus de partage et le retour du formulaire. Si l'adresse change, remplacez-la (ou modifiez `DOMAINE` dans le générateur et relancez-le). `404.html` sert de page d'erreur sur la plupart des hébergeurs.

À vérifier une fois en ligne : la présence de `assets/img/og-image.jpg` (1200 x 630 px, aperçu affiché lors d'un partage), un test Lighthouse et le lien « Itinéraire » de la page Contact, qui pointe vers une recherche Google Maps sur l'adresse et non vers un repère exact.

## Modifier le site

- **Couleurs, espacements, largeurs** : variables au début de `assets/css/style.css` (`:root`). Le site n'a que deux gris (calque `#f5f5f5`, béton `#e6e6e6`) et le noir.
- **Police** : pile système Helvetica Neue, Helvetica, Arial. Pour imposer une police, déposez le fichier dans `assets/fonts/` et décommentez le bloc `@font-face` en tête du CSS.
- **Textes et pages** : vous pouvez éditer les fichiers `.html` à la main. Le script facultatif `tools/generer-site.py` régénère les onze pages depuis un seul endroit (coordonnées, projets, expertises, en-tête, pied de page) : `python3 tools/generer-site.py`. Attention, il **écrase** les pages : ne mélangez pas les deux méthodes.
- **Ajouter un projet** : ajoutez une entrée à la liste `PROJETS` du générateur et relancez-le (fiche, index, navigation précédent et suivant, plan du site et liste des photos se mettent à jour).

## Ce qui est déjà pris en charge

- **Accessibilité** : contrastes vérifiés (texte noir sur fond clair, gris secondaire à 7,8:1 minimum), focus clavier visible, lien d'évitement, navigation au clavier du menu mobile (Échap pour fermer), champs de formulaire avec étiquettes et messages d'erreur annoncés, animations désactivées si l'utilisateur les a réduites.
- **Performance** : environ 28 Ko de CSS et de JavaScript (8 Ko une fois compressés par le serveur), aucune bibliothèque, aucune police à télécharger, images en AVIF ou WebP à la bonne taille, chargement différé sous la ligne de flottaison.
- **SEO** : un `title` et une `meta description` par page, un seul `h1` par page et une hiérarchie de titres logique, données structurées d'entreprise locale (adresse, téléphones, date de création) et fil d'Ariane, plan du site, `robots.txt`.
- **Responsive** : conçu mobile d'abord, points de rupture à 640, 768, 1024 et 1280 px.
