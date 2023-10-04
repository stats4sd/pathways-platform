@if ($crud->hasAccess('exportMedia'))
	<a href="{{ url($crud->route.'/export-media') }}" class="btn btn-success" data-button-type="export"><i class="la la-download"></i> Export media</a>
@endif
