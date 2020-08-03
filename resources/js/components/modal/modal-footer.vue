<style></style>

<template class="bottom">
    <footer class="Modal__footer text-right">
        <slot></slot>
    </footer>
</template>

<script>
    module.exports = {}
</script>
<style scoped>
.wrapper {
    position: relative;
    padding-bottom: 50px;
}

.wrapper .bottom {
    position: absolute;
    bottom: 0px;
    height: 50px;
}
</style>