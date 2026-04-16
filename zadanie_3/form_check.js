function isWhiteSpaceOrEmpty(str) {
    return /^[\s\t\r\n]*$/.test(str);
}

function isEmailInvalid(str) {
    let email = /^[a-zA-Z_0-9\.]+@[a-zA-Z_0-9\.]+\.[a-zA-Z][a-zA-Z]+$/;
    if (!email.test(str)) {
        return true;
    }
    else {
        return false;
    }
}

function checkStringAndFocus(obj, msg, validator) {
    let str = obj.value;
    let errorFieldName = "e_" + obj.name.substr(2, obj.name.length);
    if (validator(str)) {
        document.getElementById(errorFieldName).innerHTML = msg;
        obj.focus();
        return false;
    }
    else {
        document.getElementById(errorFieldName).innerHTML = "";
        return true;
    }
}

function validate(formularz) {
    let allValid = true;
    const elements = {
        "f_imie": ["Podaj imię!", isWhiteSpaceOrEmpty],
        "f_nazwisko": ["Podaj nazwisko!", isWhiteSpaceOrEmpty],
        "f_kod": ["Podaj kod pocztowy!", isWhiteSpaceOrEmpty],
        "f_ulica": ["Podaj ulicę!", isWhiteSpaceOrEmpty],
        "f_miasto": ["Podaj miasto!", isWhiteSpaceOrEmpty],
        "f_email": ["Podaj e-mail!", isEmailInvalid]
    }
    for (let key in elements) {
        let alert_msg = elements[key][0]
        let validator = elements[key][1]
        console.log(alert_msg, validator)
        if (!checkStringAndFocus(formularz.elements[key], alert_msg, validator)) {
            allValid = false;
        }
    }
    if (!allValid)
        return false;
    
    return true;
}


function showElement(e) {
    document.getElementById(e).style.visibility = 'visible';
}

function hideElement(e) {
    document.getElementById(e).style.visibility = 'hidden';
}

function alterRows(i, e) {
    if (e) {
        if (i % 2 == 1) {
            e.setAttribute("style", "background-color: Aqua;");
        }
        e = e.nextSibling;
        while (e && e.nodeType != 1) {
            e = e.nextSibling;
        }
        alterRows(++i, e);
    }
}

function nextNode(e) {
    while (e && e.nodeType != 1) {
        e = e.nextSibling;
    }
    return e;
}

function prevNode(e) {
    while (e && e.nodeType != 1) {
        e = e.previousSibling;
    }
    return e;
}

function swapRows(b) {
    let tab = prevNode(b.previousSibling);
    let tBody = nextNode(tab.firstChild);
    let lastNode = prevNode(tBody.lastChild);
    tBody.removeChild(lastNode);
    let firstNode = nextNode(tBody.firstChild);
    tBody.insertBefore(lastNode, firstNode);
}

function cnt(form, msg, maxSize) {
if (form.value.length > maxSize)
form.value = form.value.substring(0, maxSize);
else
msg.innerHTML = maxSize - form.value.length;
}