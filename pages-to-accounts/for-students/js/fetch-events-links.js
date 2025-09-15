// fetch-events-links.js
document.addEventListener("DOMContentLoaded", function() {
    // Find card bodies by heading
    const eventsCardBody = getCardBodyByHeading("Upcoming Events");
    const linksCardBody = getCardBodyByHeading("Quick Links");

    if (eventsCardBody) fetchEvents(eventsCardBody);
    if (linksCardBody) fetchQuickLinks(linksCardBody);

    function getCardBodyByHeading(headingText) {
        const cardBodies = document.querySelectorAll(".card-body");
        for (const body of cardBodies) {
            const heading = body.querySelector("h6");
            if (heading && heading.textContent.trim().includes(headingText)) {
                return body;
            }
        }
        return null;
    }

    // -------- EVENTS ----------
    function fetchEvents(container) {
        fetch("../../../backend/api/student/get_events.php")
            .then(res => res.json())
            .then(data => {
                if (data.success && data.events?.length > 0) {
                    displayEvents(container, data.events);
                } else {
                    displayNoEvents(container);
                }
            })
            .catch(err => {
                console.error("Error fetching events:", err);
                displayNoEvents(container);
            });
    }

    function displayEvents(container, events) {
        container.querySelectorAll(".event-item, .no-events-message").forEach(e => e.remove());

        events.slice(0, 3).forEach(event => {
            const date = new Date(event.start_date);

            const item = document.createElement("div");
            item.className = "event-item";

            item.innerHTML = `
                <div class="event-date">
                    <span class="day">${date.getDate()}</span>
                    <span class="month">${date.toLocaleString('en-US', {month: 'short'})}</span>
                </div>
                <div class="event-info">
                    <h5>${event.title}</h5>
                    <p class="event-time">${formatEventDate(event.start_date)}</p>
                </div>
            `;

            item.addEventListener("click", () => {
                // optional: open full event page
                window.location.href = "/events/${event.id}";
            });

            container.appendChild(item);
        });
    }

    function displayNoEvents(container) {
        const msg = document.createElement("div");
        msg.className = "text-center text-muted py-2 no-events-message";
        msg.innerHTML = `<i class="ri-calendar-2-line"></i> No upcoming events`;
        container.appendChild(msg);
    }

    function formatEventDate(dateString) {
        const d = new Date(dateString);
        return d.toLocaleDateString('en-US', {weekday:'short', month:'short', day:'numeric'});
    }

    // -------- QUICK LINKS ----------
    function fetchQuickLinks(container) {
        fetch("../../../backend/api/student/get_quick_links.php")
            .then(res => res.json())
            .then(data => {
                if (data.success && data.links?.length > 0) {
                    displayQuickLinks(container, data.links);
                } else {
                    displayNoQuickLinks(container);
                }
            })
            .catch(err => {
                console.error("Error fetching quick links:", err);
                displayNoQuickLinks(container);
            });
    }

    function displayQuickLinks(container, links) {
        container.querySelectorAll(".suggestion-item, .no-links-message").forEach(e => e.remove());

        links.slice(0, 4).forEach(link => {
            const item = document.createElement("div");
            item.className = "suggestion-item";

            item.innerHTML = `
                <i class="${link.remix_icon || 'ri-links-line'} me-2 fs-5 text-success"></i>
                <div class="suggestion-info">
                    <h5>${link.title}</h5>
                    <small>${link.category}</small>
                </div>
            `;

            item.addEventListener("click", () => window.open(link.url, "_blank"));

            container.appendChild(item);
        });
    }

    function displayNoQuickLinks(container) {
        const msg = document.createElement("div");
        msg.className = "text-center text-muted py-2 no-links-message";
        msg.innerHTML = `<i class="ri-links-line"></i> No quick links available`;
        container.appendChild(msg);
    }
});
