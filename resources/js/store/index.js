import Vue from 'vue'
import Vuex from 'vuex'

/**
 * Import Modules
 */
import modals from './modules/modals'

/**
 * Use VueX
 */
Vue.use(Vuex)

/**
 * Create Vuex Store
 */
export default new Vuex.Store({
    modules: {
        modals,
    },
})
