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
	<section>
		<label for="invoiceNumber">Password</label>
		<div>

			<?= $this->element('password'); ?>

		</div>
	</section>
	<section>
		<label for="status">Role</label>
		<div>

			<?= $this->element('role', 'user'); ?>

			<label for="role">User</label>

			<?= $this->element('role', 'admin'); ?>

			<label for="role">Admin</label>

			<?= $this->element('role', 'master'); ?>

			<label for="role">Master</label>
		</div>
	</section>
</fieldset>

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

<fieldset>
	<label>Add new user</label>
	<section>
		<div>

			<?= $this->element('addUser'); ?>

		</div>
	</section>
</fieldset>