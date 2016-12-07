/**
 *
 */
function myConfirmDelete(text) {
    if (!text) text = "Are you sure you want to delete?";
    var x = confirm(text);

    if (x) {
        return true;
    } else {
        return false;
    }
}


/**
 *
 */
function myConfirmOperate(text) {
    if (!text) text = "Are you sure?";
    var x = confirm(text);

    if (x) {
        return true;
    } else {
        return false;
    }
}
