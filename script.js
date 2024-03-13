$(document).on('submit', 'form.link-shortener', (event) => {
	event.preventDefault();

	if ($("#link").val()) {

		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: { link: $("#link").val() },
		}).done(function(response) {
				$(".result").removeClass("success");

				let parsedResponse = false;
				try {
			        parsedResponse = JSON.parse(response);
			    }
			    catch (e) {}

				if (parsedResponse) {
					if (parsedResponse.status == "success") {
						$(".result").addClass("success");
					}
					$(".result").empty().append(parsedResponse.message);
				}
				else {
					$(".result").empty().append("Internal Server Error");
				}
			});
	}
});