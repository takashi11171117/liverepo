import { Configuration } from '@nuxt/types'

const config: Configuration = {
  mode: 'universal',
  /*
   ** Headers of the page
   */
  head: {
    title: process.env.npm_package_name || '',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      {
        hid: 'description',
        name: 'description',
        content: process.env.npm_package_description || ''
      }
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: { color: '#fff' },

  env: {
    apiServerUrl: process.env.API_SERVER_URL || 'http://localhost:8000',
    apiClientUrl: process.env.API_CLIENT_URL || 'http://localhost:8000',
    appName: process.env.APP_NAME || 'Lumen-Nuxt',
    imageUrl: process.env.IMAGE_URL || 'https://liverepotest.s3.ap-northeast-1.amazonaws.com/'
  },
  /*
   ** Global CSS
   */
  css: [
    'normalize.css',
    '~assets/bulma_main.sass'
  ],
  /*
   ** Plugins to load before mounting the App
   */
  plugins: [
    '~plugins/util',
    '~plugins/axios',
    '~plugins/store',
    {
      src: '~/plugins/v-calendar',
      mode: 'client'
    },
    {
      src: '~/plugins/vue-tags-input',
      mode: 'client'
    },
    {
      src: '~/plugins/preview-input',
      mode: 'client'
    },
    {
      src: '~/plugins/vue-lightbox-plugin',
      mode: 'client'
    }
  ],
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [
    '@nuxtjs/eslint-module',
    '@nuxt/typescript-build'
  ],
  /*
   ** Nuxt.js modules
   */
  modules: [
    'nuxt-buefy',
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/pwa'
  ],
  /*
   ** Axios module configuration
   ** See https://axios.nuxtjs.org/options
   */
  axios: {},
  /*
   ** Build configuration
   */
  build: {
    extend (config: any, ctx: any) {
      if (ctx.isDev && ctx.isClient) {
        if (!config.module) {
          return
        } // undefinedの場合、pushせずにreturnするように追加
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  },
  typescript: {
    typeCheck: true,
    ignoreNotFoundWarnings: true
  },
  sassOptions: {
    indentedSyntax: true
  },
  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: 'auth/login',
            method: 'post',
            propertyName: 'meta.token'
          },
          logout: false,
          user: {
            url: 'auth/me',
            method: 'get',
            propertyName: 'data'
          }
        }
      }
    }
  }
}

export default config
