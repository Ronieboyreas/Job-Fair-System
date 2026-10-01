document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const modalEl = document.getElementById('eventModal');
    const bsModal = modalEl ? new bootstrap.Modal(modalEl) : null;

    const loggedInAccountId = typeof CURRENT_ACCOUNT_ID !== 'undefined' ? CURRENT_ACCOUNT_ID : null;
    const currentUserRole = typeof USER_ROLE !== 'undefined' ? USER_ROLE : '';

    const specialDates = [
        '2026-12-25', 
        '2026-12-30', 
        '2026-09-28', 
        '2026-02-04', 
        '2026-03-04', 
        '2026-09-04', 
        '2026-01-05', 
        '2026-06-12', 
        '2026-08-31', 
        '2026-11-01', 
        '2026-11-30', 
    ];

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: '80vh',
        expandRows: true,
        editable: true,
        events: CALENDAR_CONFIG.fetchUrl,
        dayHeaderFormat: { weekday: 'long' },
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        customButtons: {
            statusLegend: { text: '' }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'statusLegend dayGridMonth,timeGridWeek,listMonth'
        },
        dayCellDidMount: function(info) {
            const dateNum = info.el.querySelector('.fc-daygrid-day-number');
            if (dateNum){
                dateNum.style.textDecoration = 'none';
                dateNum.style.color = '#010101';
            } 

            const cell = info.el;

            if (info.isToday) {
                cell.style.backgroundColor = '#e8f4f8';
                cell.style.border = '2px solid #0d6efd';
            }

            const year = info.date.getFullYear();
            const month = String(info.date.getMonth() + 1).padStart(2, '0');
            const day = String(info.date.getDate()).padStart(2, '0');
            const localDateStr = `${year}-${month}-${day}`;

            if (specialDates.includes(localDateStr)) {
                const numberEl = cell.querySelector('.fc-daygrid-day-number');
                if (numberEl) {
                    numberEl.style.textDecoration = 'none';
                    numberEl.style.color = '#850404';
                    numberEl.style.fontWeight = 'bold';
                }
                if (!cell.querySelector('.holiday-label')) {
                    const holidayBadge = document.createElement('div');
                    holidayBadge.className = 'holiday-label badge bg-danger text-white ms-1 mt-1';
                    holidayBadge.style.fontSize = '0.75rem';
                    holidayBadge.innerText = 'Holiday';

                    const topContainer = cell.querySelector('.fc-daygrid-day-top');
                    if (topContainer) topContainer.appendChild(holidayBadge);
                }
            }
        },
        datesSet: function() {
            const legendBtn = document.querySelector('.fc-statusLegend-button');
            if (legendBtn && !legendBtn.dataset.rendered) {
                legendBtn.dataset.rendered = "true";
                legendBtn.className = 'fc-button-legend d-inline-flex align-items-center me-2 bg-transparent border-0 p-0 cursor-default';
                legendBtn.innerHTML = `
                    <div class="d-flex align-items-center gap-1 me-2">
                        <span class="badge bg-success">Approved</span>
                        <span class="badge bg-warning text-dark">Pending</span>
                        <span class="badge bg-danger">Rejected</span>
                    </div>
                `;
            }
        },
        eventDidMount: function(info) {
            const status = (info.event.extendedProps.status || '').toLowerCase();
            const el = info.el;

            el.style.fontSize = '0.82rem';
            el.style.borderRadius = '3px';
            el.style.textDecoration = 'none';

            if (status === 'approved') {
                el.style.backgroundColor = '#198754';
                el.style.borderColor = '#146c43';
                el.style.color = '#ffffff';
            } else if (status === 'pending') {
                el.style.backgroundColor = '#ffc107';
                el.style.borderColor = '#ffb000';
                el.style.color = '#000000';
            } else if (status === 'rejected') {
                el.style.backgroundColor = '#dc3545';
                el.style.borderColor = '#b02a37';
                el.style.color = '#ffffff';
                el.style.textDecoration = 'line-through';
                el.style.opacity = '0.75';
            }
        },
        eventClick: function(info) {
            const event = info.event;
            const props = event.extendedProps || {};
            const eventAccountId = props.account_id;

            const isStaffOrAdmin = (currentUserRole === 'Administrator' || currentUserRole === 'Staff');
            const isOwner = String(eventAccountId) === String(loggedInAccountId);

            if (!isStaffOrAdmin && !isOwner) {
                alert("You can only view or edit job fairs submitted by your own account.");
                return;
            }

            const setInputValue = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.value = val ?? '';
            };

            setInputValue('event_id', event.id);

            const status = (props.status || '').toLowerCase();
            let statusBadge = '';
            if (status === 'approved') {
                statusBadge = `<span class="badge bg-success ms-2">Approved</span>`;
            } else if (status === 'pending') {
                statusBadge = `<span class="badge bg-warning text-dark ms-2">Pending</span>`;
            } else if (status === 'rejected') {
                statusBadge = `<span class="badge bg-danger ms-2">Rejected</span>`;
            } else {
                statusBadge = `<span class="badge bg-secondary ms-2">${props.status || ''}</span>`;
            }

            const modalTitleEl = document.getElementById('modalTitle');
            if (modalTitleEl) {
                modalTitleEl.innerHTML = `Application #${event.id} ${statusBadge}`;
            }

            setInputValue('organization_name', props.organization_name);
            setInputValue('event_applicant', props.applicant_name);
            setInputValue('event_type', props.jobfair_type);
            setInputValue('event_address', props.proposed_address);
            setInputValue('event_status', props.status || 'Pending');

            if (event.start) {
                const dateStr = event.startStr ? event.startStr.split('T')[0] : '';
                setInputValue('proposed_date', dateStr);
            }

            const isEditable = props.canEdit ?? true;
            const saveBtn = document.getElementById('saveBtn');
            const readOnlyNotice = document.getElementById('readOnlyNotice');
            const dateInput = document.getElementById('proposed_date');
            const statusSelect = document.getElementById('event_status');

            if (isEditable) {
                if (saveBtn) saveBtn.classList.remove('d-none');
                if (readOnlyNotice) readOnlyNotice.classList.add('d-none');
                if (dateInput) dateInput.removeAttribute('disabled');
                if (statusSelect) statusSelect.removeAttribute('disabled');
            } else {
                if (saveBtn) saveBtn.classList.add('d-none');
                if (readOnlyNotice) readOnlyNotice.classList.remove('d-none');
                if (dateInput) dateInput.setAttribute('disabled', 'disabled');
                if (statusSelect) statusSelect.setAttribute('disabled', 'disabled');
            }

            if (bsModal) bsModal.show();
        },
        eventDrop: function(info) {
            const props = info.event.extendedProps || {};

            if (!props.canEdit) {
                alert('Unauthorized: You do not have permission to edit this application date.');
                info.revert();
                return;
            }

            const newDate = info.event.startStr;
            const formData = new FormData();
            formData.append('id', info.event.id);
            formData.append('proposed_date', newDate);
            formData.append('organization_name', props.organization_name || '');
            formData.append('event_applicant', props.applicant_name || '');
            formData.append('event_type', props.jobfair_type || '');
            formData.append('event_address', props.proposed_address || '');

            if (props.status) {
                formData.append('status', props.status);
            }

            fetch(CALENDAR_CONFIG.updateUrl, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                } else {
                    alert(data.message || 'Failed to update date.');
                    info.revert();
                }
            })
            .catch(err => {
                console.error('Update error:', err);
                alert('An unexpected error occurred while moving the event.');
                info.revert();
            });
        }
    });

    calendar.render();

    const editForm = document.getElementById('editEventForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(CALENDAR_CONFIG.updateUrl, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (bsModal) bsModal.hide();
                    calendar.refetchEvents();
                } else {
                    alert(data.message || 'Error updating record.');
                }
            })
            .catch(err => {
                console.error('Submit error:', err);
                alert('An unexpected error occurred while saving.');
            });
        });
    }
});