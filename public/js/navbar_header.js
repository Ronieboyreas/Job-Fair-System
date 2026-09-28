function updateClock() {
            const now = new Date();
            
            // Format Time (12-hour format with AM/PM)
            const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            document.getElementById('liveClockTime').textContent = now.toLocaleTimeString('en-US', timeOptions);
            
            // Format Date (e.g., Monday, September 28, 2026)
            const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('liveClockDate').textContent = now.toLocaleDateString('en-US', dateOptions);
        }

        // Initialize clock & update every second
        updateClock();
        setInterval(updateClock, 1000);