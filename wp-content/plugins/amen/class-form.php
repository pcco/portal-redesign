<?php
/**
 * Amen Form Generator
 *
 * @since 1.0.0
 */
class Amen_Form {

	public $form_args;

	public function __construct( $args = array() ) {
		$this->form_args = $args;
	}

	/**************************************
	* DISPLAY FORM
	**************************************/

	public function display() {
		!isset( $this->form_args['form_properties']['type'] ) ? $this->form_args['form_properties']['type'] = 'table' : FALSE;
		if ( 'table' == $this->form_args['form_properties']['type'] ) {
			ob_start(); ?>
				<table class="form-table">
					<tbody> <?php
						foreach ( $this->form_args['form_fields'] as $section => $section_args ) { ?>
							<tr id="<?php _e( $section );?>">
								<th scope="row"><?php _e( $section_args['head'], 'amen_domain'); ?></th>
								<td>
									<fieldset>
										<?php
											foreach ( $section_args['fieldset'] as $field => $field_args) {
												echo $this->set_field( $field_args );
											}
										?>
									</fieldset>
								</td>
							</tr> <?php
						} ?>
					</tbody>
				</table> <?php
			echo ob_get_clean();
		} elseif ( 'p' == $this->form_args['form_properties']['type'] ) {
			ob_start();
				foreach ( $this->form_args['form_fields'] as $section => $section_args ) { ?>
					<p>
						<h3><?php _e( $section_args['head'], 'amen_domain'); ?></h3>
							<fieldset>
								<?php
									foreach ( $section_args['fieldset'] as $field => $field_args) {
										echo $this->set_field( $field_args );
									}
								?>
							</fieldset>
					</p> <?php
				}
			echo ob_get_clean();
		}
	}

	/**************************************
	* DISPLAY MENU
	**************************************/

	public function menu() {
		ob_start(); 
			foreach ( $this->form_args['form_fields'] as $section => $section_args ) {
				_e( '<nobr><a href="#' . $section . '">' . $section_args['head'] . '</a></nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ', 'amen_domain' );
			}
		echo ob_get_clean();
	}

	/**************************************
	* ASSEMBLE FIELDS
	**************************************/

	public function set_field( $args, $amen_WPID = NULL ) {
		$defaults = array(
			'displayType'    => 0,  // All:Required
			'label'          => '',  // All:Required
			'id'             => '',  // All:Required
			'value'          => '',  // All (except Multi-Select):Required
			'description'    => '',  // All
			'class'          => '',
			'readonly'       => FALSE,  // All
			'disabled'       => FALSE,  // All
			'order'          => '%F%L%D%N',  // All
			'width'          => '20em',  // Text
			'options'        => '',  // Single-Select & Multi-Select
			'selected'       => '',  // Single-Select
			'checked'        => '',  // Multi-Select & Checkbox
			'rows'           => '12',  // Textarea
			'columns'        => '80',  // Textarea
			);
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );
		$readonly = $readonly ? ' readonly="readonly"' : '';
		$disabled = $disabled ? ' disabled="disabled"' : '';
		$width = $width ? ' style="width:' . $width . ';"' : '';

		switch ( $displayType ) {
			case 'text':  // define text field content
			case 'password':
			case 'submit':
			case 'hidden':
				$show_field = '<input id="' . $id . '" class="' . $class . '" type="' . $displayType . '" name="' . $id . '" value="' . $value . '"' . $readonly . $width . ' />';
				$show_label = '' != $label ? '<label for="' . $id . '">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description">' . $description . '</span>' : '';
				break;
			case 'single-select':  // define single-select dropdown field content
				ob_start(); ?>
					<select id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="<?php echo $class ?>"<?php echo $disabled; ?> />
						<?php foreach( $options as $possibleValue => $display ): ?>
							<option value="<?php echo $possibleValue; ?>" <?php echo ( $selected == $possibleValue ) ? 'selected="selected"' : ''; ?> <?php echo ! current_user_can( 'remove_users' ) ? 'readonly="readonly"' : ''; ?> ><?php echo $display; ?></option>
						<?php endforeach; ?>
					</select>
					<?php foreach( $options as $possibleValue => $display ):
						if ( $selected == $possibleValue ) { echo '' != $disabled ? '<input type="hidden" name="' . $id . '" value="' . $possibleValue . '" />' : ''; }
					endforeach;
				$show_field = ob_get_clean();
				$show_label = '' != $label ? '<label for="' . $id . '">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description">' . $description . '</span>' : '';
				break;
			case 'multi-select':  // define multi-select checkbox field content
				ob_start();
					$count_options = count( $options ); ?>
					<?php if ( $count_options < 10 ) {
						foreach ( $options as $possibleValue => $display ) {
							if( isset( $value[ $possibleValue ]['checked'] ) ) { $amen_checked = 'checked="checked"'; } else { $amen_checked = ''; } ?>
							<input type="hidden" id="<?php echo $id . '[' . $possibleValue . '][displayValue]'; ?>" name="<?php echo $id . '[' . $possibleValue . '][displayValue]'; ?>" value="<?php echo $display; ?>" />
							<input type="checkbox" id="<?php echo $id . '[' . $possibleValue . '][checked]'; ?>" name="<?php echo $id . '[' . $possibleValue . '][checked]'; ?>" value="" <?php echo $amen_checked; ?> /><?php echo $display; ?><br />
							<?php }
					} else {
						$split_count = $count_options / 4;
						$f = 1;
						?>
						<div style="display:inline-block;margin-right:1.5em;vertical-align:top;"><?php foreach( $options as $possibleValue => $display ) {
							if ( isset( $value[ $possibleValue ]['checked'] ) ) { $amen_checked = 'checked="checked"'; } else { $amen_checked = ''; }
							if ( 1 == $f % $split_count ) { ?></div><div style="display:inline-block;margin-right:1.5em;vertical-align:top;"><?php } ?>
							<input type="hidden" id="<?php echo $id . '[' . $possibleValue . '][displayValue]'; ?>" name="<?php echo $id . '[' . $possibleValue . '][displayValue]'; ?>" value="<?php echo $display; ?>" />
							<input type="checkbox" id="<?php echo $id . '[' . $possibleValue . '][checked]'; ?>" name="<?php echo $id . '[' . $possibleValue . '][checked]'; ?>" value="1" <?php echo $amen_checked; ?> /><?php echo $display; ?><br />
							<?php $f++; } ?>
						</div>
					<?php }
				$show_field = ob_get_clean();
				$show_label = '' != $label ? '<label for="' . $id . '">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description">' . $description . '</span>' : '';
				break;
			case 'textarea':  // define textarea field content
				$show_field = '<textarea name="' . $id . '" id="' . $id . '" class="' . $class . '" rows="' . $rows . '" cols="' . $columns . '">' . esc_textarea( $value ) . '</textarea>';
				$show_label = '' != $label ? '<label for="' . $id . '" style="vertical-align:top;">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description" style="vertical-align:top;">' . $description . '</span>' : '';
				break;
			case 'checkbox':  // define checkbox field content
				$checked = $value ? 'checked="checked"' : '';
				$show_field = '<input type="checkbox" id="' . $id . '" name="' . $id . '" value="1" ' . $checked . ' />';
				$show_label = '' != $label ? '<label for="' . $id . '">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description">' . $description . '</span>' : '';
				break;
			case 'editor':  // define editor field content 
				ob_start();
				wp_editor( $value, $id );
				$show_field = ob_get_clean();
				$show_label = '' != $label ? '<label for="' . $id . '" style="vertical-align:top;">' . $label . '</label>' : '';
				$show_description = '' != $description ? '<span class="description" style="vertical-align:top;">' . $description . '</span>' : '';
			default:
				break;
		}
		
		$searchArray = array( '%F', '%L', '%D', '%N', '%S', '%B'  );
		$replaceArray = array( $show_field . ' ', $show_label . ' ', $show_description . ' ', '<br />', '&nbsp;&nbsp;&nbsp;', '&nbsp;&nbsp;&bull;&nbsp;&nbsp;' );
		
		$order = str_replace( $searchArray, $replaceArray, $order );  // set order of content
		
		return $order;
	}
}