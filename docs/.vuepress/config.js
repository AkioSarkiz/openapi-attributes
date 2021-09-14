module.exports = {
    base: '/openapi-attributes/',
    lang: 'en-US',
    title: 'Php openapi attributes',

    themeConfig: {
        logo: 'images/openapi-logo.png',

        navbar: [
            {
                text: 'Github',
                link: 'https://github.com/AkioSarkiz/openapi-attributes',
            },
        ],

        sidebar: [
            '/',
            {
                text: 'Guide',
                link: '/guide/',
                children: [
                    '/guide/getting-started',
                ],
            },
            {
                text: 'Routes',
                link: '/routes',
            },
            {
                text: 'Schemas',
                link: '/schemas',
            },
            {
                text: 'Integrations',
                link: '/integrations',
            },
            {
                text: 'Others attributes',
                link: '/other-attributes',
            }
        ],
        displayAllHeaders: true,
        sidebarDepth: 2,
    },
};
