const express = require('express');
const comboios = require('comboios');

const app = express();
const PORT = process.env.PORT || 3000;

// Função para listar estações
const getStation = async (req, res) => {
    try {
        const stations = await comboios.stations();
        const nome = req.query.nome || '';
        const estacoesEncontradas = stations.filter(station =>
            station.name.toLowerCase().includes(nome.toLowerCase())
        );
        res.json(estacoesEncontradas);
    } catch (error) {
        res.status(500).json({ error: 'Erro ao buscar estações', details: error.message });
    }
};

// Função para listar todas as estações
const getStations = async (req, res) => {
    try {
        const stations = await comboios.stations();
        res.json(stations);
    } catch (error) {
        res.status(500).json({ error: 'Erro ao buscar estações', details: error.message });
    }
};


// Função para listar jornadas
const getJourneys = async (req, res) => {
    try {
        const { from, to, date } = req.query;
        if (!from || !to || !date) {
            return res.status(400).json({ error: 'Parâmetros inválidos. Informe "from", "to" e "date".' });
        }
        const journeys = await comboios.journeys(from, to, { when: new Date(date) });
        res.json(journeys);
    } catch (error) {
        res.status(500).json({ error: 'Erro ao buscar jornadas', details: error.message });
    }
};

// Função para listar paradas de uma estação
const getStopovers = async (req, res) => {
    try {
        const { stationId, date } = req.query;
        if (!stationId || !date) {
            return res.status(400).json({ error: 'Parâmetros inválidos. Informe "stationId" e "date".' });
        }
        const stopovers = await comboios.stopovers(stationId, { when: new Date(date) });
        res.json(stopovers);
    } catch (error) {
        res.status(500).json({ error: 'Erro ao buscar paradas', details: error.message });
    }
};

// Função para obter informações de uma viagem específica
const getTripInfo = async (req, res) => {
    try {
        const { tripId } = req.query;
        if (!tripId) {
            return res.status(400).json({ error: 'Parâmetro "tripId" é obrigatório.' });
        }
        const tripInfo = await comboios.trip(tripId);
        res.json(tripInfo);
    } catch (error) {
        res.status(500).json({ error: 'Erro ao buscar informações da viagem', details: error.message });
    }
};

// Endpoints da API
app.get('/station', getStation);
app.get('/stations', getStations)
app.get('/journeys', getJourneys);
app.get('/stopovers', getStopovers);
app.get('/trip', getTripInfo);

app.listen(PORT, () => {
    console.log(`Server running on port: ${PORT}`);
});
