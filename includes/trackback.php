<?php
	define('TRACKBACK', true);
	require_once "common.php";

	if ($config->enable_trackbacking) {
		$post = new Post($_GET['id']);
		if (empty($_POST['title']) && empty($_POST['url']) && empty($_POST['blog_name'])) {
			redirect($post->url());
			exit;
		}

		if (!Post::info('id', $_GET['id']))
			trackback_respond(true, __("Fake post ID, or nonexistant post."));

		if (!empty($_POST['url'])) {
			header('Content-Type: text/xml; charset=utf-8');

			$url = strip_tags($_POST['url']);
			$title = strip_tags($_POST['title']);
			$excerpt = strip_tags($_POST['excerpt']);
			$blog_name = strip_tags($_POST['blog_name']);

			$excerpt = truncate($excerpt, 255);
			$title = truncate($title, 250);

			$trigger->call("trackback_receive");
			trackback_respond();
		}
	}
