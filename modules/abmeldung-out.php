<?php
// Abmeldung aus Formular holen
$unsubscribe_mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if($unsubscribe_mail == "") {
	// Abmeldung aus URL holen
	$unsubscribe_mail = filter_input(INPUT_GET, 'unsubscribe', FILTER_VALIDATE_EMAIL);
}

if(rex::isBackend()) {
	print '<p><b>Multinewsletter Abmeldung</b></p>';
	print '<p>Texte, Bezeichnungen bzw. Übersetzugen werden im <a href="index.php?page=multinewsletter&subpage=config">Multinewsletter Addon</a> verwaltet.</p>';

}
else {
	$addon = rex_addon::get('multinewsletter');
	
	print '<div class="nl-form">';
	print '<h2>'. $addon->getConfig("lang_". rex_clang::getCurrentId() ."_unsubscribe") .'</h2>';
	print '<br>';
	
	$showform = true;
	if($unsubscribe_mail != "") {
		$user = MultinewsletterUser::initByMail($unsubscribe_mail, rex::getTablePrefix());
		if($user->user_id > 0) {
			$user->unsubscribe($addon->getConfig('unsubscribe_action'));
			
			print "<p>". $addon->getConfig("lang_". rex_clang::getCurrentId() ."_status0") ."</p><br />";
			$showform = false;
		}
		else {
			print "<p>". $addon->getConfig("lang_". rex_clang::getCurrentId() ."_user_not_found") ."</p><br />";
		}
	}

	if($unsubscribe_mail == "" && (filter_input(INPUT_POST, 'email') != "" || filter_input(INPUT_GET, 'unsubscribe'))) {
		print "<p>". $addon->getConfig("lang_". rex_clang::getCurrentId() ."_invalid_email") ."</p><br />";
	}
	
	if($showform) {
?>
		<form id="unsubscribe" class="formation" action="<?php print rex_getURL($this->article_id, rex_clang::getCurrentId()); ?>"
				method="post" name="unsubscribe">
			   <p>
				<label for="email"><?php print $addon->getConfig("lang_". rex_clang::getCurrentId() ."_email"); ?></label>
				<input type="email" class="text" name="email" value="" required>
			   </p>
			   <br />
			   <p>
				<input type="submit" class="submit" name="unsubscribe_newsletter"
					value="<?php print $addon->getConfig("lang_". rex_clang::getCurrentId() ."_unsubscribe"); ?>" />
			</p>
		</form>
<?php
	}
	print '</div>';
}
?>