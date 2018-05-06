<div style="margin-top:5px">
<a href="#pp-pro-info"><?php _e( 'Show list of PP Pro features and screencasts', 'pp' );?></a>
</div>

<?php
$img_url = PP_URLPATH . '/admin/images/';
$lang_id = 'pp';
?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready( function($) {
	$('a[href="#pp-pro-info"]').click( function() {
		$('#pp_features').show();
		$('ul.pro-pplinks').show();
		return false;
	});
	$('a[href="#pp-pro-hide"]').click( function() {
		$('#pp_features').hide();
		$('ul.pro-pplinks').hide();
		return false;
	});
});
/* ]]> */
</script>
<style>
#pp_features {text-align:left;border:1px solid #eee;margin:10px 20px 20px 20px;background-color:white}
div.pp-logo, div.pp-logo img { text-align: left; clear:both }
ul.pp-features { list-style: none; padding-top:10px; text-align:left; margin-left: 50px; margin-top: 0; }
ul.pp-features li:before { content: "\2713\0020"; }
ul.pp-features li { padding-bottom: 5px }
img.cme-play { margin-bottom: -3px; margin-left: 5px;}
ul.pro-pplinks {
margin-top: 0;
margin-left:20px;
width:100%;
}
ul.pro-pplinks li{
display: inline;
margin: 0 3px 0 3px;
}
ul.pro-pplinks li.spacer{
font-size: 1.5em;
}
</style>

<div id="pp_features" style="display:none"><div class="pp-logo"><a href="http://presspermit.com"><img src="<?php echo $img_url;?>pp-logo.png" /></a>

<ul class="pp-features">

<li>
<?php _e( "Customize editing permissions per-category or per-post", $lang_id );?>
<a href="https://www.youtube.com/watch?v=0yOEBD8VE9c&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=3" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Limit category/term assignment and page parent selection", $lang_id );?>
<a href="https://www.youtube.com/watch?v=QqvtxrqLPwY&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=4" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "File URL Filter: regulate direct access to uploaded files", $lang_id );?>
<a href="https://www.youtube.com/watch?v=kVusrdlgSps&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=15" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Hidden Content Teaser", $lang_id );?>
<a href="https://www.youtube.com/watch?v=d_5r8NKjxDQ&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=9" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "bbPress: customize viewing, topic creation or reply submission permissions per-forum", $lang_id );?></li>

<li>
<?php _e( "Date-limited membership in Permissions Groups", $lang_id );?>
<a href="https://www.youtube.com/watch?v=hMOVvCy_9Ws&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=7" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Custom Post Visibility statuses, fully implemented throughout wp-admin", $lang_id );?>
<a href="https://www.youtube.com/watch?v=vM3Iwt3Jdak&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=6" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Custom Moderation statuses for access-controlled, multi-step publishing workflow", $lang_id );?>
<a href="https://www.youtube.com/watch?v=v8VyKP3rIvk&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=8" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Regulate permissions for Edit Flow post statuses", $lang_id );?>
<a href="https://www.youtube.com/watch?v=eeZ6CBC5kQI&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=11" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Customize the moderated editing of published content with Revisionary or Post Forking", $lang_id );?>
<a href="https://www.youtube.com/watch?v=kCD6HQAjUXs&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=12" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "Grant supplemental content permissions to a BuddyPress group <em>(Pro)</em>", $lang_id );?>
<a href="https://www.youtube.com/watch?v=oABIT7wki_A&list=PLyelWaWwt1HxuwrZDRBO_c70Tm8A7lfb3&index=14" target="_blank"><img class="cme-play" src="<?php echo $img_url;?>play.png" /></a></li>

<li>
<?php _e( "WPML integration to mirror permissions to translations <em>(Pro)</em>", $lang_id );?>
</li>

<li>
<?php _e( "Member support forum", $lang_id );?>
</li>
</ul>

<ul class="pro-pplinks" style="display:none">
<li><a class="pp-screencasts" href="http://presspermit.com/tutorial" target="_blank"><?php _e('Screencasts', 'pp');?></a></li>
<li class="spacer">&bull;</li>
<li><a href="http://presspermit.com/pp-rs-feature-grid" target="_blank"><?php _e('Feature Grid', 'pp');?></a></li>
<li class="spacer">&bull;</li>
<li><a href="http://presspermit.com/faqs" target="_blank"><?php _e('FAQs', 'pp');?></a></li>
<li class="spacer">&bull;</li>
<li><a href="http://presspermit.com/forums/forum/pre-sale-questions/" target="_blank"><?php _e('Pre-Sale Questions', 'pp');?></a></li>
<li class="spacer">&bull;</li>
<li><a href="http://presspermit.com/purchase/" target="_blank"><?php _e('Purchase', 'pp');?></a></li>
<li class="spacer">&bull;</li>
<li><a href="#pp-pro-hide"><?php _e('Hide', 'pp');?></a></li>
</ul>

</div>
