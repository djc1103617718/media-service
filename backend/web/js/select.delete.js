
$(document).ready(function() {
    $('#operAll').click(function() {
        var tit = document.getElementById("operAll");
        var selections = document.getElementsByName("selection[]");
        for (var i = 0; i < selections.length; i++) {
            if (selections[i].type == "checkbox") {
                if (tit.checked == true) {
                    selections[i].checked = true;
                } else {
                    selections[i].checked = false;
                }
            }
        }
    })
})


/*
function getAll()
{
    var tit = document.getElementById("operAll");
    var selections = document.getElementsByName("selection");
    if (tit.checked == true) {
        for (var i = 0; i < selections.length; i++) {
            selections[i].checked = true;
        }
    } else {
        for (var i = 0; i < selections.length; i++) {
            selections[i].checked = false;
        }
    }
}*/
