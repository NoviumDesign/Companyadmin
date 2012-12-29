<?php include('head.php') ?>
<?php include('user-config.php') ?>
<?php include('headernav.php') ?>
<?php include('nav.php') ?>
	<?php
		switch ($_GET["nav"])
		{
			case "dashboard":
				include("modules/dashboard.php");
				break;
			case "order":
				include("modules/order.php");
				break;
				case "addorder":
					include("modules/addorder.php");
					break;
			case "customer":
				include("modules/customer.php");
				break;
			case "delivery":
				include("modules/delivery.php");
				break;
			case "crm":
				include("modules/crm.php");
				break;
			case "invoice":
				include("modules/invoice.php");
				break;
			case "quote":
				include("modules/quote.php");
				break;
			case "calendar":
				include("modules/calendar.php");
				break;
			case "monitor":
				include("modules/monitor.php");
				break;
			default:
				include("modules/dashboard.php");
		}
	?>
<?php include('footer.php') ?>