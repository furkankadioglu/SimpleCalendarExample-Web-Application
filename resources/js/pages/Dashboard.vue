<template>
<div class="container">
    <h1>Dashboard</h1>
    Welcome {{ currentUser.name }}!
</div>
</template>

<script>
export default {
    computed:{
        currentUser(){
            return this.$store.getters.currentUser
        },
    }
}
</script>

