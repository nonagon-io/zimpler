<!DOCTYPE html>
<html class="uk-height-1-1">
<html lang="<?php echo $lang_code?>">
<head>
	<meta charset="utf-8">
	<meta name="language" content="<?php echo $meta_language?>">
	<meta name="keywords" content="<?php echo $meta_keywords?>">
	<meta name="description" content="<?php echo $meta_description?>">

	<title><?php echo $title?></title>
	
	<link rel="icon" type="image/png" href="<?php 
		echo base_url('assets/favicon.png')
	?>"/>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/vendor.min.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/common.css')?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/public.css')?>"/>
	
	<?php
		$pages = explode('/', uri_string());
		
		if(count($pages) > 0)
		{
			$page = $pages[count($pages) - 1];
		}
		else
		{
			$page = null;
		}
	?>
	
	<?php if($page) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/public/' . $page . '.css')?>"/>
	<?php endif ?>
	
	<base href="<?php echo current_url() ?>/" />
</head>
<body>
	
	<?php $this->load->view("public/header") ?>

	<?php echo $content; ?>

	<?php $this->load->view("public/footer") ?>
	
	<script type="text/javascript" src="<?php echo base_url('js/vendor.min.js')?>"></script>
	
	<?php if($page) : ?>
	<script type="text/javascript" src="<?php echo base_url('js/app/public/' . $page . '.js')?>"></script>
	<?php endif ?>
</body>
</html>