module.exports = {
    namespaced: true,
    state: {
        isAuthenticated: false,
        accessToken: '',
        tokenType: 'Bearer',
        name: '',
        user_id: 'user_id',
    },
    mutations: {
        authenticate (state, payload) {
            state.accessToken = payload.accessToken || payload.access_token;
            state.isAuthenticated = true;
            state.name = payload.name;
            state.user_id = payload.user_id;

            // Authorization header
            window.axios.defaults.headers.common['Authorization'] = state.tokenType+' '+state.accessToken;

            // Local storage
            window.localStorage.setItem('draftPage.auth', JSON.stringify(state));
        },
        unauthenticate (state) {
            state.accessToken = '';
            state.isAuthenticated = false;
            state.name = '';
            state.user_id = '';

            delete window.axios.defaults.headers.common['Authorization'];

            window.localStorage.removeItem('draftPage.auth');
        },
    },
}