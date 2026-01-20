document.addEventListener('click', function (e) {

    if (!e.target.classList.contains('qr-add-row')) return;

    const group = e.target.dataset.group;
    const table = document.querySelector(
        `table[data-group="${group}"] tbody`
    );

    const index = table.children.length;

    table.insertAdjacentHTML('beforeend', `
        <tr>
            <td>
                <input type="text"
                    name="qr_cf_fields[${group}][${index}][label]"
                    placeholder="Field label">
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
                <button class="button qr-remove">✖</button>
            </td>
        </tr>
    `);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('qr-remove')) {
        e.preventDefault();
        e.target.closest('tr').remove();
    }
});
