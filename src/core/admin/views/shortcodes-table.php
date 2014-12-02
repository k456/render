<?php

class USL_ShortcodesTable extends WP_List_Table {

	function __construct() {

		parent::__construct( array(
			'singular' => 'usl_shortcodes_table',
			'plural'   => 'usl_shortcodes_tables',
			'ajax'     => false,
		) );
	}

	public function extra_tablenav( $which ) {

		if ( $which === 'top' ) :
			?>
			<div class="alignleft actions">
				<?php $this->categories_dropdown(); ?>
				<input type="submit" id="post-query-submit" class="button" value="<?php _e( 'Filter', 'USL' ); ?>">
			</div>
		<?php
		endif;
	}

	private function categories_dropdown() {

		$categories  = _usl_get_categories();
		$current_cat = isset( $_GET['category'] ) ? $_GET['category'] : '';
		?>

		<label for="filter-by-category" class="screen-reader-text">
			<?php _e( 'Filter by category', 'USL' ); ?>
		</label>

		<select name="category" id="filter-by-category" class="postform">
			<option value="0"><?php _e( 'All categories', 'USL' ); ?></option>

			<?php foreach ( $categories as $category ) : ?>
				<option class="level-0" value="<?php echo $category; ?>" <?php selected( $category, $current_cat ); ?>>
					<?php echo usl_translate_id_to_name( $category ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	<?php
	}

	public function get_sortable_columns() {

		return $sortable = array(
			'name'     => array( 'name', false ),
			'code'     => array( 'code', false ),
			'source'   => array( 'source', false ),
			'category' => array( 'category', false ),
		);
	}

	public function get_columns() {

		return $columns = array(
			'cb'          => '<input type="checkbox" />',
			'name'        => __( 'Name', 'USL' ),
			'description' => __( 'Description', 'USL' ),
			'category'    => __( 'Category', 'USL' ),
			'source'      => __( 'Source', 'USL' ),
			'attributes'  => __( 'Attributes', 'USL' ),
			'code'        => __( 'Code', 'USL' ),
		);
	}

	public function get_bulk_actions() {
		return $actions = array(
			'disable' => __( 'Disable', 'USL' ),
			'enable'  => __( 'Enable', 'USL' ),
		);
	}

	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="shortcodes[]" value="%s" />', $item['code']
		);
	}

	public function column_name( $item ) {

		$extra_params = isset( $_REQUEST['category'] ) ? "&category=$_REQUEST[category]" : '';

		$actions = array(
			'delete' => sprintf(
				"<a href='?page=%s&action=%s&shortcodes=%s'>%s</a>",
				$_REQUEST['page'],
				'disable',
				$item['code'],
				$extra_params,
				__( 'Disable', 'USL' )
			),
			'enable' => sprintf(
				"<a href='?page=%s&action=%s&shortcodes=%s'>%s</a>",
				$_REQUEST['page'],
				'enable',
				$item['code'],
				$extra_params,
				__( 'Enable', 'USL' )
			),
		);

		return sprintf(
			'%1$s %2$s', $item['name'], $this->row_actions( $actions )
		);
	}

	public function single_row( $item ) {

		static $alternate = '';
		$alternate = ( $alternate == '' ? 'alternate' : '' );
		$disabled  = isset( $this->shortcodes ) && in_array( $item['code'], $this->shortcodes ) ? 'disabled' : '';

		echo "<tr class='$alternate $disabled'>";
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	public function prepare_items() {

		// Save previous data
		$this->save_shortcode_options();

		// Setup some basic data
		$this->_column_headers = $this->get_column_info();

		// Get our items and setup the basic array
		$items          = array();
		$all_shortcodes = _usl_get_merged_shortcodes();

		foreach ( $all_shortcodes as $code => $shortcode ) {

			// Filter if there was a search
			if ( ! empty( $_GET['s'] ) ) {

				$merged = $shortcode['title'] . $shortcode['category'] . $shortcode['description'] . $code;

				if ( strpos( strtolower( $merged ), strtolower( $_GET['s'] ) ) === false ) {
					continue;
				}
			}

			// Filter if there was a selected category
			if ( ! empty( $_GET['category'] ) ) {
				if ( ! isset( $shortcode['category'] ) || $shortcode['category'] != $_GET['category'] ) {
					continue;
				}
			}

			array_push( $items, array(
				'name'        => $shortcode['title'],
				'code'        => $code,
				'description' => $shortcode['description'],
				'source'      => $shortcode['source'],
				'category'    => $shortcode['category'],
				'attributes'  => $shortcode['atts'],
			) );
		}

		// Sort them by the defined order
		uasort( $items, function( $a, $b ) {

			// If no sort, default to title
			$orderby = '' . ( ! empty( $_GET['orderby'] ) ? $_GET['orderby'] : 'name' );

			// If no order, default to asc
			$order = ( ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'asc';

			// Determine sort order
			$result = strcmp( $a[ $orderby ], $b[ $orderby ] );

			// Send final sort direction to usort
			return ( $order === 'asc' ) ? $result : - $result;
		});

		// Pagination
		$per_page     = $this->get_items_per_page( 'shortcodes_per_page', 10 );
		$current_page = $this->get_pagenum();
		$total_items  = count( $items );

		$this->found_data = array_slice( $items, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
		) );

		// Finally, output the items
		$this->items = $this->found_data;
	}

	public function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'name':
				return $item[ $column_name ];

			case 'code':
				return $item[ $column_name ];

			case 'source':
				return $item[ $column_name ];

			case 'description':
				return $item[ $column_name ];

			case 'category':
				return usl_translate_id_to_name( $item[ $column_name ] );

			case 'attributes':

				if ( ! empty( $item[ $column_name ] ) ) {

					$atts = array();
					foreach ( $item[ $column_name ] as $att ) {
						$atts[] = $att['label'];
					}
					$output = implode( ', ', $atts );
				} else {
					$output = 'None';
				}

				return $output;

			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public function save_shortcode_options() {

		$shortcodes = get_option( 'usl_disabled_shortcodes', array() );

		if ( ! isset( $_REQUEST['action'] ) ) {
			return;
		}

		if ( isset( $_REQUEST['shortcodes'] ) ) {

			$_shortcodes = array();
			if ( is_array( $_REQUEST['shortcodes'] ) ) {
				foreach ( $_REQUEST['shortcodes'] as $shortcode ) {
					$_shortcodes[] = $shortcode;
				}
			} else {
				$_shortcodes[] = $_REQUEST['shortcodes'];
			}

			if ( $this->current_action() === 'disable' ) {
				$shortcodes = array_merge( $shortcodes, $_shortcodes );
			} elseif ( $this->current_action() === 'enable' ) {
				$shortcodes = array_diff( $shortcodes, $_shortcodes );
			}

			update_option( 'usl_disabled_shortcodes', array_unique( $shortcodes ) );
		}

		$this->shortcodes = $shortcodes;
	}

	public function no_items() {
		_e( 'Sorry, couldn\'t find any shortcodes.', 'USL' );
	}
}