$(function() {
	function updateImage() {
		if($(this).val()) {
			$(this).next().show().attr("src", "image.php?id=" + $(this).val());
		} else {
			$(this).next().hide();
		}
	}
	$("[data-image]").after("<img width='40' height='40' alt=''/>").click(updateImage).change(updateImage).click()
	
	$("select").css({
		width : 150
	});
});