<?php
/**
 *  Used for showing the slider
 *  @package canis
 */

$slides = get_theme_mod( 'canis_slides' );

if( is_array($slides) && ( is_home() || is_front_page() ) ) : ?>

<div id="canis-slider" class="canis-slider clearfix">

		<?php foreach( $slides as $slide ) :
			$link        = isset( $slide['link'] ) ? $slide['link'] : false;
			$title       = isset( $slide['title'] ) ? sprintf( '<h2 class="slide-title" ><a href="%s">%s</a></h2>' , esc_url( $link ), esc_html($slide['title']) ) : false;
			$description = isset( $slide['description']) ? sprintf( '<p class="slide-description"><a href="%s">%s</a></p>', esc_url( $link ) , esc_html( $slide['description'] ) ) : false;
			$image       = isset( $slide['image'] ) ? sprintf( '<img src="%s" alt="%s">' , esc_url( $slide['image'] ), __( 'Slide Image' , 'canis' ) ) : false;
		 ?>
		<div class="canis-slide">
			<?php echo $image; ?>
			<?php if( $title || $description ){ ?>
			<div class="canis-slide-content">
				<div class="row">
					<?php echo $title . $description; ?>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php endforeach; ?>

	<div class="canis-slider-pager clearfix"></div>

	<?php if( count($slides) ) { ?>
	<div class="canis-prev"></div>
	<div class="canis-next"></div>
	<?php } ?>

</div> <!-- #canis-slider -->

<?php endif; ?>
