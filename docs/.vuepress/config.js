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
                text: 'Others attributes',
                link: '/others-attributes',
            },
            {
                text: 'Integrations',
                link: '/integrations',
            }
        ],
        displayAllHeaders: true,
        sidebarDepth: 2,
    },
};
