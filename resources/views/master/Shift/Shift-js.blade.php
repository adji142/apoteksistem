<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			var formData = "{{count($shift)}}";

			
			if (formData > 0) {
				$('#Kode').prop('readonly', true);
			}
			else{
				$('#Kode').prop('readonly', false);
			}
		})
	})
</script>