<div class="span2">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<li class="nav-header">Aktionen</li>
			<li>
			<?php echo $this->Html->link('Zur Telefonliste',array(
					'controller' => 'contacts',
					'action' => 'index'
				));?>
			</li>
			<?php echo $this->element('staticActions'); ?>
		</ul>
	</div>
</div>
<div class="span9">
	<h2>Email verschicken</h2>
	<p> 
	Hier können sie E-Mails an alle Mitarbeiter der Cafeteria versenden. E-Mail-Adressen, welche nicht einem Mitarbeiter in der Cafeteria zugeordnet werden
	können, werden nicht akzeptiert. Sie können als Empfänder sowohl den <b>Vor- und Nachnamen</b>, als auch eine gültige <b>E-Mail-Adresse</b> angeben.
	Um eine E-Mail an alle Mitarbeiter, oder bestimmte Mitarbeitergruppen zu versenden, wählen sie bitte die Option "Rundmail verschicken" in der Seitenleiste.
	</p>
	<br>
	
</div>