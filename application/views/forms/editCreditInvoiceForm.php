<fieldset>
	<label>Invoice number</label>
	<section>
		<label for="invoiceNumber">Invoice number</label>
		<div>

			<?= $this->element('invoiceNumber'); ?>

		</div>
	</section>
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
	<label>Dates</label>
	<section>
		<label for="invoiceDue">Invoice date</label>
		<div>

			<?= $this->element('invoiceDate'); ?>

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
					<b><?= ($product['unit'] ? $product['unit'] : $product['momentary_unit']); ?></b>
					á
					<?= ($product['price'] ? $product['price'] : $product['momentary_price']); ?>
					kr/
					<?= ($product['unit'] ? $product['unit'] : $product['momentary_unit']); ?>
				</span>
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