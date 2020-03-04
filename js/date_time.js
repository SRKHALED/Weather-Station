function e2b(v)
{
	if (v==1)
	{
		return '০১';
	}
	if (v==2)
	{
		return '০২';
	}
	if (v==3)
	{
		return '০৩';
	}
	if (v==4)
	{
		return '০৪';
	}
	if (v==5)
	{
		return '০৫';
	}
	if (v==6)
	{
		return '০৬';
	}
	if (v==7)
	{
		return '০৭';
	}
	if (v==8)
	{
		return '০৮';
	}
	if (v==9)
	{
		return '০৯';
	}
	if (v==10)
	{
		return '১০';
	}
	if (v==11)
	{
		return '১১';
	}
	if (v==12)
	{
		return '১২';
	}
	if (v==13)
	{
		return '১৩';
	}
	if (v==14)
	{
		return '১৪';
	}
	if (v==15)
	{
		return '১৫';
	}
	if (v==16)
	{
		return '১৬';
	}
	if (v==17)
	{
		return '১৭';
	}
	if (v==18)
	{
		return '১৮';
	}
	if (v==19)
	{
		return '১৯';
	}
	if (v==20)
	{
		return '২০';
	}
	if (v==21)
	{
		return '২১';
	}
	if (v==22)
	{
		return '২২';
	}
	if (v==23)
	{
		return '২৩';
	}
	if (v==24)
	{
		return '২৪';
	}
	if (v==25)
	{
		return '২৫';
	}
	if (v==26)
	{
		return '২৬';
	}
	if (v==27)
	{
		return '২৭';
	}
	if (v==28)
	{
		return '২৮';
	}
	if (v==29)
	{
		return '২৯';
	}
	if (v==30)
	{
		return '৩০';
	}
	if (v==31)
	{
		return '৩১';
	}
	if (v==32)
	{
		return '৩২';
	}
	if (v==33)
	{
		return '৩৩';
	}
	if (v==34)
	{
		return '৩৪';
	}
	if (v==35)
	{
		return '৩৫';
	}
	if (v==36)
	{
		return '৩৬';
	}
	if (v==37)
	{
		return '৩৭';
	}
	if (v==38)
	{
		return '৩৮';
	}
	if (v==39)
	{
		return '৩৯';
	}
	if (v==2020)
	{
		return '২০২০';
	}
	if (v==40)
	{
		return '৪০';
	}
	if (v==41)
	{
		return '৪১';
	}
	if (v==42)
	{
		return '৪২';
	}
	if (v==43)
	{
		return '৪৩';
	}
	if (v==44)
	{
		return '৪৪';
	}
	if (v==45)
	{
		return '৪৫';
	}
	if (v==46)
	{
		return '৪৬';
	}
	if (v==47)
	{
		return '৪৭';
	}
	if (v==48)
	{
		return '৪৮';
	}
	if (v==49)
	{
		return '৪৯';
	}
	if (v==50)
	{
		return '৫০';
	}
	if (v==51)
	{
		return '৫১';
	}
	if (v==52)
	{
		return '৫২';
	}
	if (v==53)
	{
		return '৫৩';
	}
	if (v==54)
	{
		return '৫৪';
	}
	if (v==55)
	{
		return '৫৫';
	}
	if (v==56)
	{
		return '৫৬';
	}
	if (v==57)
	{
		return '৫৭';
	}
	if (v==58)
	{
		return '৫৮';
	}
	if (v==59)
	{
		return '৫৯';
	}
	if (v==00)
	{
		return '০০';
	}
}
function date_time(id)
{
	date = new Date;
	year = date.getFullYear();
	year=e2b(year)
	month = date.getMonth();
	months = new Array('জানুয়ারি','ফেব্রুয়ারি','মার্চ ','এপ্রিল','মে','জুন','জুলই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর');
	d = date.getDate();
	d = e2b(d);
	day = date.getDay();
	days = new Array('রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার','শনিবার');
	h = date.getHours();
	h = e2b(h);
	m = date.getMinutes();
	m = e2b(m);
	s = date.getSeconds();
	s = e2b(s);
	//result = ' '+days[day]+' '+months[month]+'<br>'+d+' '+year+' '+h+':'+m+':'+s;
	result = '<h2>'+h+':'+m+':'+s+'</h2>'+days[day]+'<br>'+d+' '+months[month]+' '+year;
	document.getElementById(id).innerHTML = result;
	setTimeout('date_time("'+id+'");','1000');
	return true;
}