<div class="dt_left_sidebar-wasspace-pro-removed">

</div>

<div class="dt_sections">
	<div class="dt_right_side_story">
		<?php 
			global $db;
			$stories = $db->orderBy('RAND()')->where('status', 1)->objectbuilder()->get('success_stories',5);
			foreach ($stories as $key => $story) {
				$story->user = userData($story->user_id);
		        $story->story_user = userData($story->story_user_id);

		?>
		<div class="dt_right_side_story_list">
			<div class="images">
				<img src="<?php echo $story->user->avater->avater;?>"/>
				<img src="<?php echo $story->story_user->avater->avater;?>"/>
			</div>
			<a href="<?php echo $site_url;?>/story/<?php echo $story->id. '_'. url_slug($story->quote);?>" data-ajax="/story/<?php echo $story->id . '_'. url_slug($story->quote);?>">
				<h5><?php echo ($story->user->first_name ) ;?> & <?php echo ($story->story_user->first_name ) ;?></h5>
				<hr>
				<p><?php echo __( 'Story Begins' );?></p>
				<time><?php echo $story->story_date;?></time>
			</a>
		</div>
		<?php } ?>
	</div>
</div>

<?php if (!empty($config->native_android_url) || !empty($config->native_ios_url)) { ?>
	<div class="dt_sections">
		<div class="dt_home_pro_usr">
			<!--<h4 class="bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M17,1H7A2,2 0 0,0 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3A2,2 0 0,0 17,1M17,19H7V5H17V19M16,13H13V8H11V13H8L12,17L16,13Z" /></svg>
                <?php echo __( 'apps' );?>
            </h4>-->

            <div class="dt_side_apps">
            	<?php if (!empty($config->native_android_url) || !empty($config->native_ios_url)) { ?>
	            	<?php if (!empty($config->native_android_url)) { ?>
	            		<a href="<?php echo($config->native_android_url) ?>" target="_blank">
							<img width="130" src="<?php echo $theme_url;?>assets/img/google.png"/>
	                    </a>
	            	<?php } ?>
	            	<?php if (!empty($config->native_ios_url)) { ?>
	            		<a href="<?php echo($config->native_ios_url) ?>" target="_blank">
							<img width="130" src="<?php echo $theme_url;?>assets/img/apple.png"/>
	                    </a>
	            	<?php } ?>
            	<?php } ?>
            </div>
        </div>
	</div>
<?php } ?>
<?php echo GetAd('home_side_bar');?>