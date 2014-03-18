<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Humboldtgymnasium Berlin Tegel - Cafeteriaplaner');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>	
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('bootstrap-responsive');
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery-ui');
		echo $this->Html->script('bootstrap');
		echo $this->Html->script('/CakeBootstrappifier/js/cakebootstrap');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
	<script type='text/javascript'>
		window.onload = function() {
			//var element = document.getElementById("navlist-div");
			//if (element !== null) element.parentNode.removeChild(element);

			//element = document.getElementById("debug-kit-toolbar");
			//if (element !== null) element.parentNode.removeChild(element);

			//element = document.getElementById("paging-div");
			//if (element !== null) element.parentNode.removeChild(element);
			
			//$("html").not('table').remove();

			$(".span9").removeClass();

			//Links entfernen
			$('a').each(function(index){
				$(this).replaceWith($(this).html());
			});
		};
	</script>
	
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">	
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>