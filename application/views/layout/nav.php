<nav>
	<ul id="nav">
		<li class="i_house">
			<a href="/">
				<span>Översikt</span>
			</a>
		</li>
		<li class="i_create_write">
			<a>
				<span>
					Ordrar
					<i class="fr">
						<?= $numOrders[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/orders/view/active">
						<span>
							Aktiva
							<i class="fr">
								<?= $numOrders[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/orders/view/completed">
						<span>Slutförda</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="i_shopping_cart">
			<a href="/products/view">
				<span>
					Produkter
					<i class="fr">
						<?= $numProducts[0]['quantity']; ?>
					</i>
				</span>
			</a>
		</li>
		<li class="i_user">
			<a href="/customers/view">
				<span>
					Kunder
					<i class="fr">
						<?= $numCustomers[0]['quantity']; ?>
					</i>
				</span>
			</a>
		</li>
		<li class="i_cash_register">
			<a>
				<span>
					Fakturor
					<i class="fr">
						<?= $numInvoices[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/invoices/view/unpaid">
						<span>
							Obetalda
							<i class="fr">
								<?= $numInvoices[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/invoices/view/paid">
						<span>Betalda</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="i_truck">
			<a>
				<span>
					Leveranser
					<i class="fr">
						<?= $numMyDeliveries[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/deliveries/view">
						<span>
							Fördela ut
							<i class="fr">
								<?= $numFreeDeliveries[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/deliveries/mine">
						<span>
							Mina leveranser
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
					Ärendehantering
					<i class="fr">
						<?= $numCrs[0]['quantity']; ?>
					</i>
				</span>
			</a>
			<ul>
				<li>
					<a href="/crs/view/active">
						<span>
							Aktiva ärenden
							<i class="fr">
								<?= $numCrs[0]['quantity']; ?>
							</i>
						</span>
					</a>
				</li>
				<li>
					<a href="/crs/view/completed">
						<span>Slutförda ärenden</span>
					</a>
				</li>
			</ul>
		</li>
	</ul>
</nav>