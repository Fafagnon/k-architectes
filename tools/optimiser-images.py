#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Optimise les photos du site.

1. Déposez vos originaux dans assets/img/originaux/ (JPEG ou PNG, le plus grand possible),
   nommés comme indiqué dans PHOTOS-A-FOURNIR.md (exemple : projet-01-couverture.jpg).
2. Lancez :  python3 tools/optimiser-images.py
3. Les versions optimisées (AVIF, WebP, JPEG en 640, 1024, 1600 et 2400 px de large)
   sont écrites dans assets/img/. Les pages les utilisent automatiquement.

Prérequis : Python 3 et Pillow  (pip install pillow). L'AVIF nécessite Pillow 11.3 ou
plus récent, ou le paquet pillow-avif-plugin. Sans AVIF, le script produit WebP et JPEG.
"""
import sys
from pathlib import Path

try:
    from PIL import Image, ImageOps
except ImportError:
    sys.exit("Pillow est requis : pip install pillow")

RACINE = Path(__file__).resolve().parent.parent
SOURCE = RACINE / "assets" / "img" / "originaux"
SORTIE = RACINE / "assets" / "img"
LARGEURS = [640, 1024, 1600, 2400]
EXTENSIONS = {".jpg", ".jpeg", ".png", ".webp", ".tif", ".tiff"}

try:
    import pillow_avif  # noqa: F401  (plugin facultatif)
except ImportError:
    pass

AVIF_OK = ".avif" in Image.registered_extensions()


def enregistrer(im, chemin, fmt):
    if fmt == "jpg":
        im.save(chemin, "JPEG", quality=82, optimize=True, progressive=True)
    elif fmt == "webp":
        im.save(chemin, "WEBP", quality=80, method=6)
    elif fmt == "avif":
        im.save(chemin, "AVIF", quality=55)


def traiter(fichier):
    nom = fichier.stem
    im = ImageOps.exif_transpose(Image.open(fichier)).convert("RGB")

    if nom == "og-image":  # image de partage : 1200 x 630, un seul JPEG
        cadre = ImageOps.fit(im, (1200, 630), Image.LANCZOS)
        cadre.save(SORTIE / "og-image.jpg", "JPEG", quality=84, optimize=True, progressive=True)
        print("  og-image.jpg (1200 x 630)")
        return

    formats = ["jpg", "webp"] + (["avif"] if AVIF_OK else [])
    for w in LARGEURS:
        # pas d'agrandissement : si l'original est plus étroit, on garde sa largeur
        cible = min(w, im.width)
        version = im if cible == im.width else im.resize((cible, round(im.height * cible / im.width)), Image.LANCZOS)
        for fmt in formats:
            enregistrer(version, SORTIE / ("%s-%d.%s" % (nom, w, fmt)), fmt)
    print("  %s : %d x %d -> %s" % (fichier.name, im.width, im.height, ", ".join(formats)))


def main():
    fichiers = sorted(f for f in SOURCE.iterdir() if f.suffix.lower() in EXTENSIONS) if SOURCE.exists() else []
    if not fichiers:
        sys.exit("Aucune image dans %s" % SOURCE)
    if not AVIF_OK:
        print("Attention : AVIF indisponible (installez Pillow 11.3+ ou pillow-avif-plugin). WebP et JPEG seuls seront produits.")
    print("Optimisation de %d image(s)..." % len(fichiers))
    for f in fichiers:
        traiter(f)
    print("Terminé.")


if __name__ == "__main__":
    main()
