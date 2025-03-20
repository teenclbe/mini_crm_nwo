import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
            initialView: 'timeGridWeek',
            events: function (fetchInfo, successCallback, failureCallback) {
                axios.get('/api/bookings/calendar', {
                    params: {
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr,
                    }
                })
                    .then(response => {
                        successCallback(response.data);
                    })
                    .catch(error => {
                        console.error('Failed to fetch events:', error);
                        failureCallback(error);
                    });
            },
            editable: true,
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            eventClick: function (info) {
                alert('Booking: ' + info.event.title + '\nRooms: ' + info.event.extendedProps.rooms + '\nStatus: ' + info.event.extendedProps.status);
            },
        });
        calendar.render();
    }

    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function () {
            const bookingId = this.getAttribute('data-booking-id');
            const newStatus = this.value;

            axios.put(`/bookings/${bookingId}/status`, { status: newStatus })
                .then(response => {
                    if (response.data.success) {
                        alert(response.data.message);
                    } else {
                        alert('Error: ' + response.data.message);
                        this.value = this.getAttribute('data-previous-status');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to update status');
                    this.value = this.getAttribute('data-previous-status');
                });

            this.setAttribute('data-previous-status', newStatus);
        });

        select.setAttribute('data-previous-status', select.value);
    });

    const roomCheckboxes = document.querySelectorAll('.room-checkbox');
    const discountMessage = document.getElementById('discount-message');
    const startTimeInput = document.querySelector('input[name="start_time"]');
    const endTimeInput = document.querySelector('input[name="end_time"]');

    if (roomCheckboxes.length > 0 && discountMessage && startTimeInput && endTimeInput) {
        const updateDiscountMessage = () => {
            const selectedRooms = document.querySelectorAll('.room-checkbox:checked');
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (!startTime || !endTime) {
                discountMessage.classList.add('hidden');
                discountMessage.textContent = 'Please select start and end times to calculate the price.';
                return;
            }

            const start = new Date(startTime);
            const end = new Date(endTime);
            const hours = (end - start) / (1000 * 60 * 60);

            if (hours <= 0) {
                discountMessage.classList.add('hidden');
                discountMessage.textContent = 'End time must be after start time.';
                return;
            }

            let originalPrice = 0;
            let discountedPrice = 0;
            const prices = [];

            selectedRooms.forEach(room => {
                const pricePerHour = parseFloat(room.getAttribute('data-price'));
                const roomPrice = pricePerHour * hours;
                prices.push(roomPrice);
                originalPrice += roomPrice;
            });

            prices.sort((a, b) => b - a);

            prices.forEach((price, index) => {
                if (index === 0) {
                    discountedPrice += price;
                } else if (index === 1) {
                    discountedPrice += price * 0.9;
                } else {
                    discountedPrice += price * 0.8;
                }
            });

            const selectedCount = selectedRooms.length;
            if (selectedCount === 0) {
                discountMessage.classList.add('hidden');
                discountMessage.textContent = '';
            } else if (selectedCount === 1) {
                discountMessage.classList.remove('hidden');
                discountMessage.textContent = `Total price: $${originalPrice.toFixed(2)} (no discount).`;
            } else if (selectedCount === 2) {
                discountMessage.classList.remove('hidden');
                discountMessage.textContent = `When choosing 2 rooms, there is a 10% discount on the second! Total price: $${discountedPrice.toFixed(2)} instead of $${originalPrice.toFixed(2)}.`;
            } else {
                discountMessage.classList.remove('hidden');
                discountMessage.textContent = `When choosing 3+ rooms, there is a 20% discount on the third and each subsequent room! Total price: $${discountedPrice.toFixed(2)} instead of $${originalPrice.toFixed(2)}.`;
            }
        };

        roomCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateDiscountMessage);
        });
        startTimeInput.addEventListener('change', updateDiscountMessage);
        endTimeInput.addEventListener('change', updateDiscountMessage);

        updateDiscountMessage();
    }
});