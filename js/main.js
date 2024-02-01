const CANVAS = document.querySelector('canvas')
const CTX = CANVAS.getContext('2d')

let offset = {
	x: 0,
	y: 0
}

CANVAS.width = innerWidth
CANVAS.height = innerHeight

CTX.beginPath()
CTX.moveTo(0, 0)
CTX.stroke()

const COLORS = [
	[252, 186, 3],
	[30, 235, 68],
	[24, 240, 240],
	[132, 24, 240],
	[230, 18, 124],
	[235, 64, 52],
	[52, 235, 156]
]

const getMousePos = function (evt) {
    var rect = CANVAS.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
    }
}

const stringifyRGBA = function (r, g, b, a) {
	return 'rgba('+r.toString()+','+g.toString()+','+b.toString()+','+a.toString()+')';
}

let Circle = function (x, y) {
	this.x = x
	this.y = y
	this.r = 1
	this.opacity = 1
	this.color = COLORS[Math.floor(Math.random() * COLORS.length) % COLORS.length]

	console.log(this.color)

	this.render = function () {
		CTX.beginPath()
		CTX.fillStyle = stringifyRGBA(this.color[0], this.color[1], this.color[2], this.opacity)
		// CTX.fillStyle = 'rgb(200,200,200)'
		CTX.arc(this.x + offset.x + 10, this.y + offset.y + 10, this.r, 0, 2 * Math.PI)
		CTX.fill()
	}

	this.update = function () {
		this.r += 1
		this.opacity -= 0.008
		this.render()
	}

	this.isVisible = function () {
		return this.opacity > 0
	}

	return this
}

let circles = []


const drawCircle = (evt) => {
	let pos = getMousePos(evt)
	let circle = new Circle(pos.x, pos.y)
	circle.render()
	circles.push(circle)
}

const init = () => {

	window.requestAnimationFrame(draw)
}


const draw = () => {
	CTX.fillStyle = 'rgb(175, 206, 227)'
	CTX.fillRect(0, 0, CANVAS.width, CANVAS.height)

	for (let i in circles) {
		circles[i].update()
		if (!circles[i].isVisible()) {
			circles.splice(i, 1)
		}
	}

	window.requestAnimationFrame(draw)
}

init()



$(document).ready(function () {
	// Canvas drawing
	$('canvas').mousemove(function (e) {
		drawCircle(e)
	})

	$(window).scroll(function (e) {
		// offset.y = $(window).scrollTop()
	})

	$(window).resize(function () {
		CANVAS.width = innerWidth
		CANVAS.height = innerHeight
	})

	const navbarLinks = $(document).find('.navbar__list').find('a')

	const sectionIds = navbarLinks.map(function () {
		return $(this).attr('href')
	})

	const sectionOffsets = sectionIds.map(function () {
		let elementId = this.valueOf()
		return $(elementId).offset().top
	})

	const sectionOffsetByIds = (function (sectionIds, sectionOffsets) {
		let map = []

		for (let i = 0; i < sectionIds.length; i++) {
			map.push([sectionIds[i], sectionOffsets[i]])
		}

		return map
	})(sectionIds, sectionOffsets)

	const activateTabOnLoad = (sectionOffsetByIds) => {
		let uri = window.location.href
		let currentTab = uri.substring(uri.lastIndexOf('/') + 1)
		
		if (currentTab == '') {
			$(navbarLinks[0]).addClass('active')
		
		} else {
			for (i in sectionOffsetByIds) {
				if (sectionOffsetByIds[i][0] == currentTab) {
					$(navbarLinks[i]).addClass('active')
				}
			}
		} 
	}

	activateTabOnLoad(sectionOffsetByIds)

	const activateTabs = (sectionOffsetByIds) => (offset) => {
		let length = sectionOffsetByIds.length
		let currentTabIndex = null

		for (i in sectionOffsetByIds) {
			if (offset >= sectionOffsetByIds[length - i - 1][1]) {
				currentTabIndex = length - i - 1
				break
			}
		}

		navbarLinks.each((index) => {
			$(navbarLinks[index]).removeClass('active')
		})

		$(navbarLinks[currentTabIndex]).addClass('active')
	}

	const activateTabWhenScroll = activateTabs(sectionOffsetByIds)

	$(document).on('scroll', function () {
		var scroll = $(document).scrollTop()

		activateTabWhenScroll(scroll)
	});

	const ObjectIterator = (function (objectArray) {
		var index = 0
		var objectArray = objectArray

		this.prototype.first = () => {
			index = 0
			return objectArray[index]
		}
		this.prototype.current = () => {
			return objectArray[index]
		}
		this.prototype.next = () => {
			index++
			return objectArray[index]
		}

		return this
	})
})