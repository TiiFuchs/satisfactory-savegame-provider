<?php

namespace Tii\SatisfactorySavegameProvider;

class SaveGame
{
    protected static function saveGameDir(): string
    {
        return (new Config())->get('SATISFACTORY_SAVEGAME_DIR');
    }

    /**
     * @return array<SaveGame>
     */
    public static function list(): array
    {
        $files = glob(static::saveGameDir().'*');

        $files = array_filter($files, fn ($item) => is_file($item));

        return array_map(fn ($file) => new static($file), $files);
    }

    public static function latest(): ?static
    {
        return array_reduce(
            static::list(),
            fn (?SaveGame $latest, SaveGame $saveGame) => is_null($latest) || $saveGame->modified_at > $latest->modified_at ? $saveGame : $latest,
            null
        );
    }

    public static function get(string $filename): ?static
    {
        if (! is_file(static::saveGameDir().$filename)) {
            return null;
        }

        return new static(static::saveGameDir().$filename);
    }

    public function __construct(
        protected string $filename,
    ) {
        $this->modified_at = filemtime($this->filename);
    }

    public readonly int $modified_at;

    public function download(): never
    {
        header('Access-Control-Allow-Headers: Access-Control-Allow-Origin');
        header('Access-Control-Allow-Origin: https://satisfactory-calculator.com');

        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $this->modified_at) {
            http_response_code(304);
            exit;
        }

        header('Content-Type: application/octet-stream');
        echo file_get_contents($this->filename);
        exit;
    }
}
