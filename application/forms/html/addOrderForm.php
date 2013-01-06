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

				<?= $this->element('delivery', 'yes'); ?>

				<label for="delivery">Yes</label>

				<?= $this->element('delivery', 'no'); ?>

				<label for="delivery">No</label>
			</div>
	</section>
	<section><label for="deliveryDate">Delivery date</label>
		<div>

			<?= $this->element('deliveryDate'); ?>
			<?= $this->element('deliveryTime'); ?>

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