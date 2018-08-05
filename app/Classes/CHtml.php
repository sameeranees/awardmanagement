<?php
namespace App\Classes;

use Illuminate\Support\Facades\Session;
use Collective\Html\FormFacade as Form;

class CHtml
{
	const CROSS_BTN_CLASS = 'fa-times';
	const TICK_BTN_CLASS   = 'fa-check';
	const MANAGE_BTN_CLASS = 'icon-pencil';
	const TRASH_BTN_CLASS  = 'icon-trash';

	public function __construct() {
	}

	/**
	 * Get instance
	 *
	 * @return CMetronicTheme
	 */
    public static function instance() {
        static $instance;
        if ( !$instance ) {
            $instance = new CHtml();
        }
        return $instance;
    }


	/**
	 * Created bread-crumb
	 *
	 * @param $data
	 * @param null $class
	 * @param null $separator
	 * @return string
	 */
	public function breadcrumb( $data, $class=null, $separator=null, $activeLastItem = null ) {
		$data = array_prepend($data, route('dashboard'), 'Dashboard');
		$breadcrumb = '<ol class="'.( $class ? $class : 'breadcrumb' ) .'">';
		$size = count($data);
		foreach ( $data as $name => $url ) {
			$lastItem = $size-- == 1;
			$breadcrumb .= '<li class="breadcrumb-item"><a href="'. ($lastItem && is_null($activeLastItem)? 'javascript:;' : $url) . '">'. $name ."".'</a>';
			if ( !$lastItem ) {
				$breadcrumb .= $separator ? $separator : '';
			}
			$breadcrumb .= '</li>';
		}
		return $breadcrumb . '</ol>';
	}

	/**
	 * Shows alert message or creates an empty alert container for message.
	 *
	 * @param null $errors
	 * @param bool $onlyFirst
	 * @return string
	 */
	public function alertMessage( $errors=null, $onlyFirst=false ) {
		
		if ( Session::has( 'message') || Session::has( 'alert-danger') || Session::has( 'alert-warning') || Session::has( 'alert-success') || Session::has( 'alert-info') || count($errors)) {

			$html[] = '<div class="row">';
			$html[] = '<div class="col-md-12">';
			$html[] = '<div class="card">';
			$html[] = '<div class="card-content collapse show">';
			$html[] = '<div class="card-body">';
	                      
			$html[] = '<div class="alert-container">';

			// error handling for views
			if ( !is_null($errors) && count($errors) > 0 ) {
				if ( count($errors) == 1 )
					$onlyFirst = true;
				$html[] = '<div class="alert alert-danger">';
				$html[] = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                          </button>';
				$html[] = '<i class="fa-lg fa fa-exclamation-triangle"></i>';
				if (!$onlyFirst)
					$html[] = '<ul>';
				foreach ( $errors->all() as $error) {

					if ($onlyFirst) {
						$html[] = '&nbsp;'.$error;
						break;
					};
					$html[] = '<li>' . $error . '</li>';
				}
				if (!$onlyFirst)
					$html[] = '</ul>';
				$html[] = '</div>';
			}
			else if ( Session::has( 'message' ) ) {
				$html[] = '<div class="alert alert-info">';
				$html[] = '		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                          </button>';
				$html[] = '		<strong><i class="fa-lg fa fa-info-circle"></i></strong> ' . Session::get( 'message' );
				$html[] = '</div>';
			}
			else {
				foreach ( ['danger', 'warning', 'success', 'info'] as $msg ) {
					if ( Session::has( 'alert-' . $msg )) {
						switch($msg) {
							case 'danger': $icon = '<i class="fa-lg fa fa-exclamation-triangle"></i>'; break;
							case 'warning': $icon = '<i class="fa-lg fa fa-warning"></i>'; break;
							case 'success': $icon = '<i class="fa-lg fa fa-check"></i>'; break;
							case 'info': $icon = '<i class="fa-lg fa fa-info-circle"></i>'; break;
						}
						$html[] = '<div class="alert alert-' . $msg . ' alert-dismissible mb-2">';
						$html[] = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true">×</span>
	                          </button>';
						$html[] = '<strong>'. $icon .'</strong> '.Session::get( 'alert-' . $msg );
						$html[] = '</div>';
						break;
					}
				}
			}
			$html[] = '</div>';
			$html[] = '</div>';
			$html[] = '</div>';
			$html[] = '</div>';
			$html[] = '</div>';
			$html[] = '</div>';
			return implode( "", $html );
		}
	}

	/**
	 * Creates hyper link.
	 *
	 * @param $text
	 * @param string $url
	 * @param array $properties
	 * @return string
	 */
	public static function href( $text, $url = 'javascript:;', $properties = [] ) {
		$parts = [];
		if (is_array( $properties )) {
			foreach ($properties as $property => $value) {
				$parts[] = $property . '="' . $value . '"';
			}
		}

		return sprintf( '<a href="%s" %s>%s</a>', $url, implode( " ", $parts ), $text );

	}

	public function switchButton( $id, $name, $data, $checked=true, $colors=array() ) {
		$values = array_keys( $data );
		$offValue = $values[0];
		$onValue = $values[1];
		$offLabel = $data[ $offValue ];
		$onLabel = $data[ $onValue ];
		$offColor = '';
		$onColor = '';
		if ( is_array($colors) && count($colors) >= 2) {
			$offColor = ' data-off-color="' . $colors[0] . '"';
			$onColor = ' data-on-color="' . $colors[1] . '"';
		}
		$checked = $checked ? ' checked="checked"' : "";
		return '<input id="active" 
			class="make-switch form-control" 
			data-size="small" 
			data-on="' . $onValue . '" 
			data-off="' . $offValue . '" 
			data-on-text="' . $onLabel . '" 
			data-off-text="' . $offLabel . '" 
			' . $checked . '" 
			' . $offColor . '" 
			' . $onColor . '" 
			id="' . $id . '" 
			name="' . $name . '" 
			type="checkbox" 
			value="' . $onValue . '">';
	}

	public function groupButton( $options, $title="", $class="green", $dropdown = false ) {

		if ( !$options || !is_array($options) ) {
			return null;
		}

		$links = "";
		foreach( $options as $option) {
			if( $dropdown )
				$links .= '<li>';
			$attributes = "";
			if ( isset($option['attributes']) ) {
				foreach($option['attributes'] as $attr => $value) {
					if( $attr == 'class' )
						$value .= ' btn btn-icon';

					$attributes .= ' '.$attr.'="'. $value . '"';
				}
			}
			$option['url'] = isset($option['url']) ? $option['url'] : "javascript:;";
			$links .= '<a href="'. $option['url'] . '" '. $attributes .'  data-toggle="tooltip" data-placement="top" title="" data-original-title="' . $option['title'] . '">';
			if ( isset($option['icon']) ) {
				$links .= '<i class="'. $option['icon'] .'"></i> ';
			}
			$links .= '</a>';
			if( $dropdown )
				$links .= '<li>';
		}
		if( $dropdown ){
		$html = <<<Block
			<div class="btn-group">
		        <a class="btn $class" href="javascript:;" data-toggle="dropdown">
		            <i class="fa fa-bars"></i> $title
		            <i class="fa fa-angle-down"></i>
		        </a>
		        <ul class="dropdown-menu pull-right">
		            $links
		        </ul>
	    </div>
Block;
}else{
			$html = <<<Block
			<div class="btn-group d-flex justify-content-center">
		        $links
	    	</div>
Block;
}
		return $html;
	}

	public function select2( $id, $name, $selected=array(), $attributes=array() ) {

		$default = ['class' => 'form-control', 'buttons'=>['default'] ];
		if ( !is_array($attributes) ) {
			$attributes = array();
		}

		$attributes = array_merge( $default, $attributes );
		$attributes['id'] = $id;

		$buttons = [];
		if ( isset($attributes['buttons']) ) {
			$buttons = $attributes['buttons'];
			unset($attributes['buttons']);
		}

		$element = Form::select( $name, $selected, array_keys($selected), $attributes);

		$buttonsHtml = '';
		if ( is_array($buttons) ) {
			foreach($buttons as $button) {
				if ( is_array($button) ) {
					$btn = '<button ';
					foreach($button as $attr => $val) {
						$btn .= $attr .'="'. $val.'" ';
					}
					$btn .= '>';
					if ( isset($button['title']) ) {
						$btn .= $button['title'];
					}
					$btn .= '</button>';
					$buttonsHtml .= $btn;
				}
				else if ( strtolower($button) == 'default') {
					$buttonsHtml .= '<button class="btn btn-default" type="button" data-select2-open="'. $id . '"><span class="glyphicon glyphicon-search"></span></button>';
				}
			}
		}
		return <<<Block
			<div class="input-group select2-bootstrap-append">			
	            $element
	            <span class="input-group-btn">
	                $buttonsHtml
	            </span>
	        </div>
Block;
	}


	public function crossButton($title='Delete',$colorClass='')
	{
		return $this->button(self::CROSS_BTN_CLASS, $title, $colorClass);
	}

	public function trashButton($title='Trash',$colorClass='')
	{
		return $this->button(self::TRASH_BTN_CLASS, $title, $colorClass);
	}

	public function manageButton($title='Edit',$colorClass='')
	{
		return $this->button(self::MANAGE_BTN_CLASS, $title, $colorClass);
	}

	public function tickButton($title='Restore',$colorClass='')
	{
		return $this->button(self::TICK_BTN_CLASS, $title, $colorClass);
	}

	private function button($class='fa-check', $title='Restore', $colorClass='')
	{
		if (!$colorClass) {
			$colorClass='red';
		}

		return <<<HTML
		<button class="btn btn-sm {$colorClass} btn-outline" title="{$title}">
			<i class="fa {$class}"></i>
		</button>
HTML;
	}

	/**
	 * Backoffice sidebar navigation
	 *
	 * @return void
	 * @author 
	 **/
	public static function sidebarNavItems(){
		return [
			'dashboard' => [
				'label' => 'Home',
				'icon' => 'ft-home',
		        'link' => route('dashboard'),
			],
			'users|roles' => [				
				'label' => 'User Management',
				'icon' => 'ft-users',
		        'link' => '#',
		        'children' => [
				    'Users' => ['link' => route('users.index')],
				    'Roles' => ['link' => route('roles.index')],
			    ]
			],
			'members'=>[				
				'label' => 'Application Management',
				'icon' => 'ft-users',
		        'link' => '#',
		        'children' => [
				    'Members' => ['link' => route('members.index')],
				    'Degrees' => ['link' => route('degrees.index')],
				    'Majors' => ['link' => route('majors.index')],
				    'Seats' => ['link' => route('seats.index')]
			    ]
			]
		];
	}

	public static function generateNavigation(){
		
		$items = self::sidebarNavItems();
		$toggleClass = '';
		$current = \Route::currentRouteName();
		echo '<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">';
			foreach( $items as $key => $item ){
				$hasChildren = false;
				$active = '';
				if( isset( $item['children'] ) && count($item['children']) ){
					$toggleClass = 'dropdown-toggle';
					$parentItem = '<a href="javascript:void(0);"><i class="'.$item['icon'].'"></i><span class="menu-title">'.$item['label'].'</span></a>';
					$hasChildren = true;
				}else{
					$parentItem = '<a href="'. $item['link'] .'">
					<i class="'.$item['icon'].'"></i>
					<span class="menu-title">'. $item['label'] .'</span>
				    </a>';
				}

				if( str_contains($current, explode('|', $key)) ){
					$active = 'active';	
				}
				
				echo '<li class="nav-item '. $active .'">';
					echo $parentItem;
				    if( $hasChildren ){
				    	echo '<ul class="menu-content">';
				    		foreach ($item['children'] as $label => $child) {
				    			$act = '';
				    			if( isset($child['link']) && $child['link'] === url()->current() ){
									$act = 'active';	
								}
				    			echo '<li class="menu-item '. $act .'">';
			                        echo '<a href="'. $child['link'] .'">';
			                            echo  $label;
			                        echo '</a>';
			                    echo '</li>';
				    		}
				    	echo '</ul>';
				    	
				    }
				echo '</li>';
			}
		echo '</ul>';
	}

}