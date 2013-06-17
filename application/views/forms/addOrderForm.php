<fieldset>
	<label>Order number</label>
	<section>
		<label for="orderNumber">Order number</label>
		<div>

			<?= $this->element('orderNumber'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Customer</label>
	<section>
		<label for="customerId">Customer</label>
		<div>

			<?= $this->element('customerId'); ?>

			<input type="text" id="customer" class="autocomplete" required="" data-errortext="You can't add a new order without a customer">

		</div>
	</section>
</fieldset>

<fieldset>
	
	<?php foreach($this->products as $product) { ?>

		<section>
			<label><?= $product['product']; ?></label>
			<div>

				<?= $this->element('item[' . $product['product_id'] . ']'); ?>

				<span>
					<b><?= $product['unit']; ?></b>
					á
					<?= round($product['price'], 2); ?>
					kr/
					<?= $product['unit']; ?>
				</span>
			</div>
		</section>

	<?php } ?>

</fieldset>

<fieldset>
	<label>Delivery</label>
	<section>
		<label for="delivery">Shall we deliver this order?</label>
		<div>

			<?= $this->element('delivery', 'none'); ?>

			<label for="delivery">None</label>

			<?= $this->element('delivery', 'requested'); ?>

			<label for="delivery">Requested</label>

			<?= $this->element('delivery', 'approved'); ?>

			<label for="delivery">Approved</label>

			<?= $this->element('delivery', 'completed'); ?>

			<label for="delivery">Completed</label>
		</div>
	</section>
	<section>
		<label for="deliveryDate">Delivery date</label>
		<div>

			<?= $this->element('deliveryDate'); ?>
			<?= $this->element('deliveryTime'); ?>

		</div>
	</section>
	<section>
		<label for="deliveryAdress">Delivery adress</label>
		<div>

			<?= $this->element('deliveryAdress'); ?>

		</div>
	</section>
	<section>
		<label for="customerId">Carrier</label>
		<div>


			<?= $this->element('carrier'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Notes</label>
	<section>
		<label for="orderNotes">Notes for the order team</label>
		<div>

			<?= $this->element('orderNotes'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Custom fields</label>

	<?php
        $customFields = $this->customFields;
		if($customFields['custom_field_1']) {
	?>

	<section>
		<label for="custom1"><?= $customFields['custom_field_1']; ?></label>
		<div>

			<?= $this->element('custom1'); ?>

		</div>
	</section>

	<?php } if($customFields['custom_field_2']) { ?>

	<section>
		<label for="custom2"><?= $customFields['custom_field_2']; ?></label>
		<div>

			<?= $this->element('custom2'); ?>

		</div>
	</section>

	<?php } if($customFields['custom_field_3']) { ?>

	<section>
		<label for="custom3"><?= $customFields['custom_field_3']; ?></label>
		<div>

			<?= $this->element('custom3'); ?>

		</div>
	</section>

	<?php } ?>

</fieldset>

<fieldset>
	<label>Add new order</label>
	<section>
		<label for="delivery">Status on order?</label>
		<div>
			
			<?= $this->element('deliveryStatus', 'new'); ?>

			<label for="deliverystatus">New</label>
			
			<?= $this->element('deliveryStatus', 'active'); ?>

			<label for="deliverystatus">Active</label>

			<?= $this->element('deliveryStatus', 'completed'); ?>

			<label for="deldiverystatus">Completed</label>
		</div>
	</section>
	<section>
		<div>

			<?= $this->element('addOrder'); ?>

		</div>
	</section>
</fieldset>