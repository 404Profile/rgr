import { createI18n } from 'vue-i18n';
import ru from './ru.json';
import en from './en.json';

const getStoredLocale = () => {
    const storedLocale = localStorage.getItem('locale');
    return storedLocale || 'ru';
};

const i18n = createI18n({
    legacy: false,
    locale: getStoredLocale(),
    fallbackLocale: 'ru',
    messages: {
        ru,
        en
    }
});

export const setLocale = (locale) => {
    i18n.global.locale.value = locale;
    localStorage.setItem('locale', locale);
    document.documentElement.setAttribute('lang', locale);
};

document.documentElement.setAttribute('lang', getStoredLocale());

export default i18n;
