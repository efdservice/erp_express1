<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.1/Sortable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.1/Sortable.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

<?php
// print_r($fields);
// die();

if ($this->uri->segment(3) != '') {
    $login_id = $this->userdata['user_id'];
    $login_name = $this->userdata['first_name'] . ' ' . $this->userdata['last_name'];
    $filename = explode('/', $templates['template_file'])[2];

    if ($filename == '') {
        $filename = explode('/', $templates['template_file'])[1];
    }
    $createExt = explode('.', $templates['template_file'])[1];
    $fileuri = final_url(2) . 'media/' . $templates['template_file'];
    $fileuriUser = final_url(2) . 'media/' . $templates['template_file'];
    $key = getCurUserHostAddress() . $fileuri;
    $stat = filemtime('media/' . $templates['template_file']);
    $revision_id = GenerateRevisionId($key . $stat);



    function getCallbackUrl($fileName, $abc)
    {
        return final_url(2) . "webeditor-ajax.php"
        . "?type=track"
        . "&fileName=" . urlencode($fileName)
        . "&yearFolder=" . explode('/', $abc)[1]
        . "&mainFolder=" . explode('/', $abc)[0];
    }
    ?>
<script type="text/javascript" src="<?php echo $GLOBALS["DOC_SERV_API_URL"] ?>"></script>
<script type="text/javascript">

	 var docEditor;
	 var fileName = "<?php echo $filename ?>";

	 var fileType = "<?php echo strtolower(pathinfo($filename, PATHINFO_EXTENSION)) ?>";


	 var innerAlert = function (message) {
		 if (console && console.log)
			 console.log(message);
	 };

	 var onAppReady = function () {
		 innerAlert("Document editor ready");
	 };

	 var onDocumentStateChange = function (event) {
		 var title = document.title.replace(/\*$/g, "");
		 document.title = title + (event.data ? "*" : "");
	 };

	 var onRequestEditRights = function () {
		 location.href = location.href.replace(RegExp("action=view\&?", "i"), "");
	 };

	 var onError = function (event) {
		 if (event)
			 innerAlert(event.data);
	 };

	 var onOutdatedVersion = function (event) {
		 location.reload(true);
	 };

	 var connectEditor = function () {
		 <?php
if (!file_exists('media/' . $templates['template_file'])) {
        echo "alert('File not found'); return;";
    }
    ?>
	     var user = [{id:"<?=$login_id;?>","name":"<?=$login_name?>"}][0];
		 var type = "desktop";
		 if (type == "") {
			 type = new RegExp("<?php echo $GLOBALS['MOBILE_REGEX'] ?>", "i").test(window.navigator.userAgent) ? "mobile" : "desktop";
		 }

		 docEditor = new DocsAPI.DocEditor("iframeEditor",
			 {
				 width: "100%",
				 height: "100%",

				 type: type,
				 documentType: "<?php echo getDocumentType($filename) ?>",
				 document: {
					 title: fileName,
					 url: "<?php echo $fileuri ?>",
					 fileType: fileType,
					 key: "<?php echo $revision_id ?>",

					 info: {
						 author: "Me",
						 created: "<?php echo date('d.m.y') ?>",
					 },

					 permissions: {
						 download: true,
						 edit: true,
						 review: true
					 }
				 },
				 editorConfig: {
					 mode: 'edit',

					 lang: "en",

					 callbackUrl: "<?php echo getCallbackUrl($filename, $templates['template_file']) ?>",

					 user: user,

					 embedded: {
						 saveUrl: "<?php echo $fileuriUser ?>",
						 embedUrl: "<?php echo $fileuriUser ?>",
						 shareUrl: "<?php echo $fileuriUser ?>",
						 toolbarDocked: "top",
					 },

					 customization: {
						autosave : true,
						about: true,
						"feedback": {
							"url": "http://www.cloudclm.com/support",
							"visible": true
						},
						goback: {
							url: "<?php echo final_url(2, 'admin/add_template/' . encryptit($templates['template_id'])) ?>",
						},
						customer: {
							"address": "3275 SOUTH JONES BLVD.SUITE 103LAS VEGAS, NV 89146",
							"info": "CloudCLM, LLC",
							"logo": "http://beta2.cloudclmsoftware.com/contract_beta/assets/img/contract_logo.png",
							"mail": "Service@CloudClm.com",
							"name": "CloudCLM, LLC",
							"www": "http://www.cloudclm.com/support"
						},
						logo: {
							image: "http://beta2.cloudclmsoftware.com/contract_beta/assets/img/contract_logo.png",
							imageEmbedded: "http://beta2.cloudclmsoftware.com/contract_beta/assets/img/contract_logo.png",
							url: "https://www.cloudclmsoftware.com"
						},
					 },
				 },
				 events: {
					 'onAppReady': onAppReady,
					 'onDocumentStateChange': onDocumentStateChange,
					 'onRequestEditRights': onRequestEditRights,
					 'onError': onError,
					 'onOutdatedVersion': onOutdatedVersion,
				 }
			 });
	 };

	 if (window.addEventListener) {
		 window.addEventListener("load", connectEditor);
	 } else if (window.attachEvent) {
		 window.attachEvent("load", connectEditor);
	 }
</script>
<?php }?>

<style>
	#form1{
		height : 650px;
		width : 100%;
	}
	.cursor{
		cursor: pointer;
	}
	.select-custom{
		background: transparent;
		padding: 5px;
		width: 150px;
		border-radius: 4px;
	}
	.btn.btn-default {
		width: 100%;
		font-size: x-small;
	}
</style>
<link href="<?=final_url(2, 'assets/plugins/bootstrap-select/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">Customize Template
		<a type="button"  href="<?=final_url(1, 'admin/templates');?>" style="width:12%;" class="btn btn-default pull-right"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Finish</a>
		<a type="button" onclick="create_copy()"  style="width:12%;margin-right:1%;" class="btn btn-default pull-right" ><i class="fa fa-copy"></i>&nbsp;&nbsp;Make Copy</a>
	</h1>

    <div class="section-container section-with-top-border p-b-5">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
				<?php if (0) {?>
				<div class="panel p-20">
                    <h4 class="form-header"><span class="icon text-inverse"><i class="fa fa-file"></i></span>E-Signature</h4>
                    <hr>
                    <form class="form-input-flat" method="post" data-parsley-validate="true" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Signature on page no.</label>
                                        <input type="text" class="form-control" name="page_number" value="<?=(@$esign['page_number']) ? $esign['page_number'] : 1;?>">
                                    </div>
                                </div>
								<?php	if (0) {?>
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label>Signature Place for customer</label><br>
                                        <input type="radio" value="30_30" <?=(@$esign['customer_x'] . '_' . @$esign['customer_y'] == '30_30') ? 'CHECKED' : 'CHECKED';?> name="customer_signature_axis">&emsp;Bottom Left<br>
                                        <input type="radio" value="280_30" <?=(@$esign['customer_x'] . '_' . @$esign['customer_y'] == '280_30') ? 'CHECKED' : '';?> name="customer_signature_axis">&emsp;Bottom Center<br>
                                        <input type="radio" value="400_30" <?=(@$esign['customer_x'] . '_' . @$esign['customer_y'] == '400_30') ? 'CHECKED' : '';?> name="customer_signature_axis">&emsp;Bottom Right<br>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Signature Place for employee</label><br>
                                        <input type="radio" value="30_30" <?=(@$esign['employee_x'] . '_' . @$esign['employee_y'] == '30_30') ? 'CHECKED' : 'CHECKED';?> name="employee_signature_axis">&emsp;Bottom Left<br>
                                        <input type="radio" value="280_30" <?=(@$esign['employee_x'] . '_' . @$esign['employee_y'] == '280_30') ? 'CHECKED' : '';?> name="employee_signature_axis">&emsp;Bottom Center<br>
                                        <input type="radio" value="400_30" <?=(@$esign['employee_x'] . '_' . @$esign['employee_y'] == '400_30') ? 'CHECKED' : '';?> name="employee_signature_axis">&emsp;Bottom Right<br>
                                    </div>
                                </div>
								<?php } else {?>
									<div class="col-md-4">
										<div class="form-group">
											<label>Signature Place for customer</label>
											<div class="col-md-6 text-center">
												X - Axis <input type="text" class="form-control" placeholder="X-Axis" name="customer_signature_axis_x" value="<?=(@$esign['customer_x']);?>">
											</div>
											<div class="col-md-6 text-center">
												Y - Axis <input type="text" class="form-control" placeholder="Y-Axis" name="customer_signature_axis_y" value="<?=(@$esign['customer_y']);?>">
											</div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label>Signature Place for employee</label>
											<div class="col-md-6 text-center">
												X - Axis <input type="text" class="form-control" placeholder="X-Axis" name="employee_signature_axis_x" value="<?=(@$esign['employee_x']);?>">
											</div>
											<div class="col-md-6 text-center">
												Y - Axis <input type="text" class="form-control" placeholder="Y-Axis" name="employee_signature_axis_y" value="<?=(@$esign['employee_y']);?>">
											</div>
										</div>
									</div>
								<?php }?>
                            </div>
                            <p><br>&emsp;</p>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default btn-sm" onclick="set_esignature_fields(<?=@$templates['template_id'];?>)">Save</button>
										&emsp;
                                        <button type="button" class="btn btn-default btn-sm" onclick="esign_preview(<?=@$templates['template_id'];?>);">Preview</button>
										&emsp;
										<button type="button" class="btn btn-default btn-sm" onclick="esign_help();">Help</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
				<?php }?>

                <div class="panel p-20">
                    <h4 class="form-header">
						<span class="icon text-inverse"><i class="fa fa-file"></i></span>Customize Template
						<!-- <button type="button">Rearrange Fields</button> -->
						<span onclick="rearrangeFields()" class="btn btn-default pull-right" style="float: right;width: 19%;">Rearrange Fields</span>
						<!-- <span onclick="addSection()">Add Section</span> -->
						<!--<select type="text" class="pull-right select-custom" name="contact_type" autocomplete="off" onchange="change_customer_fields(this.value)">
							<option value="Customer">Customer</option>
							<option value="Vendor">Vendor</option>
							<option value="M&A">M&A</option>
							<option value="Employee">Employee</option>
						</select> -->
					</h4>
                    <hr>
                    <form class="form-input-flat" method="post" data-parsley-validate="true" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
								<?php 

if (isset($templates['contact_type']) && $templates['contact_type'] == 'Auto') {
								?>
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Buyer Info
									  	</button>
									  	
									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($buyer_info); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $buyer_info[$i]['label_name']) . '#'?>',<?=$buyer_info[$i]['id'];?>)"><?=$buyer_info[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Income
									  	</button>

									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($income); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $income[$i]['label_name']) . '#'?>',<?=$income[$i]['id'];?>)"><?=$income[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
                                <div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Credit
									  	</button>
									  
									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($credit); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $credit[$i]['label_name']) . '#'?>',<?=$credit[$i]['id'];?>)"><?=$credit[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
                                 <div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Vehicle
									  	</button>
									  	
									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($vehicle); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $vehicle[$i]['label_name']) . '#'?>',<?=$vehicle[$i]['id'];?>)"><?=$vehicle[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
                                <div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Trade In
									  	</button>
									  	
									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($tradeIn); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $tradeIn[$i]['label_name']) . '#'?>',<?=$tradeIn[$i]['id'];?>)"><?=$tradeIn[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
                                <div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Loan
									  	</button>
									  
									  	<div class="dropdown-menu p-10"  aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($loan); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?='#' . str_replace(" ", "_", $loan[$i]['label_name']) . '#'?>',<?=$loan[$i]['id'];?>)"><?=$loan[$i]['label_name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>
                                
								<?php 
}
if (isset($templates['contact_type']) && $templates['contact_type'] != 'Auto') {
								?>
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Insert <?=$templates['contact_type'];?> Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="customer_btn_fields" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($coustomer); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$coustomer[$i]['constant'];?>',<?=$coustomer[$i]['custom_field_id'];?>)"><?=$coustomer[$i]['name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>

								<!--04Jun21-->
								<?php if (isset($templates['contact_type']) && $templates['contact_type'] == 'Entity') {?>
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Shareholder 1 Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="shareholder1fs" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php if (isset($share1) && count($share1) > 0) {foreach ($share1 as $row) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$row['constant'];?>',<?=$row['custom_field_id'];?>)"><?=$row['name'];?></li><br>
									    	<?php }}?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Shareholder 2 Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="shareholder2fs" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php if (isset($share2) && count($share2) > 0) {foreach ($share2 as $row) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$row['constant'];?>',<?=$row['custom_field_id'];?>)"><?=$row['name'];?></li><br>
									    	<?php }}?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Shareholder 3 Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="shareholder3fs" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php if (isset($share3) && count($share3) > 0) {foreach ($share3 as $row) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$row['constant'];?>',<?=$row['custom_field_id'];?>)"><?=$row['name'];?></li><br>
									    	<?php }}?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Shareholder 4 Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="shareholder4fs" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php if (isset($share4) && count($share4) > 0) {foreach ($share4 as $row) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$row['constant'];?>',<?=$row['custom_field_id'];?>)"><?=$row['name'];?></li><br>
									    	<?php }}?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Shareholder 5 Fields
									  	</button>
									  	<div class="dropdown-menu p-10" id="shareholder5fs" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php if (isset($share5) && count($share5) > 0) {foreach ($share5 as $row) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$row['constant'];?>',<?=$row['custom_field_id'];?>)"><?=$row['name'];?></li><br>
									    	<?php }}?>
									  	</div>
									</div>
                                </div>
								<?php } else {?>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  <?=$templates['contact_type'];?>  Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|1 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|1|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|1|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|1|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|1|r:0]] ')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|1|n:Insert Text                  ]]')">Text Field  </li><br>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Insert Company Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($company); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$company[$i]['constant'];?>',<?=$company[$i]['custom_field_id'];?>)"><?=$company[$i]['name'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Company Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|0 ]]')">Signature</li><br>

											<li class="dropdown-item cursor" onclick="just_copy('[[t|0|n:Name                    ]]')">Name</li><br>

											<li class="dropdown-item cursor" onclick="just_copy('[[t|0|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|0|p:0             ]]')">Signing Date</li><br>

											<li class="dropdown-item cursor" onclick="just_copy('[[c|0|r:0]]')">Checkbox  </li><br>

											<li class="dropdown-item cursor" onclick="just_copy(' [[t|0|n:Insert Text                  ]]')">Text Field  </li><br>


									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|2 ]]')">Party 3</li><br>
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|3 ]]')">Party 4</li><br>
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|4 ]]')">Party 5</li><br>
									  	</div>
									</div>
                                </div>
								<?php }?>

                                <div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Insert Custom Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 450px;overflow: auto;">
										  <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction(this)" style="width: 100%;height: 37px;margin-bottom: 6px;">
											  <span id="custom_fields">
										 	 <?php for ($i = 0; $i < count($custom); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$custom[$i]['constant'];?>',<?=$custom[$i]['custom_field_id'];?>)"><?=$custom[$i]['name'];?>
												<?php if ($custom[$i]['field_type'] == 102) {
											    echo "<b>(P)</b>";
											} else if ($custom[$i]['field_type'] == 103) {
											    echo "<input type='checkbox'>";
											} else if ($custom[$i]['field_type'] == 104) {
											    echo "<select></select>";
											} else if ($custom[$i]['field_type'] == 105) {
											    echo "<input type='radio'>";
											} else {
											    echo "<b>(T)</b>";
											}
											    ?>


									    	</li><br>

									    	<?php }?>
											  </span>
									  	</div>
										&emsp;
									</div>
								</div>

                    			<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="coustomer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Insert Paragraph
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									  		<?php for ($i = 0; $i < count($clause); $i++) {?>
									    	<li class="dropdown-item cursor" onclick="copy('<?=$clause[$i]['constant'];?>',<?=$clause[$i]['custom_field_id'];?>)"><?=$clause[$i]['title'];?></li><br>
									    	<?php }?>
									  	</div>
									</div>
                                </div>

								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
									<button type="button" class="btn btn-default" title="Add new custom field" onclick="add_custom_fields()"><i class="fa fa-plus"></i></button>
								</div>
								<?php
									}
								?>
								</div>

                            <div class="col-md-12"><br>
                                <select class="form-control input-lg select2" id="fields_selected" multiple name="fields[]" onchange="delete_template_field(this)">
                                	<?php for ($i = 0; $i < count($fields); $i++) {?>
                                		<option value="<?=$fields[$i]['template_field_id'];?>" SELECTED><?=$fields[$i]['name'];?></option>
                                	<?php }?>
								</select>
                            </div>

							<!--04Jun21-->
							<?php if (isset($templates['contact_type']) && $templates['contact_type'] == 'Entity') {?>
							<div class="col-md-12"><br>
								<!--Entity Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="entitys" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  <?=$templates['contact_type'];?>  Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|0 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|0|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|0|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|0|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|0|r:0]]')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|0|n:Insert Text                  ]]')">Text Field  </li>
									  	</div>
									</div>
                                </div>

								<!--Shareholder1 Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="shareholder1s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Shareholder 1 Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|1 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|1|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|1|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|1|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|1|r:0]] ')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|1|n:Insert Text                  ]]')">Text Field  </li><br>
									  	</div>
									</div>
                                </div>

                                <!--Shareholder2 Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="shareholder2s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Shareholder 2 Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|2 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|2|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|2|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|2|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|2|r:0]]')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|2|n:Insert Text                  ]]')">Text Field  </li>
									  	</div>
									</div>
                                </div>

								<!--Shareholder3 Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="shareholder3s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Shareholder 3 Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|3 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|3|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|3|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|3|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|3|r:0]]')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|3|n:Insert Text                  ]]')">Text Field  </li>
									  	</div>
									</div>
                                </div>

								<!--Shareholder4 Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="shareholder4s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Shareholder 4 Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|4 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|4|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|4|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|4|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|4|r:0]]')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|4|n:Insert Text                  ]]')">Text Field  </li>
									  	</div>
									</div>
                                </div>

								<!--Shareholder5 Signature Fields-->
								<div class="col-md-2" style="padding-left: 0px;margin-top: 10px;">
                                    <div class="dropdown">
									  	<button class="btn btn-default dropdown-toggle" type="button" id="shareholder5s" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										  Shareholder 5 Signature Fields
									  	</button>
									  	<div class="dropdown-menu p-10" aria-labelledby="dropdownMenuButton" style="max-height: 250px;overflow: auto;">
									    	<li class="dropdown-item cursor" onclick="just_copy('[[S|5 ]]')">Signature</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|5|n:Name                    ]]')">Name</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[t|5|n:Title                  ]]')">Title</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[d|5|p:0             ]]')">Signing Date</li><br>
											<li class="dropdown-item cursor" onclick="just_copy('[[c|5|r:0]]')">Checkbox  </li><br>
											<li class="dropdown-item cursor" onclick="just_copy(' [[t|5|n:Insert Text                  ]]')">Text Field  </li>
									  	</div>
									</div>
                                </div>
							</div>
							<?php }?>
                        </div>
                    </form>
                </div>
                <!-- end panel -->

				<?php

if ($this->uri->segment(3) != '') {?>
					<?php if ($templates['can_customer_upload'] != '1') {?>
				<!-- begin panel -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-inverse" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						</div>
						<h4 class="panel-title">Contract</h4>
					</div>

					<div class="panel-body" style="min-height:2100px;">

						<form id="form1" style="position: relative;min-height:2100px;">
							<!-- <div class="overlayclass2" id="expended-hide" style="position: absolute;background: rgb(241, 241, 241);height: 223px;width: 21px;top: 58%;display: block;">
							</div> -->

							<div id="iframeEditor"></div>
							<span style="width: 40px;height: 48%;background: #cfcfcf;position: absolute;left: 0px;top: 37%;"></span>

						</form>
						<!-- <form id="form1">
							<div id="iframeEditor">
							</div>
					   </form> -->
					</div>
				</div>
				<!-- end panel -->
				<?php }?>
				<?php }?>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end section-container -->
	<div id="ajax"></div>

	<!-- Modal -->
	<div  class="modal fade" role="dialog" id="section_id">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add section</h4>
			</div>
			<div class="modal-body">
				<label>Name</label>
				<input type="text" name="name" id="sectionname" style="height: 36px;width: 89%;margin-left: 3%;border-radius: 6px;">
				<!-- <input type="text" name="name" id="sectionname"> -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="addSection">Add</button>
			</div>
			</div>
		</div>
	</div>

	<!-- Modal rearrnager -->
	<div  class="modal fade" role="dialog" id="rearranghe">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Rearrange Fields</h4>
			</div>
			<div class="modal-body" id="rearrange-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"  onclick="changeOrderOfTemp()" id="addSection">Save</button>
			</div>
			</div>
		</div>
	</div>

	<script src="<?=final_url(2, 'assets/plugins/bootstrap-select/bootstrap-select.min.js');?>"></script>
	<script src="<?=final_url(2, 'assets/plugins/summernote/dist/summernote.min.js');?>"></script>
	<script>
	var templates = [];

	function filterFunction(ele){
		var valu = $(ele).val();
		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/filterCustomField')?>',
			type:'post',
			data:{'valu':valu},
			success: function(data){

				$('#custom_fields').html(data);
			}
		})
	}
	function changeOrderOfTemp(){
		$('#myTable tr').each(function() {
			templates.push(this.id);
			//alert('helo');
			//console.log(this.id)
		});
		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/rearrangeTempfield')?>',
			type:'post',
			data:{'templates':templates},
			success: function(data){
				//alert('ajax');
				location.reload();

				//$('#section_id').modal('hide');
			}
		})
		console.log(templates);
	}
	function create_copy(){
		temp_id = '<?=$this->uri->segment(3);?>';
		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/duplicate_template')?>',
			type:'post',
			data:{'template_id':temp_id},
			success: function(data){
				if(data==200){
					location.href = "templates";
				}
				//$('#section_id').modal('hide');
			}
		})
	}
	function rearrangeFields(){
		temp_id = '<?=$this->uri->segment(3);?>';

		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/rearrangeField')?>',
			type:'post',
			data:{'temp_id':temp_id},
			success: function(data){
				$('#rearrange-body').html(data);
				$('#rearranghe').modal('show');

				var fixHelperModified = function(e, tr) {
					var $originals = tr.children();
					var $helper = tr.clone();
					$helper.children().each(function(index) {
						$(this).width($originals.eq(index).width())
					});
					return $helper;
				},
				updateIndex = function(e, ui) {
					$('td.index', ui.item.parent()).each(function (i) {
						$(this).html(i+1);
					});
					$('input[type=text]', ui.item.parent()).each(function (i) {
						$(this).val(i + 1);
					});
				};

				$("#myTable tbody").sortable({
					helper: fixHelperModified,
					stop: updateIndex
				}).disableSelection();

				$("tbody").sortable({
				distance: 5,
				delay: 100,
				opacity: 0.6,
				cursor: 'move',
				update: function() {}
					});

			}
		})
	}

	$('#addSection').on('click',function(){
		$('#addSection').attr('disabled');
		sectionname = $('#sectionname').val();
		//alert(sectionname);
		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/addSection')?>',
			type:'post',
			data:{'sectionname':sectionname},
			success: function(data){
				$('#section_id').modal('hide');
			}
		})
	});

	function addSection(){
		//alert('jhg');
		$('#section_id').modal('show');
	}

	$(document).ready(function() {
	    $('.select2').select2();
	    change_customer_fields('<?=$templates['contact_type'];?>');
	});

	var obj_arr = [];
	$( document ).ready(function() {
		$(".selectpicker").selectpicker("render");

		$("#summernote").summernote({
			height:300,
			airMode: true
		});

		$(".selectpicker").selectpicker("render");

		<?php if ($this->session->flashdata('error_msg')) {?>
			$.gritter.add({title:"<?php echo $this->session->flashdata('error_msg'); ?>",class_name:"gritter-danger",time: 40000});
		<?php }?>
		<?php if ($this->session->flashdata('success_msg')) {?>
			$.gritter.add({title:"<?php echo $this->session->flashdata('success_msg'); ?>",class_name:"gritter-danger",time: 40000});
		<?php }?>

		// confirmation
		$('.deletelogo').on('click', function () {
			_this=$(this);
			id=_this.attr('id');
			name=_this.attr('table_name');
			column=_this.attr('column_name');
			$.confirm({
				title: 'A secure action',
				content: 'Are you sure you want to remove this picture',
				icon: 'fa fa-question-circle',
				animation: 'scale',
				closeAnimation: 'scale',
				opacity: 0.5,
				type: 'red',
				typeAnimated: true,
				buttons: {
					'confirm': {
						text: 'Proceed',
						btnClass: 'btn-red',
						action: function () {
							$.ajax({
								'type' :'post',
								'url':'../../admin/ajax/delete_picture',
								'data':{id:id,table:name,column:column},
								success:function(data){
									data=JSON.parse(data);
									if(data.code){
										$.alert({
											title: 'Success!',
											content: data.message,
										});
										$('.logopreview').fadeOut('xslow');
										$('#logo_pre').removeAttr('disabled',true);
									}else{
										$.alert({
											title: 'Error!',
											content: data.message,
										});
									}
								},error(){
									$.alert({
										title: 'Error!',
										content: data.message,
									});
								}
							});
						}
					},
					cancel: function () {
					}
				}
			});
		});
	});

	// get input file content
	function get_summer_content(file1) {
		<?php if ($this->uri->segment(3) != '') {?>
			var url = '../../admin/ajax/load_summer_content';
		<?php } else {?>
			var url = '../admin/ajax/load_summer_content';
		<?php }?>
		var file = file1.files[0];
		var formData = new FormData();
		formData.append('formData', file);
		$.ajax({
			type: "POST",
			url:url,
			contentType: false,
			processData: false,
			data: formData,
			success: function (data) {
				$('.note-editable').html(data);
				$('#summer_txt').css('display','block');
			}
		});
	}

	function just_copy(val){
		if(val == '[[S|0 ]]'  || val == '[[S|1 ]]'){
			$.dialog({
				title:'Message.',
				content: 'The Signature Party field you have selected has been copied to your clipboard. <br>Find the location you would like to insert your signature and paste (Ctrl+V) into your document. <br>Then change the font to 48 and change the color to white.',
				closeIcon: null,
				backgroundDismiss: true
			});
		}else{
			$.dialog({
				title:'Message.',
				content: 'The Signature Party field you have selected has been copied to your clipboard. <br>Find the location you would like to insert your signature and paste (Ctrl+V) into your document. <br>Then change the color to white.',
				closeIcon: null,
				backgroundDismiss: true,

			});
		}
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val(val).select();
		document.execCommand("copy");
		$temp.remove();
		$.gritter.add({title:"copied to clipboard",class_name:"gritter-danger",time: 1000});

		id = '<?=$this->uri->segment(3);?>';
		$.ajax({
			url:'<?=final_url(2, 'admin/ajax/update_template_signer_fields')?>',
			type:'post',
			data:{'field':val,'id':id},
			success: function(data){

			}
		})
		//$.dialog().close();
	}

	function copy(text,id) {
		temp_id = '<?=$this->uri->segment(3);?>';
		$.ajax({
			url: '<?=final_url(2, 'admin/ajax/add_field_to_template');?>',
			type:'post',
			data:{'field_id':id,'template_id':temp_id},
			success: function(data){
				data = JSON.parse(data);
				if(data.status==200){
					var $temp = $("<input>");
					$("body").append($temp);
					$temp.val(text).select();
					document.execCommand("copy");
					$temp.remove();
					$('#fields_selected').append('<option selected value="'+data.id+'">'+data.name+'</option>');

					$.gritter.add({title:"copied to clipboard",class_name:"gritter-danger",time: 1000});
				}else{
					var $temp = $("<input>");
					$("body").append($temp);
					$temp.val(text).select();
					document.execCommand("copy");
					$temp.remove();
					$.gritter.add({title:"copied to clipboard",class_name:"gritter-danger",time: 1000});
				}
			}
		})
	}

	function delete_template_field(element){
		val = $(element).val();
		temp_id = '<?=$this->uri->segment(3);?>';
		$.ajax({
			url: '<?=final_url(2, 'admin/ajax/delete_template_field');?>',
			type:'post',
			data:{'ids':val,'template_id':temp_id},
			success: function(data){
				data = JSON.parse(data);
				if(data.status==200){
					$("option[value='"+data.id+"']").remove();
				}
			}
		})
	}

	function add_custom_fields(){
		$.ajax({
			url: '<?=final_url(2, 'admin/ajax/add_custom_fields');?>',
			type:'post',
			success: function(data){
				$('#ajax').html(data);
				$('#custom_fields_modal').modal('show');
			}
		});
	}

	function set_esignature_fields(id){
		id = id;
		page_number 		= $("input[name=page_number]").val();
		customer_signature_axis = $("input[name=customer_signature_axis_x]").val()+'_'+$("input[name=customer_signature_axis_y]").val();
		employee_signature_axis = $("input[name=employee_signature_axis_x]").val()+'_'+$("input[name=employee_signature_axis_y]").val();

		$.ajax({
			url: '<?=final_url(2, 'admin/ajax/save_template_esignature_fields');?>',
			type:'post',
			data:{
				'id':id,
				'page_number':page_number,
				'customer_signature_axis':customer_signature_axis,
				'employee_signature_axis':employee_signature_axis,
			},
			success: function(data){
				$.gritter.add({title:data,class_name:"gritter-danger",time: 3000});
			}
		})
	}

	function esign_help(){
		$.alert({
			title:  "Help",
			content:"To make signature box at accurate place. Make sure you are using A4 sheet. The bottom left corner of the sheet contains X-Axis 0 and Y-Axis 0."
		})
	}

	function reload(){
		location.reload();
	}

	function change_customer_fields(val){
		$.ajax({
			url: '<?=final_url(2, 'admin/ajax/change_customer_fields');?>',
			type:'POST',
			data:{'val':val},
			success: function(data){
				$('#customer_btn_fields').html(data);
			}
		})
	}
	</script>