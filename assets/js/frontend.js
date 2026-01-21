document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.qr-upload-box').forEach(box => {

        const input = box.querySelector('input[type="file"]');
        const placeholder = box.querySelector('.qr-placeholder');
        const preview = box.querySelector('.qr-preview');
        const img = preview.querySelector('img');
        const removeBtn = preview.querySelector('.qr-remove');
        const maxMB = parseInt(box.dataset.max || 5, 10);

        // click to open file
        box.addEventListener('click', () => input.click());

        // file selected
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

        // remove image
        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            input.value = '';
            img.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        });
    });

});
