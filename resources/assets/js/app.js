
require('./bootstrap')

window.Vue = require('vue')

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)


Vue.component('trip', require('./views/Trip.vue'))

const app = new Vue({
    el: '#app'
})
