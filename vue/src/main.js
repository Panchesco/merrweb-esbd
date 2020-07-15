import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
//import Buefy from 'buefy'
import './assets/scss/app.scss'

//Vue.use(Buefy,{})
 
Vue.use(VueAxios, axios)

Vue.prototype.$appdata = window.merrweb_api // Pass appdata from localized merrweb_api variable as a Vue.prototype definition.

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
