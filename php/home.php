<div class="my_meta_control">

    <label>Introductie op website</label>

    <p>
    	<p class="description">Titel</p>
    	<input type="text" name="<?php $metabox->the_name('title'); ?>" value="<?php $metabox->the_value('title'); ?>"/>
    </p>

    <p>
    	<p class="description">Lees verder link</p>
    	<input type="text" name="<?php $metabox->the_name('link'); ?>" value="<?php $metabox->the_value('link'); ?>"/>
    </p>
    <br>
    <hr>
    <br>
    <label>Eerste video</label>

    <p>
        <p class="description">Titel</p>
        <input type="text" name="<?php $metabox->the_name('video_title'); ?>" value="<?php $metabox->the_value('video_title'); ?>"/>
    </p>

    <p class="description">Content</p>
        <?php $mb->the_field('video_content');
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

    <!--<p>
        <p class="description">Lees verder link</p>
        <input type="text" name="<?php $metabox->the_name('video_link'); ?>" value="<?php $metabox->the_value('video_link'); ?>"/>
    </p> -->

</div>
