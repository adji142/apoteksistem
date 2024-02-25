<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			$('#JenisVerifikasi').change();
		})
		$('#JenisVerifikasi').change(function(){
			var oHTML = '';
			if ($('#JenisVerifikasi').val() == "1") {
				oHTML += '<div class="col-md-6">';
				oHTML += '	<div class="form-group">';
				oHTML += '		<label>No. Account *</label>';
				oHTML += '		<input type="text" class="form-control filter-input" name="AcctNumber" id="AcctNumber" placeholder="No. Account" value="{{ $metodepembayaran ? $metodepembayaran->AcctNumber : '' }}" >';
				oHTML += '	</div>';
				oHTML += '</div>';

				oHTML += '<div class="col-md-6">';
				oHTML += '	<div class="form-group">';
				oHTML += '		<label>Nama Pemilik Account *</label>';
				oHTML += '		<input type="text" class="form-control filter-input" name="AcctName" id="AcctName" placeholder="Nama Pemilik Account" value="{{ $metodepembayaran ? $metodepembayaran->AcctName : '' }}" >';
				oHTML += '	</div>';
				oHTML += '</div>';
			}
			else if ($('#JenisVerifikasi').val() == "2") {
				oHTML += '<div class="col-md-12">';
				oHTML += '	<div class="form-group">';
				oHTML += '		<label>Vendor Payment Gateway</label>';
				oHTML += '		<input type="text" class="form-control filter-input" name="VendorPaymentGateway" id="VendorPaymentGateway" placeholder="Vendor Payment Gateway" value="{{ $metodepembayaran ? $metodepembayaran->VendorPaymentGateway : '' }}" >';
				oHTML += '	</div>';
				oHTML += '</div>';

				oHTML += '<div class="col-md-6">';
				oHTML += '	<div class="form-group">';
				oHTML += '		<label>Merchant ID</label>';
				oHTML += '		<input type="text" class="form-control filter-input" name="MerchantID" id="MerchantID" placeholder="Merchant ID" value="{{ $metodepembayaran ? $metodepembayaran->MerchantID : '' }}" >';
				oHTML += '	</div>';
				oHTML += '</div>';

				oHTML += '<div class="col-md-6">';
				oHTML += '	<div class="form-group">';
				oHTML += '		<label>Merchant Key</label>';
				oHTML += '		<input type="text" class="form-control filter-input" name="MerchantKey" id="MerchantKey" placeholder="Merchant Key" value="{{ $metodepembayaran ? $metodepembayaran->MerchantKey : '' }}" >';
				oHTML += '	</div>';
				oHTML += '</div>';
			}

			$('#AfterMetodePembayaran').html(oHTML);
		})
	})
</script>