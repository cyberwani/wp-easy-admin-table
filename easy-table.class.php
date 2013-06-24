<?php

class EasyAdminTable extends WP_List_Table {

	private $easy_table_data = array();
	private $perpage = 30;

	function __construct($data, $perpage = 30) {
		if(!class_exists('WP_List_Table')){
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}

		$this->perpage = $perpage;
		$this->easy_table_data = $data;
		parent::__construct();
		$this->prepare_items();
		$this->display();
	}

	function get_columns() {
		$first_row = $this->easy_table_data[0];
		$columns = array();
		foreach($first_row as $key=>$value) {
			$columns[$key] = __(ucfirst($key));
		}
		return $columns;
	}


	public function get_sortable_columns() {
		$first_row = $this->easy_table_data[0];
		$sortable = array();
		foreach($first_row as $key=>$value) {
			$sortable[$key] = $key;
		}
		return $sortable;
	}


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




	function display_rows() {

		$records = $this->items;
		list( $columns, $hidden ) = $this->get_column_info();

		$record_count = 0;
		if(!empty($records)){foreach($records as $rec){
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
			}}
	}
}