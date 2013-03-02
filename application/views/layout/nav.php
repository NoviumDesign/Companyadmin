<nav>
	<ul id="nav">
		<li class="i_house"><a href="/"><span>Dashboard</span></a></li>
		<li class="i_create_write"><a href="/orders/view"><span>Orders<i class="fr"><?= $numOrders[0]['quantity']; ?></i></span></a></li>
		<li class="i_shopping_cart"><a href="/products/view"><span>Products<i class="fr"><?= $numProducts[0]['quantity']; ?></i></span></a></li>
		<li class="i_user"><a href="/customers/view"><span>Customers<i class="fr"><?= $numCustomers[0]['quantity']; ?></i></span></a></li>
		<li class="i_cash_register"><a href="/invoices/view"><span>Invoices<i class="fr"><?= $numInvoices[0]['quantity']; ?></i></span></a></li>
		<li class="i_truck"><a href="/deliveries/view"><span>Deliverys<i class="fr"><?= $numDeliveries[0]['quantity']; ?></i></span></a></li>


		<!--
		<li class="i_folder_love"><a href="/?nav=crm"><span>CRM</span></a></li>
		<li class="i_question"><a href="/?nav=quote"><span>Quotes</span></a></li>
		<li class="i_calendar_day"><a href="/?nav=calendar"><span>Calendar</span></a></li>
		<li class="i_graph"><a href="/?nav=monitor"><span>Monitoring</span></a></li>
		 -->
	</ul>
</nav>