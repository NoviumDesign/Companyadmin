<?= $this->element('orderId'); ?>

<fieldset>
	<label>Invoice status</label>
	<section>
		<label for="status">status</label>
		<div>

			<?= $this->element('status', 'unpaid'); ?>

			<label for="status">Unpaid</label>

			<?= $this->element('status', 'paid'); ?>

			<label for="status">Paid</label>
		</div>
	</section>
</fieldset>

<fieldset>
	<label>Customer</label>
	<section>
		<label for="customer">Customer<br><span>Enter customer ID</span></label>
		<div>

			<?= $this->element('customerId'); ?>

			<?= $this->element('customer'); ?>

		</div>
	</section>
</fieldset>


<fieldset>
	<label>Products</label>

	<?php foreach($this->products as $product) { ?>

		<section>
			<label><?= $product['product']; ?></label>
			<div>

				<?= $this->element('item[' . $product['product_id'] . ']'); ?>

				<span>
					<b><?= $product['unit']; ?></b>
					á
					<?= $product['price']; ?>
					kr/
					<?= $product['unit']; ?>
				</span>
				<?= $this->element('price[' . $product['product_id'] . ']'); ?>
			</div>
		</section>

	<?php } ?>

</fieldset>

<fieldset>
	<label>Discount</label>
	<section>
		<label for="discount">discount</label>
		<div>

			<?= $this->element('discount'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Notes</label>
	<section>
		<label for="invoice_notes">Notes to print on the invoice</label>
		<div>

			<?= $this->element('notes'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Create new invoice</label>
	<section>
		<div>

			<?= $this->element('addInvoice'); ?>

		</div>
	</section>
</fieldset>