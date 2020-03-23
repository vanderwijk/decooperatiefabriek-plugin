<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control">
 
	<p class="warning"><?php _e('These textareas will NOT work without javascript enabled.');?></p>
 
 
	<a style="float:right; margin:0 10px;" href="#" class="dodelete-repeating_textareas button"><?php _e('Verwijder alle referenties');?></a>
 
	<p><?php _e('Voeg nieuwe referenties toe door op de knop "Voeg referentie toe" te drukken. Je kunt ze sorteren door ze te slepen.');?></p>
 
	<?php while($mb->have_fields_and_multi('repeating_textareas')): ?>
	<?php $mb->the_group_open(); ?>
 
	<h3 class="handle"><?php _e('Inhoud referentie');?></h3>
	
	<a href="#" class="dodelete button"><?php _e('Verwijder referentie');?></a>
	  
	<div class="inside">
	
		<p class="warning update-warning"><?php _e('De volgorde is veranderd. Vergeet niet de wijzigingen op te slaan.');?></p>
 
		<div class="customEditor">
			
			<!--<div class="wp-editor-tools">
				<div class="custom_upload_buttons hide-if-no-js wp-media-buttons"><?php do_action( 'media_buttons' ); ?></div>
			</div>-->
			<?php $mb->the_field('title'); ?>
			<label>Naam</label>
			<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
			<?php $mb->the_field('function'); ?>
			<label>Functie</label>
			<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
			
			<label>Afbeelding</label>
			<div class="metabox mediaupload">
				<?php $mb->the_field('imgurl'); ?>
				<?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Gebruik afbeelding'); ?>
				
					<p>
				    	<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
				    	<?php echo $wpalchemy_media_access->getButton(); ?>
				    </p>

			</div>
			
			<p><?php $metabox->the_field('active'); ?>
			  <input type="checkbox" name="<?php $metabox->the_name('active'); ?>" value="1"<?php if ($metabox->get_the_value()) echo ' checked="checked"'; ?>/>  Aanwezig op klantenpagina</p>
			
			<?php $mb->the_field('textarea'); ?>
			<p>
				<p class="description">Inhoud</p>
				<textarea rows="5" cols="148" name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
			</p>
		</div>
	
	</div>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-repeating_textareas button"><?php _e('Extra referentie invoegen');?></a></p>
	
	

	
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>

</div>