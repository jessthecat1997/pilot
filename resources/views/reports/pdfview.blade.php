<style type="text/css">
	table td, table th{
		border:1px solid black;
	}
</style>
<div class="container">
	@forelse($data as $dt)
	<h1>{{ $dt->plateNumber }}</h1>
	@empty

	@endforelse
	<hr />
</div>