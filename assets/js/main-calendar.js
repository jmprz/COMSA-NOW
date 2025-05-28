 document.addEventListener('DOMContentLoaded', function() {

      /////////////////////////////////////////////////
      //             --Sample event data--
      /////////////////////////////////////////////////
      const events = [
        {
          id: 1,
          title: 'Araw ng Pag Move-On',
          start: '2025-05-15T10:00:00',
          end: '2025-05-17T12:00:00',
          type: 'workshop',
          description: 'Learn how to calculate possiblities.',
          location: 'Computer Lab 3, Main Building',
          organizer: 'COMSA Committee',
          registrationLink: 'https://forms.gle/example1',
        /////////////////////////////////////////////////
        //             --img-> 800x400--
        /////////////////////////////////////////////////
          coverImage: 'assets/img/events/haha-testin.png',
        
        /////////////////////////////////////////////////
        //             --Sample data--
        //          title, type, url
        /////////////////////////////////////////////////
          preEventMaterials: [
            {
              title: 'Workshop Slides',
              type: 'slides',
              url: 'https://docs.google.com/presentation/d/example1'
            },
            {
              title: 'Python Basics PDF',
              type: 'pdf',
              url: 'assets/materials/python-basics.pdf'
            }
          ],

        /////////////////////////////////////////////////
        //            --other xample--
        //             --Sample data--
        //          title, type, url
        /////////////////////////////////////////////////
          postEventMaterials: [
            {
              title: 'Workshop Recording',
              type: 'video',
              url: 'https://youtu.be/example1'
            },
            {
              title: 'Code Examples',
              type: 'github',
              url: 'https://github.com/comsa/python-workshop'
            }
          ],

          /////////////////////////////////////////////////
          //             --COMMENTS--
          //             user, text, date
          /////////////////////////////////////////////////
          comments: [
            {
              user: 'Jay-Kun',
              text: 'Bakit 3days lang?',
              date: '2025-05-17T11:30:00'
            },
            {
              user: 'COMSA Admin',
              text: 'Ano to?',
              date: '2025-05-17T18:30:00'
            }
          ]
        }
      ];


      /////////////////////////////////////////////////
      //           --Initialize calendar--
      //           --Calend Layout Design
      /////////////////////////////////////////////////
      const calendarEl = document.getElementById('calendar-events');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: events.map(event => ({
          id: event.id,
          title: event.title,
          start: event.start,
          end: event.end,
          extendedProps: {
            type: event.type
          },
          backgroundColor: getEventColor(event.type),
          borderColor: getEventColor(event.type)
        })),
        eventClick: function(info) {
          const eventId = info.event.id;
          const event = events.find(e => e.id == eventId);
          showEventDetails(event);
        }
      });
      
      calendar.render();
      
      /////////////////////////////////////////////////
      //     --Filter buttons functionality--
      /////////////////////////////////////////////////
      const filterButtons = document.querySelectorAll('.filter-btn');
      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Update active button
          filterButtons.forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');
          
          const filter = this.dataset.filter;
          if (filter === 'all') {
            calendar.getEventSources().forEach(source => source.refetch());
          } else {
            calendar.getEventSources().forEach(source => {
              const eventSource = source;
              eventSource.refetch({
                filter: function(event) {
                  return event.extendedProps.type === filter;
                }
              });
            });
          }
        });
      });
      

      /////////////////////////////////////////////////
      //               --materials--
      /////////////////////////////////////////////////
      function showEventDetails(event) {
        const detailsContainer = document.getElementById('event-details-content');

      /////////////////////////////////////////////////
      //               --(PRE)materials--
      //             --type to icon--
      /////////////////////////////////////////////////
        let preMaterialsHTML = '';
        if (event.preEventMaterials && event.preEventMaterials.length > 0) {
          preMaterialsHTML = `
            <h5 class="mt-4">Pre-Event Materials</h5>
            ${event.preEventMaterials.map(material => `
              <div class="event-material">
                <h5>${material.title}</h5>
                <a href="${material.url}" target="_blank" class="btn btn-sm btn-outline-primary">
                  ${material.type === 'slides' ? '<i class="bi bi-file-slides"></i> View Slides' : 
                    material.type === 'pdf' ? '<i class="bi bi-file-earmark-pdf"></i> Download PDF' : 
                    material.type === 'github' ? '<i class="bi bi-github"></i> View on GitHub' : 
                    material.type === 'video' ? '<i class="bi bi-play-circle"></i> Watch Video' : 
                    '<i class="bi bi-link-45deg"></i> Visit Link'}
                </a>
              </div>
            `).join('')}
          `;
        }

      /////////////////////////////////////////////////
      //               --(POST)materials--
      //              --XAMPLE -> SHOULD BE DATA
      //             --type to icon--
      /////////////////////////////////////////////////
        let postMaterialsHTML = '';
        if (event.postEventMaterials && event.postEventMaterials.length > 0) {
          postMaterialsHTML = `
            <h5 class="mt-4">Post-Event Materials</h5>
            ${event.postEventMaterials.map(material => `
              <div class="event-material">
                <h5>${material.title}</h5>
                <a href="${material.url}" target="_blank" class="btn btn-sm btn-outline-primary">
                  ${material.type === 'slides' ? '<i class="bi bi-file-slides"></i> View Slides' : 
                    material.type === 'pdf' ? '<i class="bi bi-file-earmark-pdf"></i> Download PDF' : 
                    material.type === 'github' ? '<i class="bi bi-github"></i> View on GitHub' : 
                    material.type === 'video' ? '<i class="bi bi-play-circle"></i> Watch Video' : 
                    '<i class="bi bi-link-45deg"></i> Visit Link'}
                </a>
              </div>
            `).join('')}
          `;
        }

      /////////////////////////////////////////////////
      //               --(POST)materials--
      //                 --XAMPLE -> SHOULD BE DATA
      //            
      /////////////////////////////////////////////////
        let commentsHTML = '';
        if (event.comments && event.comments.length > 0) {
          commentsHTML = `
            <div class="comment-section">
              <h5>Q&A</h5>
              ${event.comments.map(comment => `
                <div class="comment">
                  <strong>${comment.user}</strong>
                  <small class="text-muted">${new Date(comment.date).toLocaleString()}</small>
                  <p>${comment.text}</p>
                </div>
              `).join('')}
              <div class="mt-3">
                <textarea class="form-control mb-2" placeholder="Add your question or comment"></textarea>
                <button class="btn btn-primary btn-sm">Post Comment</button>
              </div>
            </div>
          `;
        } else {
          commentsHTML = `
            <div class="comment-section">
              <h5>Q&A</h5>
              <p>No comments yet. Be the first to ask a question!</p>
              <div class="mt-3">
                <textarea class="form-control mb-2" placeholder="Add your question or comment"></textarea>
                <button class="btn btn-primary btn-sm">Post Comment</button>
              </div>
            </div>
          `;
        }
 
      ///////////////////////////////////////////////////
      ///////////////////////////////////////////////////
      
        
        // Create live chat/updates section
        let liveUpdatesHTML = '';
        const now = new Date();
        const eventStart = new Date(event.start);
        const eventEnd = new Date(event.end);
        
        if (now >= eventStart && now <= eventEnd) {
          liveUpdatesHTML = `
            <div class="mt-4 p-3 bg-light rounded">
              <h5><i class="bi bi-chat-dots"></i> Live Updates</h5>
              <p>Join the conversation during the event:</p>
              <div class="d-flex gap-2">
                <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-discord"></i> Discord</a>
                <a href="#" class="btn btn-sm btn-success"><i class="bi bi-whatsapp"></i> WhatsApp</a>
              </div>
            </div>
          `;
        }
        
        // Create registration button if applicable
        let registrationHTML = '';
        if (event.registrationLink) {
          registrationHTML = `
            <div class="d-grid mt-3">
              <a href="${event.registrationLink}" target="_blank" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Register Now
              </a>
            </div>
          `;
        }
        
        // Combine all HTML
        detailsContainer.innerHTML = `
          <img src="${event.coverImage || 'assets/img/events/default.jpg'}" class="img-fluid rounded mb-3" alt="${event.title}">
          <h3>${event.title}</h3>
          <p><i class="bi bi-calendar-event"></i> ${formatDate(event.start)} - ${formatTime(event.start)} to ${formatTime(event.end)}</p>
          <p><i class="bi bi-geo-alt"></i> ${event.location}</p>
          <p><i class="bi bi-people"></i> Organized by: ${event.organizer}</p>
          
          <div class="event-description mt-3">
            <h5>About This Event</h5>
            <p>${event.description}</p>
          </div>
          
          ${registrationHTML}
          ${liveUpdatesHTML}
          ${preMaterialsHTML}
          ${postMaterialsHTML}
          ${commentsHTML}
        `;
      }
      
      // Helper function to get event color based on type
      function getEventColor(type) {
        switch(type) {
          case 'workshop': return '#7db832'; // green
          case 'webinar': return '#3498db'; // blue
          case 'social': return '#e74c3c'; // red
          case 'meeting': return '#9b59b6'; // purple
          default: return '#7db832'; // default green
        }
      }
      
      // Helper function to format date
      function formatDate(dateString) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
      }
      
      // Helper function to format time
      function formatTime(dateString) {
        const options = { hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleTimeString(undefined, options);
      }
    });