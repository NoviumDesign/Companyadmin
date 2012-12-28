<nav>
	<ul id="nav">
		<li class="i_house"><a href="/"><span>Dashboard</span></a></li>
		<li class="i_create_write"><a><span>Orders</span></a>
			<ul>
				<li><a href="/orders/all"><span><b>All <i style="float:right"><?= $num['orders'] ?></i></b></span></a></li>

				<?php foreach($businesses as $business) { ?>
					<li><a href="/orders/<?= $business['business_id'] ?>"><span><?= $business['business'] ?> <i style="float:right"><?= $business['orders'] ?></i></span></a></li>	
				<?php } ?>

			</ul>
		</li>
		<li class="i_create_write"><a><span>Products</span></a>
			<ul>
				<li><a href="/products/all"><span><b>All <i style="float:right"><?= $num['products'] ?></i></b></span></a></li>

				<?php foreach($businesses as $business) { ?>
					<li><a href="/products/<?= $business['business_id'] ?>"><span><?= $business['business'] ?> <i style="float:right"><?= $business['products'] ?></i></span></a></li>	
				<?php } ?>

			</ul>
		</li>
		<li class="i_user"><a href="/?nav=customer"><span>Customers</span></a></li>
		<li class="i_truck"><a href="/?nav=delivery"><span>Deliveries</span></a></li>
		<li class="i_folder_love"><a href="/?nav=crm"><span>CRM</span></a></li>
		<li class="i_cash_register"><a href="/?nav=invoice"><span>Invoices</span></a></li>
		<li class="i_question"><a href="/?nav=quote"><span>Quotes</span></a></li>
		<li class="i_calendar_day"><a href="/?nav=calendar"><span>Calendar</span></a></li>
		<li class="i_graph"><a href="/?nav=monitor"><span>Monitoring</span></a></li>
	</ul>
</nav>