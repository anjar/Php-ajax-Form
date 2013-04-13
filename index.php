<?php
require_once('include/Config.php');

$DB = new Database;

$page=2;
$limit = 10;
//fetch data from db
$message = $DB->getData(array(
					'limit' 	=> $limit,
					'offset'	=> 0
				));

?>

<!DOCTYPE html>
<html>
<head>
	<title>GUEST BOOK With AJAX and Twitter Bootsrap</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=CSS_PATH?>bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?=CSS_PATH?>bootstrap-responsive.min.css" rel="stylesheet" media="screen">
	<link href="<?=CSS_PATH?>validationEngine.jquery.css" rel="stylesheet" media="screen">
</head>
<body>
	<div class="container">
		<div class="form-contact">
			<form method="post" id="form-contact" action="<?=BASE_URL?>form.php">
			  <fieldset>
				<legend>Form Contact</legend>
				
				<label>Nama*</label>
				<input type="text" name="name" placeholder="e.g: Anjar Febrianto" class="input-xxlarge validate[required]">
				
				<label>Email*</label>
				<input type="text" name="email" placeholder="e.g: anjar.febrianto@gmail.com" class="input-xxlarge validate[required,custom[email]]">
							
				<label>Message*</label>
				<textarea name="message" class="input-xxlarge validate[required]" rows="4"></textarea>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-primary" id="btn-submit">Submit</button>
				</div>
			  </fieldset>
			</form>
		</div>
		<style>
			.contact-content{font-family: Monaco, Menlo, Consolas, "Courier New", monospace;}
			#list-msg{list-style: none;}
			.msg-email{font-size: 14px;color:#93a1a1;}
			.msg-date{font-size: 11px;}
		
		</style>
		<div class="contact-content" id="">
			<ul id="list-msg">
			<?php foreach($message as $item) : ?>
					<li>
						<div class="msg-name"><?=$item['name']?>, <span class="msg-email"><?=$item['email']?></span></div>
						<div class="message">
							<span class="msg-date"><?=$DB->human_time(strtotime($item['created']))?></span>
							<p><?=$item['message']?></p>
						</div>
					</li>
			<?php endforeach; ?>
			</ul>
			<?php if(count($message) > 10) : ?>
				<div class="form-actions" id="form-load-more">
					<button type="button" class="btn btn-info" data-loading-text="Loading..." id="load-msg" data-page=1>Load More</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="<?=JS_PATH?>bootstrap.min.js"></script>
	<script src="<?=JS_PATH?>jquery.validationEngine.js"></script>
	<script src="<?=JS_PATH?>jquery.validationEngine-en.js"></script>
	<script type="text/javascript">
		var limit = '<?=$limit?>';
		var page = '<?=$page?>';
		 $(function() {
			 $("#form-contact").validationEngine('attach', {
				  onValidationComplete: function(form, status){
					if(status) {
						$('#btn-submit').attr('disabled', true);
							$.post('<?=BASE_URL?>form.php', $("#form-contact").serialize(),  function(result) {
								var data = jQuery.parseJSON(result);
								var msg = craetMessageHtml(data.message);
								
								$('#list-msg').prepend(msg);
								$('.input-xxlarge').val('');
								$('#btn-submit').attr('disabled', false);
							
							});
					}
				  }  
			}); 
			
			$('#load-msg').click(function() {
				
				$.get('<?=BASE_URL?>ajax_load.php?page='+ page + '&limit='+limit,  function(result) {
						
					var data = jQuery.parseJSON(result);
					
					if(data.status=='ok') {
						var msg = '';
						for(var i=0; i < data.message.length; i++) {
							msg += craetMessageHtml(data.message[i]);
						}
						
						page = parseInt(page)+1;
						$('#list-msg').append(msg);
					} else {
						
						var notfound = '<div class="message"><p class="notfound">Data Not Found</p></div>';
						$('#form-load-more').html(notfound);
					}
				});
			
			});
		
		});

function craetMessageHtml(content) {
	var ret_content = '<li>' +
					'<div class="msg-name">' + content.name +', <span class="msg-email">' + content.email + '</span></div>' +
					'<div class="message">'+
						'<span class="msg-date">' + content.create_date +'</span>'+
						'<p>'+ content.message +'</p>' +
					'</div>'+
				'</li>';
	
	return ret_content;
}
	</script>
	</body>
</html>