<fieldset>
	<label>User</label>
	<section>
		<label for="invoiceNumber">Name</label>
		<div>

			<?= $this->element('name'); ?>

		</div>
	</section>
	<section>
		<label for="invoiceNumber">Mail</label>
		<div>

			<?= $this->element('mail'); ?>

		</div>
	</section>

	<?php if($this->isAdmin) { ?>

	<section>
		<label for="status">Role</label>
		<div>

			<?= $this->element('role', 'user'); ?>

			<label for="role">User</label>

			<?= $this->element('role', 'admin'); ?>

			<label for="role">Admin</label>

			<?php
			if($this->role == 'master' || $this->role == 'god') {
				$this->element('role', 'master');
			?>

			<label for="role">Master</label>

			<?php } ?>

		</div>
	</section>

	<?php } ?>

</fieldset>

<fieldset>
	<label>Change password</label>
	<section>
		<label for="invoiceNumber">New password<br><span>Left empty will not change password</span></label>
		<div>

			<?= $this->element('password'); ?>

		</div>
	</section>
</fieldset>

<?php if($this->isAdmin) { ?>

<fieldset>
	<label>User access</label>
	
	<?php foreach($this->businesses as $business) { ?>

		<section>
			<label><?= $business['business']; ?></label>
			<div>

				<?= $this->element('access[' . $business['business_id'] . ']', 'permitted'); ?>

				<label for="role">Permitted</label>

			</div>
		</section>

	<?php } ?>

</fieldset>

<?php } ?>

<fieldset>
	<label>Add new user</label>
	<section>
		<div>

			<?= $this->element('editUser'); ?>

		</div>
	</section>
</fieldset>