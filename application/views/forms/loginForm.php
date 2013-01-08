<fieldset>
	<section>
		<label for="mail">Mail</label>
		<div>
			<?= $this->element('mail'); ?>
			<?= $this->elementError('mail'); ?>
		</div>
	</section>
	<section>
		<label for="password">Password <a href="/authentication/reset">lost password?</a></label>
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