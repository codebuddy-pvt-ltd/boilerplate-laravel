/* eslint-disable-next-line */
const addQueryParamToCurrentUrlAndRefresh = (data) => {
    /* eslint-disable-next-line */
    const params = new URLSearchParams(data);

    const currentUrl = window.location.path;
    window.location.href = [currentUrl, params.toString()].join("?");
};

$(function () {
    $("body").on("click", ".__btn-open-sidebar", function (e) {
        e.preventDefault();
        const target = $(this).data("target");
        $(target).toggleClass("active");
    });

    $("body").on("click", ".__btn-close-sidebar", function (e) {
        e.preventDefault();
        $(this).parents(".sidebar-wrapper").removeClass("active");
    });

    $("body").on("click", ".__btn-cancel-sidebar", function (e) {
        e.preventDefault();
        $("body").find(".__btn-close-sidebar").trigger("click");
    });

    $("body").on("change", ".file-image-preview input", function () {
        const reader = new FileReader();
        const thisInput = $(this);

        reader.addEventListener("load", function () {
            thisInput
                .parent()
                .find(".img")
                .addClass("preview")
                .css("background-image", `url(${reader.result})`);

            if (thisInput.hasClass("hero")) {
                thisInput.addClass("hero-preview");
            }
        });

        reader.readAsDataURL(this.files[0]);
    });

    $("input.float").on("input", function () {
        this.value = this.value
            .replace(/[^0-9.]/g, "")
            .replace(/(\..*?)\..*/g, "$1");
    });
});
