<div class="modal fade" id="askAReportModal" tabindex="-1" role="dialog" aria-labelledby="askAReportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="askAReportModalTitle"><i class="fas fa-file"></i> Ask A Report </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<table class="table" id="askAReportModalTable">
					<thead>
					<tr>
						<th>Attendee ID</th>
						<th>Attendee Name</th>
						<th>Request Type</th>
						<th>DateTime</th>
					</tr>
					</thead>
					<tbody id="askAReportModalTableBody">
					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){
		$('#sessionsTableBody').on('click', '.askARepBtn', function (e) {
			e.preventDefault();
			let sessionId = $(this).attr('session-id');
			let sessionName = $(this).attr('session-name');

			$('#askarepTitleSessionId').text(sessionName);

			$.post(project_admin_url+"/sessions/askarepReport/"+sessionId,
				{
				})
				.done(function( data ) {
					// console.log(data.length);
					if((data.length > 0)) {
						console.log(data.length);
						data = JSON.parse(data);

						if ($.fn.DataTable.isDataTable('#askAReportModalTable')) {
							$('#askAReportModalTable').DataTable().destroy();
						}

						$('#askAReportModalTable tbody').empty();

						$.each(data.result, function (i, item) {
							$('#askAReportModalTableBody').append(
								'<tr>' +
								'<td>' + item.user_id + '</td>' +
								'<td>' + item.user_name + '</td>' +
								'<td>' + item.rep_type + '</td>' +
								'<td>' + item.date_time + '</td>' +
								'</tr>');
						});

						$("#askAReportModalTable").dataTable({
							"order": [[3, "desc"]],
							dom: 'Bfrtip',
							buttons: [
								'copy', 'csv', 'excel', 'pdf', 'print'
							],
							initComplete: function () {
								$('.buttons-copy').removeClass('dt-button');
								$('.buttons-copy').addClass('btn btn-info peco-dt-btns margin-right-5');
								$('.buttons-copy').html('<span><i class="fas fa-copy fa-2x"></i> Copy</span>');

								$('.buttons-csv').removeClass('dt-button');
								$('.buttons-csv').addClass('btn btn-primary peco-dt-btns margin-right-5');
								$('.buttons-csv').html('<span><i class="fas fa-file-csv fa-2x"></i> CSV <i class="fas fa-download"></i></span>');

								$('.buttons-excel').removeClass('dt-button');
								$('.buttons-excel').addClass('btn btn-success peco-dt-btns margin-right-5');
								$('.buttons-excel').html('<span><i class="fas fa-file-excel fa-2x"></i> Excel <i class="fas fa-download"></i></span>');

								$('.buttons-pdf').removeClass('dt-button');
								$('.buttons-pdf').addClass('btn btn-warning peco-dt-btns margin-right-5');
								$('.buttons-pdf').html('<span><i class="fas fa-file-pdf fa-2x"></i> PDF <i class="fas fa-download"></i></span>');

								$('.buttons-print').removeClass('dt-button');
								$('.buttons-print').addClass('btn btn-info peco-dt-btns margin-right-5');
								$('.buttons-print').html('<span><i class="fas fa-print fa-2x"></i> Print</span>');

							}
						});

						$('#askAReportModal').modal('show');
					}else{
						toastr.error('No data on this session');
					}

				})
				.fail(function() {
					toastr.error("Unable to load the report.");
				});
		})
	})
</script>
