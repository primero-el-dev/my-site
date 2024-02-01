const contactForm = document.querySelector('.contact__form')
const myMail = 'primero.el.dev@gmail.com'

contactForm.addEventListener('submit', (e) => {
	// e.preventDefault()
	let name = e.target.querySelector('[name="name"]').value
	let email = e.target.querySelector('[name="email"]').value
	let subject = e.target.querySelector('[name="subject"]').value
	let message = e.target.querySelector('[name="message"]').value

	
})