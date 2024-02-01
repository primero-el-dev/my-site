<?php

require 'vendor/autoload.php';

function dump($data) {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

function dd($data) {
	dump($data);
	die;
}

try {
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->load();
} catch (\Exception $e) {}

$mailer = new Mailjet\Client($_ENV['MAILJET_APIKEY'], $_ENV['MAILJET_APISECRET'], true, ['version' => 'v3.1']);

if ($_POST) {
	$data = [
		'name' => $_POST['name'],
		'email' => $_POST['email'],
		'subject' => $_POST['subject'],
		'message' => $_POST['message'],
	];

	$body = [
	    'Messages' => [
	        [
	            'From' => [
	                'Email' => $_ENV['APP_MAIL_FROM'],
	                'Name' => 'My portfolio',
	            ],
	            'To' => [
	                [
	                    'Email' => $_ENV['APP_MAIL_TO'],
	                    'Name' => 'Przemysław Krogulski',
	                ]
	            ],
	            'Subject' => $data['subject'],
	            'TextPart' => sprintf('Mail from %s <%s> :<br>%s', $data['name'], $data['email'], $data['message']),
	        ],
	    ],
	];

	$response = $mailer->post(Mailjet\Resources::$Email, ['body' => $body]);
	if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest') {
		echo json_encode(['status' => $response->success() ? 'success' : 'failure']);
		exit;
	}
}

?><!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#1000c8">

		<title>Krogulski Przemysław - Full Stack Developer</title>

		<!-- Scripts -->
		<!-- Font awesome -->
		<script src="https://kit.fontawesome.com/f6b4a65528.js" crossorigin="anonymous"></script>

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

		<script src="js/animation.js" defer></script>
		<script src="js/navigation.js" defer></script>
		<script src="js/sendMail.js" defer></script>

		<!-- Links -->
		<link href="favicon.ico" rel="apple-touch-icon">
		<link href="favicon.ico" rel="icon">

		<!-- Custom styles -->
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<!-- Navigation -->
		<nav class="navbar bg-primary text-light" aria-labelledby="navbar__brand">
			<div class="navbar__wrapper">
				<a class="navbar__brand" href="#home">
					Przemysław Krogulski
				</a>

				<input type="checkbox" id="toggler" aria-expanded="false" aria-controls="menuList" aria-label="Toggle navigation"/>
				<label for="toggler" class="navbar__toggler">
					<span class="line"></span>
				</label>

				<ul role="menu" id="menuList" class="navbar__list" type="none">
					<li role="presentation" class="navbar__item">
						<a role="menuitem" class="navbar__link" href="#home">
							Home
						</a>
					</li>

					<li role="presentation" class="navbar__item">
						<a role="menuitem" class="navbar__link" href="#about">
							About me
						</a>
					</li>

					<li role="presentation" class="navbar__item">
						<a role="menuitem" class="navbar__link" href="#projects">
							Projects
						</a>
					</li>

					<li role="presentation" class="navbar__item">
						<a role="menuitem" class="navbar__link" href="#contact">
							Contact
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<!-- Header -->
		<header id="home">
			<div id="hero">
				<div class="card home__card">
					<h1 class="home__card-heading">Przemysław Krogulski</h1>
					<h3 class="home__card-caption">Full Stack Developer</h3>
				</div>
			</div>
		</header>

		<main>
			<!-- About section -->
			<section class="section" id="about">
				<div class="wrapper">
					<h2 class="section__header animation--fade-in">
						About me
					</h2>

					<div class="about__content">
						<div class="about__left">
							<img src="images/me-2.png" class="about__photo animation--fade-in" loading="lazy" alt="Me">

							<article class="about__article animation--fade-in">
								<h3 class="about__article-header">
									Who am I?
								</h3>

								<p class="about__article-paragraph">
									I am selfthaught programmer from about 3 years. From 2 years also selfthaught full stack developer. I've been also interested in web security and design.
								</p>
							</article>

							<article class="about__article animation--fade-in">
								<h3 class="about__article-header">
									What I do?
								</h3>

								<p class="about__article-paragraph">
									I program websites in PHP and Javascript. I have some experience with Laravel, little experience Symfony and Wordpress.
								</p>
							</article>
						</div>

						<div class="about__right">
							<article class="about__article animation--fade-in">
								<h3 class="about__article-header">
									Technology stack
								</h3>

								<ul class="about__skills">
									<?php
									$skills = [
										'PHP' => 90,
										'Symfony' => 80,
										'Laravel' => 60,
										'Javascript' => 70,
										'Typescript' => 70,
										'React' => 70,
										'Vue' => 65,
										'MySQL' => 80,
										'PostgreSQL' => 80,
										'jQuery' => 70,
										'Python' => 60,
										'Kotlin' => 60,
										'Java' => 60,
										'UI (HTML, CSS)' => 80,
									];
									foreach ($skills as $skill => $value):
									?>

									<li class="about__skill animation--fade-in">
										<p class="about__skill-name">
											<?= $skill; ?>
										</p>
										<meter min="0" max="100" value="<?= $value; ?>" class="about__skill-meter"></meter>
									</li>
									
									<?php
									endforeach;
									?>
								</ul>
							</article>
						</div>
					</div>
				</div>
			</section>

			<!-- Projects -->
			<section class="section" id="projects">
				<div class="wrapper">
					<h2 class="section__header animation--fade-in">
						Projects
					</h2>

					<div class="projects__container">
						<?php
						$projects = [
							[						
								'link' => 'https://your-fresh-news-app.onrender.io',
								'image' => 'images/yourfreshnews.png',
								'header' => 'Fresh News',
								'description' => "News site made with Laravel 7, jQuery and SASS.",
							],
							[
								'link' => 'https://primero-el-dev.github.io/edraw',
								'image' => 'images/edraw.png',
								'header' => 'E-draw',
								'description' => "Simple paint-like SPA app with very advanced customization of drawing tools and option of importing/exporting images."
							],
							[
								'link' => 'https://play.google.com/store/apps/details?id=com.primeroeldev.mnemono',
								'image' => 'images/mnemono.png',
								'header' => 'Mnemono',
								'description' => "Android app for memory training made in Kotlin.",
							],
							[
								'link' => 'https://programming-forum.herokuapp.com',
								'image' => 'images/programming-forum.png',
								'header' => 'Programming forum',
								'description' => "Forum made with Symfony 5, jQuery and SASS",
							],
						];

						foreach ($projects as $project):
						?>
						
						<figure class="project animation--fade-in">
							<a class="project__link" target="_blank" href="<?= $project['link']; ?>">
								<img class="project__image" src="<?= $project['image']; ?>"/>
								<figcaption class="project__caption">
									<h3 class="project__header"><?= $project['header']; ?></h3>
									<p class="project__paragraph"><?= $project['description']; ?></p>
								</figcaption>
							</a>
						</figure>

						<?php
						endforeach;
						?>
					</div>
				</div>
			</section>

			<!-- Contact -->
			<section class="section" id="contact">
				<div class="wrapper">
					<h2 class="section__header animation--fade-in">
						Contact
					</h2>

					<form id="contactForm" class="contact__form" method="post">
						<label class="contact__form-control contact__form-control--nam animation--fade-in">
							<input type="text" class="contact__input" name="name" placeholder/>
							<span class="contact__input-placeholder">Name</span>
						</label>

						<label class="contact__form-control contact__form-control--nam animation--fade-in">
							<input type="email" class="contact__input" name="email" placeholder/>
							<span class="contact__input-placeholder">Email</span>
						</label>

						<label class="contact__form-control contact__form-control--nam animation--fade-in">
							<input type="text" class="contact__input" name="subject" placeholder/>
							<span class="contact__input-placeholder">Subject</span>
						</label>

						<label class="contact__form-control contact__form-control--message animation--fade-in">
							<textarea class="contact__textarea" name="message" rows="5" placeholder></textarea>
							<span class="contact__input-placeholder">Message</span>
						</label>

						<button type="submit" class="btn btn-primary contact__form-submit animation--fade-in">
							Send <span class="fas fa-paper-plane"></span>
						</button>
					</form>

					<!-- <div class="contact__card card">
						<div class="contact__method">
							<h4 class="contact__method-header">
								E-mail
							</h4>
							<p class="card__method-paragraph">
								primero.el.dev@gmail.com
							</p>
						</div>

						<div class="contact__method">
							<h4 class="contact__method-header">
								Telephone
							</h4>
							<p class="card__method-paragraph">
								536-343-411
							</p>
						</div>

						<div class="contact__method">
							<h4 class="contact__method-header">
								Telephone
							</h4>
							<p class="card__method-paragraph">
								123-456-789
							</p>
						</div>
					</div> -->
				</div>
			</section>
		</main>

		<!-- Footer -->
		<footer class="footer">
			<div class="wrapper">
				<div class="socials">
					<a class="social social--github" href="https://github.com/Przemar5" target="_blank">
						<span class="fab fa-github"></span>
					</a>
					<a class="social social--linkedin" href="https://www.linkedin.com/in/przemys%C5%82aw-krogulski-1081ba1b2/" target="_blank">
						<span class="fab fa-linkedin-in"></span>
					</a>
				</div>

				<div class="footer__footprint">
					Przemysław Krogulski &copy; <time datetime="<?= date('Y'); ?>"><?= date('Y'); ?></time>
				</div>
			</div>
		</footer>
	</body>
</html>