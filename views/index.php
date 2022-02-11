<div class="wrap">
	<h1>Spandiv Manager</h1>
	<form id="form-member" method="post" action="">
		<table class="wp-list-table widefat fixed striped table-view-list" id="table-member">
			<thead>
				<tr>
					<th class="column-primary">Member</th>
					<th width="100">Version</th>
					<th width="150">Last Sync</th>
					<th width="80">Banner</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($results as $key=>$result): ?>
				<tr data-url="<?= $result->member_url ?>">
					<td class="column-primary">
						<a class="row-title" href="<?= $result->member_url ?>" target="_blank"><?= $result->member_url ?></a>
						<br>
						<div class="member-details">Loading...</div>
						<button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
					</td>
					<td class="member-version" data-colname="Version">Loading...</td>
					<td data-colname="Last Sync"><?= date('d/m/Y, H:i:s', strtotime($result->member_last_sync)) ?></td>
					<td data-colname="Banner">
						<select onchange="changeMemberBanner()" name="banner[<?= $result->member_id ?>]" class="member-banner">
							<option value="-1" disabled selected>...</option>
							<option value="1">Show</option>
							<option value="0">Hide</option>
						</select>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</form>
</div>

<script async>
var members = document.querySelectorAll('#table-member tbody tr');
for(var i=0; i<members.length; i++) {
	// Fetch member information
	fetch(members[i].dataset.url + "/wp-json").then(response => response.json()).then(data => {
		var html = '';
		html += '<span><strong>Name:</strong> ' + data.name + '</span>';
		html += '<br>';
		html += '<span><strong>Description:</strong> ' + data.description + '</span>';
		document.querySelector('#table-member tbody tr[data-url="' + data.url + '"] .member-details').innerHTML = html;
	}).catch(error => console.log(error));

	// Fetch member plugin version
	fetch(members[i].dataset.url + "/wp-json/spandiv/v1/information").then((response) => {
		if(!response.ok) {
			var url = response.url.replace("/wp-json/spandiv/v1/information","");
			document.querySelector('#table-member tbody tr[data-url="' + url + '"] .member-version').innerHTML = '<span style="color: #b32d2e;">Inactive</span>';
		}
		return response.json();
	}).then((data) => {
		if(data.hasOwnProperty("version"))
		document.querySelector('#table-member tbody tr[data-url="' + data.home_url + '"] .member-version').innerHTML = data.version;
	}).catch(error => console.log(error));

	// Fetch member banner
	fetch("https://spandiv.xyz/wp-json/spandiv/v1/get-member?url=" + members[i].dataset.url).then(response => response.json()).then(data => {
		document.querySelector('#table-member tbody tr[data-url="' + data.member_url + '"] .member-banner').value = data.member_banner;
	}).catch(error => console.log(error));
}
</script>

<script async>
function changeMemberBanner() {
	document.getElementById("form-member").submit();
}
</script>