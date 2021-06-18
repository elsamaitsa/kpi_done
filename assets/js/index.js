const login_container = document.getElementById('login')
const register_container = document.getElementById('register')


// OPEN LOGIN MODAL
const login_btn = document.getElementById('modal-login-btn')
login_btn.addEventListener('click', () => {
    login_container.style.display = 'flex'
})

// OPEN REGISTER MODAL
const register_btn = document.getElementById('modal-register-btn')
register_btn.addEventListener('click', () => {
    register_container.style.display = 'flex'
})

// CLOSE THE MODAL ON CLOSE BUTTON CLICK
const close_modal = document.getElementsByClassName('modal-close')
close_modal[0].addEventListener('click', () => {
    if (login_container.style.display == 'flex') {
        login_container.style.display = 'none'
    }
    if (register_container.style.display == 'flex') {
        register_container.style.display = 'none'
    }

})

// CLOSE THE MODAL ON CONTAINER CLICK
window.addEventListener('click', (event) => {
    if (event.target == login_container) {
        login_container.style.display = 'none'
    }

    if (event.target == register_container) {
        register_container.style.display = 'none'
    }
})

