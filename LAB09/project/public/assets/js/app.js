$(function () {
    loadData();

    function loadData() {
        $.get('index.php?c=student&a=api&action=list', function (res) {
            let html = '';
            res.data.forEach((s, i) => {
                html += `<tr>
                    <td>${i+1}</td>
                    <td>${s.code}</td>
                    <td>${s.full_name}</td>
                    <td>${s.email}</td>
                    <td>
                        <button onclick="del(${s.id})">Xóa</button>
                    </td>
                </tr>`;
            });
            $('#tbl tbody').html(html);
        });
    }

    $('#studentForm').submit(function (e) {
        e.preventDefault();
        $.post('index.php?c=student&a=api&action=create',
            $(this).serialize(),
            function () {
                loadData();
            }
        );
    });

    window.del = function (id) {
        if (confirm('Xóa?')) {
            $.post('index.php?c=student&a=api&action=delete', {id}, loadData);
        }
    }
});
