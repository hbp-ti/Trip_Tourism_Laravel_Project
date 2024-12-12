<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrainController extends Controller
{
    protected $apiBaseUri;

    public function __construct()
    {
        // Configura o URI base da API a partir do arquivo de configuração
        $this->apiBaseUri = config('services.train_api.base_uri');
    }

    // Método para obter todas as estações
    public function stations()
    {
        $response = Http::get("{$this->apiBaseUri}/stations");

        // Verifica se a resposta da API foi bem-sucedida
        if ($response->successful()) {
            $stations = $response->json();  // Armazena a resposta JSON (uma lista de estações)
            return view('buyTicketTrain.buyTicketTrain', compact('stations'));  // Passa 'stations' para a view
        }

        // Se falhar, passa um array vazio e uma mensagem de erro
        return view('buyTicketTrain.buyTicketTrain', ['stations' => [], 'error' => 'Erro ao obter estações.']);
    }

    // Método para buscar uma estação específica
    public function station(Request $request)
    {
        $nome = $request->input('nome');
        $response = Http::get("{$this->apiBaseUri}/station", [
            'nome' => $nome,
        ]);

        if ($response->successful()) {
            $station = $response->json();
            return view('station', compact('station'));
        }

        return back()->withErrors(['message' => 'Erro ao obter a estação.']);
    }

    // Método para buscar as jornadas (viagens)
    public function journeys(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $date = $request->input('date');
        $train = $request->input('preference');

        // Busca as estações novamente, caso não estejam carregadas
        $stationsResponse = Http::get("{$this->apiBaseUri}/stations");

        if ($stationsResponse->successful()) {
            $stations = $stationsResponse->json();
        } else {
            $stations = [];
        }

        // Busca as jornadas
        $response = Http::get("{$this->apiBaseUri}/journeys", [
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'train' => $train
        ]);

        if ($response->successful()) {
            $journeys = $response->json();

            // Buscar nome da estação de origem
            $responseStationFrom = Http::get("{$this->apiBaseUri}/stationById", [
                'id' => $from,
            ]);

            if ($responseStationFrom->successful()) {
                $stationFrom = $responseStationFrom->json();
                $from = $stationFrom[0]['name'];
            }

            // Buscar nome da estação de destino
            $responseStationTo = Http::get("{$this->apiBaseUri}/stationById", [
                'id' => $to,
            ]);

            if ($responseStationTo->successful()) {
                $stationTo = $responseStationTo->json();
                $to = $stationTo[0]['name'];  // Atualiza o nome da estação de destino
            }
            // Passando tanto as jornadas quanto as estações para a mesma view
            return view('buyTicketTrain.buyTicketTrain', compact('journeys', 'stations', 'from', 'to'));
        }

        return back()->withErrors(['message' => 'Erro ao obter jornadas.']);
    }
}
