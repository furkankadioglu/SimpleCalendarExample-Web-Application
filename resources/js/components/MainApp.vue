<template>
    <div class="main">
       <Header />
       <div class="content" id="mainContent">
           <router-view></router-view>
       </div>
    </div>
</template>

<script>
import Header from './Header.vue';
export default {
    name: 'main-App',
    components: { Header }
}
</script>

<style>
</style>