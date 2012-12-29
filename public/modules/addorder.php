<section id="content">
	<div class="g12">
	<h1>Add a new order</h1>
	<p>A new order requires a existing customer in the system.</p>
		<form id="form" action="submit.php" method="post" autocomplete="off">
			<fieldset>
			<label>Customer</label>
				<section><label for="customerid">Customer<br><span>Enter customer name or ID</span></label>
					<div><input id="customerid" name="customerid" type="text" class="autocomplete" data-source="[abc,def,ghi,jkl,mno,pqr,stu,vwx,yz]" required data-errortext="You can't add a new order without a customer">
					</div>
				</section>
			</fieldset>
			<fieldset>
			<label>Order content</label>
				<section><label for="ordercontent">Crayfish</label>
					<div><input id="ordercontent" name="ordercontent" type="number" class="decimal" data-min="0"><span> kg</span>
					</div>
				</section>
			</fieldset>
			<fieldset>
			<label>Delivery</label>
			<section>
				<label for="delivery">Shall we deliver this order?</label>
					<div>
						<input type="radio" id="delivery" name="delivery" value="yes" required><label for="delivery">Yes</label>
						<input type="radio" id="delivery" name="delivery" value="no"><label for="delivery">No</label>
					</div>
			</section>
				<section><label for="delivery_date">Delivery date</label>
					<div><input id="delivery_date" name="delivery_date" type="text" class="date" data-value="+7"><input type="text" class="time" data-connect="datetime" data-value="now">
					</div>
				</section>
			</fieldset>
			<fieldset>
				<label>Notes</label>
				<section><label for="order_notes">Notes for the order team</label>
					<div><textarea id="order_notes" name="order_notes" data-autogrow="true"></textarea>
					</div>
				</section>
			</fieldset>
			<fieldset>
				<label>Add new order</label>
			<section>
				<label for="delivery">Status on order?</label>
					<div>
						<input type="radio" id="deliverystatus" name="deliverystatus" value="Active" required><label for="deliverystatus">Active</label>
						<input type="radio" id="deliverystatus" name="deliverystatus" value="Completed"><label for="deliverystatus">Completed</label>
					</div>
			</section>
				<section>
					<div><button class="submit" name="Add order" value="submit">Add order</button></div>
				</section>
			</fieldset>
		</form>	

	</div>	
</section>