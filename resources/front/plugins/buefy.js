import Vue from 'vue'
import Buefy from 'buefy'

global.File= typeof window === 'undefined' ? Object : window.File;
Vue.use(Buefy);