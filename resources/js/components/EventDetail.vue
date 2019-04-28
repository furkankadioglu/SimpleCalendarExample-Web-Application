<template class="eventDetail">
    <div v-if="calendarFocus">
        BBB {{this.calendarFocus}}
        {{this.calendarEventFocused.title}}
    </div>
    <div v-else>
        CCC {{this.calendarFocus}}
        {{this.calendarEventFocused}}
    </div>
</template>

<script>
import $ from 'jquery';
import axios from 'axios';
import moment from 'moment';

 export default {
    data: function() {
        return {
            event: null
        }
    },
    computed:{
        calendarEventFocused(){
            return this.$store.getters.calendarEventFocused
        },
        calendarFocus(){
            return this.$store.getters.calendarFocus
        }

    } 
 }
 </script>

 <style>
.eventDetail
{
    display: none;
}
 </style>