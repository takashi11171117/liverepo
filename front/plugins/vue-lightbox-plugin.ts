import Vue from 'vue'
import VueLazyLoad from 'vue-lazyload'
import VueTouch from 'vue-touch'
import LightBox from 'vue-image-lightbox'
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')

Vue.use(VueTouch, { name: 'v-touch' })
Vue.use(VueLazyLoad)
Vue.component('light-box', LightBox)
