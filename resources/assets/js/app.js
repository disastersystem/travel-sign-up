
require('./bootstrap')

window.Vue = require('vue')

// import 'element-ui/lib/theme-chalk/fonts/element-icons.woff'
// import 'element-ui/lib/theme-chalk/fonts/element-icons.ttf'
// import 'element-ui/lib/theme-chalk/index.css'

import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en' // the default language is chinese
Vue.use(ElementUI, { locale })


Vue.component('trip', require('./views/Trip.vue'))

const app = new Vue({
    el: '#app'
})
