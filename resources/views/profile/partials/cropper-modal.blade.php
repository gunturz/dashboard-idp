<style>
    /* Cropper Modal */
    .cropper-modal-backdrop {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.7);
        padding: 16px;
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
    }
    .cropper-modal-backdrop.hidden { display: none !important; }
    .cropper-modal-container {
        background: white; border-radius: 20px;
        width: 100%; max-width: 500px;
        overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .cropper-modal-header {
        padding: 16px 20px; border-bottom: 1px solid #e2e8f0;
        display: flex; justify-content: space-between; align-items: center;
    }
    .cropper-modal-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; }
    .cropper-modal-body { padding: 20px; background: #f8fafc; }
    .img-container { max-height: 400px; width: 100%; display: flex; justify-content: center; background: #e2e8f0; border-radius: 12px; overflow: hidden; }
    .img-container img { max-width: 100%; max-height: 400px; display: block; }
    .cropper-modal-footer {
        padding: 16px 20px; border-top: 1px solid #e2e8f0;
        display: flex; justify-content: flex-end; gap: 12px;
    }
</style>

<!-- Load Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<div id="cropper-modal" class="cropper-modal-backdrop hidden">
    <div class="cropper-modal-container">
        <div class="cropper-modal-header">
            <div class="cropper-modal-title">Sesuaikan Foto Profil</div>
            <button type="button" onclick="closeCropperModal()" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="cropper-modal-body">
            <div class="img-container">
                <img id="image-to-crop" src="" alt="Picture">
            </div>
        </div>
        <div class="cropper-modal-footer">
            <button type="button" onclick="closeCropperModal()" class="btn-prem btn-ghost text-sm py-2 px-4">Batal</button>
            <button type="button" onclick="cropImage()" class="btn-prem btn-teal text-sm py-2 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Terapkan
            </button>
        </div>
    </div>
</div>

<script>
    let cropper;
    
    document.addEventListener("DOMContentLoaded", function() {
        // Completely override previewFoto to open Cropper Modal
        window.previewFoto = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('image-to-crop').src = e.target.result;
                    document.getElementById('cropper-modal').classList.remove('hidden');
                    
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(document.getElementById('image-to-crop'), {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        };

        // Completely override hapusFoto
        window.hapusFoto = function() {
            // Desktop UI
            const pr = document.getElementById('foto-preview');
            const ph = document.getElementById('foto-placeholder');
            if (pr) { pr.src = ''; pr.classList.add('hidden'); }
            if (ph) ph.classList.remove('hidden');
            
            // Mobile UI
            document.querySelectorAll('.foto-preview-mobile').forEach(el => {
                if (el.tagName === 'IMG') {
                    el.src = '';
                    el.classList.add('hidden');
                }
            });
            document.querySelectorAll('.foto-placeholder-mobile').forEach(el => {
                el.classList.remove('hidden');
            });

            // Inputs
            const input = document.getElementById('foto-input');
            if (input) input.value = '';
            const shouldDelete = document.getElementById('should_delete_foto');
            if (shouldDelete) shouldDelete.value = '1';
            let hiddenInput = document.getElementById('foto_base64');
            if (hiddenInput) hiddenInput.value = '';
        };
    });

    function closeCropperModal() {
        document.getElementById('cropper-modal').classList.add('hidden');
        if (cropper) cropper.destroy();
        const input = document.getElementById('foto-input');
        if(input) input.value = ''; // Reset input
    }

    function cropImage() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        const base64Image = canvas.toDataURL('image/jpeg', 0.9);
        
        // Ensure hidden input exists in the form
        let form = document.getElementById('profile-form');
        let hiddenInput = document.getElementById('foto_base64');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'foto_base64';
            hiddenInput.id = 'foto_base64';
            form.appendChild(hiddenInput);
        }
        hiddenInput.value = base64Image;
        
        // Update UI Preview
        const pr = document.getElementById('foto-preview');
        const ph = document.getElementById('foto-placeholder');
        if (pr) {
            pr.src = base64Image;
            pr.classList.remove('hidden');
        }
        if (ph) ph.classList.add('hidden');

        // Update mobile UI previews if they exist
        document.querySelectorAll('.foto-preview-mobile').forEach(el => {
            if (el.tagName === 'IMG') {
                el.src = base64Image;
                el.classList.remove('hidden');
            }
        });
        document.querySelectorAll('.foto-placeholder-mobile').forEach(el => {
            el.classList.add('hidden');
        });
        
        // Ensure should_delete_foto is reset
        const shouldDelete = document.getElementById('should_delete_foto');
        if (shouldDelete) shouldDelete.value = '0';
        
        closeCropperModal();
    }
</script>
