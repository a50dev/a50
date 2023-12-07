import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

// https://astro.build/config
export default defineConfig({
  site: 'https://docs.a50.dev',
	integrations: [
		starlight({
			title: 'A50 — The PHP Framework',
      logo: {
        light: './src/assets/logo-light.svg',
        dark: './src/assets/logo-dark.svg',
        replacesTitle: true,
      },
			social: {
				github: 'https://github.com/a50/docs',
			},
			sidebar: [
        {
          label: 'Getting Started',
          autogenerate: { directory: 'getting-started' },
          translations: {
            'ru': 'Начало работы',
          },
        },
        {
          label: 'Architecture Concepts',
          autogenerate: { directory: 'architecture-concepts' },
          translations: {
            'ru': 'Архитектурные концепты',
          },
        },
        {
          label: 'The Basics',
          autogenerate: { directory: 'the-basics' },
          translations: {
            'ru': 'Базовые принципы',
          },
        },
        {
          label: 'Digging Deeper',
          autogenerate: { directory: 'digging-deeper' },
          translations: {
            'ru': 'Погружаемся глубже'
          },
        },
        {
          label: 'Security',
          autogenerate: { directory: 'security' },
          translations: {
            'ru': 'Безопасность'
          },
        },
        {
          label: 'Database',
          autogenerate: { directory: 'database' },
          translations: {
            'ru': 'Работа с базой данных'
          },
        },
        {
          label: 'ORM',
          autogenerate: { directory: 'orm' },
          translations: {
            'ru': 'ORM'
          },
        },
        {
          label: 'Testing',
          autogenerate: { directory: 'testing' },
          translations: {
            'ru': 'Тестирование'
          },
        }
			],
      editLink: {
        baseUrl: 'https://github.com/a50dev/a50/tree/main/packages/docs/',
      },
      defaultLocale: 'en',
      locales: {
        // English docs in `src/content/docs/en/`
        en: {
          label: 'English',
          lang: 'en',
        },
        // English docs in `src/content/docs/ru/`
        ru: {
          label: 'Русский',
          lang: 'ru',
        },
      },
		}),
	],
});
