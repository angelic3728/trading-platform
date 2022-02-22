/**
 * Initial State
 * List all modals here
 */
const state = {
    'upload-document': {
        show: false,
    },
    'trade': {
        show: false,
        data: {},
    },
}

/**
 * Getters
 */
const getters = {

    show: (state) => (modal) => {

        return state[modal].show;

    },

    data: (state) => (modal) => {

        return state[modal].data;

    },

}

/**
 * Mutations
 */
const mutations = {

    /**
     * Shows or Hide modal
     */
    toggle(state, params = {}){

        state[params.modal].show = params.show;
        state[params.modal].data = params.data;

    },

}

/**
 * Export
 */
export default {
    namespaced: true,
    state,
    getters,
    mutations
}
