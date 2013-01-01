<section id="content">
	<div class="g12">
	<h1>Gunde Svan</h1>
	<p></p>
		<form id="form" action="submit.php" method="post" autocomplete="off">
			<fieldset>
			<label>General details</label>
			<section>
				<label for="delivery">Private or company?</label>
					<div>
						<input type="radio" id="delivery" name="delivery" value="company"><label for="company">Company</label>
						<input type="radio" id="delivery" name="delivery" value="private" ><label for="private">Private</label>
					</div>
			</section>
				<section><label for="customerid">Customer ID</label>
					<div><strong>#0001</strong>
					</div>
				</section>
				<section><label for="customername">Customer name</label>
					<div><input id="customername" name="customername" type="text" class="autocomplete" value="Gunde Svan">
					</div>
				</section>
			</fieldset>
			<fieldset>
			<label>Contact details</label>
				<section><label for="phone">Phone</label>
					<div><input id="phone" name="phone" type="text" value="08789654">
					</div>
				</section>
				<section><label for="email">Email</label>
					<div><input id="email" name="email" type="email" value="gunde@skidor.se">
					</div>
				</section>
			</fieldset>
			<fieldset>
			<label>Delivery adress</label>
				<section><label for="adress">Postal adress</label>
					<div><input id="adress" name="adress" type="text" value="Fina vägen 18">
					</div>
				</section>
				<section><label for="zipcode">Zip code</label>
					<div><input id="zipcode" name="zipcode" type="text" value="489 46" data-regex="^[0-9 ]+$">
					</div>
				</section>
				<section><label for="city">City</label>
					<div><input id="city" name="city" type="text" value="Stockholm">
					</div>
				</section>
				<section><label for="country">Country</label>
					<div><input id="country" name="country" type="text" value="Sweden">
					</div>
				</section>
			</fieldset>
			<fieldset>
			<label>Invoice adress</label>
				<section><label for="adress">Invoice adress</label>
					<div><input id="adress" name="adress" type="text" value="Fina vägen 18">
					</div>
				</section>
				<section><label for="box">Box</label>
					<div><input id="box" name="box" type="text" value="47" data-regex="^[0-9 ]+$">
					</div>
				</section>
				<section><label for="zipcode">Zip code</label>
					<div><input id="zipcode" name="zipcode" type="text" value="489 46" data-regex="^[0-9 ]+$">
					</div>
				</section>
				<section><label for="city">City</label>
					<div><input id="city" name="city" type="text" value="Stockholm">
					</div>
				</section>
				<section><label for="country">Country</label>
					<div><input id="country" name="country" type="text" value="Sweden">
					</div>
				</section>
			</fieldset>
			<fieldset>
				<label>Notes</label>
				<section><label for="notes">Notes</label>
					<div><textarea id="notes" name="notes" data-autogrow="true">OBS! English speaking customer.</textarea>
					</div>
				</section>
			</fieldset>
			<fieldset>
				<label>Save changes</label>
				<section>
					<div><button name="Cancel" value="Back">Back</button><button class="submit green" name="Save changes" value="submit">Save changes</button></div>
				</section>
			</fieldset>
		</form>	

	</div>	
</section>