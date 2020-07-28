<template></template>

<script>
    module.exports = {
        created: function () {
            vueStore.commit('auth/unauthenticate');
            this.$router.replace('/login');
        }
    }
</script>