<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    protected $imagePath;

    /**
     * ImageUploader constructor.
     * @param $imagePath
     */
    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function uploadImageFromForm(UploadedFile $file){
        /**
         * var UploadedFile
         */

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move(
                $this->imagePath, $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }
        return($newFilename);

    }

    public function getTargetDirectory()
    {
        return $this->imagePath;
    }

}