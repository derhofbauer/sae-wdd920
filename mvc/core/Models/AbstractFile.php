<?php

namespace Core\Models;

use Core\Config;

/**
 * @todo: comment
 */
class AbstractFile
{

    public function __construct(
        public string $name,
        public ?string $type,
        public ?string $tmp_name,
        public ?int $error,
        public ?int $size,
    ) {
    }

    public function hasUploadError(): bool
    {
        return $this->error !== UPLOAD_ERR_OK;
    }

    public static function filesHaveBeenUploaded(string $keyInSuperglobal): bool
    {
        return ($_FILES[$keyInSuperglobal]['error'][0] !== UPLOAD_ERR_NO_FILE);
    }

    public static function createFromUploadedFiles(string $keyInSuperglobal): array
    {
        $files = $_FILES[$keyInSuperglobal];
        if (self::filesHaveBeenUploaded($keyInSuperglobal)) {
            $filesObjects = [];

            foreach ($files['name'] as $key => $name) {
                $file = new AbstractFile(
                    $name,
                    $files['type'][$key],
                    $files['tmp_name'][$key],
                    $files['error'][$key],
                    $files['size'][$key]
                );
                $filesObjects[] = $file;
            }

            return $filesObjects;
        }
        return [];
    }

    public function putToUploadsFolder(): string
    {
        $destinationPath = $this->getDestinationPath();
        if (move_uploaded_file($this->tmp_name, $destinationPath)) {
            return self::relativeUploadPathFromAbsolutePath($destinationPath);
        } else {
            throw new \Exception('Uploaded files can not be stored.');
        }
    }

    private function getDestinationPath(): string
    {
        $uploadsFolder = Config::get('app.uploads-folder');

        $storageFolder = self::getStoragePath();
        $destinationPath = realpath("{$storageFolder}/{$uploadsFolder}/");
        $destinationName = time() . "_{$this->name}";

        return "{$destinationPath}/{$destinationName}";
    }

    /**
     * @param string $absolutePath
     *
     * @return string
     * @todo: comment
     */
    static function relativeUploadPathFromAbsolutePath(string $absolutePath): string
    {
        $uploadsFolder = Config::get('app.uploads-folder');
        $uploadsFolderStrpos = strpos($absolutePath, $uploadsFolder);
        $relativePath = substr($absolutePath, $uploadsFolderStrpos);
        $relativePathWithoutStorage = str_replace('storage/', '', $relativePath);

        return $relativePathWithoutStorage;
    }

    /**
     * Hilfsfunktion zur Berechnung des Storage Path absolut zum Server Wurzelverzeichnis (Root).
     *
     * @return string
     */
    public static function getStoragePath(): string
    {
        /**
         * Wir definieren unseren Pfad ausgehend von dem Ordner, in dem diese Datei liegt, "relative".
         */
        $absoluteStoragePath = __DIR__ . '/../../storage';
        /**
         * Die realpath()-Methode löst bspw. ".." und "~" in Pfaden auf und erstellt einen absoluten Pfad daraus.
         */
        $absoluteStoragePath = realpath($absoluteStoragePath);
        /**
         * Diesen Pfad geben wir zurück.
         */
        return $absoluteStoragePath;
    }

    /**
     * Datei physisch löschen.
     *
     * @param string $filepathRelativeToStorage
     *
     * @return bool|int
     */
    public static function delete(string $filepathRelativeToStorage): bool|int
    {
        /**
         * Existiert eine Datei an dem Pfad, der übergeben wurde ...
         */
        if (file_exists($filepathRelativeToStorage)) {
            /**
             * ... so löschen wir die Datei.
             */
            return unlink($filepathRelativeToStorage);
        }
        /**
         * Andernfalls geben wir -1 zurück. Dadurch können wir zwischen Erfolg (true) und Fehler (false) der unlink()-
         * Methode unterscheiden und dem Status, dass die Datei nicht existiert.
         */
        return -1;
    }


}
