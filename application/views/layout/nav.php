<nav>
	<ul id="nav">
		<li class="i_house">
			<a href="/">
				<span>Dashboard</span>
			</a>
		</li>
		<li class="i_create_write">
			<a>
				<span>
					Orders
					<i class="fr">
						<?= $numOrders[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/orders/view/active">
						<span>
							Active
							<i class="fr">
								<?= $numOrders[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/orders/view/completed">
						<span>Completed</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="i_shopping_cart">
			<a href="/products/view">
				<span>
					Products
					<i class="fr">
						<?= $numProducts[0]['quantity']; ?>
					</i>
				</span>
			</a>
		</li>
		<li class="i_user">
			<a href="/customers/view">
				<span>
					Customers
					<i class="fr">
						<?= $numCustomers[0]['quantity']; ?>
					</i>
				</span>
			</a>
		</li>
		<li class="i_cash_register">
			<a>
				<span>
					Invoices
					<i class="fr">
						<?= $numInvoices[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/invoices/view/unpaid">
						<span>
							Unpaid
							<i class="fr">
								<?= $numInvoices[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/invoices/view/paid">
						<span>Paid</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="i_truck">
			<a>
				<span>
					Deliverys
					<i class="fr">
						<?= $numMyDeliveries[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/deliveries/view">
						<span>
							Distribute
							<i class="fr">
								<?= $numFreeDeliveries[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/deliveries/mine">
						<span>
							Mine
							<i class="fr">
								<?= $numMyDeliveries[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="i_user_comment">
			<a>
				<span>
					CRM
					<i class="fr">
						<?= $numCrs[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/crs/view/active">
						<span>
							Active
							<i class="fr">
								<?= $numCrs[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/crs/view/completed">
						<span>Completed</span>
					</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>