function notifyTicket(){
	let permission = Notification.permission;

	if(permission === "granted"){
		showNotification();
	} else {
		Notification.requestPermission()
	}
}

function showNotification(){
	
	$.ajax({
		type: "GET",
		url: "/ticket/getnotify",
		success: function (result) { 
		
			let obj = jQuery.parseJSON(result);
			if(obj.length !== 0){
				
				let title = "8Baht | You have a new ticket";
				let icon = 'https://phpstack-1646968-6541058.cloudwaysapps.com/storage/setting/616fd73fc5c0f.png';
				let body = obj['company']+' - '+obj['subject'];
				
				let audio = new Audio('https://phpstack-1646968-6541058.cloudwaysapps.com/assets/backend/sound/happy-bell.wav');
				audio.load();
				audio.play();
				
				let notification = new Notification(title, { body, icon });

				notification.onclick = () => {
					notification.close();
					window.open('https://phpstack-1646968-6541058.cloudwaysapps.com/ticket/edit/'+obj['id'], '_blank');
				}
				
			}
			
		}
	});
	
}

notifyTicket();
setInterval(notifyTicket, 120000);	// 2 min