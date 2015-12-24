function myConfirmDelete(text) {
    if (!text) text = "Are you sure you want to delete?";
    var x = confirm(text);

    if (x) {
        return true;
    } else {
        return false;
    }
}
