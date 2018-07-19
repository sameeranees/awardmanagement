<div class="input-group">
	@if($options)
		@foreach( $options as $value => $label )
			<div class="d-inline-block custom-control custom-checkbox mr-1 mr-1">
			    {!! Form::checkbox($name, $value, $selected == $value ? true : null, ['id' => $value, 'class' => 'custom-control-input']) !!}
			    {!! Form::label($value, $label, ['class' => 'custom-control-label']) !!}
			</div>
		@endforeach
	@endif
</div>