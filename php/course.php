<div class="my_meta_control">
	
    <label>Actief en extra tekstvak</label>
    
    <?php $metabox->the_field('extra_active'); ?>
      <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php if ($metabox->get_the_value()) echo ' checked="checked"'; ?>/> Aanwezig op voorpagina <br/>
    <br/>
    
    <p>
 	    <p class="description">Titel</p>
    	<input type="text" name="<?php $metabox->the_name('extra_title'); ?>" value="<?php $metabox->the_value('extra_title'); ?>"/>
    </p>
    
    <?php $mb->the_field('extra_content'); 
        wp_editor(
            html_entity_decode($metabox->get_the_value(), ENT_NOQUOTES, 'UTF-8'),
            $metabox->get_the_name(),
            
            $settings = array(
            	'textarea_name' => $metabox->get_the_name(),
				'wpautop' => true,
				'media_buttons' => false,
				'textarea_rows' => 15
             ) 
            ); ?>
    <br/>
</div>