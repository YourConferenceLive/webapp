
<!-- Session Attendees Modal-->
<div class="modal fade" id="sessionAttendeesModal" tabindex="-1" role="dialog" aria-labelledby="sessionAttendeesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="sessionAttendeesModalLabel"><i class="fas fa-users"></i> Session Attendees</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"id="attendeesContainer" data-session-id="">
				<table id="attendeesTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>User ID</th>
							<th>Name</th>
							<th>Surname</th>
							<th>Degree</th>
							<th>Email</th>
							<th>City</th>
							<th>Time</th>
						</tr>
					</thead>
					<!-- Server Side DT -->
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
