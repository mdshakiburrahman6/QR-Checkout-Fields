document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.qr-add-row').forEach(btn => {
        btn.addEventListener('click', () => {

            const group = btn.dataset.group;
            const table = document.querySelector(
                `.qr-fields-table[data-group="${group}"] tbody`
            );

            const index = table.children.length;

            table.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>
                        <input type="text" name="qr_cf_fields[${group}][${index}][label]">
                    </td>
                    <td>
                        <select class="qr-field-type"
                            name="qr_cf_fields[${group}][${index}][type]">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="image">Image</option>
                        </select>
                    </td>
                    <td>
                        <select name="qr_cf_fields[${group}][${index}][width]">
                            <option value="100">100%</option>
                            <option value="50">50%</option>
                        </select>
                    </td>
                    <td class="qr-max-size-col">
                        <input type="number"
                            class="qr-max-size"
                            min="1"
                            name="qr_cf_fields[${group}][${index}][max_size]"
                            value="5"
                            style="width:80px">
                    </td>
                    <td>
                        <input type="checkbox"
                            name="qr_cf_fields[${group}][${index}][required]"
                            value="1">
                    </td>
                    <td>
                        <button class="button qr-remove-row">✖</button>
                    </td>
                </tr>
            `);
        });
    });

    document.addEventListener('click', e => {
        if (e.target.classList.contains('qr-remove-row')) {
            e.preventDefault();
            e.target.closest('tr').remove();
        }
    });

    document.addEventListener('change', function (e) {

        if (!e.target.classList.contains('qr-field-type')) return;

        const row = e.target.closest('tr');
        if (!row) return;

        const maxSizeCol = row.querySelector('.qr-max-size-col');
        if (!maxSizeCol) return;

        if (e.target.value === 'image') {
            maxSizeCol.style.display = 'table-cell';
        } else {
            maxSizeCol.style.display = 'none';
        }
    });

    document
        .querySelectorAll('.qr-fields-table tbody tr')
        .forEach(row => {
            const typeSelect = row.querySelector('.qr-field-type');
            const maxSizeCol = row.querySelector('.qr-max-size-col');

            if (!typeSelect || !maxSizeCol) return;

            if (typeSelect.value === 'image') {
                maxSizeCol.style.display = 'table-cell';
            } else {
                maxSizeCol.style.display = 'none';
            }
        });


});
