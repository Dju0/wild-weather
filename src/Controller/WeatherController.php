<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;

class WeatherController extends AbstractController
{
    #[Route('/weather/city', name: 'weather_by_city')]
    public function weatherByCity(Request $request, WeatherService $weatherService): Response
    {
        $city = $request->query->get('city', 'Paris'); // Une ville par défaut si aucune n'est spécifiée
        $weatherData = $weatherService->getCurrentWeatherByCityName($city);
    
        return $this->render('weather/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }

    #[Route('/weather/coordinates', name: 'weather_by_coordinates')]
    public function weatherByCoordinates(WeatherService $weatherService, Request $request): Response
    {
        $lat = $request->query->get('lat');
        $lon = $request->query->get('lon');
        $weatherData = $weatherService->getCurrentWeatherByCoordinates($lat, $lon);
        return $this->renderWeatherData($weatherData);
    }

    #[Route('/weather/cityid/{cityId}', name: 'weather_by_city_id')]
    public function weatherByCityId(WeatherService $weatherService, int $cityId): Response
    {
        $weatherData = $weatherService->getCurrentWeatherByCityId($cityId);
        return $this->renderWeatherData($weatherData);
    }

    #[Route('/weather/zipcode/{zipCode}/{countryCode}', name: 'weather_by_zipcode')]
    public function weatherByZipCode(WeatherService $weatherService, string $zipCode, string $countryCode): Response
    {
        $weatherData = $weatherService->getCurrentWeatherByZipCode($zipCode, $countryCode);
        return $this->renderWeatherData($weatherData);
    }

    private function renderWeatherData($weatherData): Response
    {
        // Vous pouvez adapter cette méthode pour afficher les données comme vous le souhaitez
        return $this->render('weather/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }
}
