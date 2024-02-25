<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			var formData = "{{count($karyawan)}}";

			
			if (formData > 0) {
				$('#NIK').prop('readonly', true);
			}
			else{
				$('#NIK').prop('readonly', false);
			}
		})
	})
</script>