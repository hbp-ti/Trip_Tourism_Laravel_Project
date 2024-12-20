<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Helpers\PopupHelper;
use App\Models\Item;
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

        $validator = Validator::make($request->all(), [
            'from' => 'required|regex:/^94-\d{5}$/',
            'to' => 'required|regex:/^94-\d{5}$/',  
            'date' => 'required|date|after:today',   // Verifica se a data é válida e está no futuro
            'preference' => 'nullable|string|in:AP,IR,IC,U,R', // Verifica se a preferência de trem é válida
        ]);

        // Se a validação falhar, retorna os erros para o usuário
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Recupera os parâmetros válidos
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

            // Se não houver jornadas encontradas, cria um popup de erro e redireciona
            if (empty($journeys)) {
                $popup = PopupHelper::showPopup(
                    'No Journeys Found', 
                    'Sorry, no journeys were found for the selected route and date and train type.', 
                    'error', 
                    'OK', 
                    false, 
                    '', 
                    5000
                );
                return back()->with('popup', $popup);
            }

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

        // Caso ocorra um erro na requisição das jornadas
        $popup = PopupHelper::showPopup(
            'No Journeys Found', 
            'Sorry, no journeys were found for the selected route and date and train type.', 
            'error', 
            'OK', 
            false, 
            '', 
            10000
        );
        return back()->with('popup', $popup);
    }

    public function createTicket(Request $request)
    {
        // Recebe o objeto JSON como string
        $ticket = $request->route('journey_id');  

        // Criação do item
        $item = Item::create([
            'item_type' => 'Ticket',
        ]);
    
        // Preparar os dados para a URL e o POST
        $itemId = $item->id;
        $locale = app()->getLocale();

        // Construir a URL com parâmetros para a rota 'auth.cart.add'
        $actionUrl = route('auth.cart.add', ['locale' => $locale, 'itemId' => $itemId, 'journeyId' => $ticket]);
    
        // Criar o HTML do formulário e enviar via POST
        $html = '<!DOCTYPE html>
        <html lang="' . app()->getLocale() . '">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Redirecionamento POST</title>
        </head>
        <body>
            <form id="redirectForm" action="' . $actionUrl . '" method="POST">
                <input type="hidden" name="itemId" value="' . $itemId . '">
                <input type="hidden" name="locale" value="' . $locale . '">
                ' . csrf_field() . '
            </form>
    
            <script type="text/javascript">
                // Submete o formulário automaticamente ao carregar a página
                document.getElementById("redirectForm").submit();
            </script>
        </body>
        </html>';
    
        // Retorna o HTML com o formulário para ser enviado via POST
        return response($html);
    }
    
    
}
