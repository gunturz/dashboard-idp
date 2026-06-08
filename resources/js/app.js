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


// --- SUCCESS ALERT AUTO-FADE & STYLE ALIGNER ---
const formatAndHideSuccessAlerts = () => {
    const selectors = [
        '.reg-success-alert',
        '.session-status',
        '#flash-success',
        '.success-banner',
        '.alert-success',
        '.bg-emerald-50',
        '.bg-green-50',
        '.bg-green-100',
        '.bg-green-200',
        '[role="alert"].bg-green-50',
        '[role="alert"].bg-emerald-50',
        '.prof-alert-success',
        '#success-banner',
        '#successPopup',
        '#success-alert'
    ];
    
    selectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(alert => {
            if (alert.dataset.formatted) return;

            // Jangan ubah badge/status pill kecil di tabel atau list.
            // Approved/Rejected di dashboard sering memakai `span.inline-flex`,
            // dan sebelumnya ikut terformat sebagai alert sukses.
            const isStatusBadge =
                alert.tagName === 'SPAN' ||
                alert.classList.contains('inline-flex') ||
                alert.classList.contains('rounded-full') ||
                alert.closest('table') !== null;

            if (isStatusBadge) return;

            // Skip elements that are handled by their own dedicated inline script
            if (alert.id && (alert.id === 'panelis-success-alert' || alert.dataset.skipGlobalFormat)) return;

            alert.dataset.formatted = "true";

            // Get message content using a highly robust extraction strategy
            let message = "";
            
            // 1. Try to find a span or paragraph that holds the actual message text
            const candidates = alert.querySelectorAll('span, p, .reg-success-text');
            let foundText = "";
            for (let cand of candidates) {
                // Skip if it contains SVG or is a button or is empty
                if (cand.querySelector('svg') || cand.tagName === 'BUTTON') continue;
                let txt = cand.textContent.trim();
                if (txt && !txt.match(/^(Berhasil!|Success!)$/i)) {
                    foundText = txt;
                    break;
                }
            }
            
            if (foundText) {
                message = foundText;
            } else {
                // Fallback: clone, remove svg/button/strong/h-tags, then get textContent
                const clone = alert.cloneNode(true);
                clone.querySelectorAll('svg, button, strong, h1, h2, h3, h4, h5, h6').forEach(el => el.remove());
                message = clone.textContent.trim();
            }

            // Strip any remaining buttons, svgs, or headers
            message = message
                .replace(/<button[^>]*>.*?<\/button>/gi, '')
                .replace(/<svg[^>]*>.*?<\/svg>/gi, '')
                .replace(/<strong[^>]*>.*?<\/strong>/gi, '')
                .replace(/&nbsp;/g, ' ')
                .trim();
                
            // Remove common prefixes
            message = message.replace(/^(Berhasil!|Success!)\s*/i, '').trim();

            // Apply the gorgeous consistent template styles using setProperty
            // so that the fade-out setTimeout can override opacity/transform later.
            alert.className = '';
            const applyStyle = (prop, val) => alert.style.setProperty(prop, val, 'important');
            applyStyle('display', 'flex');
            applyStyle('align-items', 'flex-start');
            applyStyle('gap', '12px');
            applyStyle('background', 'linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%)');
            applyStyle('border', '2px solid #86efac');
            applyStyle('color', '#15803d');
            applyStyle('font-size', '0.875rem');
            applyStyle('font-weight', '600');
            applyStyle('padding', '16px 20px');
            applyStyle('border-radius', '16px');
            applyStyle('box-shadow', '0 10px 15px -3px rgba(22, 163, 74, 0.08), 0 4px 6px -2px rgba(22, 163, 74, 0.04)');
            applyStyle('margin-bottom', '20px');
            applyStyle('transition', 'opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), height 0.5s cubic-bezier(0.4, 0, 0.2, 1), padding 0.5s cubic-bezier(0.4, 0, 0.2, 1), margin 0.5s cubic-bezier(0.4, 0, 0.2, 1)');
            applyStyle('opacity', '1');
            applyStyle('transform', 'scale(1)');
            applyStyle('overflow', 'hidden');
            applyStyle('position', 'relative');
            
            alert.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px; color:#16a34a; flex-shrink:0; margin-top:2px; display:inline-block;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div style="flex-grow:1; line-height:1.55; text-align:left;">
                    <strong style="font-weight: 800; display: block; margin-bottom: 2px; color: #166534;">Berhasil!</strong>
                    <span style="font-weight: 500;">${message || 'Aksi telah berhasil dilakukan.'}</span>
                </div>
            `;

            // Auto disappear after 3 seconds — use setProperty 'important' so it overrides
            setTimeout(() => {
                alert.style.setProperty('opacity', '0', 'important');
                alert.style.setProperty('transform', 'translateY(-10px) scale(0.95)', 'important');
                setTimeout(() => {
                    alert.style.setProperty('height', '0', 'important');
                    alert.style.setProperty('padding-top', '0', 'important');
                    alert.style.setProperty('padding-bottom', '0', 'important');
                    alert.style.setProperty('margin-top', '0', 'important');
                    alert.style.setProperty('margin-bottom', '0', 'important');
                    alert.style.setProperty('border', 'none', 'important');
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 500);
            }, 3000);
        });
    });
};

// Initialize listeners
document.addEventListener('DOMContentLoaded', () => {
    formatAndHideSuccessAlerts();

    // MutationObserver to capture dynamically inserted alerts (Livewire, Ajax, etc.)
    const observer = new MutationObserver(() => {
        formatAndHideSuccessAlerts();
    });
    observer.observe(document.body, { childList: true, subtree: true });
});
