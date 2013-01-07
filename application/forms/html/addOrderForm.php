<fieldset>
	<label>Customer</label>
	<section>
		<label for="customerId">Customer<br><span>Enter customer name or ID</span></label>
		<div>

			<?= $this->element('customerId'); ?>

		</div>
	</section>
</fieldset>

<fieldset>
	<label>Order content</label>
	<section>
		<label for="orderContent">Crayfish</label>
		<div>

			<?= $this->element('orderContent'); ?>

			<?php /* get unit from db */ ?>

			<span> kg</span>
		</div>
	</section>
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
	<section>
		<label for="custom1">Custom1</label>
		<div>

			<?= $this->element('custom1'); ?>

		</div>
	</section>
	<section>
		<label for="custom2">Custom2</label>
		<div>

			<?= $this->element('custom2'); ?>

		</div>
	</section>
	<section>
		<label for="custom3">Custom3</label>
		<div>

			<?= $this->element('custom3'); ?>

		</div>
	</section>
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