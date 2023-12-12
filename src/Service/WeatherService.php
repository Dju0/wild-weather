<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getCurrentWeatherByCityName($city)
    {
        return $this->makeWeatherRequest([
            'q' => $city
        ]);
    }

    public function getCurrentWeatherByCoordinates($lat, $lon)
    {
        return $this->makeWeatherRequest([
            'lat' => $lat,
            'lon' => $lon
        ]);
    }

    public function getCurrentWeatherByCityId($cityId)
    {
        return $this->makeWeatherRequest([
            'id' => $cityId
        ]);
    }

    public function getCurrentWeatherByZipCode($zipCode, $countryCode)
    {
        return $this->makeWeatherRequest([
            'zip' => "$zipCode,$countryCode"
        ]);
    }

    // Dans WeatherService.php

    private function makeWeatherRequest(array $queryParams)
    {
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={933f059c1163bd1b762c438e31fcad1f}',
            [
                'query' => array_merge($queryParams, [
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ])
            ]
        );

        return $response->toArray();
    }

    }

