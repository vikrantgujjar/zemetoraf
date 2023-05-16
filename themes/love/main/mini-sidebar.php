<?php if( isset( $_SESSION['JWT'] ) ){ ?>
<div class="dt_mini_sidebar_links">
	<ul class="home_usr_link">
		<li class="vis <?php if($data['name'] == 'profile'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/@<?php echo Auth()->username;?>" data-ajax="/@<?php echo Auth()->username;?>"><img src="<?php echo Auth()->avater->avater;?>" alt="<?php echo Auth()->full_name;?>" /> <span><?php echo __( 'Profile' );?></span></a>
		</li>
		<li class="pli <?php if($data['name'] == 'settings'){ echo 'active';}?><?php if($data['name'] == 'settings-profile'){ echo 'active';}?><?php if($data['name'] == 'settings-privacy'){ echo 'active';}?><?php if($data['name'] == 'settings-password'){ echo 'active';}?><?php if($data['name'] == 'settings-social'){ echo 'active';}?><?php if($data['name'] == 'settings-blocked'){ echo 'active';}?><?php if($data['name'] == 'settings-email'){ echo 'active';}?><?php if($data['name'] == 'settings-delete'){ echo 'active';}?>">
            <a href="<?php echo $site_url;?>/settings/<?php echo Auth()->username;?>" data-ajax="/settings/<?php echo Auth()->username;?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" /></svg> <span><?php echo __( 'Settings' );?></span></a>
        </li>
		<hr class="border_hr"></hr>
		<li class="vis <?php if($data['name'] == 'likes'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/likes" data-ajax="/likes"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" /></svg> <span><?php echo __( 'Likes' );?></span></a>
		</li>
		<li class="pli <?php if($data['name'] == 'liked'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/liked" data-ajax="/liked"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14C12.3,14 7,15.3 7,18V20H23V18C23,15.3 17.7,14 15,14M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12M5,15L4.4,14.5C2.4,12.6 1,11.4 1,9.9C1,8.7 2,7.7 3.2,7.7C3.9,7.7 4.6,8 5,8.5C5.4,8 6.1,7.7 6.8,7.7C8,7.7 9,8.6 9,9.9C9,11.4 7.6,12.6 5.6,14.5L5,15Z" /></svg> <span><?php echo __( 'People i liked' );?></span></a>
		</li>
		<li class="dis <?php if($data['name'] == 'disliked'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/disliked" data-ajax="/disliked"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,15H23V3H19M15,3H6C5.17,3 4.46,3.5 4.16,4.22L1.14,11.27C1.05,11.5 1,11.74 1,12V14A2,2 0 0,0 3,16H9.31L8.36,20.57C8.34,20.67 8.33,20.77 8.33,20.88C8.33,21.3 8.5,21.67 8.77,21.94L9.83,23L16.41,16.41C16.78,16.05 17,15.55 17,15V5C17,3.89 16.1,3 15,3Z" /></svg> <span><?php echo __( 'People i disliked' );?></span></a>
		</li>
        <?php if( $config->connectivitySystem == '1' ){?>
        <li class="pli <?php if($data['name'] == 'friend-requests'){ echo 'active';}?>">
            <a href="<?php echo $site_url;?>/friend-requests" data-ajax="/friend-requests"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M6,10V7H4V10H1V12H4V15H6V12H9V10M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12Z" /></svg> <span><?php echo __( 'Friend requests' );?></span></a>
        </li>
        <?php } ?>

		<?php if ($config->agora_live_video == 1) { ?>
		<li class="lik <?php if($data['name'] == 'live-users'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/live-users" data-ajax="/live-users">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17,10.5L21,6.5V17.5L17,13.5V17A1,1 0 0,1 16,18H4A1,1 0 0,1 3,17V7A1,1 0 0,1 4,6H16A1,1 0 0,1 17,7V10.5M14,16V15C14,13.67 11.33,13 10,13C8.67,13 6,13.67 6,15V16H14M10,8A2,2 0 0,0 8,10A2,2 0 0,0 10,12A2,2 0 0,0 12,10A2,2 0 0,0 10,8Z"></path></svg> <span><?php echo __( 'Live Videos' );?></span>
            </a>
		</li>
		<?php } ?>
		<hr class="border_hr"></hr>
		<li class="vis <?php if($data['name'] == 'blog'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/blog" data-ajax="/blog">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20 3H4C2.89 3 2 3.89 2 5V19C2 20.11 2.89 21 4 21H20C21.11 21 22 20.11 22 19V5C22 3.89 21.11 3 20 3M5 7H10V13H5V7M19 17H5V15H19V17M19 13H12V11H19V13M19 9H12V7H19V9Z"></path></svg> <span><?php echo __( 'Blog' );?></span>
			</a>
		</li>
		<?php if ($config->success_stories_system == 1) { ?>
		<li class="pli <?php if($data['name'] == 'stories'){ echo 'active';}?>">
			<a href="<?php echo $site_url;?>/stories" data-ajax="/stories">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18,22A2,2 0 0,0 20,20V4C20,2.89 19.1,2 18,2H12V9L9.5,7.5L7,9V2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18Z"></path></svg> <span><?php echo __( 'Success stories' );?></span>
			</a>
		</li>
		<?php } ?>
	</ul>
</div>
<?php } else { ?>
<?php } ?>