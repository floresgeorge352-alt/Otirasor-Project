import './bootstrap';
import './toast';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// =========================================================
// REAL-TIME AVAILABILITY POLLING & BROADCAST LISTENER
// =========================================================
let lastAvailabilityHash = null;

async function pollAvailability() {
    // Kunin ang check_in at check_out mula sa URL params
    const params = new URLSearchParams(window.location.search);
    const checkIn = params.get('check_in');
    const checkOut = params.get('check_out');

    // Kung walang dates, hindi na mag-poll (walang silbi)
    if (!checkIn || !checkOut) return;

    try {
        const res = await fetch(`/api/availability?check_in=${checkIn}&check_out=${checkOut}`, {
            headers: { 'Accept': 'application/json' }
        });
        
        if (!res.ok) return;
        
        const data = await res.json();

        // Kung nag-iba ang hash, may nagbago sa availability
        if (lastAvailabilityHash !== null && data.hash !== lastAvailabilityHash) {
            // I-refresh ang page para makita ang bagong status ng rooms
            window.location.reload(); 
        }
        
        lastAvailabilityHash = data.hash;
    } catch (error) {
        console.error('Availability polling error:', error);
    }
}

// I-run ang polling tuwing 10 seconds (para sa mga walang WebSockets)
setTimeout(() => {
    pollAvailability();
}, 1000);

setInterval(pollAvailability, 10000);

// Real-time via Laravel Echo (Reverb/Pusher)
if (window.Echo) {
    window.Echo.channel('availability')
        .listen('.availability.updated', (e) => {
            console.log('Availability updated:', e);
            // I-trigger ang poll para makuha ang bagong hash at mag-refresh kung kailangan
            pollAvailability();
        });
}