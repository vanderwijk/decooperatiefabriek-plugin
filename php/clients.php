<div class="my_meta_control">
        
    <p>
    	<p class="description">Website</p>
    	<input type="text" name="<?php $metabox->the_name('website'); ?>" value="<?php $metabox->the_value('website'); ?>"/>
    	<p class="description">Telefoon</p>
    	<input type="text" name="<?php $metabox->the_name('phone'); ?>" value="<?php $metabox->the_value('phone'); ?>"/>
    	<p class="description">E-mailadres</p>
    	<input type="text" name="<?php $metabox->the_name('mail'); ?>" value="<?php $metabox->the_value('mail'); ?>"/>
    	<?php $mb->the_field('extra_info'); ?>
    	<p>
    		<p class="description">Extra info</p>
    		<textarea rows="5" cols="148" name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
    	</p>
    </p>

</div>