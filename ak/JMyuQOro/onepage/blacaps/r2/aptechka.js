function openAptechka() {
    setTimeout((function () {
        $(".aptechka__wrapper").fadeOut(), $(".order_block").fadeIn(), start_timer()
    }), 3e3)
}

$(document).ready((function () {
    let e = document.querySelectorAll(".aptechka"),
        t = (document.querySelectorAll(".aptechka__sales"), document.querySelector(".aptechka__wrapper"), document.querySelector(".spin-result-wrapper"));
    document.querySelector(".pop-up-button"), document.querySelector(".order_block"), document.getElementById("aptechka__1"), document.getElementById("aptechka__2"), document.getElementById("aptechka__3"), document.getElementById("aptechka__sales1"), document.getElementById("aptechka__sales2"), document.getElementById("aptechka__sales3");

    function o(n) {
        $(".box").css("background", "none"), n.currentTarget.classList.add("open"), n.currentTarget.classList.add("vin"), setTimeout((function () {
            t.style.display = "block"
        }), 2500);
        for (let t = 0; t < e.length; t++) e[t].classList.contains("open") || setTimeout((function () {
            e[t].classList.add("open")
        }), 1500);
        for (let t = 0; t < e.length; t++) e[t].removeEventListener("click", o)
    }
    e.forEach((function (e) {
        e.addEventListener("click", o)
    }))
})), $(".close-popup, .pop-up-button").click((function (e) {
    e.preventDefault(), $(".spin-result-wrapper").fadeOut()
}));
var intr, time = 600;

var timerPiece = setInterval(tickPiece, 59e3),
    pieces = 18,
    lastpack = document.querySelectorAll(".left-pack");

function tickPiece() {
    --pieces, lastpack.forEach((function (e) {
        e.innerHTML = pieces
    })), 1 == pieces && clearInterval(timerPiece)
}