<?php echo $this->Html->script('planScript.js'); ?>

<?php
$actions = array();
if (AuthComponent::user('id') && AuthComponent::user('admin')) {
$actions['print'] = array('text' => 'Druckversion anzeigen', 'params' => array('controller' => 'plan','action' => 'printversion', $displayingYear, $displayingMonth));
$actions['admin'] = array('text' => 'Adminmodus', 'htmlattributes' => array('id' => 'adminLinkAnchor'));
}

// 				'legend' => array('text' => 'Hilfe anzeigen', 'params' => array('id' => 'help', 'onClick' => 'showHelp();')),
// $actions['classic'] = array('text' => 'Klassisches Design', 'params' => array('controller' => 'plan', 'action' => 'old', $displayingYear, $displayingMonth));
$actions['prev'] = array('text' => 'Vorheriger Monat', 'params' => array('controller' => 'plan', 'action' => 'index', $prevYear, $prevMonth));
$actions['next'] = array('text' => 'Nächster Monat', 'params' => array('controller' => 'plan', 'action' => 'index', $nextYear, $nextMonth));

 echo $this->element('actions',array(
			'actions' => $actions				
		));
?>
<h2>Cafeteriaplan <?php echo $headingDate; ?></h2>
<br />	
<table class="table table-condensed table-bordered table-centered" id="planTable">
<tr>
	<th rowspan="2">Tag</th>
	<th rowspan="2">Datum</th>
	<!-- Header -->
	<?php foreach ($columns as $column):?>
		<?php if ($column['Column']['type'] == 1):?>
			<th rowspan="2" <?php  echo "obligated='".(($column['Column']['obligated']) ? "true" : "false")."' admin='".(($column['Column']['req_admin']) ? "true" : "false")."'";?>><?php echo $column['Column']['name']; ?></th>
		<?php endif;?>
	<?php endforeach;?>
	<th colspan="<?php echo $userColumnCount; ?>">Frühschicht</th>
	<th colspan="<?php echo $userColumnCount; ?>">Spätschicht</th>
</tr>
<tr>	
<?php for($i = 0;$i < 2;$i++) { ?>
		<?php foreach ($columns as $column):?>
		<?php if ($column['Column']['type'] == 2):?>
			<th <?php echo "obligated='".(($column['Column']['obligated']) ? "true" : "false")."' admin='".(($column['Column']['req_admin']) ? "true" : "false")."'";?>><?php echo $column['Column']['name']; ?></th>
		<?php endif;?>		
		<?php endforeach;?>
<?php } ?>	
</tr>	
	<!-- Data -->
	<?php 
	$success = "class='tdsuccess'";
	$successlink = "class='tdsuccesslink'";
	$error = "class='tderror'";
	$errorlink = "class='tderrorlink'";
	$nonobligated = "class='tdnonobligated'";
	$nonobligatedlink = "class='tdnonobligatedlink'";
	
	foreach ($results as $key => $result): 
		//Initialisiere die Variable, welche das Aussehen der Tabellenzeile regelt:
		$class = "";

		if (array_key_exists("specialdate",$result)) {
			//Lege fest, ob das Datum ein Specialdate ist und speichere das Ergebnis in $type
			if ($result['weekend']) { $type = "active"; } else { $type = "inactive";  $class=$success;}
		} else {
			if ($result['weekend']) { $type="inactive"; } else { $type = "active"; }
		}

			echo "<tr id='".$key."' class='".$type."Day'>";
		
		$dateIsInFuture = strtotime($key)+DAY >= time();
		//Komplette, aktive Tage grün, die nicht kompletten, aktiven Rot 
		if ($result['complete'] && $type=="active") {
			$class = $success;
			$onclick = "";
		} else if(!$result['complete'] && $type=="active" && !$dateIsInFuture) {
			$class = $error;
			$onclick = "";
	 	} else if (!$result['complete'] && $type=="active" && $dateIsInFuture) {
			$class = $errorlink;
			$onclick = "onClick=\"window.open(document.URL.split('plan')[0]+'contacts/only/$key',  'toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=800,height=550,left=10,top=10')\"";
		} else {
			//Alles andere
			$onclick = "";
		}
?>

			<td id="<?php echo "dow_".date("Y-m-d",strtotime($key)); ?>"
			<?php echo $class." "; echo $onclick; ?>>
			<?php echo $result['dow']; ?>
			</td>
			<td><?php echo date("d.m.Y",strtotime($key)); ?> </td> 	
<?php 
		//Spalten nacheinander ausgeben
		for ($i = 1;$i <= 2;$i++) {
		foreach ($columns as $column) {
			$userIsAuthorized = AuthComponent::user('id') && (AuthComponent::user('admin') == true || (!AuthComponent::user('admin') && !$column['Column']['req_admin']));
			$classString = "";
			
			//Ist die Spalte eine Textspalte?
			if ($column['Column']['type'] == 1 && $i == 1) {
				//Wenn ja, dann gebe "einfach" die Bemerkung aus
				if (isset($result[$column['Column']['id']])) {
					if ($column['Column']['obligated']) $classString = $success;
					echo "<td id='txt_".$key."' $classString>".$result[$column['Column']['id']]."</td>";
				} else {
					if ($column['Column']['obligated'] && $type == "active") $classString = $error;
					echo "<td id='txt_".$key."' $classString></td>";
				}								
			} else if ($column['Column']['type'] == 1 && $i == 2) {
				//Nichts tun, da Textspalten keine Unterteilung in zwei Schichten haben
			} else if ($column['Column']['type'] == 2) {
				//Ist die Spalte keine Textspalte, dann füge die Dienste entsprechend ein.
				
				if ($type == "inactive") {
					if (!$result['weekend']) {
						if ($column['Column']['obligated']) {
							$classString = $success;
							echo "<td $classString>#</td>";
						} else {
							echo "<td></td>";
						}
					} else {
						echo "<td></td>";
					}
				} else 	if (isset($result[$column['Column']['id']][$i])) {
					//Halbschicht ist belegt
						if ($column['Column']['obligated']) $classString = ($dateIsInFuture && $userIsAuthorized && $result[$column['Column']['id']][$i]['userid'] == AuthComponent::user('id')) ? $successlink : $success;
						else $classString = ($dateIsInFuture && $userIsAuthorized && $result[$column['Column']['id']][$i]['userid'] == AuthComponent::user('id')) ? $nonobligatedlink : $nonobligated;
						echo "<td id='".$key."_".$column['Column']['id']."_".$i."' $classString>".$result[$column['Column']['id']][$i]['username']."</td>"; 
				} else {
					//Noch gar kein Dienst wurde belegt
					
					//Oder es hat sich einfach noch niemand Eingetragen
					if ($column['Column']['obligated']) $classString = ($dateIsInFuture && $userIsAuthorized) ? $errorlink : $error;
					else $classString = ($dateIsInFuture && $userIsAuthorized) ? $nonobligatedlink : $nonobligated;
					echo "<td id='".$key."_".$column['Column']['id']."_".$i."' $classString></td>";
				}
			}

		}
		}
?>
		</tr>
	<?php endforeach; ?>
</table>
 
<!-- Modal -->
<div id="modalMenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalMenuLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="modalMenuLabel"></h3>
  </div>
  <div class="modal-body">
  	<p id="eintragenText">Sie sind im Begriff folgendes auszuführen:<br/>
  		Operation: <i id="methodAnchor"></i> <br />
  		Datum: <i id="dateAnchor"></i> <br />
  		Schicht: <i id="shiftAnchor"></i><br />
  	</p>
    <div class="btn-group" id="halfshift-btngroup" data-toggle="buttons-radio" value="">
    	<button type="button" value="3" class="btn btn-primary" id="btn-full">Ganze Schicht</button>
    	<button type="button" value="1" class="btn btn-primary" id="btn-first">1. Halbschicht</button>
    	<button type="button" value="2" class="btn btn-primary" id="btn-second">2. Halbschicht</button>
    </div>
    <input type="hidden" id="cellID" value="" />
    <input type="hidden" id="method" value="" />
    <input type="hidden" id="usernameHidden" value="<?php echo AuthComponent::user('username');?>"/>
    <input type="hidden" id="isAdmin" value="<?php echo AuthComponent::user('admin');?>" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Zurück</button>
    <button class="btn btn-primary" id="btnDialogConfirm" data-loading-text="Bitte warten ...">Speichern</button>
  </div>
</div>
</div>
