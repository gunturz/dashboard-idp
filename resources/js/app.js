import './bootstrap';
import './echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const notificationFeedUrl = '/notifications/feed';
let notificationFeedInitialized = false;
let notificationPollInFlight = false;
let notificationLastId = null;

function rememberLatestNotificationId(notification) {
    const nextId = Number(notification?.id || 0);

    if (!nextId) {
        return;
    }

    notificationLastId = notificationLastId ? Math.max(notificationLastId, nextId) : nextId;
}

async function pollNotificationFeed() {
    if (notificationPollInFlight || document.visibilityState === 'hidden') {
        return;
    }

    notificationPollInFlight = true;

    try {
        const response = await window.axios.get(notificationFeedUrl, {
            headers: {
                Accept: 'application/json',
            },
        });

        const payload = response?.data || {};
        const latest = payload.latest || null;
        const latestId = Number(latest?.id || 0);

        if (!notificationFeedInitialized) {
            notificationFeedInitialized = true;
            notificationLastId = latestId || null;
            return;
        }

        if (latestId && (!notificationLastId || latestId > notificationLastId)) {
            rememberLatestNotificationId(latest);
            window.dispatchEvent(new CustomEvent('app-notification-received', {
                detail: latest,
            }));
        }
    } catch (error) {
        console.error('[Notification Feed] polling error', error);
    } finally {
        notificationPollInFlight = false;
    }
}

window.addEventListener('app-notification-received', (event) => {
    rememberLatestNotificationId(event.detail || {});
});

if (document.querySelector('meta[name="csrf-token"]')) {
    document.addEventListener('DOMContentLoaded', () => {
        pollNotificationFeed();
        window.setInterval(pollNotificationFeed, 5000);
    });

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            pollNotificationFeed();
        }
    });
}

// NOTE: Do NOT call Alpine.start() here.
// Livewire v4 manages Alpine.js internally and will start it automatically.
// Calling Alpine.start() manually would cause a double-initialization conflict
// that prevents wire:click and other Livewire directives from working correctly.
