<?php
/**
 * This file is part of the Prodeimat project
 * @Author: Ricel Quispe
 */

declare(strict_types=1);

namespace App\DataFixtures\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploaderService
{
    public function uploadImage(File $file, $destinationPath): string
    {
        $filesystem = new Filesystem();

        $this->makeDestinationDirectory($filesystem, $destinationPath);

        if ($file instanceof UploadedFile) {
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }
        $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME) . '.' . $file->guessExtension();

        // Move or copy the file to the destination directory
        $filesystem->copy($file->getPathname(), $destinationPath . '/' . $newFilename);

        return $newFilename;

    }

    private function makeDestinationDirectory($filesystem, $destinationPath): void
    {
        // Check if the destination directory exists
        if (!$filesystem->exists($destinationPath)) {
            // Create the destination directory
            $filesystem->mkdir($destinationPath);
        }
    }
}
