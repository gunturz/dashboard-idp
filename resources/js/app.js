import './bootstrap';
import './echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// NOTE: Do NOT call Alpine.start() here.
// Livewire v4 manages Alpine.js internally and will start it automatically.
// Calling Alpine.start() manually would cause a double-initialization conflict
// that prevents wire:click and other Livewire directives from working correctly.
