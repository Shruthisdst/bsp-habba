function myFunction() {

	var url = window.location.href;
	var wordId = url.split('=')[1];
	var word = wordId.split('#');
	var wd = decodeURI(word[0]);
	var re = new RegExp(wd, 'g');
	document.body.innerHTML = document.body.innerHTML.replace(re, "<span style='color: red'>" + wd + "</span>");
}
