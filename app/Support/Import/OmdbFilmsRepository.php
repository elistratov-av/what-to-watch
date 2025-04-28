<?php

namespace App\Support\Import;

use App\Models\Film;
use Carbon\Carbon;
use GuzzleHttp\Psr7\HttpFactory as HttpFactoryAlias;
use Psr\Http\Client\ClientInterface as ClientInterface;

class OmdbFilmsRepository implements FilmsRepository
{
    public function __construct(private ClientInterface $httpClient)
    {
    }

    private function createRequest(string $imdbId)
    {
        $apiUrl = config('services.omdb.films.url') . '&i=' . $imdbId;
        return (new HttpFactoryAlias())->createRequest('get', $apiUrl);
    }

    private static function toYear(string $v)
    {
        return Carbon::createFromFormat('j M Y|', $v)->year;
    }

    private static function toArray(string $v)
    {
        $arr = explode(', ', $v);
        return !$arr ? null : $arr;
    }

    /**
     * @inheritDoc
     */
    public function getFilm(string $imdbId)
    {
        $response = $this->httpClient->sendRequest($this->createRequest($imdbId));

        $data = json_decode($response->getBody()->getContents(), true);

        if (!isset($data['Response']) || !filter_var($data['Response'], FILTER_VALIDATE_BOOLEAN)) {
            return null;
        }

        $film = Film::firstOrNew(['imdb_id' => $imdbId]);

        $film->fill([
            'name' => $data['Title'] == 'N/A' ? null : $data['Title'],
            'description' => $data['Plot'] == 'N/A' ? null : $data['Plot'],
            'director' => $data['Director'] == 'N/A' ? null : $data['Director'],
            'starring' => $data['Actors'] == 'N/A' ? null : static::toArray($data['Actors']),
            'run_time' => $data['Runtime'] == 'N/A' ? null : (int)$data['Runtime'],
            'released' => $data['Released'] == 'N/A' ? null : static::toYear($data['Released']),
        ]);

        $links = [
            'poster_image' => $data['Poster'] == 'N/A' ? null : $data['Poster'],
        ];

        $genres = null;
        if (isset($data['Genre']) && $data['Genre'] != 'N/A') {
            $genres = static::toArray($data['Genre']);
        }

        return [
            'film' => $film,
            'genres' => $genres,
            'links' => $links,
        ];
    }
}
