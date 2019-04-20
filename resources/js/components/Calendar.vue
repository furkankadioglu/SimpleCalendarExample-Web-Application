<template>
    <div class="container">
        <h1 class="text-center">Hello {{ currentUser.name }}</h1>
        <br/>


        <div id="calendar"></div>
    </div>
</template>

<script>
import fullcalendar from 'fullcalendar';
import $ from 'jquery';
import axios from 'axios';

 export default {
    mounted() {
        axios.defaults.headers.common['Authorization'] =  'Bearer ' + this.$store.getters.currentUser.token

        $('#calendar').fullCalendar({
            eventSources: [
                {
                    url: '/api/calendarEvents/getEvents', 
                    headers: {
                            'Authorization': 'Bearer ' + this.$store.getters.currentUser.token
                    },
                    success: function(response) { 
                        return response.payload; 
                    }
                }
            ],
            selectable: true,
            selectHelper: true,
            editable: true,
            select: function(start, end) {
                var title = prompt('Event Title:');
                var eventData;
                if (title) {
                    eventData = {
                        title: title,
                        start: start,
                        end: end
                    };
                    axios.post('/api/calendarEvents/create', {
                        name: title,
                        start: start,
                        end: end
                    });
                    $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                }
                $('#calendar').fullCalendar('unselect');
            },
            eventRender: function(event, element) {
                element.append( "<span class='closeon' style='font-size: 18, text-center: 'center' '>X</span>" );
                element.find(".closeon").click(function() {
                    axios.post('/api/calendarEvents/delete/' + event.id);
                    $('#calendar').fullCalendar('removeEvents',event._id);
                });
            },
            eventClick: function(event) {
                if (event.title) {
                    var title = prompt('Event Title:', event.title);
                    event.title = title;

                    axios.post('/api/calendarEvents/update/' + event.id, {
                        name: event.title,
                        start: event.start,
                        end: event.end,
                    });

                    $('#calendar').fullCalendar('updateEvent', event)

                }
            }
        })
    },
    computed:{
        currentUser(){
            return this.$store.getters.currentUser
        }
    } 
 }
 </script>

 <style>
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