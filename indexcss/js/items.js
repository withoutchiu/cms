function openForm(id){
    var displayVal = document.getElementById('edit-form-' + id).style.display;
    if(displayVal == 'none'){
      document.getElementById('edit-form-' + id).style.display = 'block';
    }else{
      document.getElementById('edit-form-' + id).style.display = 'none';
    }
}

function checkForm(form){
  if(!form.captcha.value.match(/^\d{5}$/)) {
    alert('Please enter the CAPTCHA digits in the box provided');
    form.captcha.focus();
    return false;
  }
  return true;
}
