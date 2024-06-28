document.addEventListener('DOMContentLoaded', function () {
	const payLinks = document.querySelectorAll('.pay');
	payLinks.forEach((link) => {
		if (link.dataset.paid == 'Sim') link.remove();
	});
});