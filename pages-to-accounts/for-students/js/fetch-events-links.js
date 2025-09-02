// fetch-events-links.js
document.addEventListener("DOMContentLoaded", function() {
    console.log('Loading events and quick links...');
    
    // Find containers
    const eventsContainer = findContainerByHeading('Upcoming Events');
    const linksContainer = findContainerByHeading('Quick Links');
    
    if (eventsContainer) {
        console.log('Found events container');
        fetchEvents(eventsContainer);
    } else {
        console.log('Events container not found');
    }
    
    if (linksContainer) {
        console.log('Found quick links container');
        fetchQuickLinks(linksContainer);
    } else {
        console.log('Quick links container not found');
    }
    
    function findContainerByHeading(text) {
        const headings = document.querySelectorAll('.sidebar-card h4');
        for (let heading of headings) {
            if (heading.textContent.includes(text)) {
                return heading.closest('.sidebar-card');
            }
        }
        return null;
    }
    
    function fetchEvents(container) {
        console.log('Fetching events from API...');
        fetch('../../../backend/api/student/get_events.php')
            .then(response => {
                console.log('Events API response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Events API data:', data);
                if (data.success && data.events && data.events.length > 0) {
                    console.log('Displaying', data.events.length, 'events');
                    displayEvents(container, data.events);
                } else {
                    console.log('No events from API');
                    displayNoEvents(container, data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching events:', error);
                displayNoEvents(container, 'Network error');
            });
    }
    
    function displayEvents(container, events) {
        // Clear any existing content (except the header)
        const header = container.querySelector('.section-header');
        container.innerHTML = '';
        container.appendChild(header);
        
        // Add new events
        events.slice(0, 3).forEach(event => {
            const eventElement = createEventElement(event);
            container.appendChild(eventElement);
        });
        
        console.log('Added', Math.min(events.length, 3), 'new events');
    }
    
    function displayNoEvents(container, message) {
        console.log('Displaying no events message:', message);
        
        // Clear any existing content (except the header)
        const header = container.querySelector('.section-header');
        container.innerHTML = '';
        container.appendChild(header);
        
        // Add no events message
        const noEventsMsg = document.createElement('div');
        noEventsMsg.className = 'no-events-message text-center py-3 text-muted';
        noEventsMsg.innerHTML = `
            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
            <p>No upcoming events</p>
            <small class="text-muted">${message || 'Check back later'}</small>
        `;
        container.appendChild(noEventsMsg);
    }
    
    function createEventElement(event) {
        const eventDate = new Date(event.start_date);
        const day = eventDate.getDate();
        const month = eventDate.toLocaleString('en-US', { month: 'short' });
        const formattedDate = formatEventDate(event.start_date);
        
        const eventElement = document.createElement('div');
        eventElement.className = 'event-item';
        eventElement.innerHTML = `
            <div class="event-date">
                <span class="day">${day}</span>
                <span class="month">${month}</span>
            </div>
            <div class="event-info">
                <h5>${event.title}</h5>
                <p class="event-time">${formattedDate}</p>
            </div>
        `;
        
        return eventElement;
    }
    
    function formatEventDate(dateString) {
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        } catch (error) {
            console.error('Error formatting event date:', error);
            return 'Date TBA';
        }
    }
    
    function fetchQuickLinks(container) {
        console.log('Fetching quick links from API...');
        fetch('../../../backend/api/student/get_quick_links.php')
            .then(response => {
                console.log('Quick links API response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Quick links API data:', data);
                if (data.success && data.links && data.links.length > 0) {
                    console.log('Displaying', data.links.length, 'quick links');
                    displayQuickLinks(container, data.links);
                } else {
                    console.log('No quick links from API');
                    displayNoQuickLinks(container, data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching quick links:', error);
                displayNoQuickLinks(container, 'Network error');
            });
    }
    
    function displayQuickLinks(container, links) {
        // Clear any existing content (except the header)
        const header = container.querySelector('.section-header');
        container.innerHTML = '';
        container.appendChild(header);
        
        //  new links
        links.slice(0, 3).forEach(link => {
            const linkElement = createQuickLinkElement(link);
            container.appendChild(linkElement);
        });
        
        console.log('Added', Math.min(links.length, 3), 'new quick links');
    }
    
    function displayNoQuickLinks(container, message) {
        console.log('Displaying no quick links message:', message);
        
        // Clear any existing content (except the header)
        const header = container.querySelector('.section-header');
        container.innerHTML = '';
        container.appendChild(header);
        
        //  no links message
        const noLinksMsg = document.createElement('div');
        noLinksMsg.className = 'no-links-message text-center py-3 text-muted';
        noLinksMsg.innerHTML = `
            <i class="bi bi-link-45deg fs-1 d-block mb-2"></i>
            <p>No quick links available</p>
            <small class="text-muted">${message || 'Check back later'}</small>
        `;
        container.appendChild(noLinksMsg);
    }
    
    function createQuickLinkElement(link) {
        const iconClass = link.remix_icon || getDefaultIconForCategory(link.category) || 'bi bi-link-45deg';
        
        const linkElement = document.createElement('div');
        linkElement.className = 'suggestion-item';
        linkElement.style.padding = '10px 0';
        linkElement.style.cursor = 'pointer';
        linkElement.innerHTML = `
            <i class="${iconClass}" style="font-size: 20px; color: #7db832; margin-right: 15px;"></i>
            <div class="suggestion-info">
                <h5 style="margin: 0;">${link.title}</h5>
                <small style="color: #666;">${formatCategory(link.category)}</small>
            </div>
        `;
        
        //  click event to open link
        linkElement.addEventListener('click', function() {
            window.open(link.url, '_blank', 'noopener,noreferrer');
        });
        
        //  hover effect
        linkElement.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        
        linkElement.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
        
        return linkElement;
    }
    
    function getDefaultIconForCategory(category) {
        const iconMap = {
            'academic': 'ri-book-line',
            'support': 'ri-customer-service-2-line',
            'opportunity': 'ri-briefcase-4-line',
            'resource': 'ri-links-line'
        };
        
        return iconMap[category] || 'ri-link';
    }
    
    function formatCategory(category) {
        const categoryMap = {
            'academic': 'Academic',
            'support': 'Support',
            'opportunity': 'Opportunity',
            'resource': 'Resource'
        };
        
        return categoryMap[category] || category;
    }
});