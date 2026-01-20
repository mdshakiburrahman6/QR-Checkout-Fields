document.addEventListener('change', function (e) {

    if (e.target.name !== 'qr_identity') return;

    const wrapper = document.getElementById('qr-dynamic-fields');
    wrapper.innerHTML = '';

    const group = e.target.value;
    const fields = window.QR_CF_FIELDS[group] || [];

    fields.forEach((f, i) => {

        const width = f.width === '50' ? '48%' : '100%';

        wrapper.insertAdjacentHTML('beforeend', `
            <div style="width:${width};display:inline-block">
                <label>${f.label}</label>
                ${f.type === 'textarea'
                    ? `<textarea name="qr_${group}_${i}"></textarea>`
                    : `<input type="text" name="qr_${group}_${i}">`
                }
            </div>
        `);
    });
});
