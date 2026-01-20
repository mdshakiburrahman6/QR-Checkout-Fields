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
                        <select name="qr_cf_fields[${group}][${index}][type]">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </td>
                    <td>
                        <select name="qr_cf_fields[${group}][${index}][width]">
                            <option value="100">100%</option>
                            <option value="50">50%</option>
                        </select>
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

});
