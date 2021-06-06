<style>
    #t_people tbody tr:hover {
        background-color: lavender;
    }
	.alert {
		display: none;
	}
	.alert p {
		margin-top: 13px;
	}
	.alert-success {
		position: fixed;
		top: 40px;
		right: 40px;
		padding: 15px 30px;
	}
	.alert-success p {
		margin: 0;
	}
</style>

<table id="t_people" class="table table-hover table-hover-pointer table-striped table-bordered">
    <thead>
        <tr>
            <th>Osoba</th>
        </tr>
    </thead>
</table>


<!-- Modal + Alert -->
<div class="modal fade" id="m_user_rights" tabindex="-1" role="dialog" aria-labelledby="m_user_rights_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="m_h_user_rights">Uprawdnienia użytkownika</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="m_c_user_rights">
        ...
      </div>
	  <div class="alert alert-danger text-center" role="alert" >
		<h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Błąd!</h4>
		<p></p>
	  </div>
      <div class="modal-footer">
        <button id="m_user_rights_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
        <button id="m_user_rights_save" type="button" class="btn btn-success" >Zapisz</button>
      </div>
    </div>
  </div>
</div>


<!-- Alert -->
<div class="alert alert-success" role="alert" >
	<h4 class="alert-heading"><i class="fas fa-check"></i> Zapisano!</h4>
	<p></p>
</div>

<script>
$(document).ready(function() {
	var changed_inputs = [], selected_user_id;
	var t_people = $('#t_people').DataTable({
		sAjaxSource: '<?=base_url("users_rights/getUsers");?>',
		columns: [
			{ data: "username", render: function (data, type, row) {
				return data;
			}},
		]
	});

	$("#t_people tbody").on('click', 'tr', function(){
		let user_id = t_people.row(this).data().id;
		getUserAccessRights(user_id);
		$('#m_user_rights').modal('show');
	})

	function getUserAccessRights(user_id) {
		selected_user_id = user_id;
		$.post('<?=base_url("users_rights/getUserAccessRights");?>', 'user_id=' + user_id + '&csrf_app_name=' + $.cookie('csrf_app_cookie_name'), function(data) {
			$('#m_c_user_rights').html(data);
		});
	}
	
	$('#m_user_rights_save').click(function() {
		$('#m_user_rights .l_input_changed').each(function() {
			let input_id = $(this).attr('for');
			let input_id_array = input_id.split('_');
			if(input_id_array.length == 2) {
				changed_inputs.push({
					module_id: input_id_array[0], 
					right_id: input_id_array[1], 
					value: $('#'+input_id).is(':checked')?'1':'0'
				});
			}
		})

		if(changed_inputs.length) {
			$.post('<?=base_url("users_rights/saveUserAccessRights");?>', 'user_id=' + selected_user_id + '&changed_inputs=' + JSON.stringify(changed_inputs) + '&csrf_app_name=' + $.cookie('csrf_app_cookie_name'), function(data) {
				let parsed_data = JSON.parse(data);
				if(parsed_data[0] == 1) {
					$('.alert-danger p').html(parsed_data[1]);
					$('.alert-danger').fadeIn('slow').delay(6000).fadeOut('slow');
				} else if(parsed_data[0] == 2) {
					$('.alert-success p').html(parsed_data[1]);
					$('.alert-success').fadeIn('slow').delay(2500).fadeOut('slow');
					$('#m_user_rights').modal('hide');
				}
			});
		} else {
			$('#m_user_rights').modal('hide');
		}

		changed_inputs = [];
	})

	$('#m_user_rights_cancel').click(function() {
		if($('#m_user_rights .l_input_changed').length) {
			if(!confirm('Wprowadzone zmiany nie zostały zapisane, na pewno chcesz zakończyć modyfikację praw dostępu?')) {
				return false;
			}
		}
	})
});

  








</script>