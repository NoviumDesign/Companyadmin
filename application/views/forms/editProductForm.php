<fieldset>
	<label>Product number</label>
	<section>
		<label for="productNumber">Product number</label>
		<div>

			<?= $this->element('productNumber'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Product name</label>
	<section>
		<label for="productName">Product name</label>
		<div>

			<?= $this->element('productName'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Price</label>
	<section>
		<label for="price">Price</label>
		<div>

			<?= $this->element('price'); ?>

		</div>
	</section>
	<section>
		<label for="price">Vat</label>
		<div>

			<?= $this->element('vat'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Unit</label>
	<section>
		<label for="unit">Unit</label>
		<div>

			<?= $this->element('unit'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Staus</label>
	<section>
		<label for="status">Status</label>
		<div>

			<?= $this->element('status', 'available'); ?>

			<label for="status">Available</label>

			<?= $this->element('status', 'out of stock'); ?>

			<label for="status">Out of stock</label>
		</div>
	</section>
</fieldset>

<fieldset>
	<label>Description</label>
	<section>
		<label for="description">Description</label>
		<div>

			<?= $this->element('description'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Notes</label>
	<section>
		<label for="notes">Notes for the Product team</label>
		<div>

			<?= $this->element('notes'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<section>
		<div>

			<?= $this->element('addProduct'); ?>

		</div>
	</section>
</fieldset>