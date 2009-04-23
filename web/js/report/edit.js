$(function() {
    $(".add-button").click(function() {
        $(".delete-button").show();
        $(".query:hidden").clone(true).insertBefore($(this).parent()).show();

        if ($(".query:visible").length == 10) {
            $(this).hide();
        }
    });

    $(".delete-button").click(function() {
        $(this).parent().remove();

        if ($(".query:visible > .delete-button").length == 1) {
            $(".query:visible > .delete-button").hide();
        } else {
            $(".query:visible > .delete-button").show();
        }

        $(".add-button").show();
    });

    if ($(".query:visible").length == 1) {
        $(".query:visible > .delete-button").hide();
    }

    if ($(".query:visible").length == 10) {
        $(".add-button").hide();
    }

    $(".save-button").click(function() {
        var no = 1;

        $(".query:visible").each(function(i) {
            var $queryTextField = $(this).children(":input:first");
            var $queryLabelField = $(this).children(":input:last");

            if ($queryTextField.val() != "" || $queryLabelField.val() != "") {
                $queryTextField.attr("id", "report_query_text_" + no).attr("name", "report[query_text_" + no + "]");
                $queryLabelField.attr("id", "report_query_label_" + no).attr("name", "report[query_label_" + no++ + "]");
            } else {
                $queryTextField.removeAttr("id").removeAttr("name");
                $queryLabelField.removeAttr("id").removeAttr("name");
            }
        });
    });
})