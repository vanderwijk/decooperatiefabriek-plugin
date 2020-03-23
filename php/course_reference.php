<div class="my_meta_control">
	
	<label>Referenties</label>
    
    <?php while($mb->have_fields_and_multi('referentie')): ?>
    <?php $mb->the_group_open(); ?>
    
    <hr>
     
    <?php $mb->the_field('referentie_naam'); ?>
    <p>
    	<p class="description">Naam</p>
    <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
    </p> 
    
    <?php $mb->the_field('referentie_content'); ?>
    <p>
    	<p class="description">Inhoud referentie</p>
    	<textarea rows="5" cols="148" name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
    </p>
    
    <?php $metabox->the_field('referentie_active'); ?>
      <input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php if ($metabox->get_the_value()) echo ' checked="checked"'; ?>/> Aanwezig op pagina? <br/>
    <br/>
    
    <a href="#" class="dodelete button">Verwijder referentie</a>
    <br/>
    <br/>
    <hr>
    
    <?php $mb->the_group_close(); ?>
    
    <?php endwhile; ?>
    <p>
          <a href="#" class="docopy-referentie button">Voeg extra referentie toe</a>
    </p>
    

</div>