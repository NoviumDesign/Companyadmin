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
		<label for="customerId">Customer<br><span>Enter customer ID</span></label>
		<div>

			<?= $this->element('customerId'); ?>

			<?= $this->element('customer'); ?>

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
	<label>Delivery</label>
	<section>
		<label for="delivery">Shall we deliver this order?</label>
		<div>

			<?= $this->element('delivery', 'approved'); ?>

			<label for="delivery">Approved</label>

			<?= $this->element('delivery', 'requested'); ?>

			<label for="delivery">Requested</label>

			<?= $this->element('delivery', 'none'); ?>

			<label for="delivery">None</label>
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