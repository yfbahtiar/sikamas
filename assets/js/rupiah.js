function convertToRupiah(objek) {
	separator = ".";
	a = objek.value;
	b = a.replace(/[^\d]/g, "");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) {
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) {
			c = b.substr(i - 1, 1) + separator + c;
		} else {
			c = b.substr(i - 1, 1) + c;
		}
	}
	objek.value = c;
}

function convertToRupiahInt(angka) {
	var rupiah = '';
	var angkarev = angka.toString().split('').reverse().join('');
	for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
	return rupiah.split('', rupiah.length - 1).reverse().join('');
}

function convertToAngka(rupiah) {
	return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}