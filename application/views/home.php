<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
	</head>
	<body>
		<div class="container">
		<form action="" method="post" id="home_form" name="home_form" >
			<div class="inner-top">
				<span class="inner-text" >ADD NEW CALL </span>
			</div>

			<?php $cnt = 0; $main_cnt = 0; ?>
			<div class="inner-main" id="main">
				<input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt; ?>">
				<input type="hidden" name="main_cnt" id="main_cnt" value="<?php echo $main_cnt; ?>">
			</div>

			<div class="inner-bottom-above">
				<span class="inner-bottom-above-text" onclick="add_main_question()">+ ADD NEW QUESTION</span>
			</div>

			<div class="inner-bottom">
				<button type="submit" id="save" name="save" class="btn btn-info inner-text">Save</button>
				<button type="button" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
			</div>
		</form>
		</div>
	</body>
</html>

<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var cnt = $("#cnt").val();
	var main_cnt = $("#main_cnt").val();
</script>
