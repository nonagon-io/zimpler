<?php
	
function active_if_page($page)
{
	$url = uri_string();
	if(strcasecmp($url, $page) == 0)
		echo(" class='uk-active'");
}

function active_if_page_or_null($page)
{
	$url = uri_string();
	$path_array = explode("/", $url);
	
	if(count($path_array) == 1)
	{
		echo(" class='uk-active'");
		return;
	}
	
	if(strcasecmp($url, $page) == 0 || $path_array[1] == "")
		echo(" class='uk-active'");
}

function page_title()
{
	$url = uri_string();
	$path_array = explode("/", $url);
	
	if(count($path_array) == 1)
	{
		echo lang("admin_menu_home");
		return;
	}
	
	if(count($path_array) == 2)
	{
		echo lang(sprintf("%s_menu", $path_array[1]));
		return;
	}
	
	echo lang(sprintf("%s_menu_%s", $path_array[1], $path_array[2]));
}
	
?>

<div class="uk-grid uk-grid-preserve uk-grid-small uk-height-1-1" ng-controller="AdminController">
	<div class="uk-width-1-10 uk-width-large-1-5 uk-height-1-1">
		<div class="uk-panel uk-height-1-1 n-menu-panel" data-uk-sticky="">
		    <div class="n-common">
		    	<div class="uk-text-center uk-margin-top uk-margin-bottom">
			    	<img src="<?= base_url('assets/images/logo.png') ?>" width="50px" />
		    	</div>
            	<div class="n-current-login uk-text-center uk-hidden-small uk-hidden-medium">
                	<?= lang("admin_welcome") ?> <?= $current_display_name ?>
            	</div>
            	<div class="n-menu-header uk-text-center uk-hidden-small uk-hidden-medium">
                	<?= lang("admin_main_menu") ?>
            	</div>
		    </div>
	        <ul class="n-items uk-nav uk-nav-offcanvas">
	            <li <?php active_if_page_or_null('index') ?>>
	                <a href="<?= base_url('admin/') ?>">
	                	<i class="uk-icon-home uk-icon-small"></i>
	                	<span class="uk-hidden-small uk-hidden-medium">
	                		<?= lang("admin_menu_home") ?>
	                	</span>
	                </a>
	            </li>
	            <?php foreach($menu_items as $item) : ?>
	            <li <?php active_if_page($item['path']) ?>>
	                <a href="<?= $item['link'] ?>">
	                	<i class="uk-icon-<?= $item['icon'] ?> uk-icon-small"></i>
	                	<span class="uk-hidden-small uk-hidden-medium">
	                	<?= $item['name'] ?>
	                	</span>
	                </a>
	            </li>
	            <?php endforeach ?>
	        </ul>
		</div>
	</div>
	<div class="uk-width-9-10 uk-width-large-4-5 uk-height-1-1" style="padding-left: 0px">
		<div class="n-view-host uk-height-1-1">
			<div class="n-title" ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
				<div class="uk-grid">
					<div class="uk-width-1-2">
						<h2 style="text-transform: capitalize">
							<?php page_title() ?>
						</h2>
					</div>
					<div class="uk-width-1-2 uk-text-right">
	                	<a href="<?= base_url('/user/logout'); ?>" class="uk-button">
	                		<i class="uk-icon-sign-out"></i>
	                	</a>
					</div>
				</div>
			</div>
			<div class="n-body">
				<?php echo $sub_content ?>
			</div>
		</div>
	</div>
	<?php $this->load->view("modal") ?>
</div>

<script>
	window._fileManager = "<?= $this->setting_model->get("file_manager"); ?>";
</script>

<?php if($this->setting_model->get('file_manager') != 'disable') : ?>
<div class="n-file-browser uk-modal">
	<div class="uk-modal-dialog uk-modal-dialog-large">
		<div class="uk-modal-header">
			<h2>File Manager</h2>
		</div>
		<div class="uk-modal-footer">
		</div>
	</div>
</div>
<?php endif ?>