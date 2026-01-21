document.addEventListener('DOMContentLoaded', function () {

    /* ===============================
       IMAGE UPLOAD HANDLER (GLOBAL)
    =============================== */

    document.querySelectorAll('.qr-upload-box').forEach(box => {

        const input = box.querySelector('input[type="file"]');
        const placeholder = box.querySelector('.qr-placeholder');
        const preview = box.querySelector('.qr-preview');
        const img = preview.querySelector('img');
        const removeBtn = preview.querySelector('.qr-remove');
        const maxMB = parseInt(box.dataset.max || 5, 10);

        box.addEventListener('click', () => input.click());

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;

            const sizeMB = file.size / (1024 * 1024);
            if (sizeMB > maxMB) {
                alert(`Image too large. Max allowed size is ${maxMB}MB`);
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                placeholder.style.display = 'none';
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });

        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            input.value = '';
            img.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        });
    });


    /* ===============================
       CONDITIONAL FIELDS HANDLER
    =============================== */

    const radios = document.querySelectorAll('input[name="qr_identity"]');
    const container = document.getElementById('qr-dynamic-fields');

    if (!container || typeof window.QR_CF_FIELDS === 'undefined') return;

    function renderConditionalFields(group) {

        container.innerHTML = '';

        const fields = window.QR_CF_FIELDS[group] || [];

        fields.forEach((field, i) => {

            const wrap = document.createElement('div');
            wrap.className = 'qr-field';
            wrap.style.width = field.width === '50' ? '48%' : '100%';

            let html = `<label>${field.label}</label>`;

            const name = `qr_${group}_${i}`;
            const required = field.required ? 'required' : '';

            if (field.type === 'textarea') {
                html += `<textarea name="${name}" ${required}></textarea>`;
            }
            if (field.type === 'image') {

                html += `
                    <div class="qr-upload-box" data-max="${field.max_size || 5}">
                        <input type="file" name="${name}" accept="image/*" hidden>

                        <div class="qr-placeholder">Click or drag image</div>

                        <div class="qr-preview" style="display:none">
                            <img src="">
                            <button type="button" class="qr-remove">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </button>
                        </div>
                    </div>
                `;
            }
            else {
                html += `<input type="text" name="${name}" ${required}>`;
            }

            wrap.innerHTML = html;
            container.appendChild(wrap);
        });
    }

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            renderConditionalFields(radio.value);
        });
    });

});
