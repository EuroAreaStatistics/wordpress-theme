<?php
require WP_PLUGIN_DIR.'/m-chart-highcharts-library/components/templates/highcharts-settings.php';
?>
<script type="text/html" id="tmpl-m-chart-options">
        <div class="row six-and-a-half">
               <p>
                       <label for="<?php echo esc_attr( $this->get_field_id( 'options' ) ); ?>">Highcharts options (JSON)</label><br />
                       <textarea type="text" rows="10" style="width:100%" name="<?php echo esc_attr( $this->get_field_name( 'options' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'options' ) ); ?>"><?php echo esc_textarea( $post_meta['options']) ?></textarea>
               </p>
        </div>
</script>
