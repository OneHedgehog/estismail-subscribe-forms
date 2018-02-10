window.onload = function () {
    estismailFormsForWpPlugin();
};

function estismailFormsForWpPlugin() {

    var input = document.querySelectorAll('.estisSelectShortCode');
    if (input.length !== 0) {
        for (var i = 0; i <= (input.length - 1); i++) {
            input[i].onclick = function () {
                this.select();

            }
        }
    }

}

