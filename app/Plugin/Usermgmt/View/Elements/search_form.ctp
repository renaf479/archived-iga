<div class="searchForm">
<?php
$isAjax=true;
if(isset($options['useAjax']) && !$options['useAjax']) {
	$isAjax=false;
}
$clear=true;
if(isset($options['clear']) && !$options['clear']) {
	$clear=false;
}
$targetAction=$this->request->action;
if(!empty($this->request->params['pass'])) {
	foreach($this->request->params['pass'] as $pass) {
		$targetAction .='/'.$pass;
	}
}
$page_limit='';
if(!empty($this->request->params['paging'])) {
	$page_limit = $this->request->params['paging'][$modelName]['limit'];
}
if($isAjax) {
	$data = $this->Js->get('#'.$modelName.'Usermgmt')->serializeForm(array('isForm' => true, 'inline' => true));
	$this->Js->get('#'.$modelName.'Usermgmt')->event(
		  'submit',
		  $this->Js->request(
			array('action' => $targetAction),
			array(
					'update' => '#'.$options['updateDivId'],
					'before' => '$("#'.$options['updateDivId'].'").html(\'<div class="loadning-indicator"></div>\');',
					'data' => $data,
					'async' => true,
					'dataExpression'=>true,
					'method' => 'POST'
				)
			)
		);
}
?>
<?php
	echo $this->Form->create(false, array('url' => '/'.$this->request->url, 'id' => $modelName.'Usermgmt'));
	if (isset($options['legend'])) {
		echo "<div class='searchTitle'>".$options['legend']."</div>";
	}
	echo $this->Form->input('Usermgmt.searchFormId', array('type' => 'hidden', 'value' => $modelName));

	if (isset($viewSearchParams)) {
		$jq = "<script type='text/javascript'>";
		foreach ($viewSearchParams as $field) {
			if(!$field['options']['adminOnly'] || ($field['options']['adminOnly'] && $this->UserAuth->isAdmin())) {
				$search_multiple=false;
				$searchFunc=false;
				$search_tagline='';
				$search_options= $field['options'];
				if($search_options['condition'] =='multiple') {
					$search_multiple=true;
				}
				if(!empty($search_options['tagline'])) {
					$search_tagline=$search_options['tagline'];
				}
				if(!empty($search_options['searchFunc'])) {
					$searchFunc=$search_options['searchFunc'];
				}
				unset($search_options['condition'], $search_options['tagline'], $search_options['searchFunc']);
				$search_level = isset($search_options['label']) ? $search_options['label'] : false;
				$search_level_image = isset($search_options['labelImage']) ? $search_options['labelImage'] : false;
				$search_level_image_title = isset($search_options['labelImageTitle']) ? $search_options['labelImageTitle'] : false;

				$search_options['label'] = false;
				unset($search_options['labelImage'], $search_options['labelImageTitle']);
				$search_options['div'] = false;
				$search_options['autoComplete'] = "off";
				if(!isset($search_options['value']) && $search_options['type']=='text') {
					$search_options['value'] = '';
				}
				echo "<div style='display:inline-block;margin-top:10px;margin-bottom: 5px;'>";
				if($search_level) {
					echo "<div class='tl'>".$this->Form->label(__($search_level))."</div>";
				}
				echo "<div class='tf'>";
				if(!empty($search_tagline)) {
					echo "<span style='font-style:italic;margin-top: 27px;position: absolute;'>".$search_tagline."</span>";
				}
				if($search_level_image) {
					echo $this->Html->image(SITE_URL.$search_level_image, array('title'=>$search_level_image_title));
				}
				echo $this->Form->input($field['name'], $search_options);
				$loadingId = uniqid();
				if($search_options['type']=="text" && (!$search_multiple || $searchFunc)) {
					echo "<span id='".$loadingId."' style='position: absolute;margin-left: -25px;margin-top: 4px;display:none'>".$this->Html->image(SITE_URL.'usermgmt/img/loading-circle.gif')."</span>";
				}
				echo "</div>";
				echo "<div style='clear:both'></div>";
				echo "</div>";
				if($search_options['type']=="text" && (!$search_multiple || $searchFunc)) {
					$parts = array_values(Set::filter(explode('.', $field['name']), true));
					$fieldModel = $modelName;
					$fieldName = $search_options['field'];
					if(isset($parts[1])) {
						$fieldModel = $parts[0];
						$fieldName = $parts[1];
					}
					$fieldId = $fieldModel.Inflector::camelize($fieldName);
					if($searchFunc) {
						$url = SITE_URL;
						if(!empty($searchFunc['plugin'])) {
							$url .=$searchFunc['plugin'].'/';
						}
						$url .=$searchFunc['controller'].'/'.$searchFunc['function'];
					} else {
						$url = SITE_URL."usermgmt/autocomplete/fetch/".$fieldModel."/".$fieldName;
					}
					$jq .=  "$(function() {
								$('#".$fieldId."').typeahead({
									ajax: {
										url: '".$url."',
										timeout: 500,
										triggerLength: 1,
										method: 'get',
										preDispatch: function (query) {
											$('#".$loadingId."').css('display', '');
											return {
												term: query
											}
										},
										preProcess: function (data) {
											$('#".$loadingId."').hide();
											return data;
										}
									}
								});
							});";
				}
			}
		}
		$jq .="$(function() {
					$('#searchButtonId').click(function(){
						$('#searchClearId').val(1);
						$('#searchSubmitId').trigger('click');
					});
					$('#searchPageLimit').change(function() {
						$('#searchSubmitId').trigger('click');
					});
				});";
		$jq .="</script>";
		echo $jq;
	}
	echo "<div class='search_submit'>";
		echo "<div style='display:inline-block;'>".$this->Form->submit(__('Search'), array('div'=>false, 'id' => 'searchSubmitId', 'class'=>'btn btn-primary'))."</div>";
		if($clear) {
			echo "<div style='display:inline-block;'>".$this->Form->hidden("search_clear", array('id' => 'searchClearId', 'value' => 0))."<button type='button' id='searchButtonId' class='btn btn-danger'>Clear</button></div>";
		}
		if(isset($this->request->params['paging'])) {
			echo "<div style='display:inline-block;margin-left:5px'>".$this->Form->input('page_limit', array('label'=>false, 'div'=>false, 'options'=>array(''=>'Limit', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50', '60'=>'60', '70'=>'70', '80'=>'80', '90'=>'90', '100'=>'100'), 'selected'=>$page_limit, 'autocomplete'=>'off', 'id'=>'searchPageLimit', 'class'=>'span1'))."</div>";
		}
	echo "</div>";
	echo "<div style='clear:both'></div>";
	$this->Form->unlockField('search_clear');
	echo $this->Form->end();
	echo $this->Js->writeBuffer();
?>
</div>