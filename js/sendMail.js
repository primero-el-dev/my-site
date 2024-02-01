const contactForm = document.getElementById('contactForm')

contactForm.addEventListener('submit', (e) => {
	e.preventDefault()
	$.post(window.location.href, $('#contactForm').serialize())
		.done(function(data) {
			if (JSON.parse(data).status === 'success') {
				alert('Email was sent successfully!')
			} else {
				alert("There was an error and email wasn't sent. Please try again!")
			}
		})
})