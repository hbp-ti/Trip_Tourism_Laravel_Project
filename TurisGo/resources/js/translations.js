let translations = {};

const loc = document.documentElement.lang; 

const translate = (key) => translations[key] || key;

window.translate = translate;

const loadTranslations = async () => {
    try {
        const response = await fetch(appUrl + '/lang/' + loc + '.json');
        if (!response.ok) throw new Error('Falha ao carregar as traduções.');
        return await response.json();
    } catch (error) {
        console.error(error);
        return {};
    }
};

const initTranslations = async () => {
    //const urlPath = window.location.pathname.split('/');
    //const currentLocale = urlPath[1];
    //translations = await loadTranslations(currentLocale);
    translations = await loadTranslations();
};

initTranslations();
