<script type="text/javascript">
	$(document).ready(function() {
		//Gleiche die Breite der Textarea mit der des Empfängerfeldes an
		var width = $("#MailMailTo").width();
		$("#MailContent").width(width);
		$("#MailContent").height(120);

		//Versehe den Button "Felder leeren" mit einer Funktion
		$("#clear-fields").click(function() {
			$("#MailMailTo").val("");
			$("#MailContent").val("");
		});	
		
	});
</script>

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
	<p>
	Wenn sie E-Mails an mehrere Mitarbeiter versenden wollen, so trennen sie bitte deren Namen bzw. Mail-Adressen mit einem <b>Semikolon(;)</b>
	</p>
	<br>
	<?php echo "<legend>E-Mail versenden</legend>"; ?>
	<?php echo $this->Form->create('Mail',array(
			'type' => 'post',
			'url' => array('controller' => 'contacts', 'action' => 'mail'),
			'inputDefaults' => array(
					'div' => 'control-group',
					'label' => array(
							'class' => 'control-label'
					 ),
			'class' => 'well form-horizontal')
			)); ?>
		<?php echo $this->Form->input('mailTo',array(
				'placeholder' => 'Empfänger',
				'div' => 'control-group',
				'class' => 'input-xxlarge',
				'label' => array(
						'text' => 'An:',
					),
				'value' => $receiver,
				'beforeInput' => '<div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span>',
				'afterInput' => '</div>'
				));?>
		<?php echo $this->Form->textarea('content',array(
				'placeholder' => 'Bitte geben sie den zu versendenden Text ein',
				'label' => array ( 'text' => 'Inhalt:')				
				));?>
		<div class="form-actions">
			<?php echo $this->Form->submit('E-Mail versenden',array(
						'div' => false,
						'class' => 'btn btn-primary'
					));?>
			<button type="button" class="btn" id="clear-fields">Felder leeren</button>
		</div>
	<?php echo $this->Form->end();?>
</div>