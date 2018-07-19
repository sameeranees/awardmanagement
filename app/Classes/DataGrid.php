<?php namespace App\Classes;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class DataGrid {

	const PAGING_STYLE_BS = "bootstrap";
	const PAGING_STYLE_BS_FULL_NUMBER = "bootstrap_full_number";
	const PAGING_STYLE_BS_EXTENDED = "bootstrap_extended";

	private
		$id,
		$url,
		$class,
		$bordered;

	private
		$paging = true,
		$filters = true,
		$pageLength = 25,
		$pagingType = '';

	private
		$columns,
		$sortColumn,
		$fnBeforeLoad;

	private function __construct( $id, $class=null, $bordered=true ) {
		$this->id = $id;
		$bordered = $bordered ? "table-bordered" : "";
		$this->class= $class ? $class . " $bordered" : "table table-striped $bordered table-hover";
		$this->columns = [];
		$this->sortColumn = [];
		$this->bordered = $bordered;
		$this->pagingType = self::PAGING_STYLE_BS_EXTENDED;

		$this->lastColumnHtml =<<<Block
            <div class="margin-bottom-5">
                <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
            <button class="btn btn-sm red btn-outline filter-cancel">
                <i class="fa fa-times"></i> Reset
            </button>
Block;

		$this->onBeforeLoad('
			//jQuery(".date-picker").datepicker({
            //    rtl: App.isRTL(),
            //    autoclose: true,
            //    clearBtn: true,
            //    format: "mm/dd/yyyy"
            //});
		');
	}

	/**
	 * @param $idOrOptions
	 * @param null $class
	 * @param bool $bordered
	 * @return DataGrid
	 */
	public static function instance( $idOrOptions, $class=null, $bordered=true ) {
		static $instanceManager;
		$info = null;
		$instance = null;
		//dump ( $idOrOptions );
		if (!$instanceManager) {
			$instanceManager = [];
			if ( is_array( $idOrOptions) ) {
				//dd( json_decode( $idOrOptions['buildInfo'] ) );
				if (array_key_exists( 'buildInfo', $idOrOptions )) {
					$info = json_decode( $idOrOptions['buildInfo'] );
					if (!$info) {
						toolbox()->log()->error('Bad JSON data provided to build grid. Data: ' . print_r( $idOrOptions, true ) );
						return null;
					}
					$idOrOptions = isset($info->id) ? $info->id : "";
					$class = isset($info->classes) ? $info->classes : "";
					$bordered = isset($info->bordered) ? $info->bordered : "";;
				}
				else {
					toolbox()->log()->error( 'Unable to find key "buildInfo" in provided array to build grid. Data: ' . print_r( $idOrOptions, true ) );
					return null;
				}
			}
			$idOrOptions = $idOrOptions ? $idOrOptions : "__random_grid";
			$instance = new DataGrid( $idOrOptions, $class, $bordered );
			$instanceManager[ $idOrOptions ] = $instance;
		}
		else if ( !array_key_exists( $idOrOptions, $instanceManager) ) {
			$instance = new DataGrid( $idOrOptions, $class, $bordered );
			$instanceManager[ $idOrOptions ] = $instance;
		}
		else {
			$instance = $instanceManager[ $idOrOptions ];
		}
		if ( $info ) {
			$instance->columns = isset($info->columns) ? $info->columns : [];
		}

		return $instance;
	}

	public function bind( $url ) {
		$this->url = $url;
		return $this;
	}

	/**
	 * @param $title
	 * @param $field
	 * @param $width
	 * @param bool $asc
	 * @param bool $sortable
	 * @param string $filter html or array format
	 * @return $this
	 *
	 * $filter = [ 'type' => "text|", data :{name:'email', value:'', 'class': 'abcd', 'id': 'email'}
	 * $filter = 'select:{name:'countries', value:['1', '2', '3'], 'class': 'abcd', 'id': 'email'}
	 */
	public function addColumn( $title, $field, $width='', $sortable=null, $filter="" ) {
		$this->columns[] = [
			'title' => $title,
			'field' => $field,
			'width' => $width,
	        'sortable' => $sortable,
		    'filter' => is_array($filter) ? json_encode($filter) : $filter,
		];
		return $this;
	}

	public function sortColumn( $columnIndex, $asc=true ) {
		$this->sortColumn = [$columnIndex, $asc];
		return $this;
	}


	public function hidePagination() {
		$this->paging = false;
		return $this;
	}

	public function hideFilters() {
		$this->filters = false;
		return $this;
	}

	public function pagination( $itemPerPage, $style=null ) {
		$this->pageLength = $itemPerPage;
		$this->pagingType = $style;
		return $this;
	}

	public function onBeforeLoad( $fn ) {
		$this->fnBeforeLoad = $fn;
		return $this;
	}

	public function getHtml() {
		$html = [];
		$html[] = '<table class="cdata-grid '. $this->class .'" id="'. $this->id .'">';
		$html[] = '<thead>';

		// table headings
		$html[] = '<tr role="row" class="heading">';
		foreach($this->columns as $i => $column ) {
			$html[] = '<th width="'. $column['width'] .'">'. $column['title'] . '</th>';
		}
		$html[] = '</tr>';

		// table filters
		$html[] = '<tr role="row" class="filter">';
		//dd( $this->columns );
		foreach ($this->columns as $i => $column) {
			$html[] = '<td>';
			if ( $column['filter'] /*&& $this->filters*/ ) {
				$json = json_decode($column['filter'] );
				if ( $json ) {
					$html[] = $this->parseFilter( $json, $column['field'] );
				} else {
					$html[] = $column['filter'];
				}
			}
			$html[] = '</td>';
		}
		$html[] = '</tr>';

		//
		$html[] = '</thead>';
		$html[] = '<tbody> </tbody>';
		$html[] = '</table>';
		return implode(PHP_EOL, $html);
	}

	public function getScript( $var='xGrid') {
		$script[] = sprintf('var %s = new DataTableHelper( "#%s", "%s" );', $var, $this->id, $this->url);
		$script[] = 'jQuery(document).ready(function() {';

		$script[] = 'jQuery(".cdata-grid input").keypress(function (e) {';
		$script[] = '	if (e.which == 13) {';
		$script[] = '		'.$var.'.instance.submitFilter();';
		$script[] = '		return false;';
		$script[] = '	}';
		$script[] = '});';

		if ($this->fnBeforeLoad) {
			$script[] = $var.'.onBeforeLoad( function() {';
			$script[] = $this->fnBeforeLoad;
			$script[] = '});';
		}

		if ( $this->sortColumn ) {
			$script[] = $var . '.setSortColumn(' . $this->sortColumn[0] . ', "' . ($this->sortColumn[1] ? 'asc' : 'desc') . '");';
		}

		$unorderableColumns = [];
		foreach( $this->columns as $i => $column ) {
			if ( empty($column['sortable']) )
				$unorderableColumns[] = $i;
		}
		if (!empty($unorderableColumns)) {
			$script[] = $var . '.setOrderableColumnList(['. implode(", ", $unorderableColumns) .'], false);';
		}

		$script[] = $var.".paging = ". ($this->paging ? 'true;' : 'false;');
		$script[] = $var.".showFilters = ". ($this->filters ? 'true;' : 'false;');
		$script[] = $var.".pageLength = ". $this->pageLength;
		$script[] = $var.".pagingType = '". $this->pagingType . "'";

		$columns = array();
		foreach ($this->columns as $column) {
			$columns[] = ['name' => $column['field']];
		}
		$script[] = $var . ".columns = " . json_encode($columns) . ";";
		$script[] = $var.".init()";

		// END OF JQUERY DOCUMENT LOAD
		$script[] = "});";

		return implode(PHP_EOL, $script);
	}

	/**
	 * @param $rows array Required associative array
	 * @param $totalRecords
	 * @param int $filterRecords
	 * @return array
	 */
	public static function getResponse( $rows, $totalRecords, $filterRecords=null ) {

		$response = [
			'draw'            => '',
			'recordsTotal'    => 0,
			'data'            => [],
			'recordsFiltered' => $filterRecords
		];

		if ($totalRecords <= 0) {
			return $response;
		}

		$records["columns"] = array_keys($rows[0]);
		foreach ($rows as $i => $row ) {
			$records["data"][] = $row;
		}

		//$records["draw"] = $sEcho;
		$records["recordsTotal"] = $totalRecords;
		$records["recordsFiltered"] = $totalRecords;

		return $records;
	}

	private function parseFilter( $json, $name = null ) {

		$filter = "";
		$name = isset($json->name) ? $json->name : $name;
		switch (strtolower( $json->type )) {

			case 'checkbox':
				$classes = isset($json->class) ? $json->class : 'grid-checkboxes';
				$filter = sprintf( '<input type="checkbox" class="grid-checkboxes %s" name="%s">', $classes, $name );
				break;
			
			case 'text-field':
				$classes = isset($json->class) ? $json->class : 'form-control form-filter input-sm';
				$filter = sprintf( '<input type="text" class="%s" name="%s">', $classes, $name );
				break;

			case 'search-reset':
				$containerClass = isset($json->containerClass) ? $json->containerClass : 'btn-group d-flex justify-content-center';
				$searchClass = isset($json->searchClass) ? $json->searchClass : 'btn btn-info btn-outline filter-submit margin-bottom';
				$resetClass = isset($json->resetClass) ? $json->resetClass : 'btn btn-danger btn-outline filter-cancel';
				$filter =<<<Block
                    <div class="$containerClass">
                        <button class="$searchClass" data-toggle="tooltip" data-placement="top" title="" data-original-title="Search">
                            <i class="fa fa-search"></i>
                        </button>
                        <button class="$resetClass" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reset">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>              
Block;
				break;

			case 'select':
				$classes = isset($json->class) ? $json->class : 'form-control form-filter input-sm';
				$options = isset($json->options) ? $json->options : null;
				$filter = '<select name="'. $name .'" id="'. $name .'" class="'. $classes .'">';
				if ($options && !is_scalar($options) ) {
					foreach( $options as $value => $option ) {
						$filter .= '<option value="'. $value .'">'. $option . '</option>';
					}
				}
				$filter .= '</select>';
				break;

			case 'date-from-to':
			case 'date-range':
				$format = isset($json->format) ? $json->format : settings()->getShortDateFormat() ;
				$fromContainerClass = isset($json->fromContainerClass) ? $json->fromContainerClass : 'input-group date date-picker margin-bottom-5';
				$toContainerClass = isset($json->toContainerClass) ? $json->toContainerClass : 'input-group date date-picker';
				$fromClass = isset($json->fromClass) ? $json->fromClass : 'form-control form-filter input-sm';
				$toClass = isset($json->toClass) ? $json->toClass : 'form-control form-filter input-sm';
				$fromName = isset($json->fromName) ? $json->fromName : $name.'_from';
				$toName = isset($json->toName) ? $json->toName : $name.'_to';
				$filter = <<<Block
					<div class="$fromContainerClass" data-date-format="$format">
	                    <input type="text" class="$fromClass" readonly name="$fromName" placeholder="From">
	                    <span class="input-group-btn">
	                        <button class="btn btn-sm default" type="button">
	                            <i class="fa fa-calendar"></i>
	                        </button>
	                    </span>
	                </div>
	                <div class="$toContainerClass" data-date-format="$format">
	                    <input type="text" class="$toClass" readonly name="$toName" placeholder="To">
	                    <span class="input-group-btn">
	                        <button class="btn btn-sm default" type="button">
	                            <i class="fa fa-calendar"></i>
	                        </button>
	                    </span>
	                </div>
Block;

				break;
		}

		return $filter;
	}



}