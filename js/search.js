function myFunction() {

		var url = window.location.href;
		var wordId = url.split('=')[1];
		var word = wordId.split('#');
		var wd = decodeURI(word[0]);
		var id = word[1];
		var str = document.getElementById(id).innerHTML;
		var res = str.replace(wd, "<span style='color: red'>" + wd + "</span>");
		document.getElementById(id).innerHTML = res;
	
	}
