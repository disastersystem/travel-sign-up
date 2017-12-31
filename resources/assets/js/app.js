
require('./bootstrap')

window.Vue = require('vue')

// import 'element-ui/lib/theme-chalk/index.css'

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })


Vue.component('trip', require('./views/Trip.vue'))

const app = new Vue({
    el: '#app'
})
