const form = document.getElementById("form");
const fname = document.getElementById("fname");
const lname = document.getElementById("lname");
const email = document.getElementById("email");
const number = document.getElementById("number");

form.addEventListener('submit', e => {

  const isValid = checkinput();


  if (!isValid) {
    e.preventDefault();
  }
});

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.innerText = message;
  inputControl.classList.add('error');
  inputControl.classList.remove('success');
}

const setSuccess = element => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector('.error');

  errorDisplay.innerText = '';
  inputControl.classList.add('success');
  inputControl.classList.remove('error');
}

const isValidEmail = email => {

  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\.,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,})$/i;
  return re.test(String(email).toLowerCase());
}

const isValidPhone = phone => {

  return /^[0-9]{10}$/.test(phone);
}

const checkinput = () => {
  const fnameValue = fname.value.trim();
  const lnameValue = lname.value.trim();
  const emailValue = email.value.trim();
  const numberValue = number.value.trim();


  let isValid = true;

  if (fnameValue === '') {
    setError(fname, 'Firstname can\'t be blank');
    isValid = false;
  } else {
    setSuccess(fname);
  }

  if (lnameValue === '') {
    setError(lname, 'Lastname can\'t be blank');
    isValid = false;
  } else {
    setSuccess(lname);
  }

  if (emailValue === '') {
    setError(email, 'Email cannot be blank');
    isValid = false;
  } else if (!isValidEmail(emailValue)) {
    setError(email, 'Enter a valid email');
    isValid = false;
  } else {
    setSuccess(email);
  }

  if (numberValue === '') {
    setError(number, 'Phone number cannot be blank');
    isValid = false;
  } else if (!isValidPhone(numberValue)) {
    setError(number, 'Enter a valid phone number');
    isValid = false;
  } else {
    setSuccess(number);
  }
  


  return isValid;
}
