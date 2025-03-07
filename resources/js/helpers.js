window.displayCharCount = function (element, displayCharCountElement) {
    displayCharCountElement = "#" + displayCharCountElement;
    document.querySelector(displayCharCountElement).value = element.value.length.toString() + " / " + element.maxLength;
}

window.descriptioneParser = function (currentUser, users, string) {
    let regexCurrentUser = new RegExp('@('+currentUser+')', 'ig');
    string = string.replace(regexCurrentUser, '<span class="label radius text-danger fw-bold">@$1</span>');
    users.forEach(user => {
        if(user != currentUser){
            let regexUser = new RegExp('@('+user+')', 'ig');
            string = string.replace(regexUser, '<span class="label radius text-primary">@$1</span>');
        }
    });

    let regexLogNumber = new RegExp('#(\\d+)', 'ig');
    string = string.replace(regexLogNumber, '<span class="label radius text-success fw-bold">#$1</span>');

    // (https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})
    // https?:\/\/[^\s]+
    let regexUrlLink = new RegExp(/((http|https|ftp):\/\/[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/, 'gi');
    const urls = string.match(regexUrlLink);
    if(urls != null){
        urls.forEach(url => {
            string = string.replace(url, '<a href="' + url + '" target="_blank">' + url.substring(0, 30) + '...</a>');
        });
    }

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
    
    if(regexEmail.test(providedEmail)) {
        element.classList.add('is-valid');
        element.classList.remove('is-invalid');
    } else {
        element.classList.add('is-invalid');
        element.classList.remove('is-valid');
    }
}

window.rebuildSelect = function (selectId, data, message = "") {
    const select = document.querySelector("#" + selectId);

    for (var option in select) {
        select.remove(option);
    }

    if(message != "") {
        let messageOption = document.createElement('option');
        messageOption.text = message;
        messageOption.disabled = true;
        messageOption.selected = true;
        select.add(messageOption, undefined);
    }

    data.forEach((element) => {
        let newOption = document.createElement('option');
        newOption.value = element.id;
        newOption.text = element.name;
        select.add(newOption, undefined);
    });

    select.disabled = false;
}