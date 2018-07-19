<?php
/**
* Helper File
* functions of this file are designer to use any where on plugin
*/
class Helper
{
	// Star Rating conditional HTML structure
	static function star_rating_html($star_value){
		$star_layout = "";
		$perpagebook = get_option( "perpagebook" );
		if (is_numeric($star_value)) {
			for ($i=0; $i < $perpagebook ; $i++) { 
				if($star_value > $i){
					$star_layout .= '<i class="fa fa-star" aria-hidden="true"></i>';
				}
				else{
					$star_layout .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
				}
			}
		}
		else{
			$star_layout = $star_value;
		}
		return $star_layout;
	}

	// Book result Listing with pagination
	static function book_list_structure($myposts,$perpage_book,$lbs_offset,$total_result=""){
		?>		
		<table>
			<tr>
				<th>No</th>
				<th>Book Name</th>
				<th>Price</th>
				<th>Auther</th>
				<th>Publisher</th>
				<th>Rating</th>
			</tr>
			<?php
			// If there are posts
			if(!empty($myposts->posts)){
			  // Loop the posts
			  $loop_counter = 1;
			  foreach ($myposts->posts as $mypost):
				?>
				<tr>
					<td><?php echo $lbs_offset+$loop_counter; ?></td>
					<td><a href="<?php echo get_permalink($mypost->ID); ?>"><?php echo $mypost->post_name; ?></a></td>
					<td><?php echo get_post_meta($mypost->ID,"price_value")[0]; ?></td>
					<td>
						<?php 
						$auther_terms = get_the_terms($mypost->ID,"auther");
						if(!empty($auther_terms))
							echo $auther_terms_string = join(', ', wp_list_pluck($auther_terms, 'name'));
						?>
					</td>
					<td>
						<?php 
						$publisher_terms = get_the_terms($mypost->ID,"publisher");
						if(!empty($publisher_terms))
							echo $publisher_terms_string = join(', ', wp_list_pluck($publisher_terms, 'name'));
						?>
					</td>
					<td>
						<?php 
						$star_rating_layout = get_post_meta($mypost->ID,"star_rating")[0];
						echo Helper::star_rating_html($star_rating_layout); ?>
					</td>
				</tr>
				<?php
				$loop_counter++;
			  endforeach; wp_reset_postdata();
			}else{
				echo "<tr><td colspan='6'>No Book Found.</td></tr>";
			}
			?>
		</table>
		<div class="book_pagination">
			<?php
			$perpagebook = get_option( "perpagebook" );
			if(!empty($myposts->posts)){
				$current_page = (($lbs_offset/$perpagebook)+1);
				if($total_result==""){
					$count_posts = wp_count_posts( 'book' )->publish;
					$no_of_page = ceil($count_posts/$perpage_book);	
				}
				else{
					$no_of_page = ceil($total_result/$perpage_book);	
				}

				if($no_of_page > 1){
					if($current_page >= 2){
						?><a onclick="lbs_pagination('<?php echo $current_page-1; ?>');">next</a><?php
					}

					for ($i_book_page=1; $i_book_page < $no_of_page+1 ; $i_book_page++) { 
						?><a <?php if( $current_page == $i_book_page ){ echo 'class="active_book_page"'; } ?> onclick="lbs_pagination('<?php echo $i_book_page; ?>');"><?php echo $i_book_page; ?></a><?php
					}

					if($no_of_page != $current_page){
						?><a onclick="lbs_pagination('<?php echo $current_page+1; ?>');">next</a><?php
					}
				}
			}
			?>
		</div>
		<?php
	}
}
?>