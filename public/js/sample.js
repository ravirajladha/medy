function getClick()
{
	$.ajax({
		url:'http://localhost/medhike1.0/receptions/dummy',
		type:'POST',
		success : function(data)
		{
			alert(data);
		}
	});
}