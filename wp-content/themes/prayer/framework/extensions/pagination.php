<?php 
/*	
*	CrunchPress Pagination File
*	---------------------------------------------------------------------
* 	@version	1.0
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file return the Pagination to the selected post_type
*	---------------------------------------------------------------------
*/
	
	if( !function_exists('pagination') ){
		function pagination($pages = '', $range = 4)
		{
			
			// Don't print empty markup if there's only one page.
			if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
				return;
			}

			$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
			$pagenum_link = html_entity_decode( get_pagenum_link() );
			$query_args   = array();
			$url_parts    = explode( '?', $pagenum_link );

			if ( isset( $url_parts[1] ) ) {
				wp_parse_str( $url_parts[1], $query_args );
			}

			$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
			$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

			$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
			$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

			// Set up paginated links.
			$links = paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'crunchpress' ),
				'next_text' => __( '<i class="fa fa-angle-right"></i>', 'crunchpress' ),
			) );

			if ( $links ) :

			?>
			<div class="pagination-all pagination" role="navigation">
				<ul id='pagination'>
					<li>
						<?php echo $links; ?>
					</li>
				</ul><!-- .pagination -->
			</div><!-- .navigation -->
			<?php
			endif;

		}
	}
	
	
	if( !function_exists('cp_post_nav') ){
		function cp_post_nav() {
			// Don't print empty markup if there's nowhere to navigate.
			$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}

			?>			
			<div class="nav-links">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'crunchpress' ) );
				else :
					previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'crunchpress' ) );
					next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'crunchpress' ) );
				endif;
				?>
			</div><!-- .nav-links -->			
			<?php
		}
	}
	
	
	if( !function_exists('cp_post_next') ){
		function cp_post_next() {
			// Don't print empty markup if there's nowhere to navigate.
			$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}

				if ( is_attachment() ) :
					echo '<div class="portfolio-thumb">';
					previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'crunchpress' ) );
					echo '</div>';
				else :
					echo '<div class="portfolio-thumb">';
					previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'crunchpress' ) );
					next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'crunchpress' ) );
					echo '</div>';
				endif;
		}
	}
?>