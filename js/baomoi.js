var speedbao = 2000;
var crossFadeDurationbao = 1;
var baomoi = new Array();
baomoi[0] = '../images/footer/footer1.jpg';
baomoi[1] = '../images/footer/footer2.jpg';
baomoi[2] = '../images/footer/footer3.jpg';
baomoi[3] = '../images/footer/footer4.jpg';
var bbao = baomoi.length;
var dpbao = new Array();
for (j = 0; j < bbao; j++) {
dpbao[j] = new Image();
dpbao[j].src = baomoi[j];
}

dibao = 0;
loaibao = 1;
function fbaomoi() 
	{
    	if (document.all) 
			{
			document.images.baomoi.style.filter="revealTrans(duration=0)";
			document.images.baomoi.style.filter="revealTrans(transition = loaibao)";
			document.images.baomoi.filters.revealTrans.apply();
			}
		document.images.baomoi.src = dpbao[dibao].src;	
		if (document.all) 
			{
			document.images.baomoi.filters.revealTrans.Play();
			}
		dibao++;
		if (dibao > (bbao - 1)) 
			dibao = 0;
		loaibao++;
		if (loaibao > 22 ) 
			loaibao = 0;
		setTimeout('fbaomoi()', speedbao);
	}
