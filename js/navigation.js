const navbarToggler = document.getElementById('toggler')

navbarToggler.addEventListener('click', function () {
	let expanded = this.getAttribute('aria-expanded') == 'true' || false
	this.setAttribute('aria-expanded', !expanded)
})
