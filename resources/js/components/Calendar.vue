<template>
        <div class="col-12" id="calendar">
        <h1 class="text-center">Hello {{ currentUser.name }}</h1>
        <br/>

        <FullCalendar
            class='calendar'
            ref="fullCalendar"
            defaultView="dayGridMonth"
            :header="{
                left: '',
                center: 'title',
                right: ''
            }"
            :plugins="calendarPlugins"
            :selectable="true"
            :editable="true"
            :weekends="calendarWeekends"
            :events="calendarEvents"
            :eventSources="calendarEventSources"
            @dateClick="calendarDateClick"
            @eventClick="calendarEventClick"
            @eventDrop="calendarEventDrop"
            @eventRender="calendarEventRender"
            @select="calendarSelectDate"
        />
        </div>
</template>

<script>
import $ from 'jquery';
import axios from 'axios';
import moment from 'moment';
import core from '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

 export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
    },
    mounted() {
        axios.defaults.headers.common['Authorization'] =  'Bearer ' + this.$store.getters.currentUser.token        
    },
    data: function() {
        return {
            calendarPlugins: [ // plugins must be defined in the JS
                dayGridPlugin,
                timeGridPlugin,
                interactionPlugin // needed for dateClick
            ],
            calendarWeekends: true,
            calendarSelectable: true,
            calendarEvents: [ // initial event data
                { title: 'Event Now', start: new Date() }
            ],
            calendarEventSources: [
                {
                    events: function(fetchInfo, successCallback, failureCallback) {
                        axios.get('/api/calendarEvents/getEvents?start=' + fetchInfo.start.valueOf() + "&end=" + fetchInfo.end.valueOf())
                        .then(function (response) {
                            successCallback(response.data.payload);
                        })
                        .catch(function (error) {
                            failureCallback(error);
                        });
                    },
                    color: 'green'
                },
            ],
            selectable: true
        }
    },
    methods: {
        toggleWeekends() {
            this.calendarWeekends = !this.calendarWeekends // update a property
        },
        gotoPast() {
            let calendarApi = this.$refs.fullCalendar.getApi() // from the ref="..."
            calendarApi.gotoDate('2000-01-01') // call a method on the Calendar object
        },
        calendarSelectDate(dateOrObj, endDate) {

            console.log("Log: Date selected.", dateOrObj);

            var start = dateOrObj.startStr;
            var end = dateOrObj.endStr;
            var allDay = dateOrObj.allDay;
            var title = prompt('Event Title:');
            var eventData;
            if (title) {

                eventData = {
                    name: title,
                    start: start,
                    end: end,
                };

                axios.post('/api/calendarEvents/create', eventData);
                this.calendarEvents.push(eventData);
            }
        },
        calendarDateClick(arg) {
            console.log("Log: Date clicked.", arg)            
        },
        calendarEventClick(arg) {
            console.log("Log: Event clicked.", arg)
            // var event = arg.event;
            // if (event.title) {
            //         var title = prompt('Event Title:', event.title);
            //         var eventData;
            //         console.log(moment(event.start).format("Y-m-d H:i:s"));
            //         if (title) {

            //             eventData = {
            //                 name: title,
            //                 start: event.start,
            //                 end: event.end,
            //             }

            //             axios.post('/api/calendarEvents/update/' + event.id, eventData);
            //         }

            // }
        },
        calendarEventRender(info)
        {
            console.log("Log: Event rendered.", info)
        },
        calendarEventDrop(info)
        {
            console.log("Log: Event drop.", info.event.start)
        }
    },
    computed:{
        currentUser(){
            return this.$store.getters.currentUser
        }
    } 
 }
 </script>

 <style>
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/timegrid/main.css';
 .closeon {
    text-align: center;
    flex: 1;
    color: darkred;
    justify-content: center;
    align-items: center;
    align-content: center;
    font-weight: bold;
    display: block;
 }
 </style>