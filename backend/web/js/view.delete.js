$(document).ready(function () {
    $('a[action=delete]').click(function (evt) {
        evt.preventDefault();
        var href = $(this).attr('href');
        bootbox.confirm('确定要删除吗?', function (result) {
            if (result) {
                window.location.href=href;
            }
        });
    });
});
