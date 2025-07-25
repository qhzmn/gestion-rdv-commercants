document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const eventsData = JSON.parse(calendarEl.dataset.events);  // récupère les événements via data-events

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridDay',
        contentHeight: 'auto',     // ou une valeur fixe comme 600
        slotMinTime: "08:00:00",
        slotMaxTime: "20:00:00",

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        nowIndicator: true,

        events: eventsData,

        dateClick: function(info) {
      // info.dateStr est la date/heure en format ISO 8601, par ex: "2025-07-15T14:00:00"
      var clickedDate = info.dateStr;

      // Encoder la date pour URL (juste par sécurité)
      var encodedDate = encodeURIComponent(clickedDate);

      // Redirection vers /addRDV avec la date en GET
      window.location.href = '/appointment/add?return=appointment/view?date=' + encodedDate ;
    },


        eventClick: function(info) {
    const event = info.event;

    // Mise à jour des champs
    document.getElementById('modalTitle').innerText = event.title;
    document.getElementById('modalNameClient').innerText = event.extendedProps.name_client;
    document.getElementById('modalPhoneClient').innerText = event.extendedProps.phone_client;
    document.getElementById('modalUser').innerText = event.extendedProps.user;
    document.getElementById('modalDateStart').innerText = event.start.toLocaleString();
    document.getElementById('modalDateEnd').innerText = event.end.toLocaleString();

    // Met à jour l'attribut data-id
    const deleteBtn = document.getElementById('deleteEventBtn');
    deleteBtn.setAttribute('data-id', event.id);

    // ATTACHE le listener ici
    deleteBtn.onclick = function () {
        const rdvId = this.getAttribute('data-id');
        if (rdvId) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce rendez-vous ?")) {
                console.log("ID du rendez-vous :", rdvId);
                window.location.href = '/appointment/delete?id=' + rdvId;
            }
        }
    };

    // Affiche la modale
    document.getElementById('rdvModal').style.display = 'block';
}

    });

    console.log("JS chargé !");
    calendar.render();
});

document.getElementById('closeModal').addEventListener('click', function() {
  document.getElementById('rdvModal').style.display = 'none';
});

// Optionnel : fermer si clic en dehors de la fenêtre modal
window.addEventListener('click', function(e) {
  if (e.target == document.getElementById('rdvModal')) {
    document.getElementById('rdvModal').style.display = 'none';
  }
});



document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('deleteEventBtn');

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            const rdvId = this.getAttribute('data-id');

            if (rdvId) {
                if (confirm("Êtes-vous sûr de vouloir supprimer ce rendez-vous ?")) {
                    console.log("ID du rendez-vous :", rdvId);
                    window.location.href = '/appointment/delete?id=' + rdvId;
                }
            }
        });
    }
});
