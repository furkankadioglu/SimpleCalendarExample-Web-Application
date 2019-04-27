<template>
    <div class="main">
       <Header />
       <div class="content" id="mainContent">
           <router-view></router-view>
       </div>
       <EventDetail />
    </div>
</template>

<script>
import Header from './Header.vue';
import EventDetail from './EventDetail.vue';
export default {
    name: 'main-App',
    components: { Header, EventDetail }
}
</script>

<style>
#mainContent
{
    float: left;
}
</style>