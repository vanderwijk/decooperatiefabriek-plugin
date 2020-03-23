<div class="my_meta_control">
    
    <?php $metabox->the_field('quote_active'); ?>
      <input type="checkbox" name="<?php $metabox->the_name('quote_active'); ?>" value="1"<?php if ($metabox->get_the_value()) echo ' checked="checked"'; ?>/> Aanwezig op klantenpagina?
    
    <p>
    	<p class="description">Inhoud quote</p>
    	<textarea rows="5" cols="148" name="<?php $metabox->the_name('quote_content'); ?>"><?php $metabox->the_value('quote_content'); ?></textarea>
    </p>
    
    <p>
    	<p class="description">Naam</p>
    	<input type="text" name="<?php $metabox->the_name('quote_name'); ?>" value="<?php $metabox->the_value('quote_name'); ?>"/>
    </p>
    
    <?php global $wpalchemy_media_access; ?>
    <div class="metabox mediaupload">
     	<p class="description">Foto quote</p>
        <?php $mb->the_field('quote_imgurl'); ?>
        <?php $wpalchemy_media_access->setGroupName('nn')->setInsertButtonLabel('Gebruiken als foto'); ?>
     
        <p>
            <?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
            <?php echo $wpalchemy_media_access->getButton(); ?>
        </p>

    </div>

</div>