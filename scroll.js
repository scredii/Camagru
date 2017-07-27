document.addEventListener("scroll", function (event) {
    checkForNewDiv();
});

var checkForNewDiv = function() {
    var lastDiv = document.querySelector("#scroll-content > div:last-child");
    var lastDivOffset = lastDiv.offsetTop + lastDiv.clientHeight;
    var pageOffset = window.pageYOffset + window.innerHeight;

    if(pageOffset > lastDivOffset - 20) {
        var newDiv = document.createElement("div");
        newDiv.innerHTML = "account-form";
        document.getElementById("scroll-content").appendChild(newDiv);
        checkForNewDiv();
    }
};
