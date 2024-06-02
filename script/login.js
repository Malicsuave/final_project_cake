const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});

const MIN_SPEED = 1.5
const MAX_SPEED = 2.5

function randomNumber(min, max) {
  return Math.random() * (max - min) + min
}

class Blob {
  constructor(el) {
    this.el = el
    const boundingRect = this.el.getBoundingClientRect()
    this.size = boundingRect.width
    this.initialX = randomNumber(0, window.innerWidth - this.size)
    this.initialY = randomNumber(0, window.innerHeight - this.size)
    this.el.style.top = `${this.initialY}px`
    this.el.style.left = `${this.initialX}px`
    this.vx =
      randomNumber(MIN_SPEED, MAX_SPEED) * (Math.random() > 0.5 ? 1 : -1)
    this.vy =
      randomNumber(MIN_SPEED, MAX_SPEED) * (Math.random() > 0.5 ? 1 : -1)
    this.x = this.initialX
    this.y = this.initialY
  }

  update() {
    this.x += this.vx
    this.y += this.vy
    if (this.x >= window.innerWidth - this.size) {
      this.x = window.innerWidth - this.size
      this.vx *= -1
    }
    if (this.y >= window.innerHeight - this.size) {
      this.y = window.innerHeight - this.size
      this.vy *= -1
    }
    if (this.x <= 0) {
      this.x = 0
      this.vx *= -1
    }
    if (this.y <= 0) {
      this.y = 0
      this.vy *= -1
    }
  }

  move() {
    this.el.style.transform = `translate(${this.x - this.initialX}px, ${
      this.y - this.initialY
    }px)`
  }
}

function initBlobs() {
  const blobEls = document.querySelectorAll('.bouncing-blob')
  const blobs = Array.from(blobEls).map((blobEl) => new Blob(blobEl))

  function update() {
    requestAnimationFrame(update)
    blobs.forEach((blob) => {
      blob.update()
      blob.move()
    })
  }

  requestAnimationFrame(update)
}

initBlobs()

  // Ajax for existing username 
  $(document).ready(function(){
    $('#username').on('input', function(){
        var username = $(this).val();
        if(username.length > 0) {
            $.ajax({
                url: 'check_username.php',
                method: 'POST',
                data: {username: username},
                dataType: 'json',
                success: function(response) {
                    if(response.exists) {
                        $('#username').removeClass('is-valid').addClass('is-invalid');
                        $('#usernameFeedback').text('Username is already taken.');
                        $('#nextButton').prop('disabled', true); // Disable the Next button
                    } else {
                        $('#username').removeClass('is-invalid').addClass('is-valid');
                        $('#usernameFeedback').text('');
                        $('#nextButton').prop('disabled', false); // Enable the Next button
                    }
                }
            });
        } else {
            $('#username').removeClass('is-valid is-invalid');
            $('#usernameFeedback').text('');
            $('#nextButton').prop('disabled', false); // Enable the Next button if username is empty
        }
    });
});

  
$(document).ready(function(){
  $('#email').on('input', function(){
      var email = $(this).val();
      if(email.length > 0) {
          $.ajax({
              url: 'check_email.php',
              method: 'POST',
              data: {email: email},
              dataType: 'json',
              success: function(response) {
                  if(response.exists) {
                      $('#email').removeClass('is-valid').addClass('is-invalid'); 
                      $('#emailFeedback').text('Email is already taken.');
                      $('#nextButton').prop('disabled', true); // Disable the Next button
                  } else {
                      $('#email').removeClass('is-invalid').addClass('is-valid');
                      $('#emailFeedback').text('');
                      $('#nextButton').prop('disabled', false); // Enable the Next button
                  }
              }
          });
      } else {
          $('#email').removeClass('is-valid is-invalid');
          $('#emailFeedback').text('');
          $('#nextButton').prop('disabled', false); // Enable the Next button if username is empty
      }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const birthdayInput = document.getElementById("birthday");
  const steps = document.querySelectorAll(".form-step");
  let currentStep = 0;



  // Set the max attribute of the birthday input to today's date
  const today = new Date().toISOString().split('T')[0];    
  birthdayInput.setAttribute('max', today);

  // Add event listeners for real-time validation
  const inputs = form.querySelectorAll("input, select");
  inputs.forEach(input => {
    input.addEventListener("input", () => validateInput(input));
    input.addEventListener("change", () => validateInput(input));
  });

  //MultiStep Logic 
// Add an event listener to the form's submit event
form.addEventListener("submit", (event) => {
// Prevent form submission if the current step is not valid
if (!validateStep(currentStep)) {
event.preventDefault();
event.stopPropagation();
}

// Add the 'was-validated' class to the form for Bootstrap styling
form.classList.add("was-validated");
}, false);

// Function to move to the next step
window.nextStep = () => {
// Only proceed to the next step if the current step is valid
if (validateStep(currentStep)) {
steps[currentStep].classList.remove("form-step-active"); // Hide the current step
currentStep++; // Increment the current step index
steps[currentStep].classList.add("form-step-active"); // Show the next step
}
};

// Function to move to the previous step
window.prevStep = () => {
steps[currentStep].classList.remove("form-step-active"); // Hide the current step
currentStep--; // Decrement the current step index
steps[currentStep].classList.add("form-step-active"); // Show the previous step
};

// Function to validate all inputs in the current step
function validateStep(step) {
let valid = true;
// Select all input and select elements in the current step
const stepInputs = steps[step].querySelectorAll("input, select");

// Validate each input element
stepInputs.forEach(input => {
if (!validateInput(input)) {
  valid = false; // If any input is invalid, set valid to false
}
});

return valid; // Return the overall validity of the step
}


  function validateInput(input) {
    if (input.name === 'password') {
      return validatePassword(input);
    } else if (input.name === 'confirmPassword') {
      return validateConfirmPassword(input);
    } else {
      if (input.checkValidity()) {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        return true;
      } else {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
      }
    }
  }

  function validatePassword(passwordInput) {
    const password = passwordInput.value;
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if (regex.test(password)) {
      passwordInput.classList.remove("is-invalid");
      passwordInput.classList.add("is-valid");
      return true;
    } else {
      passwordInput.classList.remove("is-valid");
      passwordInput.classList.add("is-invalid");
      return false;
    }
  }

  function validateConfirmPassword(confirmPasswordInput) {
    const passwordInput = form.querySelector("input[name='password']");
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
  
    if (password === confirmPassword && password !== '') {
      confirmPasswordInput.classList.remove("is-invalid");
      confirmPasswordInput.classList.add("is-valid");
      return true;
    } else {
      confirmPasswordInput.classList.remove("is-valid");
      confirmPasswordInput.classList.add("is-invalid");
      return false;
    }
  }

   document.addEventListener("keydown", (event) => {
    if (event.key === 'Enter') {
        event.preventDefault(); // Prevent form submission
    }
});


  

});