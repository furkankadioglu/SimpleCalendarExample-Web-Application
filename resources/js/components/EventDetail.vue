<template>
    <div id="eventDetail" class="eventDetail">
        XXXX
    </div>
</template>

<script>
import $ from 'jquery';
import axios from 'axios';
import moment from 'moment';

 export default {
    mounted() {
        axios.defaults.headers.common['Authorization'] =  'Bearer ' + this.$store.getters.currentUser.token        
    },
    data: function() {
        return {
            event: null
        }
    }
 }
 </script>

 <style>
#eventDetail
{
    float: left;
}
 </style>