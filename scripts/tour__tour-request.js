/*------------------------------------*\
    #SECTION-TOUR-REQUEST*
    Scripts for tour request pop-up 
\*------------------------------------*/
/* 
 * Functions:
 *
 * checkForm () - Function to check tour-request form
 *
 * sendForm () - Function to send tour-request form
 *
 * Listeners:
 *     listener to submit tour-request form
 *
*/

function checkForm () {
/*
 * Function to check tour-request form
*/
    var clientName    = document.forms[0].elements["client-name"],
        clientPhone   = document.forms[0].elements["client-phone"],
        clientEmail   = document.forms[0].elements["client-email"],
        clientComment = document.forms[0].elements["client-comment"],
        nameRegExp    = /^[А-Яа-яЁёA-Za-z\s]+$/,
        phoneRegExp   = /^[0-9\s\(\)\+\-]+$/,
        emailRegExp   = /[^@]+@[^@]+\.[a-zA-Z]{2,6}/,
        commentRegExp = /^[0-9А-Яа-яЁёA-Za-z\s\,\.\/\'\"\?\-\!]+$/,
        flag          = true;
    
    
    if (clientName.value === "") {
        clientName.style.border = "1px solid #db4437";
        clientName.style.boxShadow = "0 0 10px #db4437";
        flag = false;
    } else if (clientName.value.search(nameRegExp) === -1) {
        clientName.style.border = "1px solid #db4437";
        clientName.style.boxShadow = "0 0 10px #db4437";
        flag = false;
    } else {
        clientName.style.border = "";
        clientName.style.boxShadow = "";
    }
    
    if (clientPhone.value === "") {
        clientPhone.style.border = "1px solid #db4437";
        clientPhone.style.boxShadow = "0 0 10px #db4437";
        flag = false;
    } else if (clientPhone.value.search(phoneRegExp) === -1) {
        clientPhone.style.border = "1px solid #db4437";
        clientPhone.style.boxShadow = "0 0 10px #db4437";
        flag = false;
    } else {
        clientPhone.style.border = "";
        clientPhone.style.boxShadow = "";
    }

    if (clientEmail.value !== "") {
        if (clientEmail.value.search(emailRegExp) === -1) {
            clientEmail.style.border = "1px solid #db4437";
            clientEmail.style.boxShadow = "0 0 10px #db4437";
            flag = false;
        } else {
            clientEmail.style.border = "";
            clientEmail.style.boxShadow = "";
        }
    }

    if (clientComment.value !== "") {
        if (clientComment.value.search(commentRegExp) === -1) {
            clientComment.style.border = "1px solid #db4437";
            clientComment.style.boxShadow = "0 0 10px #db4437";
            flag = false;
        } else {
            clientComment.style.border = "";
            clientComment.style.boxShadow = "";
        }
    }
    
    if (flag) {
        sendForm();
    };
}

function sendForm () {
/*
 * Function to send tour-request form
*/
    var clientName    = document.forms[0].elements["client-name"],
        clientPhone   = document.forms[0].elements["client-phone"],
        clientEmail   = document.forms[0].elements["client-email"],
        tourID        = document.forms[0].elements["tour-id"],
        clientComment = document.forms[0].elements["client-comment"],
        requestChbox  = document.getElementById("tour-request"),
        answerChbox   = document.getElementById("tour-answer"),
        answerText    = document.querySelector(".tour-answer p");
        
    var xhttp, resultObj, parameters;
  

    if (!tourID) {tourID = "";}
    parameters = "client-name=" + clientName.value + "&" +
                 "client-phone=" + clientPhone.value + "&" +
                 "client-email=" + clientEmail.value + "&" +
                 "tour-id=" + tourID.value + "&" +
                 "client-comment=" +  clientComment.value;
    xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            resultObj = JSON.parse(xhttp.responseText);
            if (resultObj.result === "success") {
                requestChbox.checked = false;
                answerChbox.checked  = true;
                answerText.innerHTML = "<span>Thank you for choosing our " +
                                       "company!</span><br>" +
                                       "<b>Your request has been sent.</b><br>" +
                                       "Our manager will contact you soon.";
            } else {
                answerChbox.checked = true;
                answerText.innerHTML = resultObj.reason;
            }
        }
    };
    xhttp.open("POST", "tools/handler--send-request.php", true);
    xhttp.setRequestHeader("Content-type", 
    "application/x-www-form-urlencoded");
    xhttp.send(parameters);
}

document.addEventListener("DOMContentLoaded", function () { 
/*
 * Set listener to submit tour-request form
 *
*/
    var requestForm = document.getElementById('request-form'); 

    requestForm.onsubmit = function() { 
        checkForm();
        return false;
    };
});