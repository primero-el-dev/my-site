const sections = document.querySelectorAll('.section')
const fadeIns = document.querySelectorAll('.animation--fade-in')
const options = {
	root: null,
	threshold: 0,
	rootMargin: '50px',
}

const fadeIn = function (entry) {
	entry.classList.remove('hidden')
	entry.classList.add('fade-in')
}

let observer = new IntersectionObserver(function (entries, observer) {
	entries.forEach(function (entry) {
		if (!entry.isIntersecting) return
		let fadeIns = entry.target.querySelectorAll('.animation--fade-in')
		let delay = 150
		
		for (let i in fadeIns) {
			item = fadeIns.item(i)
			setTimeout(fadeIn, i*delay, item)
		}
		observer.unobserve(entry.target)
	})
}, {})

fadeIns.forEach(function (fadeIn) {
	fadeIn.classList.add('hidden')
})
sections.forEach(function (section) {
	observer.observe(section)
})
