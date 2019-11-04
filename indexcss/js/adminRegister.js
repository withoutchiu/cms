'use strict';

function disableForm(){
  document.getElementById("confirmError").style.display = 'none';
  document.getElementById("confirmSuccess").style.display = 'none';
  document.getElementById('register').disabled = true;

}
function load(){
  var myInput = document.getElementById("password");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  }

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  }

  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(myInput.value.match(lowerCaseLetters)) {
      letter.classList.remove("invalid");
      letter.classList.add("valid");
    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(myInput.value.match(upperCaseLetters)) {
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }

    // Validate length
    if(myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  }

  disableForm();
  document.getElementById("password_confirmation").addEventListener('blur', function(e){
    disableForm();
    e.preventDefault();
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("password_confirmation").value;
    console.log(password);
    console.log(confirmPassword);

    if(password == confirmPassword){
      document.getElementById("confirmSuccess").style.display = 'block';
      document.getElementById('register').disabled = false;
    }else{
      document.getElementById("confirmError").style.display = 'block';
    }
  })
}

document.addEventListener('DOMContentLoaded', load);
