window.displayCharCount = function (element, displayCharCountElement) {
    displayCharCountElement = "#" + displayCharCountElement;
    document.querySelector(displayCharCountElement).innerHTML = element.value.length.toString() + " / " + element.maxLength;
}

window.descriptioneParser = function (currentUser, users, string) {
    let regexCurrentUser = new RegExp('(\\W|^)@('+currentUser+')(\\W|$)', 'ig');
    string = string.replace(regexCurrentUser, '$1<span class="label radius text-danger fw-bold">@$2</span>$3');
    users.forEach(user => {
        if(user != currentUser){
            let regexUser = new RegExp('(\\W|^)@('+user+')(\\W|$)', 'ig');
            string = string.replace(regexUser, '$1<span class="label radius text-primary">@$2</span>$3');
        }
    });

    return string;
}

window.displayErrorModal = function (errorMessage, stackTrace) {
    if(document.querySelector("#errorModal")) {
        document.querySelector("#errorMessage").innerHTML = errorMessage;
        document.querySelector("#stackTrace").innerHTML = stackTrace;

        var errorModal = new bootstrap.Modal(document.querySelector('#errorModal'));
        errorModal.show();
    } else {
        console.error(stackTrace);
    }
}

window.checkEmailAddress = function (element) {
    let regexEmail = new RegExp('^[\\w-\\.]+@([\\w-]+\\.)+[\\w-]{2,4}$', 'g');
    let providedEmail = element.value;
console.log(regexEmail);
    if(regexEmail.test(providedEmail)) {
        element.classList.add('is-valid');
        element.classList.remove('is-invalid');
    } else {
        element.classList.add('is-invalid');
        element.classList.remove('is-valid');
    }
}