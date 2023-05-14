// Get current date
const currentDate = new Date();

// Get elements
const monthElement = document.getElementById("month");
const yearElement = document.getElementById("year");
const daysElement = document.querySelector(".days");
const eventNameElement = document.getElementById("event-name");
const eventDateElement = document.getElementById("event-date");

// Set current month and year
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

// Set event list
let events = [];

// Add event to list and refresh calendar
function addEvent(eventName, eventDates, action) {
    const eventDate = new Date(eventDates);
    events.push({ name: eventName, date: eventDate, action: action });
    renderCalendar(currentMonth, currentYear);
}



const PrevBtn = document.getElementById("prev-btn");
const NextBtn = document.getElementById("next-btn");

if (PrevBtn) {
    PrevBtn.addEventListener("click", () => {
        currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
        currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        renderCalendar(currentMonth, currentYear);
    });
}

if (NextBtn) {
    NextBtn.addEventListener("click", () => {
        currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
        currentMonth = currentMonth === 11 ? 0 : currentMonth + 1;
        renderCalendar(currentMonth, currentYear);
    });
}


// Render calendar
function renderCalendar(month, year) {
    // Set month and year in header
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",  "November", "December"];
    monthElement.textContent = monthNames[month];
    yearElement.textContent = year;

    // Clear days element
    daysElement.innerHTML = "";

    // Get number of days in month
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Get first day of month
    const firstDayOfMonth = new Date(year, month, 1).getDay();

    // Add empty days to start of calendar
    for (let i = 0; i < firstDayOfMonth; i++) {
        const emptyDayElement = document.createElement("div");
        emptyDayElement.classList.add("empty-day");
        daysElement.appendChild(emptyDayElement);
    }

    // Add days to calendar
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement("div");
        daysElement.appendChild(dayElement);

        // Highlight current day
        if (day === currentDate.getDate() && year === currentDate.getFullYear() && month === currentDate.getMonth()) {
            dayElement.classList.add("current-day");

        }

        // Check for events on this day
        const eventsOnThisDay = events.filter(event => {
            return event.date.getFullYear() === year &&
                event.date.getMonth() === month &&
                event.date.getDate() === day;
        });

        // Add event markers
        if (eventsOnThisDay.length > 0) {
            const markerElement = document.createElement("span");
            markerElement.textContent = day;
            dayElement.appendChild(markerElement);
            dayElement.classList.add("event-day");
            dayElement.addEventListener("click", eventsOnThisDay[0].action);
            continue;
        }
        dayElement.textContent = day;
    }
}

// Render calendar initially
renderCalendar(currentMonth, currentYear);

