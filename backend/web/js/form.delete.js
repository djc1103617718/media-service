$(document).ready(function () {

    var $listForm = $('#ql');

    $('a[data-action=audit]').click(function (evt) {
        evt.preventDefault();
        var checked = $listForm.find(':checkbox[name=selection\\[\\]]:checked').length;
        if (checked > 0) {
            bootbox.confirm('确定要发布吗?', function (result) {
                if (result) {
                    $listForm.attr('action', '/basic2/web/index.php?r=news/audit');
                    $listForm.submit();
                }
            });
        } else {
            bootbox.alert('没有选中任何项!');
        }
    });

    $('a[action=audit]').click(function (evt) {
        evt.preventDefault();
        var href = $(this).attr('href');
        bootbox.confirm('确定要发布吗?', function (result) {
            if (result) {
                window.location.href=href;
            }
        });
    });

    $('a[data-action=delete]').click(function (evt) {
        evt.preventDefault();
        var checked = $listForm.find(':checkbox[name=selection\\[\\]]:checked').length;
        if (checked > 0) {
            bootbox.confirm('确定要删除吗?', function (result) {
                if (result) {
                    //$listForm.attr('action', 'index.php?r=news/delete');
                    $listForm.submit();
                }
            });
        } else {
            bootbox.alert('没有选中任何项!');
        }
    });

    $('a[data-actions=delete]').click(function (evt) {
        var $a = $(this);
        evt.preventDefault();
        bootbox.confirm('确定要删除吗?', function (result) {
            if (!result) {
                return true;
            }
            var $listForm = $('#ql');
            $listForm.attr('action', $a.attr('href'));
            $listForm.submit();
        });
        //var $listForm = $('#ql');
        //var checked = $listForm.find(':checkbox[name=selection\\[\\]]:checked').length;
        //if (checked > 0) {
        //} else {
        //    bootbox.alert('没有选中任何项!');
        //}
    });
});
