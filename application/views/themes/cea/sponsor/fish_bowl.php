<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

<style></style>
<body>
	<main role="main">
		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col m-lg-5 m-sm-0">
					<div class="data-tables">
						<table class="table table-striped text-center table-bordered" id="fish-bowl-table">
							<thead>
								<tr >
									<th class="p-4"> Name </th>
									<th class="p-4"> Email </th>
									<th class="p-4"> Card Drop At </th>
								</tr>
							</thead>
							<tbody>
							<?php if (isset($fish_bowl_data) && !empty($fish_bowl_data))
							{
								foreach ($fish_bowl_data as $data)
								{
									?>
								<tr>
									<td class="p-3"><?=$data->full_name?></td>
									<td class="p-3"><?=$data->email?></td>
									<td class="p-3"><?=$data->date_time?></td>
								</tr>
							<?php
								}
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
<script>
	$(document).ready( function () {
	var dtable = $('#fish-bowl-table').DataTable({
		dom: 'Bfrtip',
		buttons:[
			{
				extend:'csv',
				className: 'btn btn-outline-success '
			},
			{
				extend:'excel',
				className: 'btn btn-outline-primary'
			}

		]
		});

			} );
</script>
