let translations = {};

const translate = (key) => translations[key] || key;

window.translate = translate;

const loadTranslations = async (locale) => {
    try {
        const response = await fetch(`/lang/${locale}.json`);
        if (!response.ok) throw new Error('Falha ao carregar as traduções.');
        return await response.json();
    } catch (error) {
        console.error(error);
        return {};
    }
};

const initTranslations = async () => {
    const urlPath = window.location.pathname.split('/');
    const currentLocale = urlPath[1];
    translations = await loadTranslations(currentLocale);
};

initTranslations();
