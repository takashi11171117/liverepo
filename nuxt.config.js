export default {
  srcDir: 'resources/front',

  axios: {
    logLevel: 'debug',
  },
  router: {
    middleware: ['check-auth']
  },
  env: {
    apiUrl: process.env.APP_URL || 'http://localhost:8000',
    appName: process.env.APP_NAME || 'Lumen-Nuxt',
    imageUrl: process.env.IMAGE_URL || 'https://liverepotest.s3.ap-northeast-1.amazonaws.com/',
  },

  mode: 'universal',

  /*
  ** Headers of the page
  */
  head: {
    title: 'ライブレポ',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'ライブレポ' }
    ],
    link: [
      {rel: 'icon', type: 'image/x-icon', href: '/favicon.ico'},
      {rel: 'stylesheet', href: '//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css'},
      {rel: 'stylesheet', href: 'https://use.fontawesome.com/releases/v5.2.0/css/all.css'}
    ],
  },

  /*
  ** Customize the progress-bar color
  */
  loading: {color: '#3B8070'},

  /*
  ** Global CSS
  */
  css: [
    { src: '~assets/bulma_main.scss', lang: 'scss' },
    'animate.css'
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    '~plugins/axios',
    '~plugins/nuxt-client-init',
    '~plugins/buefy',
    '~plugins/util',
    '~plugins/preview-input',
    {
      src: '~/plugins/vue-lightbox-pluign.js',
      ssr: false
    },

    {
      src: '~/plugins/vue-tags-input.js',
      ssr: false
    },
  ],

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: '/auth/login',
            method: 'post',
            propertyName: 'meta.token'
          },
          user: {
            url: '/auth/me',
            method: 'get',
            propertyName: 'data'
          }
        }
      }
    }
  },

  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/bulma',
    '@nuxtjs/font-awesome',
  ],

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
      if (process.server && process.browser) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
