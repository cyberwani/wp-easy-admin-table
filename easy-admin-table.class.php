<?php

/**
 * Simplified usage of tables in wordpress plugin admin views.
 *
 * See https://github.com/moritzjacobs/wp-easy-admin-table
 *
 * @package   EasyAdminTable
 * @author    Moritz Jacobs <mail@moritzjacobs.de>
 * @license   GPL-2.0+
 * @link      http://moritzjacobs.de
 */


class EasyAdminTable extends WP_List_Table {

	private $easy_table_data = array();
	private $perpage = 30;

	function __construct($data, $perpage = 30) {

		// WP_List_Table isn't available for some reason
		if(!class_exists('WP_List_Table')){
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}

		$this->perpage = $perpage;
		$this->easy_table_data = $data;

		parent::__construct();

		$this->prepare_items();
		$this->display();
	}

	// prepare column names according to array keys (capitalized)
	function get_columns() {
		$first_row = $this->easy_table_data[0];
		$columns = array();
		foreach($first_row as $key=>$value) {
			$columns[$key] = __(ucwords(str_replace("_", " ", $key)));
		}
		return $columns;
	}

	// all columns are sortable by default
	public function get_sortable_columns() {
		$first_row = $this->easy_table_data[0];
		$sortable = array();
		foreach($first_row as $key=>$value) {
			$sortable[$key] = $key;
		}
		return $sortable;
	}


	// prepare items for display
	function prepare_items() {
		$data = $this->easy_table_data;

		$this->set_pagination_args( array(
				"total_items" => sizeof($data),
				"total_pages" => sizeof($data) / $this->perpage,
				"per_page" => $this->perpage,
			) );

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->items = $data;
	}



	// display the table
	// this is where you would want to modify the code if you want something special
	function display_rows() {

		$records = $this->items;
		list( $columns, $hidden ) = $this->get_column_info();

		$record_count = 0;

		foreach($records as $rec){
			$record_count++;

			echo '<tr id="record_'.$record_count.'">';
			
			foreach ( $columns as $column_name => $column_display_name ) {

				$class = "class='$column_name column-$column_name'";
				$style = "";
				
				if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
				$attributes = $class . $style;

				echo '<td '.$attributes.'>'.@$rec[$column_name].'</td>';

			}

			echo'</tr>';
		}

	}
}