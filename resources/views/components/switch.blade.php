<div class="input-group">
	<fieldset>
      <div class="float-left">
      	@php 
      		$attributes = array_prepend($attributes, 'switch', 'class');
      	@endphp
      	{{ Form::checkbox($name, $value, $checked, $attributes ) }}
    </fieldset>
</div>