<template>
    <div class="eventDetail" :class="{'opened': isOpened}">

        <div id="eventSidebarContent">
            <div class="eventSidebarHeader">
                <i class="close-icon" @click="closeSidebar">X</i>
            </div>

            <div>
                {{calendarEventFocused.title}}
            </div>
        </div>

    </div>
</template>

<script>
 export default {
     props: {
         isOpened: Boolean
     },
    computed:{
        calendarEventFocused(){
            const focusedEvent = this.$store.getters.calendarEventFocused;

            if( typeof focusedEvent !== 'undefined' && focusedEvent !== null ) {
                return focusedEvent;
            }

            return {
                title: ''
            };
        },
        calendarFocus(){
            return this.$store.getters.calendarFocus
        }

    },
     methods: {
         closeSidebar() {
             this.$store.dispatch('changeSidebarState', false);
         }
     }
 }
 </script>

 <style>
     .eventDetail {
         position: absolute;
         right: 0;
         top: 0;
         bottom: 0;
         width: 0;
         overflow: hidden;
         background: red;
         transition: width 300ms ease-out;
     }

     .opened {
         width: 250px;
     }

     #eventSidebarContent {
         width: 250px;
         position: relative;
     }

     .eventSidebarHeader {
         height: 40px;
         position: relative;
         display: flex;
         flex-direction: row;
         align-items: center;
         justify-content: flex-end;
     }

     .close-icon {
         display: block;
         width: 30px;
         height: 30px;
         font-style: normal;
         font-weight: bold;
         font-size: 30px;
         cursor: pointer;
     }
 </style>
