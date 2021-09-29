$(document).ready(function () {
    var age = "";
    $('#dob').datepicker({
        onSelect: function (value, ui) {
            var today = new Date();
            age = today.getFullYear() - ui.selectedYear;
            $('#age').val(age);
        },
        dateFormat: 'dd-mm-yy',changeMonth: true,changeYear: true,yearRange:"c-100:c+0"
    })
})