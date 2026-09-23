<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class ImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Traite et optimise une image de couverture (largeur max 2400px, JPEG 85%).
     */
    public function processCoverImage(UploadedFile $file, string $directory = 'articles'): string
    {
        $image = $this->manager->decodePath($file->getRealPath());

        // Redimensionne proportionnellement si la largeur dépasse 2400px
        $image->scaleDown(width: 2400);

        // Encode en JPEG qualité 85
        $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 85);

        $filename = $directory . '/' . Str::random(40) . '.jpg';
        Storage::disk('public')->put($filename, (string) $encoded);

        return $filename;
    }
}
