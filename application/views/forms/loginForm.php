<fieldset>
	<section>
		<label for="mail">Epostadress</label>
		<div>
			<?= $this->element('mail'); ?>
			<?= $this->elementError('mail'); ?>
		</div>
	</section>
	<section>
		<label for="password">Lösenord <a href="/authentication/reset">Glömt lösenordet</a></label>
		<div>
			<?= $this->element('password'); ?>
			<?= $this->elementError('password'); ?>
		</div>
	</section>
	<section>
		<div>
			<?= $this->element('login'); ?>
		</div>
	</section>
</fieldset>