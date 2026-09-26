<img src="{{ asset('images/logo_2.png') }}" style="width:16rem; height:auto;">

<script>
	window.addEventListener('open-in-new-tab', function (event) {
		try {
			var url = event?.detail?.url || (event && event.detail && event.detail.url);
			if (url) {
				window.open(url, '_blank');
			}
		} catch (e) {
			// ignore
		}
	});
</script>
