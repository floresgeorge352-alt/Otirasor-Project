import './bootstrap';
import './toast';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
Alpine.start();

// =========================================================
// LARAVEL ECHO SETUP (REVERB) — DAPAT UNAHIN BAGO GAMITIN
// =========================================================
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// =========================================================
// REAL-TIME AVAILABILITY POLLING & BROADCAST LISTENER
// =========================================================
let lastAvailabilityHash = null;

async function pollAvailability() {
    const params = new URLSearchParams(window.location.search);
    const checkIn = params.get('check_in');
    const checkOut = params.get('check_out');

    if (!checkIn || !checkOut) return;

    try {
        const res = await fetch(`/api/availability?check_in=${checkIn}&check_out=${checkOut}`, {
            headers: { 'Accept': 'application/json' }
        });

        if (!res.ok) return;

        const data = await res.json();

        if (lastAvailabilityHash !== null && data.hash !== lastAvailabilityHash) {
            window.location.reload();
        }

        lastAvailabilityHash = data.hash;
    } catch (error) {
        console.error('Availability polling error:', error);
    }
}

setTimeout(pollAvailability, 1000);
setInterval(pollAvailability, 10000);

// =========================================================
// ECHO LISTENERS
// =========================================================

// Legacy generic channel
window.Echo.channel('availability')
    .listen('.availability.updated', (e) => {
        console.log('Availability updated (generic):', e);
        pollAvailability();
    });

// Per-accommodation channel
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-accommodation-id]').forEach((card) => {
        const accommodationId = card.dataset.accommodationId;
        if (!accommodationId) return;

        window.Echo.channel(`accommodation.${accommodationId}`)
            .listen('.availability.changed', (e) => {
                console.log('Accommodation availability changed:', e);

                const statusContainer = card.querySelector('.status-container');
                const badge = card.querySelector('.availability-badge');
                const selectBox = card.querySelector('.select-box');
                const checkbox = card.querySelector('input[name="accommodations[]"]');

                if (statusContainer) {
                    statusContainer.dataset.available = e.available ? '1' : '0';
                }

                if (badge) {
                    if (e.available) {
                        badge.textContent = '✓ Available';
                        badge.className = 'availability-badge available';
                    } else {
                        badge.textContent = '✕ Already Booked';
                        badge.className = 'availability-badge booked';
                    }
                }

                if (selectBox) {
                    selectBox.style.display = e.available ? '' : 'none';
                }

                if (!e.available && checkbox) {
                    checkbox.checked = false;
                    checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
    });
});