<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 *
 * @link       https://icanwp.com/plugins/portfolio-gallery/
 * @since      1.0.0
 *
 * @package    iCanWP_Portfolio_Gallery
 * @subpackage iCanWP_Portfolio_Gallery/admin/partials
 */
	$wpcdd_rules = get_post_meta( $post->ID, '_wpcdd', false );

	if( empty( $wpcdd_rules ) ){
		$wpcdd_rules = array();
	} else {
		$wpcdd_rules = $wpcdd_rules[0];
	}
	
	$wpcdd_default = get_post_meta( $post->ID, '_wpcdd_default', false );
	if( empty( $wpcdd_default ) ){
		$wpcdd_default = array();
	} else {
		$wpcdd_default = $wpcdd_default[0];
	}
	$wpcdd_page_templates = get_page_templates();
	$wpcdd_post_categories = get_categories();
	$wpcdd_posts = get_posts();
	$wpcdd_pages = get_pages();
	$html_rules = '';
	
	$wpcdd_default_type = ( isset( $wpcdd_default['content']['type'] ) ) ? $wpcdd_default['content']['type'] : 'text-single';
	$wpcdd_default_content = ( isset( $wpcdd_default['content']['value'] ) ) ? $wpcdd_default['content']['value'] : '';
	
	
?>

<div id="wpcdd-default" class="wpcdd-rule">
	<div class="wpcdd-content-section">
		<h3>Default Content</h3>
		<select class="wpcdd-select wpcdd-content-type" name="wpcdd_default[content][type]">
			<option value="text-single"<?php echo ( $wpcdd_default_type == 'text-single' ? ' selected' : '' ); ?>>Text (1 line)</option>
		</select>
		<input type="text" class="wpcdd-text wpcdd-content-value" name="wpcdd_default[content][value]" maxlength="180" placeholder="Default Content" value="<?php echo $wpcdd_default_content; ?>" />
	</div>
	<div class="wpcdd-rules-section">
		<p>Default content shows when none of the conditions are met.<br> Leave it blank if you <strong>do not</strong> want to display anything by default.</p>
	</div>
</div>
<div id="wpcdd-actions">
	<input type="hidden" id="wpcdd-count" value="<?php echo count( $wpcdd_rules ); ?>" />
	<div id="wpcdd-add" class="wpcdd-button"><i class="fa fa-plus"></i> Add New Dynamic Content Variation</div>
</div>
<div id="wpcdd-rules">
<?php
	$rule_order = 0;
	if ( !empty( $wpcdd_rules ) ){
		foreach( $wpcdd_rules as $id => $rule ){
			$rule_order++;
			$html_condition_terms = '';
			$content_value = $rule['content']['value'];
			$condition_type = $rule['condition']['type'];
			$condition_terms = $rule['condition']['terms'];
			$condition_bool = $rule['condition']['bool'];
			if ( empty( $condition_terms ) ){
				$condition_terms = array();
			}

			if( $condition_type == 'post' ){
				$html_condition_terms = '<select class="wpcdd-select wpcdd-rule-terms wpcdd-sol" name="wpcdd[' . $id . '][condition][terms][]" multiple="multiple">';
				if ( !empty( $wpcdd_posts ) ){
					foreach( $wpcdd_posts as $post ){
						$html_condition_terms .= '<option value="' . $post->ID . '"' . ( in_array ( $post->ID, $condition_terms ) ? ' selected' : '' ) . '>' . $post->post_title . '</option>';
					}
				} else {
					$html_condition_terms .= '<option>No Posts Available</option>';
				}
				$html_condition_terms .= '</select>';
			} elseif( $condition_type == 'page-template' ){
				$html_condition_terms = '<select class="wpcdd-select wpcdd-rule-terms wpcdd-sol" name="wpcdd[' . $id . '][condition][terms][]" multiple="multiple">';
				if ( !empty( $wpcdd_page_templates ) ){
					foreach ( $wpcdd_page_templates as $template_name => $template_filename ) {
						$html_condition_terms .= '<option value="' . $template_filename . '"' . ( in_array( $template_filename, $condition_terms ) ? ' selected' : '' ) . '>' . $template_name . '</option>';
					}
				} else {
					$html_condition_terms .= '<option>No Page Templates Available</option>';
				}
				$html_condition_terms .= '</select>';
			} elseif( $condition_type == 'post-category' ){
				$html_condition_terms = '<select class="wpcdd-select wpcdd-rule-terms wpcdd-sol" name="wpcdd[' . $id . '][condition][terms][]" multiple="multiple">';
				if ( !empty( $wpcdd_post_categories ) ){
					foreach( $wpcdd_post_categories as $category ){
						$html_condition_terms .= '<option value="' . $category->cat_ID . '"' . ( in_array ( $category->cat_ID, $condition_terms ) ? ' selected' : '' ) . '>' . $category->cat_name . '</option>';
					}
				} else {
					$html_condition_terms .= '<option>No Post Categories Available</option>';
				}
				$html_condition_terms .= '</select>';
			} elseif( $condition_type == 'page' ){
				$html_condition_terms = '<select class="wpcdd-select wpcdd-rule-terms wpcdd-sol" name="wpcdd[' . $id . '][condition][terms][]" multiple="multiple">';
				$html_condition_terms .= '<option value="home"' . ( in_array ( 'home', $condition_terms ) ? ' selected' : '' ) . '>Homepage (Front Page)</option>';
				if ( !empty( $wpcdd_pages ) ){
					foreach( $wpcdd_pages as $page ){
						$html_condition_terms .= '<option value="' . $page->ID . '"' . ( in_array ( $page->ID, $condition_terms ) ? ' selected' : '' ) . '>' . $page->post_title . '</option>';
					}
				} else {
					$html_condition_terms .= '<option>No Pages Available</option>';
				}
				$html_condition_terms .= '</select>';
			}
			$html_rules .= '
			<div class="wpcdd-rule">
				<div class="wpcdd-control-bar">
					<div class="wpcdd-drag"><i class="fa fa-arrows"></i></div>
					<div class="wpcdd-rule-title"><p>Rule Priority <span class="wpcdd-rule-priority">' . $rule_order . '</span></p></div>
					<div class="wpcdd-remove"><i class="fa fa-times"></i> Remove</div>
				</div>
				<div class="wpcdd-content-section">
					<h3>Content</h3>
					<select class="wpcdd-select wpcdd-content-type" name="wpcdd[' . $id . '][content][type]">
						<option value="text-single"' . ( $rule['content']['type'] == 'text-single' ? ' selected' : '' ) . '>Text (1 line)</option>
					</select>
					<input type="text" class="wpcdd-text wpcdd-content-value" name="wpcdd[' . $id . '][content][value]" maxlength="180" ' . ( isset( $content_value ) ? 'value="' . $content_value . '"' : 'placeholder="Type Text Here"' ) . ' />
				</div>
				<div class="wpcdd-rules-section">
					<h3>Conditions <span>(applies to any of the selected.)</span></h3>
					<select class="wpcdd-select wpcdd-rule-type" name="wpcdd[' . $id . '][condition][type]">
						<option value="page"' . ( $rule['condition']['type'] == 'page' ? ' selected' : '' ) . '>Page</option>
						<option value="page-template"' . ( $rule['condition']['type'] == 'page-template' ? ' selected' : '' ) . '>Page Template</option>
						<option value="post"' . ( $rule['condition']['type'] == 'post' ? ' selected' : '' ) . '>Post</option>
						<option value="post-category"' . ( $rule['condition']['type'] == 'post-category' ? ' selected' : '' ) . '>Post Category</option>
					</select>
					<select class="wpcdd-select wpcdd-rule-boolean" name="wpcdd[' . $id . '][condition][bool]">
						<option value="is"' . ( $condition_bool == "is" ? ' selected' : '' ) . '>is</option>
						<option value="not"' . ( $condition_bool == "not" ? ' selected' : '' ) . '>is not</option>
					</select>';
			$html_rules .= '<div class="wpcdd-conditionals">' . $html_condition_terms . '</div>';		
			$html_rules .= '		
				</div>
			</div>
			';
		}
		echo $html_rules;
	}
?>
</div>