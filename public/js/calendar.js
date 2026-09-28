document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const modalEl = new bootstrap.Modal(document.getElementById('eventModal'));

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        editable: true,
        events: CALENDAR_CONFIG.fetchUrl,

        // Handle Event Click (Open Modal)
        eventClick: function(info) {
            const props = info.event.extendedProps;

            document.getElementById('event_id').value = info.event.id;
            document.getElementById('modalTitle').innerText = 'Application #' + info.event.id;
            document.getElementById('event_org').value = props.organization_name;
            document.getElementById('event_applicant').value = props.display_name;
            document.getElementById('event_type').value = props.jobfair_type;
            document.getElementById('event_address').value = props.proposed_address;
            document.getElementById('proposed_date').value = props.proposed_date;

            const statusElem = document.getElementById('event_status');
            if (statusElem) statusElem.value = props.status;

            const dateInput = document.getElementById('proposed_date');
            const saveBtn = document.getElementById('saveBtn');
            const notice = document.getElementById('readOnlyNotice');

            // Apply read-only mode if the user lacks permissions
            if (props.canEdit) {
                dateInput.removeAttribute('readonly');
                if (statusElem) statusElem.removeAttribute('disabled');
                saveBtn.classList.remove('d-none');
                notice.classList.add('d-none');
            } else {
                dateInput.setAttribute('readonly', true);
                if (statusElem) statusElem.setAttribute('disabled', true);
                saveBtn.classList.add('d-none');
                notice.classList.remove('d-none');
            }

            modalEl.show();
        },

        // Drag & Drop event date change
        eventDrop: function(info) {
            if (!info.event.extendedProps.canEdit) {
                alert('Unauthorized: You do not have permission to edit this application date.');
                info.revert();
                return;
            }

            const newDate = info.event.startStr;
            const formData = new FormData();
            formData.append('id', info.event.id);
            formData.append('proposed_date', newDate);

            fetch(CALENDAR_CONFIG.updateUrl, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                } else {
                    alert(data.message);
                    info.revert();
                }
            })
            .catch(() => info.revert());
        }
    });

    calendar.render();

    // Form submit inside modal
    document.getElementById('editEventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(CALENDAR_CONFIG.updateUrl, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                modalEl.hide();
                calendar.refetchEvents();
            } else {
                alert(data.message);
            }
        });
    });
});