$(document).ready(function () {
    $(".select2").select2();
    getTotal();
});
$(document).on(
    "focus",
    ".select2-selection.select2-selection--single",
    function (e) {
        $(this)
            .closest(".select2-container")
            .siblings("select:enabled")
            .select2("open");
        //$(this).css("background-color", "red");
    }
);

$(document).on("click", ".remove", function () {
    $(this).closest(".row").remove();
    //
    var sum = 0;
    $(".cr_amount").each(function () {
        sum += Number($(this).val());
    });
    $(".total_cr").val(sum);
    //
    var summ = 0;
    $(".dr_amount").each(function () {
        summ += Number($(this).val());
    });
    $(".total_dr").val(summ);
});
$(document).on("keyup", ".cr_amount", function () {
    var sum = 0;
    $(".cr_amount").each(function () {
        sum += Number($(this).val());
    });
    $(".total_cr").val(sum);
});
$(document).on("keyup", ".dr_amount", function () {
    var sum = 0;
    $(".dr_amount").each(function () {
        sum += Number($(this).val());
    });
    $(".total_dr").val(sum);
});

$(function () {
    $(".date").daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        showDropdowns: true,
        startDate: true,
        minYear: 1930,
        maxYear: parseInt(moment().format("YYYY"), 15),
        locale: {
            format: "YYYY-MM-DD",
        },
    });
    $(".date").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(picker.startDate.format("YYYY-M-DD"));
    });
    $(".date").attr("autocomplete", "off");
});
