/**
 * Get cart content count
 */
if (document.getElementById('cart-number')) {
    axios.get(_urlBaseLang +'/cart/get_quantity_cart')
        .then(response => {
            $('#cart-number').text(response.data)
        })
}

$(document).ready(function () {

	//redirect sau khi nhận thông báo session hết hạn
	$('body').on('click', '#redirect', function () {
		window.location.href = _urlBaseLang
	})

	document.addEventListener('visibilitychange', function(){
		// document.hidden == true
		axios.get(_base_app +'/check-token-expired').catch((error) => {
			$('#token-expired-dialog').modal({backdrop: 'static', keyboard: false})
		})
	})
})