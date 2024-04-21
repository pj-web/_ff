function removeBunner() {
    var blackFridayContainer = document.querySelector(".february_23_container");
    var blackFridayClose = document.querySelector(".february_23_close");

    blackFridayClose.addEventListener("click", function (event) {
        event.preventDefault();

        blackFridayContainer.remove();
        document.body.setAttribute("style", "margin-top: 0px !important");
        document.body.classList.remove("february_23_body");
    })
}

document.body.classList.add("february_23_body");
removeBunner();
