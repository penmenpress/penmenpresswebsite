<?php
/**
 * Editorial: Homepage Featured Slider
 *
 * Homepage slider section with featured section
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'widgets_init', 'editorial_news_register_featured_slider_widget' );

function editorial_news_register_featured_slider_widget() {
    register_widget( 'Editorial_News_Featured_Slider' );
}

class Editorial_News_Featured_Slider extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'editorial_news_featured_slider clearfix',
            'description' => __( 'Display slider with featured posts.', 'editorial-news' )
        );
        parent::__construct( 'editorial_news_featured_slider', __( 'Editorial: Featured Slider', 'editorial-news' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
	
	   $editorial_category_dropdown = editorial_category_dropdown();

    	$fields = array(

            'slider_header_section' => array(
                'editorial_widgets_name' => 'slider_header_section',
                'editorial_widgets_title' => __( 'Slider Section', 'editorial-news' ),
                'editorial_widgets_field_type' => 'widget_section_header'
            ),

            'editorial_slider_category' => array(
                'editorial_widgets_name' => 'editorial_slider_category',
                'editorial_widgets_title' => __( 'Category for Slider', 'editorial-news' ),
                'editorial_widgets_default'      => 0,
                'editorial_widgets_field_type' => 'select',
                'editorial_widgets_field_options' => $editorial_category_dropdown
            ),

            'editorial_slide_count' => array(
                'editorial_widgets_name' => 'editorial_slide_count',
                'editorial_widgets_title' => __( 'No. of slides', 'editorial-news' ),
                'editorial_widgets_default' => 5,
                'editorial_widgets_field_type' => 'number'
            ),

            'featured_header_section' => array(
                'editorial_widgets_name' => 'featured_header_section',
                'editorial_widgets_title' => __( 'Featured Posts Section', 'editorial-news' ),
                'editorial_widgets_field_type' => 'widget_section_header'
            ),

            'editorial_featured_category' => array(
                'editorial_widgets_name' => 'editorial_featured_category',
                'editorial_widgets_title' => __( 'Category for Featured Posts', 'editorial-news' ),
                'editorial_widgets_default'      => 0,
                'editorial_widgets_field_type' => 'select',
                'editorial_widgets_field_options' => $editorial_category_dropdown
            ),

        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $editorial_slider_category_id      = intval( empty( $instance['editorial_slider_category'] ) ? null : $instance['editorial_slider_category'] );
        $editorial_slide_count             = intval( empty( $instance['editorial_slide_count'] ) ? 5 : $instance['editorial_slide_count'] );
        $editorial_featured_category_id    = intval( empty( $instance['editorial_featured_category'] ) ? null : $instance['editorial_featured_category'] );
        echo $before_widget;
    ?>
        <div class="mt-featured-slider-wrapper">
            <div class="mt-slider-section">
                <?php
                    $slider_args = editorial_query_args( $editorial_slider_category_id, $editorial_slide_count );
                    $slider_query = new WP_Query( $slider_args );
                    if( $slider_query->have_posts() ) {
                        echo '<ul class="editorialSlider">';
                        while( $slider_query->have_posts() ) {
                            $slider_query->the_post();
                    ?>
                            <li>
                                <a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>">
                                    <figure><?php the_post_thumbnail( 'editorial-slider-large' ); ?></figure>
                                </a>
                                <div class="slider-content-wrapper">
                                    <?php do_action( 'editorial_post_categories' ); ?>
                                    <h3 class="slide-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                    <div class="post-meta-wrapper">
                                        <?php editorial_posted_on(); ?>
                                        <?php editorial_post_comment(); ?>
                                    </div>
                                </div><!-- .post-meta-wrapper -->
                            </li>
                    <?php
                        }
                        echo '</ul>';
                    }
                    wp_reset_postdata();
                ?>
            </div><!-- .mt-slider-section -->
        </div><!-- .mt-featured-slider-wrapper -->

        <div class="featured-post-wrapper">
            <?php
                $featured_post_count = apply_filters( 'editorial_news_featured_post_count', '4' );
                $featured_args = editorial_query_args( $editorial_featured_category_id, $featured_post_count );
                $featured_query = new WP_Query( $featured_args );
                $total_post_count = $featured_query->post_count;
                if( $featured_query->have_posts() ) {
                    while ( $featured_query->have_posts() ) {
                        $featured_query->the_post();                    
            ?>
                        <div class="single-featured-wrap">
                            <?php if( has_post_thumbnail() ) { ?>
                                <a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
                                    <figure><?php the_post_thumbnail( 'editorial-news-block-thumb' ) ?></figure>
                                </a>
                            <?php } ?>
                            <div class="featured-content-wrapper">
                                <?php do_action( 'editorial_post_categories' ); ?>
                                <h3 class="featured-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                <div class="post-meta-wrapper"> <?php editorial_posted_on(); ?> </div>
                            </div><!-- .post-meta-wrapper -->
                        </div><!-- .single-featured-wrap -->
            <?php
                    }
                }
                wp_reset_postdata();
            ?>
        </div><!-- .featured-post-wrapper -->
        
    <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	editorial_widgets_updated_field_value()		defined in editorial-widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$editorial_widgets_name] = editorial_widgets_updated_field_value( $widget_field, $new_instance[$editorial_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	editorial_widgets_show_widget_field()		defined in editorial-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $editorial_widgets_field_value = !empty( $instance[$editorial_widgets_name] ) ? wp_kses_post( $instance[$editorial_widgets_name] ) : '';
            editorial_widgets_show_widget_field( $this, $widget_field, $editorial_widgets_field_value );
        }
    }

}